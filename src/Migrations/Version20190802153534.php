<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190802153534 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rating ADD response_to_rating_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D889262246367F1C FOREIGN KEY (response_to_rating_id) REFERENCES response_to_rating (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D889262246367F1C ON rating (response_to_rating_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D889262246367F1C');
        $this->addSql('DROP INDEX UNIQ_D889262246367F1C ON rating');
        $this->addSql('ALTER TABLE rating DROP response_to_rating_id');
    }
}
