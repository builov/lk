<?php
$dir = 'uploads';
$files = scandir($dir);

//print_r($files);

foreach ($files as $file)
{
    if (in_array(pathinfo($file, PATHINFO_EXTENSION), array('jpg','png','jpeg')))
    {
        echo $file . "\r\n";
    }
}