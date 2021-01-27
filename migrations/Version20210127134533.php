<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210127134533 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_97A0ADA312469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ticket AS SELECT id, category_id, title, description, created_at, updated_at FROM ticket');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('CREATE TABLE ticket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CONSTRAINT FK_97A0ADA312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO ticket (id, category_id, title, description, created_at, updated_at) SELECT id, category_id, title, description, created_at, updated_at FROM __temp__ticket');
        $this->addSql('DROP TABLE __temp__ticket');
        $this->addSql('CREATE INDEX IDX_97A0ADA312469DE2 ON ticket (category_id)');
        $this->addSql('DROP INDEX IDX_BF48C371700047D2');
        $this->addSql('DROP INDEX IDX_BF48C371A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ticket_user AS SELECT ticket_id, user_id FROM ticket_user');
        $this->addSql('DROP TABLE ticket_user');
        $this->addSql('CREATE TABLE ticket_user (ticket_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(ticket_id, user_id), CONSTRAINT FK_BF48C371700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_BF48C371A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO ticket_user (ticket_id, user_id) SELECT ticket_id, user_id FROM __temp__ticket_user');
        $this->addSql('DROP TABLE __temp__ticket_user');
        $this->addSql('CREATE INDEX IDX_BF48C371700047D2 ON ticket_user (ticket_id)');
        $this->addSql('CREATE INDEX IDX_BF48C371A76ED395 ON ticket_user (user_id)');
        $this->addSql('ALTER TABLE user ADD COLUMN email VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_97A0ADA312469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ticket AS SELECT id, category_id, title, description, created_at, updated_at FROM ticket');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('CREATE TABLE ticket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL)');
        $this->addSql('INSERT INTO ticket (id, category_id, title, description, created_at, updated_at) SELECT id, category_id, title, description, created_at, updated_at FROM __temp__ticket');
        $this->addSql('DROP TABLE __temp__ticket');
        $this->addSql('CREATE INDEX IDX_97A0ADA312469DE2 ON ticket (category_id)');
        $this->addSql('DROP INDEX IDX_BF48C371700047D2');
        $this->addSql('DROP INDEX IDX_BF48C371A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ticket_user AS SELECT ticket_id, user_id FROM ticket_user');
        $this->addSql('DROP TABLE ticket_user');
        $this->addSql('CREATE TABLE ticket_user (ticket_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(ticket_id, user_id))');
        $this->addSql('INSERT INTO ticket_user (ticket_id, user_id) SELECT ticket_id, user_id FROM __temp__ticket_user');
        $this->addSql('DROP TABLE __temp__ticket_user');
        $this->addSql('CREATE INDEX IDX_BF48C371700047D2 ON ticket_user (ticket_id)');
        $this->addSql('CREATE INDEX IDX_BF48C371A76ED395 ON ticket_user (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, username) SELECT id, username FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }
}
