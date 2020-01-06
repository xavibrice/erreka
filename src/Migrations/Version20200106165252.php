<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200106165252 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE charge ADD property_id INT DEFAULT NULL, CHANGE charge_type_id charge_type_id INT DEFAULT NULL, CHANGE price price NUMERIC(10, 0) DEFAULT NULL, CHANGE price_ok price_ok NUMERIC(10, 0) DEFAULT NULL, CHANGE expiration_date expiration_date DATE DEFAULT NULL, CHANGE end_date end_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE charge ADD CONSTRAINT FK_556BA434549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_556BA434549213EC ON charge (property_id)');
        $this->addSql('ALTER TABLE booking CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE end_at end_at DATETIME DEFAULT NULL, CHANGE color color VARCHAR(255) DEFAULT NULL, CHANGE text_color text_color VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE client CHANGE heating_id heating_id INT DEFAULT NULL, CHANGE orientation_id orientation_id INT DEFAULT NULL, CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE type_property_id type_property_id INT DEFAULT NULL, CHANGE price price NUMERIC(10, 0) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE mobile mobile VARCHAR(255) DEFAULT NULL, CHANGE created created DATE DEFAULT NULL, CHANGE real_meters real_meters INT DEFAULT NULL, CHANGE bedrooms bedrooms INT DEFAULT NULL, CHANGE bathrooms bathrooms INT DEFAULT NULL, CHANGE terrace terrace TINYINT(1) DEFAULT NULL, CHANGE suit_bathroom suit_bathroom TINYINT(1) DEFAULT NULL, CHANGE direct_garage direct_garage TINYINT(1) DEFAULT NULL, CHANGE video_intercom video_intercom TINYINT(1) DEFAULT NULL, CHANGE storage_room storage_room TINYINT(1) DEFAULT NULL, CHANGE disabled_access disabled_access TINYINT(1) DEFAULT NULL, CHANGE zero_dimension zero_dimension TINYINT(1) DEFAULT NULL, CHANGE elevator elevator TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE energy_certificate CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE images CHANGE rate_housing_id rate_housing_id INT DEFAULT NULL, CHANGE name_image name_image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE note_commercial CHANGE commercial_id commercial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note_new CHANGE property_id property_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offered CHANGE property_id property_id INT DEFAULT NULL, CHANGE client_id client_id INT DEFAULT NULL, CHANGE created created DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE property CHANGE street_id street_id INT DEFAULT NULL, CHANGE reason_id reason_id INT DEFAULT NULL, CHANGE type_property_id type_property_id INT DEFAULT NULL, CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE rate_housing_id rate_housing_id INT DEFAULT NULL, CHANGE historical_id historical_id INT DEFAULT NULL, CHANGE charge_id charge_id INT DEFAULT NULL, CHANGE full_name full_name VARCHAR(255) DEFAULT NULL, CHANGE mobile mobile VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE price price NUMERIC(10, 0) DEFAULT NULL, CHANGE enabled enabled TINYINT(1) DEFAULT NULL, CHANGE portal portal VARCHAR(255) DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE property_reduction CHANGE property_id property_id INT DEFAULT NULL, CHANGE reduction_next_date reduction_next_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE rate_housing CHANGE bathroom_state_id bathroom_state_id INT DEFAULT NULL, CHANGE been_cooking_id been_cooking_id INT DEFAULT NULL, CHANGE windows_state_id windows_state_id INT DEFAULT NULL, CHANGE been_walls_id been_walls_id INT DEFAULT NULL, CHANGE doors_state_id doors_state_id INT DEFAULT NULL, CHANGE ground_state_id ground_state_id INT DEFAULT NULL, CHANGE heating_id heating_id INT DEFAULT NULL, CHANGE window_id window_id INT DEFAULT NULL, CHANGE door_id door_id INT DEFAULT NULL, CHANGE orientation_id orientation_id INT DEFAULT NULL, CHANGE energy_certificate_id energy_certificate_id INT DEFAULT NULL, CHANGE state_keys_id state_keys_id INT DEFAULT NULL, CHANGE min_price min_price NUMERIC(10, 0) DEFAULT NULL, CHANGE max_price max_price NUMERIC(10, 0) DEFAULT NULL, CHANGE bedrooms bedrooms INT DEFAULT NULL, CHANGE bathrooms bathrooms INT DEFAULT NULL, CHANGE real_meters real_meters INT DEFAULT NULL, CHANGE elevator elevator TINYINT(1) DEFAULT NULL, CHANGE terrace terrace TINYINT(1) DEFAULT NULL, CHANGE alarm_system alarm_system TINYINT(1) DEFAULT NULL, CHANGE automatic_door automatic_door TINYINT(1) DEFAULT NULL, CHANGE air_conditioning air_conditioning TINYINT(1) DEFAULT NULL, CHANGE antiquity antiquity INT DEFAULT NULL, CHANGE community_expenses community_expenses NUMERIC(10, 0) DEFAULT NULL, CHANGE amount_pending_spills amount_pending_spills NUMERIC(10, 0) DEFAULT NULL, CHANGE administrator administrator VARCHAR(255) DEFAULT NULL, CHANGE mobile_administrator mobile_administrator VARCHAR(255) DEFAULT NULL, CHANGE exterior_bedrooms exterior_bedrooms INT DEFAULT NULL, CHANGE patio_bedrooms patio_bedrooms INT DEFAULT NULL, CHANGE exterior_bathrooms exterior_bathrooms INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reason CHANGE situation_id situation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE street CHANGE zone_id zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE agency_id agency_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE image_filename image_filename VARCHAR(255) DEFAULT NULL, CHANGE full_name full_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE visit CHANGE property_id property_id INT DEFAULT NULL, CHANGE client_id client_id INT DEFAULT NULL, CHANGE visited visited DATE DEFAULT NULL, CHANGE price price NUMERIC(10, 0) DEFAULT NULL');
        $this->addSql('ALTER TABLE zone CHANGE agency_id agency_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE end_at end_at DATETIME DEFAULT \'NULL\', CHANGE color color VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE text_color text_color VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE charge DROP FOREIGN KEY FK_556BA434549213EC');
        $this->addSql('DROP INDEX UNIQ_556BA434549213EC ON charge');
        $this->addSql('ALTER TABLE charge DROP property_id, CHANGE charge_type_id charge_type_id INT DEFAULT NULL, CHANGE price price NUMERIC(10, 0) DEFAULT \'NULL\', CHANGE price_ok price_ok NUMERIC(10, 0) DEFAULT \'NULL\', CHANGE expiration_date expiration_date DATE DEFAULT \'NULL\', CHANGE end_date end_date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE client CHANGE heating_id heating_id INT DEFAULT NULL, CHANGE orientation_id orientation_id INT DEFAULT NULL, CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE type_property_id type_property_id INT DEFAULT NULL, CHANGE price price NUMERIC(10, 0) DEFAULT \'NULL\', CHANGE email email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE mobile mobile VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE created created DATE DEFAULT \'NULL\', CHANGE real_meters real_meters INT DEFAULT NULL, CHANGE bedrooms bedrooms INT DEFAULT NULL, CHANGE bathrooms bathrooms INT DEFAULT NULL, CHANGE terrace terrace TINYINT(1) DEFAULT \'NULL\', CHANGE suit_bathroom suit_bathroom TINYINT(1) DEFAULT \'NULL\', CHANGE direct_garage direct_garage TINYINT(1) DEFAULT \'NULL\', CHANGE video_intercom video_intercom TINYINT(1) DEFAULT \'NULL\', CHANGE storage_room storage_room TINYINT(1) DEFAULT \'NULL\', CHANGE disabled_access disabled_access TINYINT(1) DEFAULT \'NULL\', CHANGE zero_dimension zero_dimension TINYINT(1) DEFAULT \'NULL\', CHANGE elevator elevator TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE energy_certificate CHANGE name name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE images CHANGE rate_housing_id rate_housing_id INT DEFAULT NULL, CHANGE name_image name_image VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE note_commercial CHANGE commercial_id commercial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note_new CHANGE property_id property_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offered CHANGE property_id property_id INT DEFAULT NULL, CHANGE client_id client_id INT DEFAULT NULL, CHANGE created created DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE property CHANGE street_id street_id INT DEFAULT NULL, CHANGE reason_id reason_id INT DEFAULT NULL, CHANGE type_property_id type_property_id INT DEFAULT NULL, CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE rate_housing_id rate_housing_id INT DEFAULT NULL, CHANGE historical_id historical_id INT DEFAULT NULL, CHANGE charge_id charge_id INT DEFAULT NULL, CHANGE full_name full_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE mobile mobile VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE email email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE price price NUMERIC(10, 0) DEFAULT \'NULL\', CHANGE enabled enabled TINYINT(1) DEFAULT \'NULL\', CHANGE portal portal VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE floor floor VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE property_reduction CHANGE property_id property_id INT DEFAULT NULL, CHANGE reduction_next_date reduction_next_date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE rate_housing CHANGE bathroom_state_id bathroom_state_id INT DEFAULT NULL, CHANGE been_cooking_id been_cooking_id INT DEFAULT NULL, CHANGE windows_state_id windows_state_id INT DEFAULT NULL, CHANGE been_walls_id been_walls_id INT DEFAULT NULL, CHANGE doors_state_id doors_state_id INT DEFAULT NULL, CHANGE ground_state_id ground_state_id INT DEFAULT NULL, CHANGE heating_id heating_id INT DEFAULT NULL, CHANGE window_id window_id INT DEFAULT NULL, CHANGE door_id door_id INT DEFAULT NULL, CHANGE orientation_id orientation_id INT DEFAULT NULL, CHANGE energy_certificate_id energy_certificate_id INT DEFAULT NULL, CHANGE state_keys_id state_keys_id INT DEFAULT NULL, CHANGE min_price min_price NUMERIC(10, 0) DEFAULT \'NULL\', CHANGE max_price max_price NUMERIC(10, 0) DEFAULT \'NULL\', CHANGE bedrooms bedrooms INT DEFAULT NULL, CHANGE bathrooms bathrooms INT DEFAULT NULL, CHANGE real_meters real_meters INT DEFAULT NULL, CHANGE elevator elevator TINYINT(1) DEFAULT \'NULL\', CHANGE terrace terrace TINYINT(1) DEFAULT \'NULL\', CHANGE alarm_system alarm_system TINYINT(1) DEFAULT \'NULL\', CHANGE automatic_door automatic_door TINYINT(1) DEFAULT \'NULL\', CHANGE air_conditioning air_conditioning TINYINT(1) DEFAULT \'NULL\', CHANGE antiquity antiquity INT DEFAULT NULL, CHANGE community_expenses community_expenses NUMERIC(10, 0) DEFAULT \'NULL\', CHANGE amount_pending_spills amount_pending_spills NUMERIC(10, 0) DEFAULT \'NULL\', CHANGE administrator administrator VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE mobile_administrator mobile_administrator VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE exterior_bedrooms exterior_bedrooms INT DEFAULT NULL, CHANGE patio_bedrooms patio_bedrooms INT DEFAULT NULL, CHANGE exterior_bathrooms exterior_bathrooms INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reason CHANGE situation_id situation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE street CHANGE zone_id zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE agency_id agency_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE image_filename image_filename VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE full_name full_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE visit CHANGE property_id property_id INT DEFAULT NULL, CHANGE client_id client_id INT DEFAULT NULL, CHANGE visited visited DATE DEFAULT \'NULL\', CHANGE price price NUMERIC(10, 0) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE zone CHANGE agency_id agency_id INT DEFAULT NULL');
    }
}