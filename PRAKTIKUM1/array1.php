<?php
$ar_buah = ["semangka", "manggo", "nangka"];


//memanggil array
echo "buah ke 2 adalah $ar_buah[2]";

//mencetak jumlah array
echo "<br>jumlah array: ". count($ar_buah);

//mencetak seluruh buah
echo '<br> seluruh buah <ol>';
   foreach($ar_buah as $_buah){
    echo '<li>' .$_buah. '<li>';
   }

echo '</ol>';
//menambahkan buah
$ar_buah[]="nanas";

//hapus index ke 1
unset($ar_buah[1]);

//ubah index ke 3 menjadi melon
$ar_buah[3]="melon";

//cetak seluruh buah dengan indexnya
echo '<ul>' ;
foreach($ar_buah as $ak => $av){
    echo'<li>'index: '.$ak.' - nama buah: '.$av'
}

   ?>