<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201023173621 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD type_storage_room_id INT DEFAULT NULL, ADD storage_room_location_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455D41FD785 FOREIGN KEY (type_storage_room_id) REFERENCES type_storage_room (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455124B8052 FOREIGN KEY (storage_room_location_id) REFERENCES storage_room_location (id)');
        $this->addSql('CREATE INDEX IDX_C7440455D41FD785 ON client (type_storage_room_id)');
        $this->addSql('CREATE INDEX IDX_C7440455124B8052 ON client (storage_room_location_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455D41FD785');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455124B8052');
        $this->addSql('DROP INDEX IDX_C7440455D41FD785 ON client');
        $this->addSql('DROP INDEX IDX_C7440455124B8052 ON client');
        $this->addSql('ALTER TABLE client DROP type_storage_room_id, DROP storage_room_location_id');
    }
}
