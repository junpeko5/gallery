<?php

function classAutoLoader($class) {
    $class = strtolower($class);
    $the_path = "includes/{$class}.php";

//    if (file_exists($the_path)) {
//        require_once($the_path);
//    } else {
//        die("This file name {$class}.php was not found man....");
//    }

    if (is_file($the_path) && !class_exists($class)) {
        include $the_path;
    }
}
spl_autoLoad_register('classAutoLoader');