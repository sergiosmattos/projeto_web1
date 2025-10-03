<?php

$db_host = getenv('DB_HOST') ?: 'localhost';

$pdo = new PDO(
    'mysql:host=' . $db_host . ';dbname=dbProjetoWeb1;charset=utf8mb4',
    'root',
    'root',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
    
);
