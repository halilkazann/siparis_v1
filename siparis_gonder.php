<?php
session_start();
require_once "baglan.php";

$veri = $_GET["active"];
$webSite = $_SESSION["webSite"];
$url = "http://$webSite/rest1/order2/createOrders";

foreach ($veri as $value){
    $getOrder = $con->prepare("Select * From `order` where siparis_no = ? ");
    $getOrder->execute([$value]);
    $orderCount = $getOrder->rowCount();
    $getOrdervalue = $getOrder->fetchAll(PDO::FETCH_ASSOC);


    $getProduct = $con->prepare("Select * From order_product where siparis_kodu=?");
    $getProduct->execute([$value]);
    $productCount = $getProduct->rowCount();
    $getProductValue[$value] = $getProduct->fetchAll(PDO::FETCH_ASSOC);

    $siparis_urun="";



    for($i=0;$i<count($getProductValue[$value]);$i++)
    {
        $Type[] = explode("-",$getProductValue[$value][$i]["type"]);



        $siparis_urun .= '
                {
                "ProductCode": "'. $getProductValue[$value][$i]["urunkodu"] .'",                   
                "Quantity": "'. $getProductValue[$value][$i]["miktar"] .'",               
                "OrderNote": "",                
                "GiftPackage": "0",   
                "VariantType1": "'. @$Type[$i][0] .'",
                "VariantType2": "'. @$Type[$i][1] .'",
                "SubProductCode": "'. $getProductValue[$value][$i]["varkod"] .'"
                },';
 }

    echo $siparis_urun;

$tarih = time();
    $fields = array( 'token' => $_SESSION["token"],
        'data' => '[{        
            "OrderCode": "'.$getOrdervalue[0]["siparis_no"].'",
            "Currency": "TL",
            "PaymentTypeId": "-2",
            "OrderStatusId": "8",
            "InvoiceName": "'.$getOrdervalue[0]["fatura_alici"].'",
            "InvoiceMobile": "'.$getOrdervalue[0]["fatura_tel"].'",
            "InvoiceCountry": "Türkiye", 
            "InvoiceCountryCode": "TR",
            "InvoiceCity": "'.$getOrdervalue[0]["fatura_siparis_ili"].'",      
            "InvoiceTown": "'.$getOrdervalue[0]["fatura_siparis_ilce"].'",       
            "InvoiceAddress":"'.$getOrdervalue[0]["fatura_teslim_adres"].'",  
            "DeliveryName": "'.$getOrdervalue[0]["teslim_alici"].'",        
            "DeliveryMobile": "'.$getOrdervalue[0]["teslim_tel"].'",    
            "DeliveryCountry": "Türkiye",        
            "DeliveryCountryCode": "TR",      
            "DeliveryCity": "'.$getOrdervalue[0]["teslim_siparis_ili"].'",         
            "DeliveryTown": "'.$getOrdervalue[0]["teslim_siparis_ilce"].'", 
            "DeliveryAddress": "'.$getOrdervalue[0]["teslim_adres"].'",
            "OrderTotalPrice": "'.$getOrdervalue[0]["teslim_adres"].'",          
            "CargoCode": "'.$getOrdervalue[0]["kargo_kodu"].'",
            "OrderDate": "'.$tarih.'",        
            "Products": 
              ['. rtrim($siparis_urun,",") . ']
             }]');


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response,true);

    echo "<pre>";

    print_r($response);

}





