<?php
/* Чтение изображения */
$im = new Imagick('E:\OpenServer\domains\lk\advanced\frontend\web\test.png');

/* Миниатюра изображения */
$im->thumbnailImage(200, null);

/* Создание рамки для изображения */
$im->borderImage(new ImagickPixel("white"), 5, 5);

/* Клонируем изображение и зеркально поворачиваем его */
$reflection = clone $im;
$reflection->flipImage();

/* Создаём градиент. Это будет наложением для отражения */
$gradient = new Imagick();

/* Градиент должен быть достаточно большой для изображения и его рамки */
$gradient->newPseudoImage($reflection->getImageWidth() + 10, $reflection->getImageHeight() + 10, "gradient:transparent-black");

/* Наложение градиента на отражение */
$reflection->compositeImage($gradient, imagick::COMPOSITE_OVER, 0, 0);

/* Добавляем прозрачность. Требуется ImageMagick 6.2.9 или выше */
//$reflection->setImageOpacity( 0.3 );

/* Создаём пустой холст */
$canvas = new Imagick();

/* Холст должен быть достаточно большой, чтобы вместить оба изображения */
$width = $im->getImageWidth() + 40;
$height = ($im->getImageHeight() * 2) + 30;
$canvas->newImage($width, $height, new ImagickPixel("black"));
$canvas->setImageFormat("png");

/* Наложение оригинального изображения и отражения на холст */
$canvas->compositeImage($im, imagick::COMPOSITE_OVER, 20, 10);
$canvas->compositeImage($reflection, imagick::COMPOSITE_OVER, 20, $im->getImageHeight() + 10);

/* Вывод изображения */
header("Content-Type: image/png");
echo $canvas;

