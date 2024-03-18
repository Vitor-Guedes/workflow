<?php

use App\DatabaseManager;

include_once __DIR__ . '/vendor/autoload.php';

$sql = file_get_contents(__DIR__ . '/database.sql');
DatabaseManager::getSingletonWithoutDatabase()->getPdo()->exec($sql);