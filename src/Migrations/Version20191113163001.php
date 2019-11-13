<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191113163001 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE agency (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, begin_at DATETIME NOT NULL, end_at DATETIME DEFAULT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, heating_id INT DEFAULT NULL, orientation_id INT DEFAULT NULL, full_name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, mobile VARCHAR(255) DEFAULT NULL, comment LONGTEXT DEFAULT NULL, created DATE DEFAULT NULL, real_meters INT DEFAULT NULL, bedrooms INT DEFAULT NULL, bathrooms INT DEFAULT NULL, terrace TINYINT(1) DEFAULT NULL, suit_bathroom TINYINT(1) DEFAULT NULL, direct_garage TINYINT(1) DEFAULT NULL, video_intercom TINYINT(1) DEFAULT NULL, storage_room TINYINT(1) DEFAULT NULL, disabled_access TINYINT(1) DEFAULT NULL, zero_dimension TINYINT(1) DEFAULT NULL, elevator TINYINT(1) DEFAULT NULL, INDEX IDX_C7440455520F822 (heating_id), INDEX IDX_C74404555545372F (orientation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE door (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE energy_certificate (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE heating (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historical (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, name_image VARCHAR(255) DEFAULT NULL, INDEX IDX_E01FBE6A549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note_commercial (id INT AUTO_INCREMENT NOT NULL, commercial_id INT DEFAULT NULL, note LONGTEXT NOT NULL, notice_date DATE NOT NULL, INDEX IDX_16F4DA9E7854071C (commercial_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note_new (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, note LONGTEXT NOT NULL, notice_date DATE NOT NULL, next_call DATE NOT NULL, INDEX IDX_1B1064A5549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orientation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, street_id INT DEFAULT NULL, reason_id INT DEFAULT NULL, type_property_id INT DEFAULT NULL, commercial_id INT DEFAULT NULL, full_name VARCHAR(255) DEFAULT NULL, mobile VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, price NUMERIC(10, 0) DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, comment LONGTEXT DEFAULT NULL, created DATE NOT NULL, portal VARCHAR(255) DEFAULT NULL, floor VARCHAR(255) DEFAULT NULL, url LONGTEXT DEFAULT NULL, INDEX IDX_8BF21CDE87CF8EB (street_id), INDEX IDX_8BF21CDE59BB1592 (reason_id), INDEX IDX_8BF21CDE1F8BC47D (type_property_id), INDEX IDX_8BF21CDE7854071C (commercial_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_client (property_id INT NOT NULL, client_id INT NOT NULL, INDEX IDX_B9336B29549213EC (property_id), INDEX IDX_B9336B2919EB6921 (client_id), PRIMARY KEY(property_id, client_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_reduction (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, price NUMERIC(10, 2) NOT NULL, reduction_date DATE NOT NULL, reduction_next_date DATE DEFAULT NULL, last_price NUMERIC(10, 2) NOT NULL, percentage DOUBLE PRECISION NOT NULL, INDEX IDX_C00856D5549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rate_housing (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, bathroom_state_id INT DEFAULT NULL, been_cooking_id INT DEFAULT NULL, windows_state_id INT DEFAULT NULL, been_walls_id INT DEFAULT NULL, doors_state_id INT DEFAULT NULL, ground_state_id INT DEFAULT NULL, heating_id INT DEFAULT NULL, window_id INT DEFAULT NULL, door_id INT DEFAULT NULL, orientation_id INT DEFAULT NULL, energy_certificate_id INT DEFAULT NULL, visited DATE NOT NULL, comment LONGTEXT DEFAULT NULL, min_price NUMERIC(10, 2) DEFAULT NULL, max_price NUMERIC(10, 2) DEFAULT NULL, bedrooms INT DEFAULT NULL, bathrooms INT DEFAULT NULL, real_meters INT DEFAULT NULL, suit_bathroom TINYINT(1) NOT NULL, video_intercom TINYINT(1) NOT NULL, storage_room TINYINT(1) NOT NULL, direct_garage TINYINT(1) NOT NULL, disabled_access TINYINT(1) NOT NULL, zero_dimension TINYINT(1) NOT NULL, elevator TINYINT(1) DEFAULT NULL, terrace TINYINT(1) DEFAULT NULL, alarm_system TINYINT(1) DEFAULT NULL, automatic_door TINYINT(1) DEFAULT NULL, air_conditioning TINYINT(1) DEFAULT NULL, antiquity INT DEFAULT NULL, community_expenses NUMERIC(10, 0) DEFAULT NULL, pending_spills LONGTEXT DEFAULT NULL, amount_pending_spills NUMERIC(10, 0) DEFAULT NULL, spills_future LONGTEXT DEFAULT NULL, administrator VARCHAR(255) DEFAULT NULL, mobile_administrator VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_21430D22549213EC (property_id), INDEX IDX_21430D2260F1BE35 (bathroom_state_id), INDEX IDX_21430D22394F640 (been_cooking_id), INDEX IDX_21430D222ED4DF49 (windows_state_id), INDEX IDX_21430D22DA462B74 (been_walls_id), INDEX IDX_21430D2241AE3D41 (doors_state_id), INDEX IDX_21430D228738B342 (ground_state_id), INDEX IDX_21430D22520F822 (heating_id), INDEX IDX_21430D2281091F4D (window_id), INDEX IDX_21430D2258639EAE (door_id), INDEX IDX_21430D225545372F (orientation_id), INDEX IDX_21430D22C3AA8EA7 (energy_certificate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reason (id INT AUTO_INCREMENT NOT NULL, situation_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_3BB8880C3408E8AF (situation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE situation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, name_slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_EC2D9ACA5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE street (id INT AUTO_INCREMENT NOT NULL, zone_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_F0EED3D89F2C3FAB (zone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_property (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_property TINYINT(1) NOT NULL, name_slug VARCHAR(255) NOT NULL, template INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, agency_id INT DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, image_filename VARCHAR(255) DEFAULT NULL, active TINYINT(1) NOT NULL, mobile VARCHAR(255) NOT NULL, full_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D649CDEADB2A (agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valuation_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE window (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, agency_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_A0EBC007CDEADB2A (agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455520F822 FOREIGN KEY (heating_id) REFERENCES heating (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404555545372F FOREIGN KEY (orientation_id) REFERENCES orientation (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE note_commercial ADD CONSTRAINT FK_16F4DA9E7854071C FOREIGN KEY (commercial_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note_new ADD CONSTRAINT FK_1B1064A5549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE87CF8EB FOREIGN KEY (street_id) REFERENCES street (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE59BB1592 FOREIGN KEY (reason_id) REFERENCES reason (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE1F8BC47D FOREIGN KEY (type_property_id) REFERENCES type_property (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE7854071C FOREIGN KEY (commercial_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property_client ADD CONSTRAINT FK_B9336B29549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_client ADD CONSTRAINT FK_B9336B2919EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_reduction ADD CONSTRAINT FK_C00856D5549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D22549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D2260F1BE35 FOREIGN KEY (bathroom_state_id) REFERENCES valuation_status (id)');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D22394F640 FOREIGN KEY (been_cooking_id) REFERENCES valuation_status (id)');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D222ED4DF49 FOREIGN KEY (windows_state_id) REFERENCES valuation_status (id)');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D22DA462B74 FOREIGN KEY (been_walls_id) REFERENCES valuation_status (id)');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D2241AE3D41 FOREIGN KEY (doors_state_id) REFERENCES valuation_status (id)');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D228738B342 FOREIGN KEY (ground_state_id) REFERENCES valuation_status (id)');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D22520F822 FOREIGN KEY (heating_id) REFERENCES heating (id)');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D2281091F4D FOREIGN KEY (window_id) REFERENCES window (id)');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D2258639EAE FOREIGN KEY (door_id) REFERENCES door (id)');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D225545372F FOREIGN KEY (orientation_id) REFERENCES orientation (id)');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D22C3AA8EA7 FOREIGN KEY (energy_certificate_id) REFERENCES energy_certificate (id)');
        $this->addSql('ALTER TABLE reason ADD CONSTRAINT FK_3BB8880C3408E8AF FOREIGN KEY (situation_id) REFERENCES situation (id)');
        $this->addSql('ALTER TABLE street ADD CONSTRAINT FK_F0EED3D89F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE zone ADD CONSTRAINT FK_A0EBC007CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CDEADB2A');
        $this->addSql('ALTER TABLE zone DROP FOREIGN KEY FK_A0EBC007CDEADB2A');
        $this->addSql('ALTER TABLE property_client DROP FOREIGN KEY FK_B9336B2919EB6921');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D2258639EAE');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D22C3AA8EA7');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455520F822');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D22520F822');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404555545372F');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D225545372F');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A549213EC');
        $this->addSql('ALTER TABLE note_new DROP FOREIGN KEY FK_1B1064A5549213EC');
        $this->addSql('ALTER TABLE property_client DROP FOREIGN KEY FK_B9336B29549213EC');
        $this->addSql('ALTER TABLE property_reduction DROP FOREIGN KEY FK_C00856D5549213EC');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D22549213EC');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE59BB1592');
        $this->addSql('ALTER TABLE reason DROP FOREIGN KEY FK_3BB8880C3408E8AF');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE87CF8EB');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE1F8BC47D');
        $this->addSql('ALTER TABLE note_commercial DROP FOREIGN KEY FK_16F4DA9E7854071C');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE7854071C');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D2260F1BE35');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D22394F640');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D222ED4DF49');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D22DA462B74');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D2241AE3D41');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D228738B342');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D2281091F4D');
        $this->addSql('ALTER TABLE street DROP FOREIGN KEY FK_F0EED3D89F2C3FAB');
        $this->addSql('DROP TABLE agency');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE door');
        $this->addSql('DROP TABLE energy_certificate');
        $this->addSql('DROP TABLE heating');
        $this->addSql('DROP TABLE historical');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE note_commercial');
        $this->addSql('DROP TABLE note_new');
        $this->addSql('DROP TABLE orientation');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE property_client');
        $this->addSql('DROP TABLE property_reduction');
        $this->addSql('DROP TABLE rate_housing');
        $this->addSql('DROP TABLE reason');
        $this->addSql('DROP TABLE situation');
        $this->addSql('DROP TABLE street');
        $this->addSql('DROP TABLE type_property');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE valuation_status');
        $this->addSql('DROP TABLE window');
        $this->addSql('DROP TABLE zone');
    }
}
