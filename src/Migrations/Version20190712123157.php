<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190712123157 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, advert_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_C0B9F90FD07ECCB6 (advert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FD07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE mail DROP FOREIGN KEY FK_5126AC48D07ECCB6');
        $this->addSql('DROP INDEX IDX_5126AC48D07ECCB6 ON mail');
        $this->addSql('ALTER TABLE mail DROP advert_id, DROP conversation');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE discussion');
        $this->addSql('ALTER TABLE mail ADD advert_id INT DEFAULT NULL, ADD conversation BIGINT NOT NULL');
        $this->addSql('ALTER TABLE mail ADD CONSTRAINT FK_5126AC48D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('CREATE INDEX IDX_5126AC48D07ECCB6 ON mail (advert_id)');
    }
}
