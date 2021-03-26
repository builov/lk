<?php

//require_once("../../merge-pdf-files/MergePdf.class.php");


$images = array(
    'E:\OpenServer\domains\lk\advanced\frontend\web\uploads\06.2021-1.jpg',
    'E:\OpenServer\domains\lk\advanced\frontend\web\uploads\06.2021-2.jpg',
    'E:\OpenServer\domains\lk\advanced\frontend\web\uploads\06.2021-3.jpg'
);

$pdf = new Imagick($images);

$pdf->setImageFormat('pdf');

if (!$pdf->writeImages('E:\OpenServer\domains\lk\advanced\frontend\web\uploads\combined.pdf', true))
{
    die('Could not write!');
}

//header('Content-Type: application/pdf');
//echo $pdf;


//MergePdf::merge(
//    Array(
//        "../../merge-pdf-files/test/file-a.pdf",
//        "../../merge-pdf-files/test/file-b.pdf",
//        "../../merge-pdf-files/test/file-c.pdf",
//        "../../merge-pdf-files/test/file-d.pdf",
//        "../../merge-pdf-files/test/file-e.pdf"
//    ),
//    MergePdf::DESTINATION__INLINE
//);
