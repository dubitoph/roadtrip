<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190712125142 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE thread (id INT AUTO_INCREMENT NOT NULL, advert_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_31204C83D07ECCB6 (advert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE thread ADD CONSTRAINT FK_31204C83D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('ALTER TABLE mail ADD thread_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mail ADD CONSTRAINT FK_5126AC48E2904019 FOREIGN KEY (thread_id) REFERENCES thread (id)');
        $this->addSql('CREATE INDEX IDX_5126AC48E2904019 ON mail (thread_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mail DROP FOREIGN KEY FK_5126AC48E2904019');
        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, advert_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_C0B9F90FD07ECCB6 (advert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FD07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('DROP TABLE thread');
        $this->addSql('DROP INDEX IDX_5126AC48E2904019 ON mail');
        $this->addSql('ALTER TABLE mail DROP thread_id');
    }
}
