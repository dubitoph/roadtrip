<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190907163801 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vehicle CHANGE beds_number beds_number SMALLINT NOT NULL, CHANGE seats_number seats_number SMALLINT NOT NULL, CHANGE length length NUMERIC(3, 2) DEFAULT NULL, CHANGE height height NUMERIC(3, 2) DEFAULT NULL, CHANGE weight weight SMALLINT DEFAULT NULL, CHANGE power power SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE subscription CHANGE duration duration SMALLINT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE subscription CHANGE duration duration INT NOT NULL');
        $this->addSql('ALTER TABLE vehicle CHANGE beds_number beds_number INT NOT NULL, CHANGE seats_number seats_number INT NOT NULL, CHANGE length length DOUBLE PRECISION DEFAULT NULL, CHANGE height height DOUBLE PRECISION DEFAULT NULL, CHANGE weight weight INT DEFAULT NULL, CHANGE power power INT DEFAULT NULL');
    }
}
