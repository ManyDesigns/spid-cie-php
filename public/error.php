<?php

include("src/header.html");

$data = base64_decode($_GET['data']);
$client_id = $_GET['client_id'];
$redirect_uri = $_GET['redirect_uri'];

$config = getConfig();
//TODO:After AGID approaval we need to hold cliend and redirect_uri somehow and redirect to main page again!!
$entityID = $config['authsources']['SPID']['entityID'];
//TODO: If we arrive main page without client id, redirect to error page with message (After AGID approval!!)
echo "<div class='section'>
        <div class='section-content'>
            <div class='row text-center'>
                <div style='margin-left: auto; margin-right: auto;'>
                    <div style='display: flex; justify-content: center; align-items: center;'>
                        <object class='error-icon' data='src/resources/icons/exclamation-triangle.svg' height='100' width='100'></object>
                    </div>
                    <div class='error-data'>" .$data. "</div>
                    <div style='display: flex; justify-content: center;'>
                       <a href=\"" .$entityID."/proxy-login.php?client_id=".$client_id."&redirect_uri=".$redirect_uri."\" class=\"btn btn-primary\" role=\"button\" aria-disabled=\"true\">Riprova</a> 
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
";

function getConfig() {
    $setupFile = "../spid-php-setup.json";
    return file_exists($setupFile) ?
        json_decode(file_get_contents($setupFile), true) : array();
}

function properties() {
    $propertiesFile = '../setup/application.json';
    return json_decode(file_get_contents($propertiesFile), true);
}
