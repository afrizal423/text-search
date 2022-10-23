<?php
namespace Afrizalmy\TextSearch\jaccard;


class PerhitunganJaccard
{
    private $data = [];
    private $hasil = [];
    private $query = [];

    function __construct(array $hasil, array $dt) {
        $this->data = $dt;
        $this->hasil = $hasil;
        $this->ambilQuery();
    }

    /**
     * Proses pemisahan query dari array dokumen
     *
     * @return void
     */
    private function ambilQuery(): void
    {
        $this->query = $this->data[0];
        // hapus query from array
        array_splice($this->data, 0, 1);
    }

    /**
     * Mencari jumlah irisan dan gabungan antara query dengan dokumen
     *
     * @param integer $indexdoc
     * @return array
     */
    private function irisanGabungan(int $indexdoc): array
    {
        $jumlahIrisan = 0;
        $jumQGab = 0;
        $jumDocGab = 0;
        foreach ($this->query as $keyQ => $valueQ) {
            foreach ($this->data[$indexdoc] as $keyd => $valued) {
                // cari yang sama
                if ($valueQ->term == $valued->term) {
                    $jumlahIrisan+=1;
                }
            }
            $jumQGab+=1;
        }
        foreach ($this->data[$indexdoc] as $keyd => $valued) {
            $jumDocGab+=1;
        }
        return [
            "irisan" => round($jumlahIrisan, 3),
            "A" => round($jumQGab, 3),
            "B" => round($jumDocGab, 3)
        ];
    }

    /**
     * Perhitungan jaccard dengan penjumlah tfdf (gabungan irisan)
     *
     * @return array
     */
    private function jaccard1(): array
    {
        $hasil = [];
        foreach ($this->data as $key => $value) {
            $ag = $this->irisanGabungan($key);
            $hasil[$key] = (object) [
                'similarity' => $ag['irisan']/($ag['A']+$ag['B']-$ag['irisan'])
            ];
        }
        return $hasil;

    }

    /**
     * buat partisi untuk mencari min max
     *
     * @return array
     */
    private function buatPartisi(): array
    {
        $HaslQuery = [];
        $hasil = [];
        foreach ($this->hasil as $key => $value) {
            $tmp = [];
            foreach ($this->hasil[$key] as $keyd => $valued) {
                if ($key == 0) {
                    array_push($HaslQuery, $valued->tfidf);
                } else {
                    array_push($tmp, $valued->tfidf);
                }
            }
            array_push($hasil, $tmp);
        }

        array_splice($hasil, 0, 1);
        return [
            "query" => $HaslQuery,
            "data" => $hasil
        ];
    }

    /**
     * Perhitungan jaccard dengan rumus mix max
     *
     * @return array
     */
    private function jaccard2(): array
    {
        $dt = $this->buatPartisi();
        $hasil = [];
        foreach ($this->data as $doc => $value) {
            $tmpmin = [];
            $tmpmax = [];
            for ($iterasi=0; $iterasi < count($dt['query']); $iterasi++) { 
                # code...
                // echo $iterasi.PHP_EOL;
                $min = min($dt["data"][$doc][$iterasi], $dt['query'][$iterasi]);
                $max = max($dt["data"][$doc][$iterasi], $dt['query'][$iterasi]);
                array_push($tmpmin, $min);
                array_push($tmpmax, $max);
            }

            $hasil[$doc] = (object) [
                'similarity' => array_sum($tmpmin) / array_sum($tmpmax)
            ];
        }
        return $hasil;
    }

    /**
     * Proses perhitungan jaccard pake perhitungan jumlah tfdf (gabungan irisan) atau pake min max (soon)
     *
     * @return array
     */
    public function hitungJaccard(): array
    {
        return $this->jaccard2();
    }
}
