<?php
require_once "baglan.php";

function getProduct($urunler = array())
{
    $i = 1;
    foreach ($urunler as $urun){

        $url = "http://zehrakanadikirik.1isim.com/rest1/product/getProductByCode/".$urun["urunkodu"];

        $fields = array( 'token' =>  $_SESSION["token"]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $response= json_decode($response,true);

        if($response["success"]==true && $response["message"][0]["text"][0]=="Başarılı!"){
            echo "<hr>";
            echo "Siparişe ait ürün T-Soft panelde yer alıyor";
            echo "<a href='siparis_gonder.php?siparis_no='".$urun['siparis_kodu'].">Siparişi Aktar</a>";

        }
        elseif($response["message"][0]["text"][0] =="ProductCode sistemde bulunamadı!"){
            echo "<hr>";
            echo "Siparişe ait  ürün (".$urun["urunkodu"].") T-Soft sitesinde bulunamadı.";
            echo "<a href='createProduct.php?urunkodu=".$urun["urunkodu"]."&kod=".$urun["kod"]."&varkod=".$urun["varkod"]."&barcode=".$urun["barcode"]."&urunadi=".$urun["urunadi"]."&fatura_adi=".$urun["fatura_adi"]."&type=".$urun["fatura_adi"]."&fiyat=".$urun["fiyat"]."&miktar=".$urun["miktar"]."&kdv=".$urun["kdv"]."&siparis_kodu=".$urun["siparis_kodu"]."'> Siparişin aktarılabilmesi için tıklayarak ürünü T-Soft'ta hızlı oluşturabilirsiniz.</a>";
            echo "<hr>";
            die;
        }
    }




}



