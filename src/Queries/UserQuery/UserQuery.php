<?php

namespace App\Queries\UserQuery;

class UserQuery
{
    // Queries preconfiguradas
    const SQL_GENERIC = "SELECT
                            user.id AS u_id,
                            user.email AS u_email,
                            user.roles AS u_role,
                            user.user_role AS u_user_role,
                            user.user_player AS u_user_player,
                            user.full_name AS u_username,
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