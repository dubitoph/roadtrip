<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190710153212 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, number VARCHAR(6) NOT NULL, box INT DEFAULT NULL, zip_code VARCHAR(25) NOT NULL, city VARCHAR(50) NOT NULL, state VARCHAR(50) DEFAULT NULL, country VARCHAR(50) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE advert (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT DEFAULT NULL, insurance_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, subscription_id INT DEFAULT NULL, title VARCHAR(80) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, expires_at DATETIME NOT NULL, extra_kilometer_cost DOUBLE PRECISION DEFAULT NULL, included_cleaning TINYINT(1) DEFAULT NULL, cleaning_cost INT DEFAULT NULL, stripe_intent_id VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_54F1F40B545317D1 (vehicle_id), UNIQUE INDEX UNIQ_54F1F40BD1E63CD1 (insurance_id), INDEX IDX_54F1F40B7E3C61F9 (owner_id), INDEX IDX_54F1F40B9A1887DC (subscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT NOT NULL, begin_at DATETIME NOT NULL, end_at DATETIME DEFAULT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_E00CEDDE545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE included_mileage (id INT AUTO_INCREMENT NOT NULL, advert_id INT NOT NULL, duration_id INT NOT NULL, mileage INT NOT NULL, INDEX IDX_EE4B960FD07ECCB6 (advert_id), INDEX IDX_EE4B960F37B987D8 (duration_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE insurance (id INT AUTO_INCREMENT NOT NULL, deductible INT NOT NULL, included TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE insurance_price (id INT AUTO_INCREMENT NOT NULL, duration_id INT NOT NULL, insurance_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_651C18DA37B987D8 (duration_id), INDEX IDX_651C18DAD1E63CD1 (insurance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE period (id INT AUTO_INCREMENT NOT NULL, season_id INT NOT NULL, advert_id INT NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, INDEX IDX_C5B81ECE4EC001D1 (season_id), INDEX IDX_C5B81ECED07ECCB6 (advert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, advert_id INT NOT NULL, name VARCHAR(255) NOT NULL, main_photo TINYINT(1) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_14B78418D07ECCB6 (advert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price (id INT AUTO_INCREMENT NOT NULL, advert_id INT NOT NULL, season_id INT NOT NULL, duration_id INT NOT NULL, price INT NOT NULL, INDEX IDX_CAC822D9D07ECCB6 (advert_id), INDEX IDX_CAC822D94EC001D1 (season_id), INDEX IDX_CAC822D937B987D8 (duration_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price_period (price_id INT NOT NULL, period_id INT NOT NULL, INDEX IDX_8821B69ED614C7E7 (price_id), INDEX IDX_8821B69EEC8B7ADE (period_id), PRIMARY KEY(price_id, period_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, sort_id INT NOT NULL, fuel_id INT NOT NULL, mark_id INT NOT NULL, situation_id INT NOT NULL, manufacture_date DATETIME NOT NULL, beds_number INT NOT NULL, seats_number INT NOT NULL, length DOUBLE PRECISION DEFAULT NULL, height DOUBLE PRECISION DEFAULT NULL, weight INT DEFAULT NULL, power INT DEFAULT NULL, gearbox VARCHAR(25) NOT NULL, INDEX IDX_1B80E48647013001 (sort_id), INDEX IDX_1B80E48697C79677 (fuel_id), INDEX IDX_1B80E4864290F12B (mark_id), INDEX IDX_1B80E4863408E8AF (situation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle_equipment (vehicle_id INT NOT NULL, equipment_id INT NOT NULL, INDEX IDX_248790D1545317D1 (vehicle_id), INDEX IDX_248790D1517FE9FE (equipment_id), PRIMARY KEY(vehicle_id, equipment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bill (id INT AUTO_INCREMENT NOT NULL, advert_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_7A2119E3D07ECCB6 (advert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE duration (id INT AUTO_INCREMENT NOT NULL, duration VARCHAR(50) NOT NULL, days_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, equipment VARCHAR(255) NOT NULL, belonging VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel (id INT AUTO_INCREMENT NOT NULL, fuel VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mark (id INT AUTO_INCREMENT NOT NULL, mark VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, season VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sort (id INT AUTO_INCREMENT NOT NULL, sort VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, duration INT NOT NULL, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vat (id INT AUTO_INCREMENT NOT NULL, state VARCHAR(30) NOT NULL, abbreviation VARCHAR(5) NOT NULL, vat DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mail (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, receiver_id INT NOT NULL, advert_id INT DEFAULT NULL, template VARCHAR(100) NOT NULL, message LONGTEXT NOT NULL, subject VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_5126AC48F624B39D (sender_id), INDEX IDX_5126AC48CD53EDB6 (receiver_id), INDEX IDX_5126AC48D07ECCB6 (advert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, advert_id INT DEFAULT NULL, tenant_id INT DEFAULT NULL, comment LONGTEXT DEFAULT NULL, score INT DEFAULT NULL, created_at DATETIME NOT NULL, rental_beginning DATETIME NOT NULL, rental_end DATETIME NOT NULL, rental_confirmation VARCHAR(3) DEFAULT NULL, rating_approved TINYINT(1) DEFAULT NULL, response_approved TINYINT(1) DEFAULT NULL, response LONGTEXT DEFAULT NULL, type VARCHAR(6) NOT NULL, automatically_confirmed_rental TINYINT(1) DEFAULT NULL, INDEX IDX_D8892622A76ED395 (user_id), INDEX IDX_D8892622D07ECCB6 (advert_id), INDEX IDX_D88926229033212A (tenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, advert_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_68C58ED9A76ED395 (user_id), INDEX IDX_68C58ED9D07ECCB6 (advert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owner (id INT AUTO_INCREMENT NOT NULL, billing_address_id INT NOT NULL, user_id INT NOT NULL, company_name VARCHAR(50) DEFAULT NULL, company_number VARCHAR(20) DEFAULT NULL, UNIQUE INDEX UNIQ_CF60E67C79D0C0E4 (billing_address_id), UNIQUE INDEX UNIQ_CF60E67CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, phone_number VARCHAR(25) DEFAULT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(50) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_active TINYINT(1) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE advert ADD CONSTRAINT FK_54F1F40B545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE advert ADD CONSTRAINT FK_54F1F40BD1E63CD1 FOREIGN KEY (insurance_id) REFERENCES insurance (id)');
        $this->addSql('ALTER TABLE advert ADD CONSTRAINT FK_54F1F40B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
        $this->addSql('ALTER TABLE advert ADD CONSTRAINT FK_54F1F40B9A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE included_mileage ADD CONSTRAINT FK_EE4B960FD07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE included_mileage ADD CONSTRAINT FK_EE4B960F37B987D8 FOREIGN KEY (duration_id) REFERENCES duration (id)');
        $this->addSql('ALTER TABLE insurance_price ADD CONSTRAINT FK_651C18DA37B987D8 FOREIGN KEY (duration_id) REFERENCES duration (id)');
        $this->addSql('ALTER TABLE insurance_price ADD CONSTRAINT FK_651C18DAD1E63CD1 FOREIGN KEY (insurance_id) REFERENCES insurance (id)');
        $this->addSql('ALTER TABLE period ADD CONSTRAINT FK_C5B81ECE4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE period ADD CONSTRAINT FK_C5B81ECED07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D9D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D94EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D937B987D8 FOREIGN KEY (duration_id) REFERENCES duration (id)');
        $this->addSql('ALTER TABLE price_period ADD CONSTRAINT FK_8821B69ED614C7E7 FOREIGN KEY (price_id) REFERENCES price (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE price_period ADD CONSTRAINT FK_8821B69EEC8B7ADE FOREIGN KEY (period_id) REFERENCES period (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E48647013001 FOREIGN KEY (sort_id) REFERENCES sort (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E48697C79677 FOREIGN KEY (fuel_id) REFERENCES fuel (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4864290F12B FOREIGN KEY (mark_id) REFERENCES mark (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4863408E8AF FOREIGN KEY (situation_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE vehicle_equipment ADD CONSTRAINT FK_248790D1545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vehicle_equipment ADD CONSTRAINT FK_248790D1517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E3D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE mail ADD CONSTRAINT FK_5126AC48F624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mail ADD CONSTRAINT FK_5126AC48CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mail ADD CONSTRAINT FK_5126AC48D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926229033212A FOREIGN KEY (tenant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE owner ADD CONSTRAINT FK_CF60E67C79D0C0E4 FOREIGN KEY (billing_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE owner ADD CONSTRAINT FK_CF60E67CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4863408E8AF');
        $this->addSql('ALTER TABLE owner DROP FOREIGN KEY FK_CF60E67C79D0C0E4');
        $this->addSql('ALTER TABLE included_mileage DROP FOREIGN KEY FK_EE4B960FD07ECCB6');
        $this->addSql('ALTER TABLE period DROP FOREIGN KEY FK_C5B81ECED07ECCB6');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418D07ECCB6');
        $this->addSql('ALTER TABLE price DROP FOREIGN KEY FK_CAC822D9D07ECCB6');
        $this->addSql('ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E3D07ECCB6');
        $this->addSql('ALTER TABLE mail DROP FOREIGN KEY FK_5126AC48D07ECCB6');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622D07ECCB6');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9D07ECCB6');
        $this->addSql('ALTER TABLE advert DROP FOREIGN KEY FK_54F1F40BD1E63CD1');
        $this->addSql('ALTER TABLE insurance_price DROP FOREIGN KEY FK_651C18DAD1E63CD1');
        $this->addSql('ALTER TABLE price_period DROP FOREIGN KEY FK_8821B69EEC8B7ADE');
        $this->addSql('ALTER TABLE price_period DROP FOREIGN KEY FK_8821B69ED614C7E7');
        $this->addSql('ALTER TABLE advert DROP FOREIGN KEY FK_54F1F40B545317D1');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE545317D1');
        $this->addSql('ALTER TABLE vehicle_equipment DROP FOREIGN KEY FK_248790D1545317D1');
        $this->addSql('ALTER TABLE included_mileage DROP FOREIGN KEY FK_EE4B960F37B987D8');
        $this->addSql('ALTER TABLE insurance_price DROP FOREIGN KEY FK_651C18DA37B987D8');
        $this->addSql('ALTER TABLE price DROP FOREIGN KEY FK_CAC822D937B987D8');
        $this->addSql('ALTER TABLE vehicle_equipment DROP FOREIGN KEY FK_248790D1517FE9FE');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E48697C79677');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4864290F12B');
        $this->addSql('ALTER TABLE period DROP FOREIGN KEY FK_C5B81ECE4EC001D1');
        $this->addSql('ALTER TABLE price DROP FOREIGN KEY FK_CAC822D94EC001D1');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E48647013001');
        $this->addSql('ALTER TABLE advert DROP FOREIGN KEY FK_54F1F40B9A1887DC');
        $this->addSql('ALTER TABLE advert DROP FOREIGN KEY FK_54F1F40B7E3C61F9');
        $this->addSql('ALTER TABLE mail DROP FOREIGN KEY FK_5126AC48F624B39D');
        $this->addSql('ALTER TABLE mail DROP FOREIGN KEY FK_5126AC48CD53EDB6');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622A76ED395');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D88926229033212A');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9A76ED395');
        $this->addSql('ALTER TABLE owner DROP FOREIGN KEY FK_CF60E67CA76ED395');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE advert');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE included_mileage');
        $this->addSql('DROP TABLE insurance');
        $this->addSql('DROP TABLE insurance_price');
        $this->addSql('DROP TABLE period');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE price');
        $this->addSql('DROP TABLE price_period');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE vehicle_equipment');
        $this->addSql('DROP TABLE bill');
        $this->addSql('DROP TABLE duration');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE fuel');
        $this->addSql('DROP TABLE mark');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE sort');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE vat');
        $this->addSql('DROP TABLE mail');
        $this->addSql('DROP TABLE rating');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE owner');
        $this->addSql('DROP TABLE user');
    }
}
