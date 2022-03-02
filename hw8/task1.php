<?php

function getDirectoryTree(string $path) {

    $dir = new DirectoryIterator($path);
    $message = "";
    foreach ($dir as $value) {
        if(!$value->isDot()) {
            $message .= $value->getPathname();
            if ($value->isDir()) {
                $message .= ": dir <br>";
                $message .= getDirectoryTree($value->getPathname())."<br>";
            }
            if ($value->isFile()) $message .= ": file, type: ".$value->getExtension().", size: ".$value->getSize()."<br>";
        }
    }
    return $message;
}


echo getDirectoryTree("C:\Users\q\Desktop\подготовка");