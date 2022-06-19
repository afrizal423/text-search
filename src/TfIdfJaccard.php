<?php
namespace Afrizalmy\TIJ;

use Afrizalmy\TIJ\tfidf\TextProcessing;
use Afrizalmy\TIJ\tfidf\PerhitunganTfIdf;

class TfIdfJaccard 
{
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
        // var_dump($stemming);
        return $stemming;
    }
 
    /**
     * Function proses perhitungan TF-IDF
     *
     * @param array $str
     * @return array
     */
    public function HitungTFIDF(array $str): array
    {
        $textpro = $this->textProcessing($str);
        $tfidf = new PerhitunganTfIdf($textpro);
        $hasil = $tfidf->hitungTfIdf();
        return $hasil;
    }

    
}
