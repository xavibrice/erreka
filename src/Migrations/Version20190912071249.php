<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190912071249 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD mobile VARCHAR(255) NOT NULL, ADD phone VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE owner_id owner_id INT DEFAULT NULL, CHANGE zone_id zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reason CHANGE news_id news_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE company_id company_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news DROP first_name, DROP last_name, DROP mobile, DROP phone, DROP email, CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE owner_id owner_id INT DEFAULT NULL, CHANGE zone_id zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reason CHANGE news_id news_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE company_id company_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
