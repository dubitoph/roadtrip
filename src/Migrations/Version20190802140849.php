<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190802140849 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE response_to_rating (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, rating_id INT NOT NULL, created_at DATETIME NOT NULL, response LONGTEXT NOT NULL, INDEX IDX_D05831D8A76ED395 (user_id), UNIQUE INDEX UNIQ_D05831D8A32EFC6 (rating_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE response_to_rating ADD CONSTRAINT FK_D05831D8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE response_to_rating ADD CONSTRAINT FK_D05831D8A32EFC6 FOREIGN KEY (rating_id) REFERENCES rating (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE response_to_rating');
    }
}
