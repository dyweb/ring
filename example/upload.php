<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/21
 * Time: 下午8:11
 */
require_once(__DIR__ . '/../vendor/autoload.php');

$uploadedFile = new \Dy\Ring\Source\UploadedFile("data");

$data = array(
    'post' => $_POST,
    'file' => $uploadedFile->getInfo()
);
echo json_encode($data);