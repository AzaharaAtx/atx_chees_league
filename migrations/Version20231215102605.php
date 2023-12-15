<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231215102605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game ADD id_round_fk_id INT NOT NULL, ADD white_player_fk_id INT NOT NULL, ADD black_player_fk_id INT NOT NULL, DROP type_game');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C6B16C0DE FOREIGN KEY (id_round_fk_id) REFERENCES round (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CF5E6D29E FOREIGN KEY (white_player_fk_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C2B5C9234 FOREIGN KEY (black_player_fk_id) REFERENCES player (id)');
        $this->addSql('CREATE INDEX IDX_232B318C6B16C0DE ON game (id_round_fk_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318CF5E6D29E ON game (white_player_fk_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318C2B5C9234 ON game (black_player_fk_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C6B16C0DE');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CF5E6D29E');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C2B5C9234');
        $this->addSql('DROP INDEX IDX_232B318C6B16C0DE ON game');
        $this->addSql('DROP INDEX UNIQ_232B318CF5E6D29E ON game');
        $this->addSql('DROP INDEX UNIQ_232B318C2B5C9234 ON game');
        $this->addSql('ALTER TABLE game ADD type_game VARCHAR(50) DEFAULT NULL, DROP id_round_fk_id, DROP white_player_fk_id, DROP black_player_fk_id');
    }
}
