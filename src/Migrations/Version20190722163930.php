<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190722163930 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F14B78418');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FD4E6F81');
        $this->addSql('DROP INDEX IDX_8157AA0FD4E6F81 ON profile');
        $this->addSql('DROP INDEX UNIQ_8157AA0F14B78418 ON profile');
        $this->addSql('ALTER TABLE profile ADD photo_id INT DEFAULT NULL, ADD address_id INT DEFAULT NULL, DROP photo, DROP address');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F7E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0F7E9E4C8C ON profile (photo_id)');
        $this->addSql('CREATE INDEX IDX_8157AA0FF5B7AF75 ON profile (address_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F7E9E4C8C');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FF5B7AF75');
        $this->addSql('DROP INDEX UNIQ_8157AA0F7E9E4C8C ON profile');
        $this->addSql('DROP INDEX IDX_8157AA0FF5B7AF75 ON profile');
        $this->addSql('ALTER TABLE profile ADD photo INT DEFAULT NULL, ADD address INT DEFAULT NULL, DROP photo_id, DROP address_id');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F14B78418 FOREIGN KEY (photo) REFERENCES photo (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FD4E6F81 FOREIGN KEY (address) REFERENCES address (id)');
        $this->addSql('CREATE INDEX IDX_8157AA0FD4E6F81 ON profile (address)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0F14B78418 ON profile (photo)');
    }
}
