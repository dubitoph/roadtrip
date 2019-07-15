<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190714140329 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE thread DROP FOREIGN KEY FK_31204C8361220EA6');
        $this->addSql('DROP INDEX IDX_31204C8361220EA6 ON thread');
        $this->addSql('ALTER TABLE thread ADD owner_id INT NOT NULL, CHANGE creator_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE thread ADD CONSTRAINT FK_31204C83A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE thread ADD CONSTRAINT FK_31204C837E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
        $this->addSql('CREATE INDEX IDX_31204C83A76ED395 ON thread (user_id)');
        $this->addSql('CREATE INDEX IDX_31204C837E3C61F9 ON thread (owner_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE thread DROP FOREIGN KEY FK_31204C83A76ED395');
        $this->addSql('ALTER TABLE thread DROP FOREIGN KEY FK_31204C837E3C61F9');
        $this->addSql('DROP INDEX IDX_31204C83A76ED395 ON thread');
        $this->addSql('DROP INDEX IDX_31204C837E3C61F9 ON thread');
        $this->addSql('ALTER TABLE thread ADD creator_id INT NOT NULL, DROP user_id, DROP owner_id');
        $this->addSql('ALTER TABLE thread ADD CONSTRAINT FK_31204C8361220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_31204C8361220EA6 ON thread (creator_id)');
    }
}
