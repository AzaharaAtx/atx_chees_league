<?php

use App\Kernel;
use Symfony\Component\HttpFoundation\Request;


require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};

$request = Request::createFromGlobals();

if ($_SERVER['APP_ENV'] === 'dev') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
}