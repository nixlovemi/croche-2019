<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*function sendPushNotifications($to, $data=array()){
    // $apiKey = 'AIzaSyCpaHqVj03f2Yrdpz0EWxAhXZ-ny4F2kMc';
    $apiKey = "AIzaSyBN1KJYtTaQE5uapHHGcntbdAQDOpgAjgs";
    $fields = [
        "to" => $to, #específico pra 1 pessoa | usa assim pra topicos: 'to' => '/topics/lelex'
        //"registration_ids" => $to, #1 ate 1000 # aqui passa um array com os IDS registrados
        "notification" => $data,
    ];
    $headers = [
        "Authorization: key=$apiKey",
        "Content-Type: application/json",
    ];
    $url = "https://fcm.googleapis.com/fcm/send";
    $ch     = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    var_dump($result);
    curl_close($ch);
    return json_decode($result, true);
}*/

function sendPushNotificationsTopic($topic, $notification=array()){
    $apiKey = "AIzaSyBN1KJYtTaQE5uapHHGcntbdAQDOpgAjgs";
    $fields = [
        "to"           => $topic,
        "notification" => $notification,
        "data"         => array(
          "post_id" => 1971
        ),
        "options"      => array(
          "priority" => "high"
        )
    ];
    $headers = [
        "Authorization: key=$apiKey",
        "Content-Type: application/json",
    ];
    $url = "https://fcm.googleapis.com/fcm/send";
    $ch     = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}

$topic        = "/topics/crocheapp";
$notification = [
  "title"                      => "Teste",
  "body"                       => "Mais um teste de notificação!",
  "sound"                      => "default",
  "icon"                       => "fcm_push_icon",
  "delivery_receipt_requested" => true,
  "badge"                      => 0, # bolinha vermelha no icone do app
];
$result = sendPushNotificationsTopic($topic, $notification);
// var_dump($result);

/*
$hoje = date("Y-m-d");
$this->load->model('Tb_Lancamento');
$return = $this->Tb_Lancamento->restFcmNotifContasPagar($hoje);
if($return !== false){
  $to   = ["eBIf9IyhkVM:APA91bGpDMYZ2BwwqPkUFQS-aTTmZ4Z0s4s175GBLhAymwsTG3SYwqAjfMBnz6mEKRV0JKznEJV3Y6IJ2RgRWNzSve9fTl5qIdOQvfoTdzc24cUS2hv2h3Xp4h_PJD2jPEJov7-WC8QK"];
  $data = [
    "title" => "Contas a Vencer",
    "body"  => $return,
    "sound" => "default",
  ];
  $result = sendPushNotifications($to, $data);
  print_r($result);
}
*/