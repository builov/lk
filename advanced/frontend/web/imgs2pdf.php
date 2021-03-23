<?php

//E:\OpenServer\domains\lk\advanced\frontend\web\06.2021-1.jpg

$images = array(
    'E:\OpenServer\domains\lk\advanced\frontend\web\uploads\06.2021-1.jpg',
    'E:\OpenServer\domains\lk\advanced\frontend\web\uploads\06.2021-2.jpg',
    'E:\OpenServer\domains\lk\advanced\frontend\web\uploads\06.2021-3.jpg'
);

$pdf = new Imagick($images);

$pdf->setImageFormat('pdf');

if (!$pdf->writeImages('combined.pdf', true))
{
    die('Could not write!');
}

header('Content-Type: application/pdf');
echo $pdf;
