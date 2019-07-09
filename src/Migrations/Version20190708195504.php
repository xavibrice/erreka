<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190708195504 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news ADD commercial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD399507854071C FOREIGN KEY (commercial_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1DD399507854071C ON news (commercial_id)');
        $this->addSql('ALTER TABLE owner CHANGE news_id news_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B5A459A0');
        $this->addSql('DROP INDEX IDX_8D93D649B5A459A0 ON user');
        $this->addSql('ALTER TABLE user DROP news_id, CHANGE company_id company_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD399507854071C');
        $this->addSql('DROP INDEX IDX_1DD399507854071C ON news');
        $this->addSql('ALTER TABLE news DROP commercial_id');
        $this->addSql('ALTER TABLE owner CHANGE news_id news_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD news_id INT DEFAULT NULL, CHANGE company_id company_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649B5A459A0 ON user (news_id)');
    }
}
