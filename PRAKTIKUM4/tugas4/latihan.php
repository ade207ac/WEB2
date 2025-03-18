<?php

class luasSegitiga
{
    public $tinggi;
    public $alas;
    public const SETENGAH = 1 / 2;

    public function __construct($alas, $tinggi)
    {
        $this->alas = $alas;
        $this->tinggi = $tinggi;
    }

    public function getLuas()
    {
        $luas = self::SETENGAH * $this->alas * $this->tinggi;
        return $luas;
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
    <h1>Luas Segitiga</h1>
    <?php

    $ls = new luasSegitiga(10, 12);

    echo "Segitiga dengan alas = ", $ls->alas, "<br>";
    echo "Segitiga dengan tinggi = ", $ls->tinggi, "<br>";
    echo "Maka luas Segitiga tersebut adalah = ", $ls->getLuas();


    ?>
</body>

</html>