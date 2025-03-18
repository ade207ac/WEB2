<?php

//class persegi panjang
class persegiPanjang
{
    public $panjang;
    public $lebar;

    //konstruktor persegi pangjang
    function __construct($panjang, $lebar)
    {
        $this->panjang = $panjang;
        $this->lebar = $lebar;
    }

    //method untuk menghitung luas
    function getLuas()
    {
        $luasPP = $this->panjang * $this->lebar;
        return $luasPP;
    }

    //method hitung keliling
    function getKeliling()
    {
        $kelilingPP = 2 * ($this->panjang + $this->lebar);
        return $kelilingPP;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="section">
        <h2>Contoh penggunaan persegi panjang</h2>
        <?php
        $pp = new persegiPanjang(10, 8);

        echo "panjang : ", $pp->panjang . "<br>";
        echo "lebar : ", $pp->lebar . "<br>";
        echo "<hr>";
        echo "Luas : " . $pp->getLuas() . "<br>";
        echo "keliling : " . $pp->getKeliling() . "<br>";


        ?>
    </div>
</body>

</html>