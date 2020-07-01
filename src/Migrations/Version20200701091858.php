<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200701091858 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE offered DROP FOREIGN KEY FK_21950C74549213EC');
        $this->addSql('DROP INDEX IDX_21950C74549213EC ON offered');
        $this->addSql('ALTER TABLE offered CHANGE property_id charge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offered ADD CONSTRAINT FK_21950C7455284914 FOREIGN KEY (charge_id) REFERENCES charge (id)');
        $this->addSql('CREATE INDEX IDX_21950C7455284914 ON offered (charge_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE offered DROP FOREIGN KEY FK_21950C7455284914');
        $this->addSql('DROP INDEX IDX_21950C7455284914 ON offered');
        $this->addSql('ALTER TABLE offered CHANGE charge_id property_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offered ADD CONSTRAINT FK_21950C74549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('CREATE INDEX IDX_21950C74549213EC ON offered (property_id)');
    }
}
