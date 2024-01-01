<?php

namespace App\Queries\GameQuery;

class GameQuery
{
    // Queries preconfiguradas
    const SQL_GENERIC = "SELECT
                            game.id AS g_id,
                            game.id_round_fk_id AS g_round_fk_id,
                            game.status AS g_status,
                            game.white_player_fk_id AS g_white_player_fk,
                            game.black_player_fk_id AS g_black_player_fk,
                            game.soft_delete AS g_deleted
                            FROM Game";

    // Métodos Repository Class
    public function __construct() {
        return $this;
    }
    public function getSQL() {
        return self::SQL_GENERIC;
    }


}