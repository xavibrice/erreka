<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201023103659 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE migration_versions');
        $this->addSql('ALTER TABLE client ADD type_local_id INT DEFAULT NULL, ADD stays_id INT DEFAULT NULL, ADD local_garage_location_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045590A506FD FOREIGN KEY (type_local_id) REFERENCES type_local (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455883AF033 FOREIGN KEY (stays_id) REFERENCES stays (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404555F1E9674 FOREIGN KEY (local_garage_location_id) REFERENCES local_garage_location (id)');
        $this->addSql('CREATE INDEX IDX_C744045590A506FD ON client (type_local_id)');
        $this->addSql('CREATE INDEX IDX_C7440455883AF033 ON client (stays_id)');
        $this->addSql('CREATE INDEX IDX_C74404555F1E9674 ON client (local_garage_location_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE migration_versions (version VARCHAR(14) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, executed_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(version)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045590A506FD');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455883AF033');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404555F1E9674');
        $this->addSql('DROP INDEX IDX_C744045590A506FD ON client');
        $this->addSql('DROP INDEX IDX_C7440455883AF033 ON client');
        $this->addSql('DROP INDEX IDX_C74404555F1E9674 ON client');
        $this->addSql('ALTER TABLE client DROP type_local_id, DROP stays_id, DROP local_garage_location_id');
    }
}
