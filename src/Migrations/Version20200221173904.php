<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200221173904 extends AbstractMigration
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
        $this->addSql('CREATE TABLE bedrooms (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, commercial_id INT DEFAULT NULL, begin_at DATETIME NOT NULL, end_at DATETIME DEFAULT NULL, title VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT NULL, text_color VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_E00CEDDE7854071C (commercial_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE building_structure (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE charge (id INT AUTO_INCREMENT NOT NULL, charge_type_id INT DEFAULT NULL, property_id INT DEFAULT NULL, state_keys_id INT DEFAULT NULL, price NUMERIC(10, 0) DEFAULT NULL, price_ok NUMERIC(10, 0) DEFAULT NULL, expiration_date DATE DEFAULT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, INDEX IDX_556BA43491A77836 (charge_type_id), UNIQUE INDEX UNIQ_556BA434549213EC (property_id), INDEX IDX_556BA4341ECCB2C0 (state_keys_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE charge_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, heating_id INT DEFAULT NULL, orientation_id INT DEFAULT NULL, commercial_id INT DEFAULT NULL, type_property_id INT DEFAULT NULL, bedrooms_id INT DEFAULT NULL, building_structure_id INT DEFAULT NULL, zone_one_id INT DEFAULT NULL, zone_two_id INT DEFAULT NULL, zone_three_id INT DEFAULT NULL, reason_id INT DEFAULT NULL, full_name VARCHAR(255) NOT NULL, price NUMERIC(10, 0) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, mobile VARCHAR(255) DEFAULT NULL, comment LONGTEXT DEFAULT NULL, created DATE DEFAULT NULL, terrace TINYINT(1) DEFAULT NULL, direct_garage TINYINT(1) DEFAULT NULL, storage_room TINYINT(1) DEFAULT NULL, disabled_access TINYINT(1) DEFAULT NULL, zero_dimension TINYINT(1) DEFAULT NULL, elevator TINYINT(1) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, income NUMERIC(10, 0) DEFAULT NULL, pets TINYINT(1) DEFAULT NULL, balcony TINYINT(1) DEFAULT NULL, INDEX IDX_C7440455520F822 (heating_id), INDEX IDX_C74404555545372F (orientation_id), INDEX IDX_C74404557854071C (commercial_id), INDEX IDX_C74404551F8BC47D (type_property_id), INDEX IDX_C7440455BE7F364B (bedrooms_id), INDEX IDX_C7440455BECD3E04 (building_structure_id), INDEX IDX_C7440455C489E661 (zone_one_id), INDEX IDX_C7440455AFD501AE (zone_two_id), INDEX IDX_C74404555F1D81F8 (zone_three_id), INDEX IDX_C744045559BB1592 (reason_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE door (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE energy_certificate (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ground (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE heating (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historical (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, rate_housing_id INT DEFAULT NULL, name_image VARCHAR(255) DEFAULT NULL, INDEX IDX_E01FBE6A7F339F8 (rate_housing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note_commercial (id INT AUTO_INCREMENT NOT NULL, commercial_id INT DEFAULT NULL, note LONGTEXT NOT NULL, notice_date DATETIME NOT NULL, INDEX IDX_16F4DA9E7854071C (commercial_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note_new (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, note LONGTEXT DEFAULT NULL, notice_date DATE NOT NULL, INDEX IDX_1B1064A5549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offered (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, client_id INT DEFAULT NULL, comment LONGTEXT DEFAULT NULL, price LONGTEXT DEFAULT NULL, created DATE DEFAULT NULL, INDEX IDX_21950C74549213EC (property_id), INDEX IDX_21950C7419EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orientation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, street_id INT DEFAULT NULL, reason_id INT DEFAULT NULL, type_property_id INT DEFAULT NULL, commercial_id INT DEFAULT NULL, rate_housing_id INT DEFAULT NULL, historical_id INT DEFAULT NULL, full_name VARCHAR(255) DEFAULT NULL, mobile VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, price NUMERIC(10, 0) DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, comment LONGTEXT DEFAULT NULL, created DATE NOT NULL, portal VARCHAR(255) DEFAULT NULL, floor VARCHAR(255) DEFAULT NULL, url LONGTEXT DEFAULT NULL, reference CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', phone VARCHAR(255) DEFAULT NULL, next_call DATE DEFAULT NULL, INDEX IDX_8BF21CDE87CF8EB (street_id), INDEX IDX_8BF21CDE59BB1592 (reason_id), INDEX IDX_8BF21CDE1F8BC47D (type_property_id), INDEX IDX_8BF21CDE7854071C (commercial_id), INDEX IDX_8BF21CDE7F339F8 (rate_housing_id), INDEX IDX_8BF21CDEC75EAE06 (historical_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_reduction (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, price NUMERIC(10, 0) NOT NULL, reduction_date DATE NOT NULL, reduction_next_date DATE DEFAULT NULL, last_price NUMERIC(10, 0) NOT NULL, percentage DOUBLE PRECISION NOT NULL, INDEX IDX_C00856D5549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposal (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, client_id INT DEFAULT NULL, price NUMERIC(10, 0) NOT NULL, agree TINYINT(1) DEFAULT NULL, contract DATE DEFAULT NULL, scriptures DATE DEFAULT NULL, created DATE NOT NULL, INDEX IDX_BFE59472549213EC (property_id), INDEX IDX_BFE5947219EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rate_housing (id INT AUTO_INCREMENT NOT NULL, bathroom_state_id INT DEFAULT NULL, been_cooking_id INT DEFAULT NULL, windows_state_id INT DEFAULT NULL, been_walls_id INT DEFAULT NULL, doors_state_id INT DEFAULT NULL, ground_state_id INT DEFAULT NULL, heating_id INT DEFAULT NULL, window_id INT DEFAULT NULL, door_id INT DEFAULT NULL, orientation_id INT DEFAULT NULL, energy_certificate_id INT DEFAULT NULL, wall_id INT DEFAULT NULL, ground_id INT DEFAULT NULL, building_structure_id INT DEFAULT NULL, visited DATE NOT NULL, comment LONGTEXT DEFAULT NULL, min_price NUMERIC(10, 0) DEFAULT NULL, max_price NUMERIC(10, 0) DEFAULT NULL, bedrooms INT DEFAULT NULL, bathrooms INT DEFAULT NULL, real_meters INT DEFAULT NULL, storage_room TINYINT(1) NOT NULL, direct_garage TINYINT(1) NOT NULL, disabled_access TINYINT(1) NOT NULL, zero_dimension TINYINT(1) NOT NULL, elevator TINYINT(1) DEFAULT NULL, terrace TINYINT(1) DEFAULT NULL, alarm_system TINYINT(1) DEFAULT NULL, automatic_door TINYINT(1) DEFAULT NULL, air_conditioning TINYINT(1) DEFAULT NULL, antiquity INT DEFAULT NULL, community_expenses NUMERIC(10, 0) DEFAULT NULL, pending_spills LONGTEXT DEFAULT NULL, amount_pending_spills NUMERIC(10, 0) DEFAULT NULL, spills_future LONGTEXT DEFAULT NULL, administrator VARCHAR(255) DEFAULT NULL, mobile_administrator VARCHAR(255) DEFAULT NULL, pets TINYINT(1) NOT NULL, exterior_bedrooms INT DEFAULT NULL, patio_bedrooms INT DEFAULT NULL, exterior_bathrooms INT DEFAULT NULL, exterior_cooking TINYINT(1) NOT NULL, energy_consumption NUMERIC(10, 2) DEFAULT NULL, balcony TINYINT(1) DEFAULT NULL, INDEX IDX_21430D2260F1BE35 (bathroom_state_id), INDEX IDX_21430D22394F640 (been_cooking_id), INDEX IDX_21430D222ED4DF49 (windows_state_id), INDEX IDX_21430D22DA462B74 (been_walls_id), INDEX IDX_21430D2241AE3D41 (doors_state_id), INDEX IDX_21430D228738B342 (ground_state_id), INDEX IDX_21430D22520F822 (heating_id), INDEX IDX_21430D2281091F4D (window_id), INDEX IDX_21430D2258639EAE (door_id), INDEX IDX_21430D225545372F (orientation_id), INDEX IDX_21430D22C3AA8EA7 (energy_certificate_id), INDEX IDX_21430D22C33923F1 (wall_id), INDEX IDX_21430D221D297B0A (ground_id), INDEX IDX_21430D22BECD3E04 (building_structure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reason (id INT AUTO_INCREMENT NOT NULL, situation_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_3BB8880C3408E8AF (situation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE situation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, UNIQUE INDEX UNIQ_EC2D9ACA5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state_keys (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE street (id INT AUTO_INCREMENT NOT NULL, zone_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_F0EED3D89F2C3FAB (zone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_property (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_property TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, agency_id INT DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, image_filename VARCHAR(255) DEFAULT NULL, active TINYINT(1) NOT NULL, mobile VARCHAR(255) NOT NULL, full_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D649CDEADB2A (agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valuation_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visit (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, client_id INT DEFAULT NULL, visited DATE DEFAULT NULL, price NUMERIC(10, 0) DEFAULT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_437EE939549213EC (property_id), INDEX IDX_437EE93919EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wall (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE window (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, agency_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_A0EBC007CDEADB2A (agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE7854071C FOREIGN KEY (commercial_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE charge ADD CONSTRAINT FK_556BA43491A77836 FOREIGN KEY (charge_type_id) REFERENCES charge_type (id)');
        $this->addSql('ALTER TABLE charge ADD CONSTRAINT FK_556BA434549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE charge ADD CONSTRAINT FK_556BA4341ECCB2C0 FOREIGN KEY (state_keys_id) REFERENCES state_keys (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455520F822 FOREIGN KEY (heating_id) REFERENCES heating (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404555545372F FOREIGN KEY (orientation_id) REFERENCES orientation (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404557854071C FOREIGN KEY (commercial_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404551F8BC47D FOREIGN KEY (type_property_id) REFERENCES type_property (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BE7F364B FOREIGN KEY (bedrooms_id) REFERENCES bedrooms (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BECD3E04 FOREIGN KEY (building_structure_id) REFERENCES building_structure (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455C489E661 FOREIGN KEY (zone_one_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455AFD501AE FOREIGN KEY (zone_two_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404555F1D81F8 FOREIGN KEY (zone_three_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045559BB1592 FOREIGN KEY (reason_id) REFERENCES reason (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A7F339F8 FOREIGN KEY (rate_housing_id) REFERENCES rate_housing (id)');
        $this->addSql('ALTER TABLE note_commercial ADD CONSTRAINT FK_16F4DA9E7854071C FOREIGN KEY (commercial_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note_new ADD CONSTRAINT FK_1B1064A5549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE offered ADD CONSTRAINT FK_21950C74549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE offered ADD CONSTRAINT FK_21950C7419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE87CF8EB FOREIGN KEY (street_id) REFERENCES street (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE59BB1592 FOREIGN KEY (reason_id) REFERENCES reason (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE1F8BC47D FOREIGN KEY (type_property_id) REFERENCES type_property (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE7854071C FOREIGN KEY (commercial_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE7F339F8 FOREIGN KEY (rate_housing_id) REFERENCES rate_housing (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEC75EAE06 FOREIGN KEY (historical_id) REFERENCES historical (id)');
        $this->addSql('ALTER TABLE property_reduction ADD CONSTRAINT FK_C00856D5549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE proposal ADD CONSTRAINT FK_BFE59472549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE proposal ADD CONSTRAINT FK_BFE5947219EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
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
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D22C33923F1 FOREIGN KEY (wall_id) REFERENCES wall (id)');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D221D297B0A FOREIGN KEY (ground_id) REFERENCES ground (id)');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D22BECD3E04 FOREIGN KEY (building_structure_id) REFERENCES building_structure (id)');
        $this->addSql('ALTER TABLE reason ADD CONSTRAINT FK_3BB8880C3408E8AF FOREIGN KEY (situation_id) REFERENCES situation (id)');
        $this->addSql('ALTER TABLE street ADD CONSTRAINT FK_F0EED3D89F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE939549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE93919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE zone ADD CONSTRAINT FK_A0EBC007CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CDEADB2A');
        $this->addSql('ALTER TABLE zone DROP FOREIGN KEY FK_A0EBC007CDEADB2A');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BE7F364B');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BECD3E04');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D22BECD3E04');
        $this->addSql('ALTER TABLE charge DROP FOREIGN KEY FK_556BA43491A77836');
        $this->addSql('ALTER TABLE offered DROP FOREIGN KEY FK_21950C7419EB6921');
        $this->addSql('ALTER TABLE proposal DROP FOREIGN KEY FK_BFE5947219EB6921');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE93919EB6921');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D2258639EAE');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D22C3AA8EA7');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D221D297B0A');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455520F822');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D22520F822');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEC75EAE06');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404555545372F');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D225545372F');
        $this->addSql('ALTER TABLE charge DROP FOREIGN KEY FK_556BA434549213EC');
        $this->addSql('ALTER TABLE note_new DROP FOREIGN KEY FK_1B1064A5549213EC');
        $this->addSql('ALTER TABLE offered DROP FOREIGN KEY FK_21950C74549213EC');
        $this->addSql('ALTER TABLE property_reduction DROP FOREIGN KEY FK_C00856D5549213EC');
        $this->addSql('ALTER TABLE proposal DROP FOREIGN KEY FK_BFE59472549213EC');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE939549213EC');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A7F339F8');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE7F339F8');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045559BB1592');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE59BB1592');
        $this->addSql('ALTER TABLE reason DROP FOREIGN KEY FK_3BB8880C3408E8AF');
        $this->addSql('ALTER TABLE charge DROP FOREIGN KEY FK_556BA4341ECCB2C0');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE87CF8EB');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404551F8BC47D');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE1F8BC47D');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE7854071C');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404557854071C');
        $this->addSql('ALTER TABLE note_commercial DROP FOREIGN KEY FK_16F4DA9E7854071C');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE7854071C');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D2260F1BE35');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D22394F640');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D222ED4DF49');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D22DA462B74');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D2241AE3D41');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D228738B342');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D22C33923F1');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D2281091F4D');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455C489E661');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455AFD501AE');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404555F1D81F8');
        $this->addSql('ALTER TABLE street DROP FOREIGN KEY FK_F0EED3D89F2C3FAB');
        $this->addSql('DROP TABLE agency');
        $this->addSql('DROP TABLE bedrooms');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE building_structure');
        $this->addSql('DROP TABLE charge');
        $this->addSql('DROP TABLE charge_type');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE door');
        $this->addSql('DROP TABLE energy_certificate');
        $this->addSql('DROP TABLE ground');
        $this->addSql('DROP TABLE heating');
        $this->addSql('DROP TABLE historical');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE note_commercial');
        $this->addSql('DROP TABLE note_new');
        $this->addSql('DROP TABLE offered');
        $this->addSql('DROP TABLE orientation');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE property_reduction');
        $this->addSql('DROP TABLE proposal');
        $this->addSql('DROP TABLE rate_housing');
        $this->addSql('DROP TABLE reason');
        $this->addSql('DROP TABLE situation');
        $this->addSql('DROP TABLE state_keys');
        $this->addSql('DROP TABLE street');
        $this->addSql('DROP TABLE type_property');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE valuation_status');
        $this->addSql('DROP TABLE visit');
        $this->addSql('DROP TABLE wall');
        $this->addSql('DROP TABLE window');
        $this->addSql('DROP TABLE zone');
    }
}
