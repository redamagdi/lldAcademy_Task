<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

$res = exec("git pull origin master");

print_r($res);

?>