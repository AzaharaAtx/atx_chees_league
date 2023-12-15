<?php

namespace App\Queries\RoundQuery;

class RoundQuery
{
    // Queries preconfiguradas
    const SQL_GENERIC = "SELECT
                            round.id AS r_id,
                            round.id_league_fk AS r_id_league_fk,
                            round.games AS r_game,
                            round.status AS r_status,
                            round.soft_delete AS r_soft_delete,
                            FROM Round";

    // Métodos Repository Class
    public function __construct() {
        return $this;
    }
    public function getSQL() {
        return self::SQL_GENERIC;
    }


}