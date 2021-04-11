<?php

require_once __DIR__ . '/CsvLoader.php';
require_once __DIR__ . '/XmlLoader.php';

class BookmarksManager
{
    private const csvDataFileURI = __DIR__ . '/bookmarks.csv';

    private const xmlDataFileURI = __DIR__ . '/bookmarks.xml';

    private array $bookmarksData = array();

    private CsvLoader $csvBookmarksLoader;

    private XmlLoader $xmlBookmarksLoader;

    public function findAll() : array
    {
        return $this->bookmarksData;
    }

    public function findOneById(int $searchedId) : ?array
    {
        $i = array_search(strval($searchedId), array_column($this->bookmarksData, 'id'));
        return ($i !== false ? $this->bookmarksData[$i] : null);
    }

    public function loadBookmarksFromCsv() : void
    {
        $this->csvBookmarksLoader = new CsvLoader(self::csvDataFileURI);
        $this->bookmarksData = $this->csvBookmarksLoader->loadDataFromCsvFile();
    }

    public function loadBookmarksFromXML() : void
    {
        $this->xmlBookmarksLoader = new XmlLoader(self::xmlDataFileURI);
        $this->bookmarksData = $this->xmlBookmarksLoader->loadDataFromXmlFile();
    }

    public function getBookmarksFromDatabase() : void
    {
        /**
         * @todo
         * zaimplementować metodę
         */
    }
}
