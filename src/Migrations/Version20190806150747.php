<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190806150747 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rating ADD advert_id INT DEFAULT NULL, ADD tenant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926229033212A FOREIGN KEY (tenant_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D8892622D07ECCB6 ON rating (advert_id)');
        $this->addSql('CREATE INDEX IDX_D88926229033212A ON rating (tenant_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622D07ECCB6');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D88926229033212A');
        $this->addSql('DROP INDEX IDX_D8892622D07ECCB6 ON rating');
        $this->addSql('DROP INDEX IDX_D88926229033212A ON rating');
        $this->addSql('ALTER TABLE rating DROP advert_id, DROP tenant_id');
    }
}
