<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230130104026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create feedback, feedback response and user tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE feedback (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, content VARCHAR(350) NOT NULL, status VARCHAR(30) NOT NULL, promotion VARCHAR(30) NOT NULL, is_read TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D22944587E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feedback_response (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, feedback_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7135A0897E3C61F9 (owner_id), INDEX IDX_7135A089D249A887 (feedback_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D22944587E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE feedback_response ADD CONSTRAINT FK_7135A0897E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE feedback_response ADD CONSTRAINT FK_7135A089D249A887 FOREIGN KEY (feedback_id) REFERENCES feedback (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D22944587E3C61F9');
        $this->addSql('ALTER TABLE feedback_response DROP FOREIGN KEY FK_7135A0897E3C61F9');
        $this->addSql('ALTER TABLE feedback_response DROP FOREIGN KEY FK_7135A089D249A887');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE feedback_response');
        $this->addSql('DROP TABLE user');
    }
}
