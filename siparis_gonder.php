<?php
require_once "baglan.php";

$veri = $_GET["active"];


if (isset($_GET["tekilsiparis"])){
    header("Location:teksiparis.php?");
}

echo "<pre>";

print_r($veri);


