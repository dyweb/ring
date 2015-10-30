<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/21
 * Time: 下午8:11
 */
require_once(__DIR__ . '/../vendor/autoload.php');

$uploadedFile = new \Dy\Ring\Source\UploadedFile("data");
$localBackend = new \Dy\Ring\Backend\LocalBackend("data");

$uploader = new \Dy\Ring\Uploader($localBackend, $uploadedFile);
$uploader->check();
$uploader->save();

$data = array(
    'post' => $_POST,
    'file' => $uploader->getMeta()
);
echo json_encode($data);