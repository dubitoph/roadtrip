<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190606083429 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rating ADD approved_rating TINYINT(1) DEFAULT NULL, ADD approved_response TINYINT(1) DEFAULT NULL, ADD automatically_confirmed_rental TINYINT(1) DEFAULT NULL, DROP rating_approved, DROP response_approved, DROP rental_automatically_confirmed');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rating ADD rating_approved TINYINT(1) DEFAULT NULL, ADD response_approved TINYINT(1) DEFAULT NULL, ADD rental_automatically_confirmed TINYINT(1) DEFAULT NULL, DROP approved_rating, DROP approved_response, DROP automatically_confirmed_rental');
    }
}
