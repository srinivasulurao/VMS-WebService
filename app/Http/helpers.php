<?php

function debug($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function debug_exit($data){
    debug($data);
    exit;
}

?>