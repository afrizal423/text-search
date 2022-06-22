<?php
namespace Afrizalmy\TextSearch\tfidf;

use Sastrawi\Stemmer\StemmerFactory;

class TextProcessing
{
    protected $stopwords = array("ajak", "akan", "beliau", "khan", "lah", "dong", "ahh", "sob", "elo", "so", "kena", "kenapa", "yang", "dan", "tidak", "agak", "kata", "bilang", "sejak", "kagak", "cukup", "jua", "cuma", "hanya", "karena", "oleh", "lain", "setiap", "untuk", "dari", "dapat", "dapet", "sudah", "udah", "selesai", "punya", "belum", "boleh", "gue", "gua", "aku", "kamu", "dia", "mereka", "kami", "kita", "jika", "bila", "kalo", "kalau", "dalam", "nya", "atau", "seperti", "mungkin", "sering", "kerap", "acap", "harus", "banyak", "doang", "kemudian", "nyala", "mati", "milik", "juga", "mau", "dimana", "apa", "kapan", "kemana", "selama", "siapa", "mengapa", "dengan", "kalian", "bakal", "bakalan", "tentang", "setelah", "hadap", "semua", "hampir", "antara", "sebuah", "apapun", "sebagai", "di", "tapi", "lainnya", "bagaimana", "namun", "tetapi", "biar", "pun", "itu", "ini", "suka", "paling", "mari", "ayo", "barangkali", "mudah", "kali", "sangat", "banget", "disana", "disini", "terlalu", "lalu", "terus", "trus", "sungguh", "telah", "mana", "apanya", "ada", "adanya", "adalah", "adapun", "agaknya", "agar", "akankah", "akhirnya", "akulah", "amat", "amatlah", "anda", "andalah", "antar", "diantaranya", "antaranya", "diantara", "apaan", "apabila", "apakah", "apalagi", "apatah", "ataukah", "ataupun", "bagai", "bagaikan", "sebagainya", "bagaimanapun", "sebagaimana", "bagaimanakah", "bagi", "bahkan", "bahwa", "bahwasanya", "sebaliknya", "sebanyak", "beberapa", "seberapa", "begini", "beginian", "beginikah", "beginilah", "sebegini", "begitu", "begitukah", "begitulah", "begitupun", "sebegitu", "belumlah", "sebelum", "sebelumnya", "sebenarnya", "berapa", "berapakah", "berapalah", "berapapun", "betulkah", "sebetulnya", "biasa", "biasanya", "bilakah", "bisa", "bisakah", "sebisanya", "bolehkah", "bolehlah", "buat", "bukan", "bukankah", "bukanlah", "bukannya", "percuma", "dahulu", "daripada", "dekat", "demi", "demikian", "demikianlah", "sedemikian", "depan", "dialah", "dini", "diri", "dirinya", "terdiri", "dulu", "enggak", "enggaknya", "entah", "entahlah", "terhadap", "terhadapnya", "hal", "hanyalah", "haruslah", "harusnya", "seharusnya", "hendak", "hendaklah", "hendaknya", "hingga", "sehingga", "ia", "ialah", "ibarat", "ingin", "inginkah", "inginkan", "inikah", "inilah", "itukah", "itulah", "jangan", "jangankan", "janganlah", "jikalau", "justru", "kala", "kalaulah", "kalaupun", "kamilah", "kamulah", "kan", "kau", "kapankah", "kapanpun", "dikarenakan", "karenanya", "ke", "kecil", "kepada", "kepadanya", "ketika", "seketika", "khususnya", "kini", "kinilah", "kiranya", "sekiranya", "kitalah", "kok", "lagi", "lagian", "selagi", "melainkan", "selaku", "melalui", "lama", "lamanya", "selamanya", "lebih", "terlebih", "bermacam", "macam", "semacam", "maka", "makanya", "makin", "malah", "malahan", "mampu", "mampukah", "manakala", "manalagi", "masih", "masihkah", "semasih", "masing", "maupun", "semaunya", "memang", "merekalah", "meski", "meskipun", "semula", "mungkinkah", "nah", "nanti", "nantinya", "nyaris", "olehnya", "seorang", "seseorang", "pada", "padanya", "padahal", "sepanjang", "pantas", "sepantasnya", "sepantasnyalah", "para", "pasti", "pastilah", "per", "pernah", "pula", "merupakan", "rupanya", "serupa", "saat", "saatnya", "sesaat", "aja", "saja", "sajalah", "saling", "bersama", "sama", "sesama", "sambil", "sampai", "sana", "sangatlah", "saya", "sayalah", "se", "sebab", "sebabnya", "tersebut", "tersebutlah", "sedang", "sedangkan", "sedikit", "sedikitnya", "segala", "segalanya", "segera", "sesegera", "sejenak", "sekali", "sekalian", "sekalipun", "sesekali", "sekaligus", "sekarang", "sekitar", "sekitarnya", "sela", "selain", "selalu", "seluruh", "seluruhnya", "semakin", "sementara", "sempat", "semuanya", "sendiri", "sendirinya", "seolah", "sepertinya", "seringnya", "serta", "siapakah", "siapapun", "disinilah", "sini", "sinilah", "sesuatu", "sesuatunya", "suatu", "sesudah", "sesudahnya", "sudahkah", "sudahlah", "supaya", "tadi", "tadinya", "tak", "tanpa", "tentu", "tentulah", "tertentu", "seterusnya", "tiap", "setidaknya", "tidakkah", "tidaklah", "toh", "waduh", "wah", "wahai", "sewaktu", "walau", "walaupun", "wong", "yaitu", "yakni",
                            "ada","adanya","adalah","adapun","agak","agaknya","agar","akan","akankah","akhirnya","aku","akulah","amat","amatlah","anda","andalah","antar","diantaranya","antara","antaranya","diantara","apa","apaan","mengapa","apabila","apakah","apalagi","apatah","atau","ataukah","ataupun","bagai","bagaikan","sebagai","sebagainya","bagaimana","bagaimanapun","sebagaimana","bagaimanakah","bagi","bahkan","bahwa","bahwasanya","sebaliknya","banyak","sebanyak","beberapa","seberapa","begini","beginian","beginikah","beginilah","sebegini","begitu","begitukah","begitulah","begitupun","sebegitu","belum","belumlah","sebelum","sebelumnya","sebenarnya","berapa","berapakah","berapalah","berapapun","betulkah","sebetulnya","biasa","biasanya","bila","bilakah","bisa","bisakah","sebisanya","boleh","bolehkah","bolehlah","buat","bukan","bukankah","bukanlah","bukannya","cuma","percuma","dahulu","dalam","dan","dapat","dari","daripada","dekat","demi","demikian","demikianlah","sedemikian","dengan","depan","di","dia","dialah","dini","diri","dirinya","terdiri","dong","dulu","enggak","enggaknya","entah","entahlah","terhadap","terhadapnya","hal","hampir","hanya","hanyalah","harus","haruslah","harusnya","seharusnya","hendak","hendaklah","hendaknya","hingga","sehingga","ia","ialah","ibarat","ingin","inginkah","inginkan","ini","inikah","inilah","itu","itukah","itulah","jangan","jangankan","janganlah","jika","jikalau","juga","justru","kala","kalau","kalaulah","kalaupun","kalian","kami","kamilah","kamu","kamulah","kan","kapan","kapankah","kapanpun","dikarenakan","karena","karenanya","ke","kecil","kemudian","kenapa","kepada","kepadanya","ketika","seketika","khususnya","kini","kinilah","kiranya","sekiranya","kita","kitalah","kok","lagi","lagian","selagi","lah","lain","lainnya","melainkan","selaku","lalu","melalui","terlalu","lama","lamanya","selama","selama","selamanya","lebih","terlebih","bermacam","macam","semacam","maka","makanya","makin","malah","malahan","mampu","mampukah","mana","manakala","manalagi","masih","masihkah","semasih","masing","mau","maupun","semaunya","memang","mereka","merekalah","meski","meskipun","semula","mungkin","mungkinkah","nah","namun","nanti","nantinya","nyaris","oleh","olehnya","seorang","seseorang","pada","padanya","padahal","paling","sepanjang","pantas","sepantasnya","sepantasnyalah","para","pasti","pastilah","per","pernah","pula","pun","merupakan","rupanya","serupa","saat","saatnya","sesaat","saja","sajalah","saling","bersama","sama","sesama","sambil","sampai","sana","sangat","sangatlah","saya","sayalah","se","sebab","sebabnya","sebuah","tersebut","tersebutlah","sedang","sedangkan","sedikit","sedikitnya","segala","segalanya","segera","sesegera","sejak","sejenak","sekali","sekalian","sekalipun","sesekali","sekaligus","sekarang","sekarang","sekitar","sekitarnya","sela","selain","selalu","seluruh","seluruhnya","semakin","sementara","sempat","semua","semuanya","sendiri","sendirinya","seolah","seperti","sepertinya","sering","seringnya","serta","siapa","siapakah","siapapun","disini","disinilah","sini","sinilah","sesuatu","sesuatunya","suatu","sesudah","sesudahnya","sudah","sudahkah","sudahlah","supaya","tadi","tadinya","tak","tanpa","setelah","telah","tentang","tentu","tentulah","tentunya","tertentu","seterusnya","tapi","tetapi","setiap","tiap","setidaknya","tidak","tidakkah","tidaklah","toh","waduh","wah","wahai","sewaktu","walau","walaupun","wong","yaitu","yakni","yang");
    

    /**
     * Proses face folding text
     * Menghapus simbol, emoji, dan text lowercase
     *
     * @param array $arr
     * @return array
     */
    public function caseFolding(array $arr): array
    {
        $hasil = [];
        foreach ($arr as $key => $value) {
             // hapus emoji dan simbol
            $str = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $value);
            // text to lower case
            $str = mb_convert_case($str, MB_CASE_LOWER, "UTF-8");
            array_push($hasil, $str);
        }       
        return $hasil;
    }

    /**
     * Proses tokenisasi kata
     *
     * @param array $arr
     * @return array
     */
    public function tokenize(array $arr): array
    {
        $hasil = [];
        foreach ($arr as $key => $value) {
            $tmp = [];
            $arrString = explode(" ", $value);
            foreach ($arrString as $keyArrString => $valueString) {
                //hapus spasi
                if (strlen($valueString) > 0) {
                    // echo $valueString.PHP_EOL;
                    array_push($tmp, $valueString);
                }
                
            }
            // echo json_encode(explode(" ", $value)).PHP_EOL;
            // echo $value.' '.strlen($value).PHP_EOL;
            array_push($hasil,$tmp);
        }       
        return $hasil;
    }

    /**
     * Stopword removal, menghapus kata tidak baku
     *
     * @param array $arr
     * @return array
     */
    public function stopword(array $arr): array
    {
        $hasil = [];
        
        foreach ($arr as $key => $value) {
            $tmp = [];
            foreach ($value as $pos => $item) {
                // echo $item;
                if (in_array($item, $this->stopwords)) {
                    unset($value[$pos]);
                } else {
                    array_push($tmp, $item);
                }
            }
            array_push($hasil, $tmp);
            $tmp = [];
        }       
        return $hasil;
    }

    /**
     * Proses stemmer, mengembalikan ke kata tunggal
     *
     * @param array $arr
     * @return array
     */
    public function stemmer(array $arr): array
    {
        $hasil = [];
        
        foreach ($arr as $key => $value) {
            $tmp = [];
            foreach ($value as $pos => $item) {
                $stemmerFactory = new StemmerFactory();
                $stemmer  = $stemmerFactory->createStemmer();
                // echo $item;
                array_push($tmp, $stemmer->stem($item));
            }
            array_push($hasil, $tmp);
            $tmp = [];
        }       
        return $hasil;
    }
}
