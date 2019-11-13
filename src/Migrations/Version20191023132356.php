<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191023132356 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rate_housing DROP living_room, DROP balcony, DROP terrace, DROP pantry, DROP fitted_wardrobes, DROP security_door, CHANGE bathroom_state_id bathroom_state_id INT DEFAULT NULL, CHANGE been_cooking_id been_cooking_id INT DEFAULT NULL, CHANGE windows_state_id windows_state_id INT DEFAULT NULL, CHANGE been_walls_id been_walls_id INT DEFAULT NULL, CHANGE doors_state_id doors_state_id INT DEFAULT NULL, CHANGE ground_state_id ground_state_id INT DEFAULT NULL, CHANGE property_id property_id INT DEFAULT NULL, CHANGE heating_id heating_id INT DEFAULT NULL, CHANGE window_id window_id INT DEFAULT NULL, CHANGE door_id door_id INT DEFAULT NULL, CHANGE min_price min_price NUMERIC(10, 2) DEFAULT NULL, CHANGE max_price max_price NUMERIC(10, 2) DEFAULT NULL, CHANGE pets pets TINYINT(1) DEFAULT NULL, CHANGE bedrooms bedrooms INT DEFAULT NULL, CHANGE bathrooms bathrooms INT DEFAULT NULL, CHANGE approx_meters approx_meters INT DEFAULT NULL, CHANGE real_meters real_meters INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking CHANGE end_at end_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE client CHANGE price price NUMERIC(10, 2) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE mobile mobile VARCHAR(255) DEFAULT NULL, CHANGE created created DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE property CHANGE street_id street_id INT DEFAULT NULL, CHANGE reason_id reason_id INT DEFAULT NULL, CHANGE type_property_id type_property_id INT DEFAULT NULL, CHANGE state_property_id state_property_id INT DEFAULT NULL, CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE full_name full_name VARCHAR(255) DEFAULT NULL, CHANGE mobile mobile VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE price price NUMERIC(10, 2) DEFAULT NULL, CHANGE enabled enabled TINYINT(1) DEFAULT NULL, CHANGE portal portal VARCHAR(255) DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE note_commercial CHANGE commercial_id commercial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note_new CHANGE property_id property_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reason CHANGE situation_id situation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE street CHANGE zone_id zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE agency_id agency_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE image_filename image_filename VARCHAR(255) DEFAULT NULL, CHANGE full_name full_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE zone CHANGE agency_id agency_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE property_reduction CHANGE property_id property_id INT DEFAULT NULL, CHANGE reduction_next_date reduction_next_date DATE DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking CHANGE end_at end_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE client CHANGE price price NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE email email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE mobile mobile VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE created created DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE note_commercial CHANGE commercial_id commercial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note_new CHANGE property_id property_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE property CHANGE street_id street_id INT DEFAULT NULL, CHANGE reason_id reason_id INT DEFAULT NULL, CHANGE type_property_id type_property_id INT DEFAULT NULL, CHANGE state_property_id state_property_id INT DEFAULT NULL, CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE full_name full_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE mobile mobile VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE email email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE price price NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE enabled enabled TINYINT(1) DEFAULT \'NULL\', CHANGE portal portal VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE floor floor VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE property_reduction CHANGE property_id property_id INT DEFAULT NULL, CHANGE reduction_next_date reduction_next_date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE rate_housing ADD living_room TINYINT(1) NOT NULL, ADD balcony TINYINT(1) NOT NULL, ADD terrace TINYINT(1) NOT NULL, ADD pantry TINYINT(1) NOT NULL, ADD fitted_wardrobes TINYINT(1) NOT NULL, ADD security_door TINYINT(1) NOT NULL, CHANGE property_id property_id INT DEFAULT NULL, CHANGE bathroom_state_id bathroom_state_id INT DEFAULT NULL, CHANGE been_cooking_id been_cooking_id INT DEFAULT NULL, CHANGE windows_state_id windows_state_id INT DEFAULT NULL, CHANGE been_walls_id been_walls_id INT DEFAULT NULL, CHANGE doors_state_id doors_state_id INT DEFAULT NULL, CHANGE ground_state_id ground_state_id INT DEFAULT NULL, CHANGE heating_id heating_id INT DEFAULT NULL, CHANGE window_id window_id INT DEFAULT NULL, CHANGE door_id door_id INT DEFAULT NULL, CHANGE min_price min_price NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE max_price max_price NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE pets pets TINYINT(1) DEFAULT \'NULL\', CHANGE bedrooms bedrooms INT DEFAULT NULL, CHANGE bathrooms bathrooms INT DEFAULT NULL, CHANGE approx_meters approx_meters INT DEFAULT NULL, CHANGE real_meters real_meters INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reason CHANGE situation_id situation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE street CHANGE zone_id zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE agency_id agency_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE image_filename image_filename VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE full_name full_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE zone CHANGE agency_id agency_id INT DEFAULT NULL');
    }
}
