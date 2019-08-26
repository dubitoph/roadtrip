<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190728123409 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE advert CHANGE expires_at expires_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle DROP INDEX IDX_1B80E4863408E8AF, ADD UNIQUE INDEX UNIQ_1B80E4863408E8AF (situation_id)');
        $this->addSql('ALTER TABLE profile DROP INDEX IDX_8157AA0FF5B7AF75, ADD UNIQUE INDEX UNIQ_8157AA0FF5B7AF75 (address_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE advert CHANGE expires_at expires_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE profile DROP INDEX UNIQ_8157AA0FF5B7AF75, ADD INDEX IDX_8157AA0FF5B7AF75 (address_id)');
        $this->addSql('ALTER TABLE vehicle DROP INDEX UNIQ_1B80E4863408E8AF, ADD INDEX IDX_1B80E4863408E8AF (situation_id)');
    }
}
