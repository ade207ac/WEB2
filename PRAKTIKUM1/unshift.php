<?php

$laptop = ["Asus", "Lenovo",
    "Dell", "Realme"]

//Menambahkan elemen di awal
    array_unshift($laptop, "HP", "Acer");

//Hasil
echo "Hasil";
foreach ($laptop as $p){
    echo "<br>".$p;
}

?>