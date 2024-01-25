<?php

namespace App\Queries\LeaguePlayerQuery;

class LeaguePlayerQuery
{
    // Queries preconfiguradas
    const SQL_GENERIC = "SELECT
                            leagueplayer.id AS id,
                            leagueplayer.id_league_fk AS league_fk,
                            leagueplayer.id_player_fk AS id_player_fk,
                            leagueplayer.defeats_number AS defeats_number,
                            leagueplayer.wins_number AS wins_number
                            FROM league_player";

    // Métodos Repository Class
    public function __construct() {
        return $this;
    }
    public function getSQL() {
        return self::SQL_GENERIC;
    }


}