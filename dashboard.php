<?php

require_once "baglan.php";
@$page = $_GET["page"];
@$limit = $_GET["limit"];

if (empty($page)) {
    $page = 1;
}
if (empty($limit)) {
    $limit = 25;
}
if ($limit == 100 || $limit == 50 || $limit == 25) {

} else {
    $limit = 25;
}

$start = ($page - 1) * 25;


$fullOrder = $con->prepare("Select * From `order` ");
$fullOrder->execute();
$FullorderCount = $fullOrder->rowCount();


$getOrder = $con->prepare("Select * From `order` LIMIT $start,$limit ");
$getOrder->execute();
$orderCount = $getOrder->rowCount();
$getOrdervalue = $getOrder->fetchAll(PDO::FETCH_ASSOC);
$i = 1;

if ($orderCount > 0) {
    include "siparis_table.html";
    foreach ($getOrdervalue as $value) {

        include "siparis.html";


        $getProduct = $con->prepare("Select * From order_product where siparis_kodu=?");
        $getProduct->execute([$value['siparis_no']]);
        $productCount = $getProduct->rowCount();

        $getProductValue = $getProduct->fetchAll(PDO::FETCH_ASSOC);


        include "urun_table.html";

        $i++;
        foreach ($getProductValue as $product) {
            include "siparis_urun.html";
        }
        include "urun_table_finish.html";
    }

}

include "siparis_table_finish.html";

echo $FullorderCount . "<br>";
echo $limit . "<br>";
echo $page . "<br>";
$sayfa = ceil($FullorderCount / $limit);
echo $sayfa;


if (!empty($page)) {


}
include "alt_bilgi.html";
?>
