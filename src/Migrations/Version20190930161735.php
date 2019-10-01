<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190930161735 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD399509F2C3FAB');
        $this->addSql('DROP INDEX IDX_1DD399509F2C3FAB ON news');
        $this->addSql('ALTER TABLE news DROP zone_id, CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE price price NUMERIC(10, 2) DEFAULT NULL, CHANGE first_name first_name VARCHAR(255) DEFAULT NULL, CHANGE last_name last_name VARCHAR(255) DEFAULT NULL, CHANGE mobile mobile VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE portal portal VARCHAR(255) DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE booking CHANGE end_at end_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE note_commercial CHANGE commercial_id commercial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note_new CHANGE new_id new_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reason CHANGE situation_id situation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE company_id company_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE image_filename image_filename VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking CHANGE end_at end_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE news ADD zone_id INT DEFAULT NULL, CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE price price NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE first_name first_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE last_name last_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE mobile mobile VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE phone phone VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE email email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE portal portal VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE floor floor VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD399509F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('CREATE INDEX IDX_1DD399509F2C3FAB ON news (zone_id)');
        $this->addSql('ALTER TABLE note_commercial CHANGE commercial_id commercial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note_new CHANGE new_id new_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reason CHANGE situation_id situation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE company_id company_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE image_filename image_filename VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
