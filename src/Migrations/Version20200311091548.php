<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200311091548 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE note_commercial ADD from_commercial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note_commercial ADD CONSTRAINT FK_16F4DA9E3100068B FOREIGN KEY (from_commercial_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_16F4DA9E3100068B ON note_commercial (from_commercial_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE note_commercial DROP FOREIGN KEY FK_16F4DA9E3100068B');
        $this->addSql('DROP INDEX IDX_16F4DA9E3100068B ON note_commercial');
        $this->addSql('ALTER TABLE note_commercial DROP from_commercial_id');
    }
}
