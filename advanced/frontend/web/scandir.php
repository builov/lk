<?php
$dir = 'uploads';
$files = scandir($dir);

//print_r($files);

$abs = __DIR__;

foreach ($files as $file)
{
    if (in_array(pathinfo($file, PATHINFO_EXTENSION), array('jpg','png','jpeg')))
    {
        $path = $abs . '/' . $dir . '/' . $file;
        if (filesize($path) > 3000000)
        {
            echo $file . ': ' . filesize($path) . "<br>\r\n";
        }
    }
}