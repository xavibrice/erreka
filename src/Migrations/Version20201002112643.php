<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201002112643 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE local_garage_location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rate_housing ADD local_garage_location_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D225F1E9674 FOREIGN KEY (local_garage_location_id) REFERENCES local_garage_location (id)');
        $this->addSql('CREATE INDEX IDX_21430D225F1E9674 ON rate_housing (local_garage_location_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D225F1E9674');
        $this->addSql('DROP TABLE local_garage_location');
        $this->addSql('DROP INDEX IDX_21430D225F1E9674 ON rate_housing');
        $this->addSql('ALTER TABLE rate_housing DROP local_garage_location_id');
    }
}
