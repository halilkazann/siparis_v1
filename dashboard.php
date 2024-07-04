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
   ?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="css/input.css" rel="stylesheet">
    <title>Login</title>
</head>
<body class="bg-gray-100">

<header class="h-16 w-full bg-white p-5 flex justify-between items-center">
    <a href="logout.php"> <button class="p-3 bg-gray-400 hover:bg-gray-600 transition-all duration-100 font-semibold text-md h-12 rounded-sm text-white">Çıkış Yap</button></a>
</header>




<div class="flex justify-center mt-5">
    <form method="get" action="siparis_gonder.php" class="mt-5 ">
        <div class="flex items-center space-x-3 my-3 ">
            <a href="toplusiparisgonder.php" class="p-2 bg-blue-400 font-semibold text-md rounded-sm h-10 items-center text-white hover:bg-gray-600 transition-all duration-100" >toplu sipariş gönder</a>
            <button name="tekilsiparis" value="1" type="submit" class="p-2 bg-blue-400 font-semibold text-md rounded-sm h-10 items-center text-white hover:bg-gray-600 transition-all duration-100">seçili sipariş gönder</button>
            <a class="p-2 bg-blue-400 font-semibold text-md rounded-sm h-10 items-center text-white hover:bg-gray-600 transition-all duration-100">toplu ürün oluştur</a>
            <a class="p-2 bg-blue-400 font-semibold text-md rounded-sm h-10 items-center text-white hover:bg-gray-600 transition-all duration-100">ürün oluştur</a>
            <input class="h-10 p-2 outline-none text-gray-600 w-72 rounded-sm" type="text" placeholder="Ara">
            <a class="p-2 bg-blue-400 font-semibold text-md rounded-sm h-10 items-center text-white hover:bg-gray-600 transition-all duration-100">filtrele</a>
        </div>
        <table class="table-auto">
            <thead>
            <tr class="h-9">
                <th class="bg-gray-600 text-white"><input type="checkbox" id="topInput" class="custom-checkbox ml-2"></th>
                <th class="bg-gray-600 text-white w-16 text-center">Detaylar</th>
                <th class="bg-gray-600 text-white w-60">Sipariş No</th>
                <th class="bg-gray-600 text-white w-40">PazarYeri Kargo</th>
                <!-- <th class="bg-gray-600 text-white w-40">Mail</th> -->
                <th class="bg-gray-600 text-white w-40">Tarih</th>
                <th class="bg-gray-600 text-white w-40">Zaman</th>
                <th class="bg-gray-600 text-white w-40">Teslim Alıcı</th>
                <th class="bg-gray-600 text-white w-40">Teslim Sipariş İli</th>
                <th class="bg-gray-600 text-white w-40">Teslim Tel</th>
            </tr>
            </thead>
            <tbody>


            <?php
    foreach ($getOrdervalue as $value) {

        ?>
<tr class="hover:bg-green-200 transition-all duration-100 relative">
    <td><input type="checkbox" id="<?php echo $i; ?>" class="custom-checkbox ml-2" name="siparis[]" value="<?php echo $value['siparis_no']?>"></td>
    <td class="text-center text-gray-500 hover:text-gray-700 transition-all duration-100 " onclick="infoOpen(info<?php echo $i; ?>)"><i class="fa-solid fa-circle-info"></i></td>
    <td class="text-center whitespace-nowrap overflow-hidden  w-10" onclick="toggleCheckbox(<?php echo $i; ?>)"><?php echo $value['siparis_no']?></td>
    <td class="text-center whitespace-nowrap overflow-hidden  w-40" onclick="toggleCheckbox(<?php echo $i; ?>)"><?php echo $value['pazaryeri_kargo']?></td>
    <!-- <td class="text-center whitespace-nowrap overflow-hidden  w-40" onclick="toggleCheckbox(<?php echo $i; ?>)"><?php echo $value['mail']?></td> -->
    <td class="text-center whitespace-nowrap overflow-hidden  w-40" onclick="toggleCheckbox(<?php echo $i; ?>)"><?php echo $value['tarih']?></td>
    <td class="text-center whitespace-nowrap  overflow-hidden w-40" onclick="toggleCheckbox(<?php echo $i; ?>)"><?php echo $value['zaman']?></td>
    <td class="text-center whitespace-nowrap  overflow-hidden w-40" onclick="toggleCheckbox(<?php echo $i; ?>)"><?php echo $value['teslim_alici']?></td>
    <td class="text-center whitespace-nowrap overflow-hidden  w-40" onclick="toggleCheckbox(<?php echo $i; ?>)"><?php echo $value['teslim_siparis_ili']?></td>
    <td class="text-center whitespace-nowrap  overflow-hidden w-40" onclick="toggleCheckbox(<?php echo $i; ?>)"><?php echo $value['teslim_tel']?></td>
</tr>
<?php


        $getProduct = $con->prepare("Select * From order_product where siparis_kodu=?");
        $getProduct->execute([$value['siparis_no']]);
        $productCount = $getProduct->rowCount();

        $getProductValue = $getProduct->fetchAll(PDO::FETCH_ASSOC);


       ?>
            <tr class="detail-row hidden" id="info<?php echo $i; ?>"  onclick="toggleCheckbox(<?php echo $i; ?>)">
                <td colspan="11">
                    <div class=" w-full flex flex-col p-4">
                        <table>
                            <tr class="bg-gray-400 text-white">
                                <th class="w-14">Ürün Kodu</th>
                                <th class="w-14">Ürün Adı</th>
                                <th class="w-14">VarKod</th>
                                <th class="w-14">Barcode</th>
                                <th class="w-14">Type</th>
                                <th class="w-14">Fiyat</th>
                                <th class="w-7">Miktar</th>
                                <th class="w-7">Kdv</th>
                            </tr>

            <?php

        $i++;
        foreach ($getProductValue as $product) {
            ?>
            <tr class="space-x-4 hover:bg-green-400">

                <td class="text-center break-all w-20"><?php echo $product["urunkodu"] ?></td>
                <td class="text-center break-all w-40"><?php echo $product["urunadi"] ?></td>
                <td class="text-center break-all w-20"><?php echo $product["varkod"] ?></td>
                <td class="text-center break-all w-20"><?php echo $product["barcode"] ?></td>
                <td class="text-center break-all w-10"><?php echo $product["type"] ?></td>
                <td class="text-center break-all w-15"><?php echo $product["fiyat"] ?></td>
                <td class="text-center break-all w-10"><?php echo $product["miktar"] ?></td>
                <td class="text-center break-all w-10"><?php echo $product["kdv"] ?></td>
            </tr>
                            <?php
        }
       ?>
                        </table>

                    </div>
                </td>
            </tr>
<?php
            }

}

?>
            </tbody>

        </table>


</div>
            <?php

echo $FullorderCount . "<br>";
echo $limit . "<br>";
echo $page . "<br>";
$sayfa = ceil($FullorderCount / $limit);
echo $sayfa;


if (!empty($page)) {


}
?>


<script src="js/tableCheck.js"></script>
<script src="js/info.js"></script>
<script src="https://kit.fontawesome.com/de0713e58b.js" crossorigin="anonymous"></script>
</form>
</body>
<?php
?>
