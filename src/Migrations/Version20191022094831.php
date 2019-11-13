<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191022094831 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE note_new DROP FOREIGN KEY FK_1B1064A5BD06B3B3');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D22BD06B3B3');
        $this->addSql('DROP TABLE news');
        $this->addSql('ALTER TABLE booking CHANGE end_at end_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE client CHANGE price price NUMERIC(10, 2) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE mobile mobile VARCHAR(255) DEFAULT NULL, CHANGE created created DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE note_commercial CHANGE commercial_id commercial_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_1B1064A5BD06B3B3 ON note_new');
        $this->addSql('ALTER TABLE note_new DROP new_id, CHANGE property_id property_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE property CHANGE street_id street_id INT DEFAULT NULL, CHANGE reason_id reason_id INT DEFAULT NULL, CHANGE type_property_id type_property_id INT DEFAULT NULL, CHANGE state_property_id state_property_id INT DEFAULT NULL, CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE full_name full_name VARCHAR(255) DEFAULT NULL, CHANGE mobile mobile VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE price price NUMERIC(10, 2) DEFAULT NULL, CHANGE enabled enabled TINYINT(1) DEFAULT NULL, CHANGE portal portal VARCHAR(255) DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE property_reduction CHANGE property_id property_id INT DEFAULT NULL, CHANGE reduction_next_date reduction_next_date DATE DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_21430D22BD06B3B3 ON rate_housing');
        $this->addSql('ALTER TABLE rate_housing DROP new_id, CHANGE bathroom_state_id bathroom_state_id INT DEFAULT NULL, CHANGE been_cooking_id been_cooking_id INT DEFAULT NULL, CHANGE windows_state_id windows_state_id INT DEFAULT NULL, CHANGE been_walls_id been_walls_id INT DEFAULT NULL, CHANGE doors_state_id doors_state_id INT DEFAULT NULL, CHANGE ground_state_id ground_state_id INT DEFAULT NULL, CHANGE property_id property_id INT DEFAULT NULL, CHANGE min_price min_price NUMERIC(10, 2) DEFAULT NULL, CHANGE max_price max_price NUMERIC(10, 2) DEFAULT NULL, CHANGE pets pets TINYINT(1) DEFAULT NULL, CHANGE bedrooms bedrooms INT DEFAULT NULL, CHANGE bathrooms bathrooms INT DEFAULT NULL, CHANGE approx_meters approx_meters INT DEFAULT NULL, CHANGE real_meters real_meters INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reason CHANGE situation_id situation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE street CHANGE zone_id zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE agency_id agency_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE image_filename image_filename VARCHAR(255) DEFAULT NULL, CHANGE full_name full_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE zone CHANGE agency_id agency_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, commercial_id INT DEFAULT NULL, reason_id INT DEFAULT NULL, street_id INT DEFAULT NULL, historical_id INT DEFAULT NULL, price NUMERIC(10, 2) DEFAULT \'NULL\', comment LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, first_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, last_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, mobile VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, phone VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, portal VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, floor VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, created DATE NOT NULL, url LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, state TINYINT(1) NOT NULL, sale_price NUMERIC(10, 2) DEFAULT \'NULL\', sale_date DATE DEFAULT \'NULL\', INDEX IDX_1DD3995087CF8EB (street_id), INDEX IDX_1DD3995059BB1592 (reason_id), INDEX IDX_1DD399507854071C (commercial_id), INDEX IDX_1DD39950C75EAE06 (historical_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD3995059BB1592 FOREIGN KEY (reason_id) REFERENCES reason (id)');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD399507854071C FOREIGN KEY (commercial_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD3995087CF8EB FOREIGN KEY (street_id) REFERENCES street (id)');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD39950C75EAE06 FOREIGN KEY (historical_id) REFERENCES historical (id)');
        $this->addSql('ALTER TABLE booking CHANGE end_at end_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE client CHANGE price price NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE email email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE mobile mobile VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE created created DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE note_commercial CHANGE commercial_id commercial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note_new ADD new_id INT DEFAULT NULL, CHANGE property_id property_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note_new ADD CONSTRAINT FK_1B1064A5BD06B3B3 FOREIGN KEY (new_id) REFERENCES news (id)');
        $this->addSql('CREATE INDEX IDX_1B1064A5BD06B3B3 ON note_new (new_id)');
        $this->addSql('ALTER TABLE property CHANGE street_id street_id INT DEFAULT NULL, CHANGE reason_id reason_id INT DEFAULT NULL, CHANGE type_property_id type_property_id INT DEFAULT NULL, CHANGE state_property_id state_property_id INT DEFAULT NULL, CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE full_name full_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE mobile mobile VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE email email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE price price NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE enabled enabled TINYINT(1) DEFAULT \'NULL\', CHANGE portal portal VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE floor floor VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE property_reduction CHANGE property_id property_id INT DEFAULT NULL, CHANGE reduction_next_date reduction_next_date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE rate_housing ADD new_id INT DEFAULT NULL, CHANGE property_id property_id INT DEFAULT NULL, CHANGE bathroom_state_id bathroom_state_id INT DEFAULT NULL, CHANGE been_cooking_id been_cooking_id INT DEFAULT NULL, CHANGE windows_state_id windows_state_id INT DEFAULT NULL, CHANGE been_walls_id been_walls_id INT DEFAULT NULL, CHANGE doors_state_id doors_state_id INT DEFAULT NULL, CHANGE ground_state_id ground_state_id INT DEFAULT NULL, CHANGE min_price min_price NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE max_price max_price NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE pets pets TINYINT(1) DEFAULT \'NULL\', CHANGE bedrooms bedrooms INT DEFAULT NULL, CHANGE bathrooms bathrooms INT DEFAULT NULL, CHANGE approx_meters approx_meters INT DEFAULT NULL, CHANGE real_meters real_meters INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D22BD06B3B3 FOREIGN KEY (new_id) REFERENCES news (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_21430D22BD06B3B3 ON rate_housing (new_id)');
        $this->addSql('ALTER TABLE reason CHANGE situation_id situation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE street CHANGE zone_id zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE agency_id agency_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE image_filename image_filename VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE full_name full_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE zone CHANGE agency_id agency_id INT DEFAULT NULL');
    }
}
