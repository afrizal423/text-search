<?php
require 'vendor/autoload.php';

use Afrizalmy\TextSearch\TfIdfJaccard;

// soal
// Apa yang kamu ketahui tentang perpustakaan?
// jawaban
// string variasi jawaban (dijadikan array)
$str = array(
    "Perpustakaan adalah tempat membaca buku.",
    "Ada banyak sekali buku di perpustakaan.",
    "perpustakaan tempat nyaman buat belajar",
);

// query bertipe string
$query = "perpustakaan adalah tempat paling enak buat membaca dan banyak buku";

$tfidfjaccard = new TfIDFJaccard();
$hasilTfIdf = $tfidfjaccard->document($str)
                        ->query($query)
                        ->HitungTFIDF();
                        
$hasilakhir = $tfidfjaccard->HitungJaccard();
echo json_encode($hasilakhir);
