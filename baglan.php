<?php

try {
    $con = new PDO("mysql:host=localhost;dbname=siparis;charset=utf8","root","");
}catch (PDOException $hata){
    echo $hata->getMessage();
}

function filtre($deger)
{
    $bir = trim($deger);
    $iki = strip_tags($bir);
    $uc = htmlspecialchars($iki);

    return $uc;
}

?>