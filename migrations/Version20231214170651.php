<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214170651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A6558AFC4DE');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65E48FD905');
        $this->addSql('ALTER TABLE league DROP FOREIGN KEY FK_3EB4C318A93DA36D');
        $this->addSql('ALTER TABLE league DROP FOREIGN KEY FK_3EB4C318F6DBB035');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C8C071AA');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CA6005CA0');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CD89A78F9');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CF6DBB035');
        $this->addSql('ALTER TABLE game_user DROP FOREIGN KEY FK_6686BA65A76ED395');
        $this->addSql('ALTER TABLE game_user DROP FOREIGN KEY FK_6686BA65E48FD905');
        $this->addSql('ALTER TABLE round_user DROP FOREIGN KEY FK_2824C7E9A6005CA0');
        $this->addSql('ALTER TABLE round_user DROP FOREIGN KEY FK_2824C7E9A76ED395');
        $this->addSql('ALTER TABLE league_player DROP FOREIGN KEY FK_57D4021358AFC4DE');
        $this->addSql('ALTER TABLE league_player DROP FOREIGN KEY FK_57D4021399E6F5DF');
        $this->addSql('ALTER TABLE round_player DROP FOREIGN KEY FK_5CAE43C999E6F5DF');
        $this->addSql('ALTER TABLE round_player DROP FOREIGN KEY FK_5CAE43C9A6005CA0');
        $this->addSql('ALTER TABLE game_player DROP FOREIGN KEY FK_E52CD7AD99E6F5DF');
        $this->addSql('ALTER TABLE game_player DROP FOREIGN KEY FK_E52CD7ADE48FD905');
        $this->addSql('ALTER TABLE round DROP FOREIGN KEY FK_C5EEEA34D89A78F9');
        $this->addSql('ALTER TABLE round DROP FOREIGN KEY FK_C5EEEA34E085AD71');
        $this->addSql('DROP TABLE league');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_user');
        $this->addSql('DROP TABLE round_user');
        $this->addSql('DROP TABLE league_player');
        $this->addSql('DROP TABLE round_player');
        $this->addSql('DROP TABLE game_player');
        $this->addSql('DROP TABLE round');
        $this->addSql('DROP INDEX UNIQ_98197A6558AFC4DE ON player');
        $this->addSql('DROP INDEX UNIQ_98197A65E48FD905 ON player');
        $this->addSql('ALTER TABLE player DROP league_id, DROP game_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE league (id INT AUTO_INCREMENT NOT NULL, winner_league_id INT DEFAULT NULL, id_round_id INT DEFAULT NULL, name_league VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, start_date_league DATETIME DEFAULT NULL, end_date_league DATETIME DEFAULT NULL, end_date_participate DATETIME DEFAULT NULL, soft_delete SMALLINT DEFAULT NULL, UNIQUE INDEX UNIQ_3EB4C318A93DA36D (winner_league_id), UNIQUE INDEX UNIQ_3EB4C318F6DBB035 (id_round_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, winner_game_id INT DEFAULT NULL, id_round_id INT DEFAULT NULL, id_league_id INT DEFAULT NULL, round_id INT DEFAULT NULL, type_game VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, start_date_game DATETIME DEFAULT NULL, end_date_game DATETIME DEFAULT NULL, classification INT DEFAULT NULL, soft_delete SMALLINT DEFAULT NULL, color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_232B318CF6DBB035 (id_round_id), UNIQUE INDEX UNIQ_232B318CD89A78F9 (id_league_id), INDEX IDX_232B318CA6005CA0 (round_id), UNIQUE INDEX UNIQ_232B318C8C071AA (winner_game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE game_user (game_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_6686BA65E48FD905 (game_id), INDEX IDX_6686BA65A76ED395 (user_id), PRIMARY KEY(game_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE round_user (round_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_2824C7E9A6005CA0 (round_id), INDEX IDX_2824C7E9A76ED395 (user_id), PRIMARY KEY(round_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE league_player (league_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_57D4021358AFC4DE (league_id), INDEX IDX_57D4021399E6F5DF (player_id), PRIMARY KEY(league_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE round_player (round_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_5CAE43C9A6005CA0 (round_id), INDEX IDX_5CAE43C999E6F5DF (player_id), PRIMARY KEY(round_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE game_player (game_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_E52CD7ADE48FD905 (game_id), INDEX IDX_E52CD7AD99E6F5DF (player_id), PRIMARY KEY(game_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE round (id INT AUTO_INCREMENT NOT NULL, winner_round_id INT DEFAULT NULL, id_league_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_C5EEEA34E085AD71 (winner_round_id), INDEX IDX_C5EEEA34D89A78F9 (id_league_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE league ADD CONSTRAINT FK_3EB4C318A93DA36D FOREIGN KEY (winner_league_id) REFERENCES player (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE league ADD CONSTRAINT FK_3EB4C318F6DBB035 FOREIGN KEY (id_round_id) REFERENCES round (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C8C071AA FOREIGN KEY (winner_game_id) REFERENCES player (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CA6005CA0 FOREIGN KEY (round_id) REFERENCES round (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CD89A78F9 FOREIGN KEY (id_league_id) REFERENCES league (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CF6DBB035 FOREIGN KEY (id_round_id) REFERENCES round (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE game_user ADD CONSTRAINT FK_6686BA65A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_user ADD CONSTRAINT FK_6686BA65E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE round_user ADD CONSTRAINT FK_2824C7E9A6005CA0 FOREIGN KEY (round_id) REFERENCES round (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE round_user ADD CONSTRAINT FK_2824C7E9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE league_player ADD CONSTRAINT FK_57D4021358AFC4DE FOREIGN KEY (league_id) REFERENCES league (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE league_player ADD CONSTRAINT FK_57D4021399E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE round_player ADD CONSTRAINT FK_5CAE43C999E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE round_player ADD CONSTRAINT FK_5CAE43C9A6005CA0 FOREIGN KEY (round_id) REFERENCES round (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_player ADD CONSTRAINT FK_E52CD7AD99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_player ADD CONSTRAINT FK_E52CD7ADE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE round ADD CONSTRAINT FK_C5EEEA34D89A78F9 FOREIGN KEY (id_league_id) REFERENCES league (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE round ADD CONSTRAINT FK_C5EEEA34E085AD71 FOREIGN KEY (winner_round_id) REFERENCES player (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE player ADD league_id INT DEFAULT NULL, ADD game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A6558AFC4DE FOREIGN KEY (league_id) REFERENCES league (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98197A6558AFC4DE ON player (league_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98197A65E48FD905 ON player (game_id)');
    }
}
