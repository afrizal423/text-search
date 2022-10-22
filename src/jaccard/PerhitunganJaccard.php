<?php
namespace Afrizalmy\TextSearch\jaccard;


class PerhitunganJaccard
{
    private $data = [];
    private $query = [];

    function __construct(array $dt) {
        $this->data = $dt;
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
                    $jumlahIrisan+=$valued->tfidf;
                }
            }
            $jumQGab+=$valueQ->tfidf;
        }
        foreach ($this->data[$indexdoc] as $keyd => $valued) {
            $jumDocGab+=$valued->tfidf;
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
        // echo json_encode($hasil);
        return $hasil;

    }

    /**
     * Proses perhitungan jaccard pake perhitungan jumlah tfdf (gabungan irisan) atau pake min max (soon)
     *
     * @return array
     */
    public function hitungJaccard(): array
    {
        return $this->jaccard1();
    }
}
