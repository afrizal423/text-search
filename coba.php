<?php
require 'vendor/autoload.php';

use Afrizalmy\TIJ\TfIdfJaccard;

//helper 
function array_insert(&$arr, $index, $val)
{
    if (is_string($index))
        $index = array_search($index, array_keys($arr));
    if (is_array($val))
        array_splice($arr, $index, 0, [$index => $val]);
    else
        array_splice($arr, $index, 0, $val);
}

//soal
// Apa yang kamu ketahui tentang perpustakaan?
// jawaban
// string dokumen (dijadikan array)
$str = array(
    "Perpustakaan adalah tempat membaca buku.",
    "Ada banyak sekali buku di perpustakaan.",
    "perpustakaan tempat nyaman buat belajar",
);
// $str = array(
//     "Program logika dan semantik",
//     "ilmu antar individu",
//     "Dalam program ilmu terdapat transfer ilmu semantik"
// );

// query tetep satu, namun tetap berupa array saja
$query = "perpustakaan adalah tempat paling enak buat membaca dan banyak buku";

array_insert($str, 0, $query);
// array_push($str,$query);
// var_dump($str);
// array_push($arr,$str);
//pemanggilan

$tfidfjaccard = new TfIDFJaccard();
$hasilTfIdf = $tfidfjaccard->HitungTFIDF($str);
echo json_encode($hasilTfIdf);
// $hasilQuery = $tfidfjaccard->HitungTFIDF($query);
// echo json_encode($hasilQuery);
