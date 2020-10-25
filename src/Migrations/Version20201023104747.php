<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201023104747 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD air_conditioning TINYINT(1) DEFAULT NULL, ADD smoke_outlet TINYINT(1) DEFAULT NULL, ADD security_door TINYINT(1) DEFAULT NULL, ADD alarm_system TINYINT(1) DEFAULT NULL, ADD equipped_kitchen TINYINT(1) DEFAULT NULL, ADD corner TINYINT(1) DEFAULT NULL, ADD closed_security_circuit TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP air_conditioning, DROP smoke_outlet, DROP security_door, DROP alarm_system, DROP equipped_kitchen, DROP corner, DROP closed_security_circuit');
    }
}
