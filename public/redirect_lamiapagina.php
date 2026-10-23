<?php

require_once("../proxy-spid-php.php");
use Firebase\JWT\JWT;

include("src/header.html");
echo "<div class='row' style='display:flex;flex-direction: column;align-items: center; margin-top: 20px;'>";
echo "<div><h4>Questo è un esempio della pagina di login dell'Ospedale Galliera</h4></div>";

$properties = properties();
$service_uri = $properties['service_uri'];
$client_id = "4nlhkmdttz8th";
$encodedURL = urlencode($service_uri."/redirect_lamiapagina.php");

if(isset($_GET['token'])) $token = $_GET['token'];
if(isset($_GET['service'])) $service = $_GET['service'];

if(!isset($service) || $service == null) {
    $service = 'SPID';
}

if(!isset($token)) {
    echo "<div class='row'><a href=\"".$service_uri."?client_id=".$client_id."&redirect_uri=".$encodedURL."\" 
               class=\"btn btn-primary border-25px\" role=\"button\" aria-disabled=\"true\">Login</a></div><br>";
}else {
    //printJWTdata($token);
    echo "<h6>Login effettuato con <span style='color: green'>SUCCESSO</span>.</h6>";
    echo "<div class='row'>
            <a href=\"/proxy-spid.php?client_id=".$client_id."&action=logout&service=".$service."\" class=\"btn btn-primary border-25px\" role=\"button\" 
            aria-disabled=\"true\">Esci | Logout</a></div><br>";
}

echo "</div>";

function printJWTdata($token) {
    echo "<b>Encoded JWT data:</b>" . $token . "<br>";
    $publicKey = file_get_contents(__DIR__ . '/../cert/spid-sp.crt', true);
    $decoded = JWT::decode($token, $publicKey, array('RS256'));
    echo "<b>Decoded JWT data:</b>" . print_r($decoded, true) . "<br>";
}

function properties() {
    $propertiesFile = '../setup/application.json';
    return json_decode(file_get_contents($propertiesFile), true);
}