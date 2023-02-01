<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230130132530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add is_anonymous field to feedback';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE feedback ADD is_anonymous TINYINT(1) DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE feedback DROP is_anonymous');
    }
}
