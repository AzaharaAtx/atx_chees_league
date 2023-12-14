<?php

namespace App\Queries\UserQuery;

class UserQuery
{
    // Queries preconfiguradas
    const SQL_GENERIC = "SELECT
                            user.id AS u_id,
                            user.email AS u_email,
                            user.roles AS u_roles,
                            user.user_player_id AS u_user_player_id,
                            user.full_name AS u_full_name,
                            user.last_name AS u_last_name
                            FROM user";

    // Métodos Repository Class
    public function __construct() {
        return $this;
    }
    public function getSQL() {
        return self::SQL_GENERIC;
    }


}