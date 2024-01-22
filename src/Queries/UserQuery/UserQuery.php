<?php

namespace App\Queries\UserQuery;

class UserQuery
{
    // Queries preconfiguradas
    const SQL_GENERIC = "SELECT
                            user.id AS id,
                            user.email AS email,
                            user.roles AS roles,
                            user.full_name AS full_name,
                            user.last_name AS last_name,
                            user.password AS password,
                            user.username_in_chess AS username_in_chess,
                            user.jwt_token AS token
                            FROM user";

    // Métodos Repository Class
    public function __construct() {
        return $this;
    }
    public function getSQL() {
        return self::SQL_GENERIC;
    }


}