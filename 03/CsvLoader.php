<?php

interface CsvLoaderInterface
{
    public function loadDataFromCsvFile();
}

class CsvLoader
{
    /**
     * @var string|null     - nazwa pliku (niewymagana, można określić w metodzie loadDataFromCsv())
     */
    private ?string $filename = null;

    /**
     * @var string          - jeśli nazwa pliku csv nie zostanie podana, jest defaultowana do 'data.csv'
     */
    private string $defaultFileName = 'data.csv';

    /**
     * CsvLoader constructor.
     * @param string|null $csvFileName - opcjonalna nazwa pliku csv do przetworzenia
     */
    public function __construct(?string $csvFileName)
    {
        $this->filename = $csvFileName;
    }

    /**
     * @param string|null $filename  - nazwa pliku (podana w konstruktorze lub jako parametr metody)
     * @return array                 - tablica php zawierająca wczytane rekordy z pliku csv
     */
    public function loadDataFromCsvFile(?string $filename = null) : array
    {
        if (! isset($filename)) $filename = $this->filename ?? $this->defaultFileName;
        $headers = array();
        $data = array();
        if (($handle = fopen($filename, "r")) !== FALSE) {
            $headersParsed = FALSE;
            while (($row = fgetcsv($handle, 0, ",", '\'')) !== FALSE) {
                if ($headersParsed) {
                    $data[] = $this->extractRecordsFromCsv($headers, $row);
                } else {
                    $headers = $this->prepareHeaders($row);
                    $headersParsed = TRUE;
                }
            }
            fclose($handle);
        }
        return $data;
    }

    /**
     * @param array $firstRow   - pierwszy wiersz z pliku csv zawierający nagłówki
     * @return array            - tablica zawierająca nagłówki kolumn z pliku csv
     */
    private function prepareHeaders(array $firstRow) : array
    {
        return array_map('strtolower', $firstRow);
    }

    /**
     * @param array $headers    - nagłówki kolumn z aktualnie przetwarzanego pliku csv
     * @param array $row        - aktualnie przetwarzany wiersz z pliku csv
     * @return array            - wyekstrahowany wiersz z pliku csv jako tablica php
     */
    private function extractRecordsFromCsv(array $headers, array $row) : array
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