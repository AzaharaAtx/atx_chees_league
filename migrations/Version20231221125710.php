<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231221125710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE league_player DROP FOREIGN KEY FK_57D4021339C417E4');
        $this->addSql('DROP INDEX IDX_57D4021339C417E4 ON league_player');
        $this->addSql('ALTER TABLE league_player ADD id_user_fk_id INT DEFAULT NULL, DROP id_player_fk_id');
        $this->addSql('ALTER TABLE league_player ADD CONSTRAINT FK_57D40213E23F625F FOREIGN KEY (id_user_fk_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_57D40213E23F625F ON league_player (id_user_fk_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE league_player DROP FOREIGN KEY FK_57D40213E23F625F');
        $this->addSql('DROP INDEX IDX_57D40213E23F625F ON league_player');
        $this->addSql('ALTER TABLE league_player ADD id_player_fk_id INT NOT NULL, DROP id_user_fk_id');
        $this->addSql('ALTER TABLE league_player ADD CONSTRAINT FK_57D4021339C417E4 FOREIGN KEY (id_player_fk_id) REFERENCES player (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_57D4021339C417E4 ON league_player (id_player_fk_id)');
    }
}
