<?php
$siswa = ["Tian", "Asep", 
            "Ahong", "Cipe"]

//menampilkan array awal
echo "Array awal :\n";
print_r($siswa);

//Menghapus elemen terakhir dari array
$orang_terakhir = array_pop($siswa);

//Menampilkan elemen yang dihapus
echo "<br>Elemen yang akan dihapus" .$orang_terakhir. "\n";

//menampilkan array setelah penghapusan

echo "<br>Array setelah penghapusan : <br>";
print_r($siswa);

?>