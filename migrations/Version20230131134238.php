<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * class Version20230131134238.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20230131134238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'response count';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE feedback ADD response_count INT DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE feedback DROP response_count');
    }
}
