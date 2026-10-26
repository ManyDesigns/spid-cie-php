<?php
require_once("../proxy-spid-php.php");
//$spidsdk->setPurpose("P");

if(isset($_GET['client_id'])) $client_id = $_GET['client_id'];
if(isset($_GET['redirect_uri'])) $redirect_uri = urldecode($_GET['redirect_uri']);
$production = false;
$state = '';

$spidsdk = new PROXY_SPID_PHP($client_id, $redirect_uri, $state, $production);

if ($spidsdk->isAuthenticated()
    && isset($_GET['idp'])
    && $spidsdk->isIdP($_GET['idp'])) {

    echo "<p>IdP: <b>" . $spidsdk->getIdP() . "</b></p>";
    sendAuthenticatedDataResponse($spidsdk->getAttributes());
    echo "<hr/><p><a href='" . $spidsdk->getLogoutURL() . "'>Logout</a></p>";

} else {
    if (!isset($_GET['idp'])) {
        $spidsdk->insertSPIDButtonCSS();
        $spidsdk->insertMainPage($client_id, $redirect_uri, $state, $production);
        //$spidsdk->insertSPIDButton("L");
        $spidsdk->insertSPIDButtonJS();
    } else {
        $spidsdk->login($_GET['idp'], 2);

        // set AttributeConsumingServiceIndex 2
        //$spidsdk->login($_GET['idp'], 2, "", 2);
    }
}

?>