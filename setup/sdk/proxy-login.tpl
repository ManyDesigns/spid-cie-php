<?php 

    require_once("{{SDKHOME}}/proxy-spid-php.php");

    if(isset($_GET['client_id'])) $client_id = $_GET['client_id'];
    if(isset($_GET['redirect_uri'])) $redirect_uri = urldecode($_GET['redirect_uri']);

    $production = false;
    $state = '';

    $spidsdk = new PROXY_SPID_PHP($client_id, $redirect_uri, $state, $production);

    //$spidsdk->setPurpose("P");

    if($spidsdk->isAuthenticated() 
        && isset($_GET['idp']) 
        && $spidsdk->isIdP($_GET['idp'])) {

            echo "<p>IdP: <b>" . $spidsdk->getIdP() . "</b></p>";
            
            foreach($spidsdk->getAttributes() as $attribute=>$value) {
                echo "<p>" . $attribute . ": <b>" . $value[0] . "</b></p>";
            }
    
            echo "<hr/><p><a href='" . $spidsdk->getLogoutURL("/proxy-login.php") . "'>Logout</a></p>";

    } else {

        if(!isset($_GET['idp'])) {    
            if($spidsdk->isSPIDEnabled()) {
                echo "<p>SPID BUTTON</p>";
                $spidsdk->insertSPIDButtonCSS();
                $spidsdk->insertSPIDButton("L");  
                $spidsdk->insertSPIDButtonJS(); 
            }
            if($spidsdk->isCIEEnabled()) {
                echo "<p>CIE BUTTON";
                $spidsdk->insertCIEButton();
            }
            
        } else {
            $spidsdk->login($_GET['idp'], 2);  

            // set AttributeConsumingServiceIndex 2
            //$spidsdk->login($_GET['idp'], 2, "", 2);
        }
    }
?>

