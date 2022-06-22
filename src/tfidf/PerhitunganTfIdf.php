<?php
namespace Afrizalmy\TextSearch\tfidf;

use stdClass;

class PerhitunganTfIdf
{
    private $data = [];

    function __construct(array $dt) {
        $this->data = $dt;
    }

    private function hitungTf(string $word): array
    {
        $hasil = [];
        foreach ($this->data as $keyDOc => $valueDoc) {
            $hitung = 0;
            foreach ($valueDoc as $keyTerm => $valueTerm) {
                if ($valueTerm == $word) {
                    $hitung++;
                }
            }
            array_push($hasil, $hitung);
        }
        // echo json_encode($hasil).' '.$word.PHP_EOL;
        return $hasil;
    }

    private function hitungDf(array $arrData): int
    {
        $df = 0;
        foreach ($arrData as $value) {
            if ($value > 0) {
                $df++;
            }
        }
        // echo json_encode($arrData).' '.$df.PHP_EOL;
        return $df;
    }

    private function hitungIDF(int $df): float
    {
        $jumlahDokumen = count($this->data);
        $dPerDf = $jumlahDokumen/$df;
        // echo "d/DF= ".$jumlahDokumen.'/'.$df.'='.$dPerDf.PHP_EOL;
        // echo "IDF= ".log10($dPerDf).PHP_EOL;
        return log10($dPerDf)+1;
    }

    private function TfIdfnya($doc, $tf, $idf): float
    {
        // echo "TFIDF= ".$tf[$doc]*$idf.PHP_EOL;
        return $tf[$doc]*$idf;
    }

    public function hitungTfIdf(): array
    {
        // echo json_encode($arr);
        // echo json_encode($this->data).PHP_EOL;
        $hasil = [];
        foreach ($this->data as $keyArr => $values) {
            $tmp = [];
            foreach ($values as $key => $value) {
                // echo $value.' '.$keyArr.' '.$key.PHP_EOL;
                $obj = new stdClass;

                $obj->term = $value;
                $obj->tf = $this->hitungTf($value);
                $obj->df = $this->hitungDf($obj->tf);
                $obj->idf = $this->hitungIDF($obj->df);
                $obj->tfidf = $this->TfIdfnya($keyArr,$obj->tf,$obj->idf);

                array_push($tmp, $obj);
            }

            array_push($hasil, $tmp);
        }
        // echo json_encode($hasil);
        return $hasil;
    }
}
