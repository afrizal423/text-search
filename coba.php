<?php
require 'vendor/autoload.php';

use Afrizalmy\TIJ\TfIdfJaccard;

// string dokumen (dijadikan array)
$str = array(
    "Perpustakaan adalah tempat membaca.😀",
    "Ada banyak sekali buku cerita di perpustakaan.😃",
    "Membaca buku ketika waktu luang adalah kebiasaan baik!.😄",
    'Perekonomian Indonesia sedang dalam pertumbuhan yang membanggakan'
);
// query tetep satu, namun tetap berupa array saja
$query = array(
    "perpustakaan adalah tempat beragam buku"
);
//pemanggilan

$tfidfjaccard = new TfIDFJaccard();
$tfidfjaccard->HitungTFIDF($str);