<?php
require_once "baglan.php";

$veri = $_GET["active"];



foreach ($veri as $value){
    $getOrder = $con->prepare("Select * From `order` where siparis_no = ? ");
    $getOrder->execute([$value]);
    $orderCount = $getOrder->rowCount();
    $getOrdervalue[] = $getOrder->fetchAll(PDO::FETCH_ASSOC);

    $siparis_kodu = $getOrdervalue[0][0]["siparis_no"];

    $getProduct = $con->prepare("Select * From order_product where siparis_kodu=?");
    $getProduct->execute([$siparis_kodu]);
    $productCount = $getProduct->rowCount();
    $getProductValue[] = $getProduct->fetchAll(PDO::FETCH_ASSOC);
}


echo "<pre>";

print_r($getProductValue);

echo "<pre>";

print_r($getOrdervalue);

