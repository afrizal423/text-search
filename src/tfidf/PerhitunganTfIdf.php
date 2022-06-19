<?php
namespace Afrizalmy\TIJ\tfidf;

use stdClass;

class PerhitunganTfIdf
{
    private $data = [];

    function __construct($dt) {
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
        return $df;
    }

    private function hitungIDF(int $df): float
    {
        $jumlahDokumen = count($this->data);
        $dPerDf = $jumlahDokumen/$df;
        // echo $jumlahDokumen.PHP_EOL;
        return log10($dPerDf);
    }

    private function TfIdfnya($doc, $tf, $idf): float
    {
        return $tf[$doc]*$idf;
    }

    public function hitungTfIdf(): array
    {
        // echo json_encode($arr);
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
