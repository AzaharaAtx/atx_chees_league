<?php

namespace App\Queries\LeaguePlayerQuery;

class LeaguePlayerQuery
{
    // Queries preconfiguradas
    const SQL_GENERIC = "SELECT
                            leagueplayer.id AS lp_id,
                            leagueplayer.id_league_fk AS lp_id_league_fk,
                            leagueplayer.id_player_fk AS lp_id_player_fk,
                            leagueplayer.current_points AS lp_current_points,
                            leagueplayer.defeats_number AS lp_end_date,
                            leagueplayer.ties_number AS lp_ties_number
                            FROM League";

    // Métodos Repository Class
    public function __construct() {
        return $this;
    }
    public function getSQL() {
        return self::SQL_GENERIC;
    }


}