<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231215104504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE league_player (id INT AUTO_INCREMENT NOT NULL, id_league_fk_id INT NOT NULL, current_points INT DEFAULT NULL, wins_number INT DEFAULT NULL, defeats_number INT DEFAULT NULL, ties_number INT DEFAULT NULL, INDEX IDX_57D40213F15B8394 (id_league_fk_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE league_player_player (league_player_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_507B543CCBA9AC01 (league_player_id), INDEX IDX_507B543C99E6F5DF (player_id), PRIMARY KEY(league_player_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE league_player ADD CONSTRAINT FK_57D40213F15B8394 FOREIGN KEY (id_league_fk_id) REFERENCES league (id)');
        $this->addSql('ALTER TABLE league_player_player ADD CONSTRAINT FK_507B543CCBA9AC01 FOREIGN KEY (league_player_id) REFERENCES league_player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE league_player_player ADD CONSTRAINT FK_507B543C99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE league ADD winner_league VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE round ADD id_league_fk_id INT NOT NULL, ADD round_number INT DEFAULT NULL');
        $this->addSql('ALTER TABLE round ADD CONSTRAINT FK_C5EEEA34F15B8394 FOREIGN KEY (id_league_fk_id) REFERENCES league (id)');
        $this->addSql('CREATE INDEX IDX_C5EEEA34F15B8394 ON round (id_league_fk_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE league_player DROP FOREIGN KEY FK_57D40213F15B8394');
        $this->addSql('ALTER TABLE league_player_player DROP FOREIGN KEY FK_507B543CCBA9AC01');
        $this->addSql('ALTER TABLE league_player_player DROP FOREIGN KEY FK_507B543C99E6F5DF');
        $this->addSql('DROP TABLE league_player');
        $this->addSql('DROP TABLE league_player_player');
        $this->addSql('ALTER TABLE round DROP FOREIGN KEY FK_C5EEEA34F15B8394');
        $this->addSql('DROP INDEX IDX_C5EEEA34F15B8394 ON round');
        $this->addSql('ALTER TABLE round DROP id_league_fk_id, DROP round_number');
        $this->addSql('ALTER TABLE league DROP winner_league');
    }
}
