<?php 

    class Result{  
      public $status;  
     } ;
     class Put_session{  
      } ;
      class Uid{   //一定要定义，session只有数据，没有保存关系！！！！！！！！！！
        public $name;  
        public $randomId;  
       } ;
     $result=new Result(); 
     $result->status=200;


     //判断是否登录
     if(!isset($_COOKIE['uid'])){
            $result->returnDes='cookie不存在';
            $result->cookie=$_COOKIE['uid'];
            die(json_encode($result));
            return false;
     }
     $uid=$_COOKIE['uid'];
     $isLogin=false;
     if(!isset($_SESSION)){
         session_start();
     }
     // $result->cookieid=$uid;
     $user_info = unserialize(base64_decode($_SESSION['userArr']));
     $result->session=$user_info;
     foreach($user_info as $key=>$val)  
     {  
         
         if($val->randomId==$uid){
              $isLogin=true;
              $userId=$val->name; //取出用户名
         }
     } 
     if($isLogin!=false){
        // 已经登录
        $result->returnDes='已经登录';
        $result->returnCode='000000';
        // $result->userId= $userId;
        // die(json_encode($result));
     }else{
        $result->returnDes='未登录';
        die(json_encode($result));
        return false;
     }

     // session_destroy();
     
   

 ?>
