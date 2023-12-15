<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231215110907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE league_player ADD id_player_fk_id INT NOT NULL');
        $this->addSql('ALTER TABLE league_player ADD CONSTRAINT FK_57D4021339C417E4 FOREIGN KEY (id_player_fk_id) REFERENCES player (id)');
        $this->addSql('CREATE INDEX IDX_57D4021339C417E4 ON league_player (id_player_fk_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE league_player DROP FOREIGN KEY FK_57D4021339C417E4');
        $this->addSql('DROP INDEX IDX_57D4021339C417E4 ON league_player');
        $this->addSql('ALTER TABLE league_player DROP id_player_fk_id');
    }
}
