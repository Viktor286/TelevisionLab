<?php

/* Get Remote Image Function */

$image_link = "http://i.vimeocdn.com/video/435567027.jpg";//Direct link to image
$split_image = pathinfo($image_link);
$file_name = "_global/store/thumbs/" . $split_image['filename'] . "." . $split_image['extension'];

function grab_image($url, $saveto)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    $raw = curl_exec($ch);
    curl_close($ch);
    if (file_exists($saveto)) {
        unlink($saveto);
    }
    $fp = fopen($saveto, 'x');
    fwrite($fp, $raw);
    fclose($fp);
}

grab_image($image_link, $file_name);