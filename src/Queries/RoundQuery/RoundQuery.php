<?php

namespace App\Queries\RoundQuery;

class RoundQuery
{
    // Queries preconfiguradas
    const SQL_GENERIC = "SELECT
                            round.id AS r_id,
                            round.soft_delete AS r_soft_delete,
                            round.id_league_fk_id AS r_id_league_fk,
                            round.round_number AS r_round_number
                            FROM Round";

    // Métodos Repository Class
    public function __construct() {
        return $this;
    }
    public function getSQL() {
        return self::SQL_GENERIC;
    }


}