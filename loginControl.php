<?php
session_start();
require_once "baglan.php";

@$website = filtre($_POST["webSite"]);
@$kullanici_adi = filtre($_POST["kullanici"]);
@$pass = filtre($_POST["pass"]);



if($kullanici_adi != "" && $pass != "" && $website != ""){


    $url = "http://$website/rest1/auth/login/$kullanici_adi";

    $fields = array( 'pass' => $pass);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response,true);




    if($response["message"][0]["text"][0] == "Giriş yapıldı!" && $response["success"] == true )
    {
        $_SESSION["token"] = $response["data"][0]["token"];
        $_SESSION["kullanici_adi"] = $kullanici_adi;
        $_SESSION["pass"] = $pass;

    }
    elseif($response["message"][0]["text"][0] == "Geçersiz kullanıcı adı veya şifre!" )
    {
        echo "Geçersiz kullanıcı adı veya şifre!";
    }
    if(@$_SESSION["kullanici_adi"] != "" && @$_SESSION["pass"] != ""&&  $_SESSION["token"] != ""){
        header("Location:index.php");
    }
}else{

    echo "post edilemedi";

}

