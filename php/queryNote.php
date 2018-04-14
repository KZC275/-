<?php 
    
    class Res{  
      public $status;  
     } 
     $res=new Res(); 
     $res->status=200;

     //判断是否登录
     if($_COOKIE['uid']&&$_SESSION['randomId']){
            $isLogin=in_array($_COOKIE['uid'],$_SESSION['randomId']);
     }
     if($isLogin!=false){
        // 已经登录
     }else{
        $res->returnCode='未登录';
        return false;
     }
     // print_r(strpos(json_encode($_SESSION['randomId']),$_COOKIE['uid']));
     // print_r(json_encode($test));

     // print_r($_COOKIE['uid']);

   

 ?>
