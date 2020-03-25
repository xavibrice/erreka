<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200325123214 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking ADD title_booking_id INT DEFAULT NULL, ADD location_booking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEF27FF50 FOREIGN KEY (title_booking_id) REFERENCES title_booking (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEBA181DBF FOREIGN KEY (location_booking_id) REFERENCES location_booking (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEF27FF50 ON booking (title_booking_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEBA181DBF ON booking (location_booking_id)');
        $this->addSql('ALTER TABLE title_booking DROP FOREIGN KEY FK_A270D4A7A76ED395');
        $this->addSql('DROP INDEX IDX_A270D4A7A76ED395 ON title_booking');
        $this->addSql('ALTER TABLE title_booking DROP user_id');
        $this->addSql('ALTER TABLE location_booking DROP FOREIGN KEY FK_E49FE7AA76ED395');
        $this->addSql('DROP INDEX IDX_E49FE7AA76ED395 ON location_booking');
        $this->addSql('ALTER TABLE location_booking DROP user_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEF27FF50');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEBA181DBF');
        $this->addSql('DROP INDEX IDX_E00CEDDEF27FF50 ON booking');
        $this->addSql('DROP INDEX IDX_E00CEDDEBA181DBF ON booking');
        $this->addSql('ALTER TABLE booking DROP title_booking_id, DROP location_booking_id');
        $this->addSql('ALTER TABLE location_booking ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE location_booking ADD CONSTRAINT FK_E49FE7AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E49FE7AA76ED395 ON location_booking (user_id)');
        $this->addSql('ALTER TABLE title_booking ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE title_booking ADD CONSTRAINT FK_A270D4A7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A270D4A7A76ED395 ON title_booking (user_id)');
    }
}
