<?php

namespace App\Queries\LeagueQuery;

class LeagueQuery
{
    // Queries preconfiguradas
    const SQL_GENERIC = "SELECT
                            league.id AS id,
                            league.league_name AS name_league,
                            league.status AS status,
                            league.start_date AS start_date,
                            league.end_date AS end_date,
                            league.winner_league as winner_league
                            FROM League";

    // Métodos Repository Class
    public function __construct() {
        return $this;
    }
    public function getSQL() {
        return self::SQL_GENERIC;
    }


}