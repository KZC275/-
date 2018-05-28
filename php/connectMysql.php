<?php 
    //php数据库操作
    //准备好数据连接对象
    // $con = new mysqli('127.0.0.1','root','yy789789','myproject'); //连接地址不可加上http协议开头
    $con = new mysqli('bdm274246623.my3w.com','bdm274246623','aA852233','bdm274246623_db'); 
    if (mysqli_connect_errno()){
        echo '数据库连接错误'.mysqli_connect_error();
        exit();
    }
    // 检测连接
    // if ($con->connect_error) {
    //     die("连接失败: " . $con->connect_error);
    // } 
    mysqli_query($con,"set names 'utf8'");
    // echo 'success';

        
   
 ?>
