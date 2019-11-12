<?php

declare(strict_types=1);

use Phalcon\Config;

return new Config([
    'database' => [
        'dbname'    => 'documents',
        'driver'    => 'pdo_mysql',
        'user'      => 'root',
        'password'  => 'Qwerty1!',
        'host'      => 'percona.mynet',
    ],
]);
