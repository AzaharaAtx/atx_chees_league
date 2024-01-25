<?php

namespace App\Queries\GameQuery;

class GameQuery
{
    // Queries preconfiguradas
    const SQL_GENERIC = "SELECT
                            game.id AS id,
                            game.id_round_fk_id AS round_fk_id,
                            game.status AS status,
                            game.white_player_fk_id AS white_player_fk,
                            game.black_player_fk_id AS black_player_fk
                            FROM Game";

    // Métodos Repository Class
    public function __construct() {
        return $this;
    }
    public function getSQL() {
        return self::SQL_GENERIC;
    }


}