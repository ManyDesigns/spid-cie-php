<?php

use SimpleSAML\Session;

$session = Session::getSessionFromRequest();
error_log(json_encode($this->data,JSON_PRETTY_PRINT));
header("Location: /error.php?data=".base64_encode($this->data['errorMessage'])."&client_id=".$session->getClientId()."&redirect_uri=".$session->getRedirectUri()."");
die();