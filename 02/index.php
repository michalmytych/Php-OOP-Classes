<?php

require_once __DIR__ . '/BookmarksManager.php';

$bookmarksManager = new BookmarksManager();

$bookmarksManager->loadDataFromCsv();

// var_dump($bookmarksManager->findAll());

// var_dump($bookmarksManager->findOneById(1));
