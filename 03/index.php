<?php

require_once __DIR__ . '/BookmarksManager.php';

$bookmarksManager = new BookmarksManager();

$bookmarksManager->loadBookmarksFromCsv();

// var_dump($bookmarksManager->findAll());

// var_dump($bookmarksManager->findOneById(1));
