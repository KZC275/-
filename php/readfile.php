<?php 
    //获取文件dir
    $file_dir = '../pdfTest.pdf';
    //使用file_exists判断文件是否存
    ob_end_clean();
    ob_start();
    //打开文件
    $handler   = fopen($file_dir, 'r+b');
    $file_size = filesize($file_dir);
    //声明头信息
    Header("Content-type: application/octet-stream");
    Header("Accept-Ranges: bytes");
    Header("Accept-Length: ".$file_size);
    Header("Content-Disposition: attachment; filename=" . basename( $file_dir));
    // 输出文件内容
    echo fread($handler,$file_size);
    fclose($handler);
    ob_end_flush();
    exit;
   
 ?>
