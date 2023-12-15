<?php

namespace App\Queries\PlayerQuery;

class PlayerQuery
{
    // Queries preconfiguradas
    const SQL_GENERIC = "SELECT
                            player.id AS p_id,
                            player.username_in_chess AS p_username_in_chess,
                            player.phone AS p_status,
                            player.soft_delete AS p_deleted,
                            player.user AS p_user
                            FROM Player";

    // Métodos Repository Class
    public function __construct() {
        return $this;
    }
    public function getSQL() {
        return self::SQL_GENERIC;
    }


}