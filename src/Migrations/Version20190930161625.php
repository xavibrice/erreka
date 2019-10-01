<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190930161625 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F79812469DE2');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143F7BFE87C');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE sub_category');
        $this->addSql('ALTER TABLE booking CHANGE end_at end_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD399503408E8AF');
        $this->addSql('DROP INDEX IDX_1DD399503408E8AF ON news');
        $this->addSql('ALTER TABLE news DROP situation_id, CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE zone_id zone_id INT DEFAULT NULL, CHANGE price price NUMERIC(10, 2) DEFAULT NULL, CHANGE first_name first_name VARCHAR(255) DEFAULT NULL, CHANGE last_name last_name VARCHAR(255) DEFAULT NULL, CHANGE mobile mobile VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE portal portal VARCHAR(255) DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE note_commercial CHANGE commercial_id commercial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note_new CHANGE new_id new_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reason CHANGE situation_id situation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE street DROP FOREIGN KEY FK_F0EED3D89F2C3FAB');
        $this->addSql('DROP INDEX IDX_F0EED3D89F2C3FAB ON street');
        $this->addSql('ALTER TABLE street DROP zone_id');
        $this->addSql('ALTER TABLE user CHANGE company_id company_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE image_filename image_filename VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, sub_category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_C0155143F7BFE87C (sub_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sub_category (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_BCE3F79812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id)');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F79812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE booking CHANGE end_at end_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE news ADD situation_id INT DEFAULT NULL, CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE zone_id zone_id INT DEFAULT NULL, CHANGE price price NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE first_name first_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE last_name last_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE mobile mobile VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE phone phone VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE email email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE portal portal VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE floor floor VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD399503408E8AF FOREIGN KEY (situation_id) REFERENCES situation (id)');
        $this->addSql('CREATE INDEX IDX_1DD399503408E8AF ON news (situation_id)');
        $this->addSql('ALTER TABLE note_commercial CHANGE commercial_id commercial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note_new CHANGE new_id new_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reason CHANGE situation_id situation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE street ADD zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE street ADD CONSTRAINT FK_F0EED3D89F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('CREATE INDEX IDX_F0EED3D89F2C3FAB ON street (zone_id)');
        $this->addSql('ALTER TABLE user CHANGE company_id company_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE image_filename image_filename VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
