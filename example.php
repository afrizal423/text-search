<?php
require 'vendor/autoload.php';

use Afrizalmy\TextSearch\TfIdfJaccard;

// soal
// Apa yang kamu ketahui tentang perpustakaan?
// jawaban
// string variasi jawaban (dijadikan array)
$str = array(
    "tempat membaca buku.",
    "Ada banyak buku di perpustakaan.",
    "perpustakaan tempat sumber ilmu.",
);

// query bertipe string
$query = "tempat membaca dan banyak sekali buku";

$tfidfjaccard = new TfIDFJaccard();
$hasilTfIdf = $tfidfjaccard->document($str)
                        ->query($query)
                        ->HitungTFIDF();
                        
$hasilakhir = $tfidfjaccard->HitungJaccard();
echo json_encode($hasilakhir);
