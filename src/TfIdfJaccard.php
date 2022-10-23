<?php

namespace Afrizalmy\TextSearch;

use Afrizalmy\TextSearch\jaccard\PerhitunganJaccard;
use Afrizalmy\TextSearch\tfidf\TextProcessing;
use Afrizalmy\TextSearch\tfidf\PerhitunganTfIdf;


class TfIdfJaccard
{
    private array $document;
    private string $query;
    private array $hasilTfidf;
    private array $data;

    /**
     * Inisialisasi dokumen
     *
     * @param array $doc
     * @return TfIdfJaccard
     */
    public function document(array $doc): TfIdfJaccard
    {
        $this->document = $doc;
        return $this;
    }

    /**
     * Inisialisasi query
     *
     * @param string $q
     * @return TfIdfJaccard
     */
    public function query(string $q): TfIdfJaccard
    {
        $this->query = $q;
        return $this;
    }

    /**
     * Function proses text processing
     *
     * @param array $arr
     * @return array
     */
    private function textProcessing(array $arr): array
    {
        $textprosessing = new TextProcessing;
        $casefolding = $textprosessing->caseFolding($arr);
        $tokenize = $textprosessing->tokenize($casefolding);
        $stopword = $textprosessing->stopword($tokenize);
        $stemming = $textprosessing->stemmer($stopword);
        // echo json_encode($stemming).PHP_EOL;
        return $stemming;
    }

    /**
     * Function proses perhitungan TF-IDF
     *
     * @param array $str
     * @return array
     */
    public function HitungTFIDF(): array
    {
        $str = $this->array_insert($this->document, 0, $this->query);
        $textpro = $this->textProcessing($str);
        $tfidf = new PerhitunganTfIdf($textpro);
        $hasil = $tfidf->hitungTfIdf();
        $this->hasilTfidf = $hasil['hasil'];
        $this->data = $hasil['data'];
        return $hasil;
    }

    /**
     * Proses input query ke index 0 (buat perhitungan tf-idf)
     *
     * @param array $arr
     * @param integer $index
     * @param string $val
     * @return array
     */
    private function array_insert(array $arr,int $index,string $val): array
    {
        if (is_string($index))
            $index = array_search($index, array_keys($arr));
        if (is_array($val))
            array_splice($arr, $index, 0, [$index => $val]);
        else
            array_splice($arr, $index, 0, $val);
        return $arr;
    }

    /**
     * Proses perhitungan jaccard
     *
     * @return array
     */
    public function HitungJaccard(): array
    {
        $jc = new PerhitunganJaccard($this->hasilTfidf, $this->data);
        return $jc->hitungJaccard();
        
    }
}
