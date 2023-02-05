<?php

declare(strict_types=1);

namespace Infrastructure\Feedback\Doctrine\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Authentication\Entity\User;
use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Repository\FeedbackRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;
use Infrastructure\Shared\Doctrine\Repository\NativeQueryTrait;

/**
 * class FeedbackRepository.
 *
 * @extends AbstractRepository<Feedback>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class FeedbackRepository extends AbstractRepository implements FeedbackRepositoryInterface
{
    use NativeQueryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feedback::class);
    }

    public function monthlyFeedbackLimitReached(User $owner, int $limit = 1): bool
    {
        $start = new \DateTimeImmutable('first day of this month');
        $end = new \DateTimeImmutable('last day of this month');

        try {
            $count = $this->createQueryBuilder('f')
                ->select('COUNT(f.id)')
                ->where('f.owner = :owner')
                ->andWhere('f.created_at BETWEEN :start AND :end')
                ->setParameter('owner', $owner)
                ->setParameter('start', $start->format('Y-m-d'))
                ->setParameter('end', $end->format('Y-m-d'))
                ->getQuery()
                ->getSingleScalarResult();

            return $count > $limit;
        } catch (NoResultException) {
            return false;
        } catch (NonUniqueResultException) {
            return true;
        }
    }

    public function findStats(): array
    {
        $currentMonth = $this->createDateTimeInterval('first day of this month', 'last day of this month');
        $previousMonth = $this->createDateTimeInterval('first day of previous month', 'last day of previous month');

        $sql = <<< SQL
            SELECT
                (SELECT COUNT(id) FROM feedback WHERE created_at BETWEEN :current_month_start AND :current_month_end) AS feedbacks_current_month,
                (SELECT COUNT(id) FROM feedback WHERE created_at BETWEEN  :previous_month_start AND :previous_month_end) AS feedbacks_previous_month
            FROM DUAL;
        SQL;

        $data = $this->execute($sql, [
            'current_month_start' => $currentMonth[0],
            'current_month_end' => $currentMonth[1],
            'previous_month_start' => $previousMonth[0],
            'previous_month_end' => $previousMonth[1],
        ], false);

        $dataRatio = $this->calculateProgressionRatio($data['feedbacks_previous_month'], $data['feedbacks_current_month']);

        return [
            ...$data,
            'feedbacks_month_ratio' => $dataRatio,
        ];
    }

    public function findCurrentYearFrequency(): array
    {
        $interval = $this->createDateTimeInterval(
            'first day of January this year',
            'last day of December this year'
        );
        $monthSum = $this->createMonthSumSQL('created_at');

        $sql = <<< SQL
            SELECT ${monthSum} FROM feedback WHERE created_at BETWEEN :start AND :end
        SQL;

        return $this->execute($sql, [
            'start' => $interval[0],
            'end' => $interval[1],
        ], false);
    }

    private function calculateProgressionRatio(int $previous, int $current): int|float
    {
        return 0 === $previous ?
            $current * 100 :
            round(($current - $previous) * ($previous / 100), 2);
    }

    private function createDateTimeInterval(string $start, string $end): array
    {
        return [
            (new \DateTimeImmutable($start))->format('Y-m-d'),
            (new \DateTimeImmutable($end))->format('Y-m-d'),
        ];
    }

    private function createMonthSumSQL(string $date): string
    {
        return <<< SQL
            SUM(MONTH({$date}) = 1) AS 'Jan',
            SUM(MONTH({$date}) = 2) AS 'Feb',
            SUM(MONTH({$date}) = 3) AS 'Mar',
            SUM(MONTH({$date}) = 4) AS 'Apr',
            SUM(MONTH({$date}) = 5) AS 'May',
            SUM(MONTH({$date}) = 6) AS 'Jun',
            SUM(MONTH({$date}) = 7) AS 'Jul',
            SUM(MONTH({$date}) = 8) AS 'Aug',
            SUM(MONTH({$date}) = 9) AS 'Sep',
            SUM(MONTH({$date}) = 10) AS 'Oct',
            SUM(MONTH({$date}) = 11) AS 'Nov',
            SUM(MONTH({$date}) = 12) AS 'Dec'
        SQL;
    }
}
