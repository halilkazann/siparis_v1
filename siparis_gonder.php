<?php
session_start();
require_once "baglan.php";

@$veri = $_GET["active"];
@$webSite = $_SESSION["webSite"];
$url = "http://$webSite/rest1/order2/createOrders";

if(isset($veri)) {
    foreach ($veri as $value) {
        $getOrder = $con->prepare("Select * From `order` where siparis_no = ? ");
        $getOrder->execute([$value]);
        $orderCount = $getOrder->rowCount();
        $getOrdervalue = $getOrder->fetchAll(PDO::FETCH_ASSOC);

        if ($getOrdervalue[0]["teslim_adres"] == ""){
            $getOrdervalue[0]["teslim_adres"] = "Sipariş aktarımı sağlanması için 3-5 kelime";
            $getOrdervalue[0]["fatura_teslim_adres"] = "Sipariş aktarımı sağlanması için 3-5 kelime";
        }



        $getProduct = $con->prepare("Select * From order_product where siparis_kodu=?");
        $getProduct->execute([$value]);
        $productCount = $getProduct->rowCount();
        $getProductValue[$value] = $getProduct->fetchAll(PDO::FETCH_ASSOC);




        $urun_array = array();
        $i = 0;
        $toplam_siparis_tutar=0;
        foreach ($getProductValue[$value] as $urun) {

            // siparişin ürünü var mı yok mu kontrol et

            $url = "http://$webSite/rest1/product/getProductByCode/" . $urun['urunkodu'];
            $fields = array('token' => $_SESSION["token"]);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response, true);


            // eğer yoksa

            if ($response['message'][0]['text'][0] == "ProductCode sistemde bulunamadı!") {

                $url = "http://$webSite/rest1/product/createProducts";

                $fields = array('token' => $_SESSION["token"],
                    'data' => '[    
                    {        
                    "ProductCode": "' . $urun["urunkodu"] . '",
                    "ProductName": "' . $urun["urunadi"] . '",
                    "DefaultCategoryCode": "T1917",
                    "SupplierProductCode": "' . $urun["urunkodu"] . '",
                    "Barcode": "' . $urun["barcode"] . '",
                    "IsActive": "0",    
                    "Vat": "' . $urun["kdv"] . '",
                    "Currency": "TL",    
                    "BuyingPrice": "' . $urun["fiyat"] . '",
                    "SellingPrice": "' . $urun["fiyat"] . '",
                    "Brand": "halilkazan",
                    "Model": "siparisaktar_v1" 
                    }]');

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($response, true);
            }

            if (!empty($getProductValue[$value][$i]["type"])) {
                $Type[] = explode("-", $getProductValue[$value][$i]["type"]);
            }else{
                $Type[0] = "Type1";
                $Type[1] = "Type2";
            }

            $urun_array[$i]['ProductCode'] = $urun["urunkodu"];
            $urun_array[$i]['Quantity'] = $urun["miktar"];
            $urun_array[$i]['VariantType1'] = $Type[0];
            $urun_array[$i]['VariantType2'] = $Type[1];
            $urun_array[$i]['SubProductCode'] = $urun["urunkodu"];
            $i++;

            $toplam_siparis_tutar += $urun["fiyat"];
        }



        for ($i = 0; $i < count($getProductValue[$value]); $i++) {

            $tarih = time();
            $fields = array('token' => $_SESSION["token"],
                'data' => '[{        
                "OrderCode": "' . $getOrdervalue[0]["siparis_no"] .  '",
                "Currency": "TL",
                "PaymentTypeId": "-2",
                "OrderStatusId": "8",
                "InvoiceName": "' . $getOrdervalue[0]["fatura_alici"] . '",
                "InvoiceMobile": "' . $getOrdervalue[0]["fatura_tel"] . '",
                "InvoiceCountry": "Türkiye", 
                "InvoiceCountryCode": "TR",
                "InvoiceCity": "' . $getOrdervalue[0]["fatura_siparis_ili"] . '",      
                "InvoiceTown": "' . $getOrdervalue[0]["fatura_siparis_ilce"] . '",       
                "InvoiceAddress":"' . $getOrdervalue[0]["fatura_teslim_adres"]. "12" . '",  
                "DeliveryName": "' . $getOrdervalue[0]["teslim_alici"] . '",        
                "DeliveryMobile": "' . $getOrdervalue[0]["teslim_tel"] . '",    
                "DeliveryCountry": "Türkiye",        
                "DeliveryCountryCode": "TR",      
                "DeliveryCity": "' . $getOrdervalue[0]["teslim_siparis_ili"] . '",         
                "DeliveryTown": "' . $getOrdervalue[0]["teslim_siparis_ilce"] . '", 
                "DeliveryAddress": "' . $getOrdervalue[0]["teslim_adres"]. "12" . '",
                "OrderTotalPrice": "' . $toplam_siparis_tutar . '",          
                "CargoCode": "11",
                "OrderDate": "' . $tarih . '",        
                "Products":  '.json_encode($urun_array) .' 
                 }]');

            $json = json_encode($fields);
            $json = json_decode($json,true);

        }

        $url = "http://$webSite/rest1/order2/createOrders";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);

        echo "<pre>";
        echo  $getOrdervalue[0]["siparis_no"] .' kodlu'. $response["message"][0]["text"][0] . "<br>";

        if($response["success"] == 1 & $response["message"][0]["text"][0] == "Sipariş başarıyla oluşturuldu."){
            $siparis_kodu = $getOrdervalue[0]["siparis_no"];


            $updateOrder = $con->prepare("Update `order` set durum = 1 where siparis_no = ? ");
            $updateOrder->execute([$siparis_kodu]);
            $updateOrderCount = $updateOrder->rowCount();
            if($updateOrderCount>0){
                echo "$siparis_kodu kodlu sipariş aktarılan siparişler arasına katıldı";
            }
        }

    }
}else{
    echo "Veri Girişi Sağlamadınız <a href='dashboard.php'>AnaSayfa</a>";
}





