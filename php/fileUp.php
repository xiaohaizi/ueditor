<?php
include "Uploader.class.php";
date_default_timezone_set("Asia/chongqing");
header("Content-Type: text/html; charset=utf-8");
error_reporting(E_ERROR | E_WARNING);

/* 全局配置项 */
$CONFIG = include("config.php");

/* 上传配置 */
switch($_GET['type']){
    case 'image':
        $config = array(
            "savePath" => $CONFIG['savePath'],
            "fileNameFormat" => $CONFIG['nameFormat'],
            "maxSize" => $CONFIG['imageMaxSize'], //单位KB
            "allowFiles" => $CONFIG['imageAllowFiles']
        );
        $fieldName = $CONFIG['imageFieldName'];
        break;
    case 'file':
        $config = array(
            "savePath" => $CONFIG['savePath'],
            "fileNameFormat" => $CONFIG['nameFormat'],
            "maxSize" => $CONFIG['fileMaxSize'], //单位KB
            "allowFiles" => $CONFIG['fileAllowFiles']
        );
        $fieldName = $CONFIG['fileFieldName'];
        break;
    case 'video':
        $config = array(
            "savePath" => $CONFIG['savePath'],
            "fileNameFormat" => $CONFIG['nameFormat'],
            "maxSize" => $CONFIG['videoMaxSize'], //单位KB
            "allowFiles" => $CONFIG['videoAllowFiles']
        );
        $fieldName = $CONFIG['videoFieldName'];
        break;
}

/* 生成上传实例对象并完成上传 */
$up = new Uploader($fieldName, $config);

/**
 * 得到上传文件所对应的各个参数,数组结构
 * array(
 *     "originalName" => "",   //原始文件名
 *     "name" => "",           //新文件名
 *     "url" => "",            //返回的地址
 *     "size" => "",           //文件大小
 *     "type" => "" ,          //文件类型
 *     "state" => ""           //上传状态，上传成功时必须返回"SUCCESS"
 * )
 */
$info = $up->getFileInfo();

if ($callback = $_GET["callback"]) {
    echo '{"url":"' . $info["url"] . '","fileType":"' . $info["type"] . '","original":"' . $info["originalName"] . '","state":"' . $info["state"] . '"}';
} else {
    echo $callback . '({"url":"' . $info["url"] . '","fileType":"' . $info["type"] . '","original":"' . $info["originalName"] . '","state":"' . $info["state"] . '"})';
}
