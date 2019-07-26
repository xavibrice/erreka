<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190723214743 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE owner DROP FOREIGN KEY FK_CF60E67CB5A459A0');
        $this->addSql('DROP INDEX IDX_CF60E67CB5A459A0 ON owner');
        $this->addSql('ALTER TABLE owner DROP news_id');
        $this->addSql('ALTER TABLE news ADD owner_id INT DEFAULT NULL, CHANGE commercial_id commercial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD399507E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
        $this->addSql('CREATE INDEX IDX_1DD399507E3C61F9 ON news (owner_id)');
        $this->addSql('ALTER TABLE user CHANGE company_id company_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE zone CHANGE news_id news_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD399507E3C61F9');
        $this->addSql('DROP INDEX IDX_1DD399507E3C61F9 ON news');
        $this->addSql('ALTER TABLE news DROP owner_id, CHANGE commercial_id commercial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE owner ADD news_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE owner ADD CONSTRAINT FK_CF60E67CB5A459A0 FOREIGN KEY (news_id) REFERENCES news (id)');
        $this->addSql('CREATE INDEX IDX_CF60E67CB5A459A0 ON owner (news_id)');
        $this->addSql('ALTER TABLE user CHANGE company_id company_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
        $this->addSql('ALTER TABLE zone CHANGE news_id news_id INT DEFAULT NULL');
    }
}
