<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190919142834 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE zone_id zone_id INT DEFAULT NULL, CHANGE reason_id reason_id INT DEFAULT NULL, CHANGE situation_id situation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note_commercial CHANGE commercial_id commercial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE street CHANGE zone_id zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD image_filename VARCHAR(255) DEFAULT NULL, CHANGE company_id company_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE zone_id zone_id INT DEFAULT NULL, CHANGE reason_id reason_id INT DEFAULT NULL, CHANGE situation_id situation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note_commercial CHANGE commercial_id commercial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE street CHANGE zone_id zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP image_filename, CHANGE company_id company_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
