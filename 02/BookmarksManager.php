<?php

class BookmarksManager
{
    private const dataFileURI = __DIR__ . '/bookmarks.csv';

    private array $bookmarksData = array();

    public function findAll() : array
    {
        return $this->bookmarksData;
    }

    public function findOneById(int $searchedId) : ?array
    {
        $i = array_search(strval($searchedId), array_column($this->bookmarksData, 'id'));
        return ($i !== false ? $this->bookmarksData[$i] : null);
    }

    public function loadDataFromCsv() : void
    {
        $headers = array();
        $data = array();
        if (($handle = fopen(self::dataFileURI, "r")) !== FALSE) {
            $headersParsed = FALSE;
            while (($row = fgetcsv($handle, 0, ",", '\'')) !== FALSE) {
                if ($headersParsed) {
                    $data[] = $this->extractRecords($headers, $row);
                } else {
                    $headers = $this->prepareHeaders($row);
                    $headersParsed = TRUE;
                }
            }
            fclose($handle);
        }
        $this->bookmarksData = $data;
    }

    private function prepareHeaders(array $row) : array
    {
        return array_map('strtolower', $row);
    }

    private function extractRecords(array $headers, array $row) : array
    {
        $tmp = array();
        $i = 0;
        for ($size = count($headers); $i < $size; $i++) {
            if ($i == $size - 1) {
                $tmp[$headers[$i]] = explode(',', $row[$i]);
            }
            else {
                $tmp[$headers[$i]] = $row[$i];
            }
        }
        return $tmp;
    }
}

/**
@todo
1. array_filter()
2. Rozłożyć na osobne funkcje
private function prepareHeaders(array $row) : array
private function extractRecord($headers, $row) : array
3. Wczytywanie z XML
4. Wczytywanie z bazy danych MySQL
5. Relacje w programowaniu obiektowym (jest, ma)
6. Kompozycja w praktyce
7. Polimorfizm
8. Różnice między require_once(), require() oraz include() i include_once()
9. Nadpisywanie metod, słowo kluczowe parent::
10. Metody abstrakcyjne
11. Myślenie projektowe w programowaniu
12. 3 typy relacji typu ma: Asocjacja, Kompozycja, Agregacja
 */