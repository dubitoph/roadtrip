<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190731101907 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D88926229033212A');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622A76ED395');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622D07ECCB6');
        $this->addSql('DROP INDEX IDX_D8892622D07ECCB6 ON rating');
        $this->addSql('DROP INDEX IDX_D88926229033212A ON rating');
        $this->addSql('DROP INDEX IDX_D8892622A76ED395 ON rating');
        $this->addSql('ALTER TABLE rating DROP user_id, DROP advert_id, DROP tenant_id, DROP rental_beginning, DROP rental_end, DROP rental_confirmation, DROP response_approved, DROP response, DROP type, DROP automatically_confirmed_rental');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rating ADD user_id INT NOT NULL, ADD advert_id INT DEFAULT NULL, ADD tenant_id INT DEFAULT NULL, ADD rental_beginning DATETIME NOT NULL, ADD rental_end DATETIME NOT NULL, ADD rental_confirmation VARCHAR(3) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD response_approved TINYINT(1) DEFAULT NULL, ADD response LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD type VARCHAR(6) NOT NULL COLLATE utf8mb4_unicode_ci, ADD automatically_confirmed_rental TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926229033212A FOREIGN KEY (tenant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('CREATE INDEX IDX_D8892622D07ECCB6 ON rating (advert_id)');
        $this->addSql('CREATE INDEX IDX_D88926229033212A ON rating (tenant_id)');
        $this->addSql('CREATE INDEX IDX_D8892622A76ED395 ON rating (user_id)');
    }
}
