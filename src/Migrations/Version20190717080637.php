<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190717080637 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking ADD user_mail_id INT NOT NULL, ADD owner_mail_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE907A710B FOREIGN KEY (user_mail_id) REFERENCES mail (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE4401E9DE FOREIGN KEY (owner_mail_id) REFERENCES mail (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDE907A710B ON booking (user_mail_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDE4401E9DE ON booking (owner_mail_id)');
        $this->addSql('ALTER TABLE mail DROP FOREIGN KEY FK_5126AC483301C60');
        $this->addSql('DROP INDEX IDX_5126AC483301C60 ON mail');
        $this->addSql('ALTER TABLE mail DROP booking_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE907A710B');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE4401E9DE');
        $this->addSql('DROP INDEX UNIQ_E00CEDDE907A710B ON booking');
        $this->addSql('DROP INDEX UNIQ_E00CEDDE4401E9DE ON booking');
        $this->addSql('ALTER TABLE booking DROP user_mail_id, DROP owner_mail_id');
        $this->addSql('ALTER TABLE mail ADD booking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mail ADD CONSTRAINT FK_5126AC483301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_5126AC483301C60 ON mail (booking_id)');
    }
}
