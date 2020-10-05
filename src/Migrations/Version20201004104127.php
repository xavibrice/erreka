<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201004104127 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rate_housing ADD size_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D22498DA827 FOREIGN KEY (size_id) REFERENCES size (id)');
        $this->addSql('CREATE INDEX IDX_21430D22498DA827 ON rate_housing (size_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D22498DA827');
        $this->addSql('DROP INDEX IDX_21430D22498DA827 ON rate_housing');
        $this->addSql('ALTER TABLE rate_housing DROP size_id');
    }
}
