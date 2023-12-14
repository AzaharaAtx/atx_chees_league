<?php

namespace App\Queries\LeagueQuery;

class LeagueQuery
{
    // Queries preconfiguradas
    const SQL_GENERIC = "SELECT
                            league.id AS l_id,
                            league.league_name AS l_name_league,
                            league.status AS l_status,
                            league.start_date AS l_start_date,
                            league.end_date AS l_end_date
                            FROM League";

    // Métodos Repository Class
    public function __construct() {
        return $this;
    }
    public function getSQL() {
        return self::SQL_GENERIC;
    }


}