<?php
require 'vendor/autoload.php';

use Afrizalmy\TIJ\TfIdfJaccard;

// string dokumen (dijadikan array)
// $str = array(
//     "Perpustakaan adalah tempat membaca.😀",
//     "Ada banyak sekali buku cerita di perpustakaan.😃",
//     "Membaca buku ketika waktu luang adalah kebiasaan baik!.😄",
//     'Tetap berhati-hati ya, menghadapi resesi harga jual buku-buku semakin mahal. Terburu-buru'
// );
$str = array(
    "Program logika dan semantik",
    "ilmu antar individu",
    "Dalam program ilmu terdapat transfer ilmu semantik"
);

// query tetep satu, namun tetap berupa array saja
$query = array(
    "Sekumpulan instruksi-instruksi yang dijalankan oleh komputer untuk menjalankan fungsi"
);
//pemanggilan

$tfidfjaccard = new TfIDFJaccard();
$hasilTfIdf = $tfidfjaccard->HitungTFIDF($str);
echo json_encode($hasilTfIdf);
// $hasilQuery = $tfidfjaccard->HitungTFIDF($query);
// echo json_encode($hasilQuery);
