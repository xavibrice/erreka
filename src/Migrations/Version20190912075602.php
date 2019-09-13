<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190912075602 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE note_commercial (id INT AUTO_INCREMENT NOT NULL, commercial_id INT DEFAULT NULL, note VARCHAR(255) NOT NULL, notice_data DATE NOT NULL, INDEX IDX_16F4DA9E7854071C (commercial_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE note_commercial ADD CONSTRAINT FK_16F4DA9E7854071C FOREIGN KEY (commercial_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE company_id company_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE news CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE owner_id owner_id INT DEFAULT NULL, CHANGE zone_id zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reason CHANGE news_id news_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE note_commercial');
        $this->addSql('ALTER TABLE news CHANGE commercial_id commercial_id INT DEFAULT NULL, CHANGE owner_id owner_id INT DEFAULT NULL, CHANGE zone_id zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reason CHANGE news_id news_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE company_id company_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
