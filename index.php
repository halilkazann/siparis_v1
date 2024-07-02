<?php
session_start();
$islem = "";
if (@$_SESSION["kullanici_adi"] != "" && @$_SESSION["pass"] != "") {
    echo "giriş başarılı";
    $islem =1;
} else {
    echo "giriş hatalı";
    $islem=0;

}

if ($islem==1){
    header("Location:dashboard.php");
}


?>