<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231215110703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE league_player_player DROP FOREIGN KEY FK_507B543C99E6F5DF');
        $this->addSql('ALTER TABLE league_player_player DROP FOREIGN KEY FK_507B543CCBA9AC01');
        $this->addSql('DROP TABLE league_player_player');
        $this->addSql('ALTER TABLE player DROP last_seen');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE league_player_player (league_player_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_507B543CCBA9AC01 (league_player_id), INDEX IDX_507B543C99E6F5DF (player_id), PRIMARY KEY(league_player_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE league_player_player ADD CONSTRAINT FK_507B543C99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE league_player_player ADD CONSTRAINT FK_507B543CCBA9AC01 FOREIGN KEY (league_player_id) REFERENCES league_player (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player ADD last_seen DATETIME DEFAULT NULL');
    }
}
