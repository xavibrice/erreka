<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201002111519 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE type_local (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stays (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rate_housing ADD type_local_id INT DEFAULT NULL, ADD stays_id INT DEFAULT NULL, ADD shop_windows INT DEFAULT NULL, ADD plants INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D2290A506FD FOREIGN KEY (type_local_id) REFERENCES type_local (id)');
        $this->addSql('ALTER TABLE rate_housing ADD CONSTRAINT FK_21430D22883AF033 FOREIGN KEY (stays_id) REFERENCES stays (id)');
        $this->addSql('CREATE INDEX IDX_21430D2290A506FD ON rate_housing (type_local_id)');
        $this->addSql('CREATE INDEX IDX_21430D22883AF033 ON rate_housing (stays_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D2290A506FD');
        $this->addSql('ALTER TABLE rate_housing DROP FOREIGN KEY FK_21430D22883AF033');
        $this->addSql('DROP TABLE type_local');
        $this->addSql('DROP TABLE stays');
        $this->addSql('DROP INDEX IDX_21430D2290A506FD ON rate_housing');
        $this->addSql('DROP INDEX IDX_21430D22883AF033 ON rate_housing');
        $this->addSql('ALTER TABLE rate_housing DROP type_local_id, DROP stays_id, DROP shop_windows, DROP plants');
    }
}
