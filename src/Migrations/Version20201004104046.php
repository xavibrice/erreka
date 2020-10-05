<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201004104046 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE size (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rate_housing CHANGE storage_room storage_room TINYINT(1) DEFAULT NULL, CHANGE direct_garage direct_garage TINYINT(1) DEFAULT NULL, CHANGE disabled_access disabled_access TINYINT(1) DEFAULT NULL, CHANGE zero_dimension zero_dimension TINYINT(1) DEFAULT NULL, CHANGE pets pets TINYINT(1) DEFAULT NULL, CHANGE exterior_cooking exterior_cooking TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE size');
        $this->addSql('ALTER TABLE rate_housing CHANGE storage_room storage_room TINYINT(1) NOT NULL, CHANGE direct_garage direct_garage TINYINT(1) NOT NULL, CHANGE disabled_access disabled_access TINYINT(1) NOT NULL, CHANGE zero_dimension zero_dimension TINYINT(1) NOT NULL, CHANGE pets pets TINYINT(1) NOT NULL, CHANGE exterior_cooking exterior_cooking TINYINT(1) NOT NULL');
    }
}
