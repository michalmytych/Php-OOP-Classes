<?php

require_once __DIR__ . '/DatabaseConnector.php';

$conn = new DatabaseConnector();

var_dump($conn->getConnection());