<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241001123303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL COMMENT \'(DC2Type:json)\', ADD username VARCHAR(100) NOT NULL, DROP firstname, DROP lastname, DROP admin, CHANGE mail mail VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_MAIL ON user (mail)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_MAIL ON user');
        $this->addSql('ALTER TABLE user ADD lastname VARCHAR(100) NOT NULL, ADD admin TINYINT(1) NOT NULL, DROP roles, CHANGE mail mail VARCHAR(255) NOT NULL, CHANGE username firstname VARCHAR(100) NOT NULL');
    }
}
