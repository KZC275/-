<?php 
        
    header('content-type:application:json;charset=utf8');  
    // header('Access-Control-Allow-Origin:http://localhost:8080');
    // header('Access-Control-Allow-Methods:*');  
    // header('Access-Control-Allow-Headers:x-requested-with,content-type');
    // header('Access-Control-Allow-Credentials:true');


    class Res{  
      public $status;  
     } ;
     class Put_session{  
      } ;
      class Uid{   //一定要定义，session只有数据，没有保存关系！！！！！！！！！！
        public $name;  
        public $randomId;  
       } ;
     $res=new Res(); 
     $res->status=200;
     if(!isset($_SESSION)){
         session_start();
     }

    // $test=array(10,20,30,"10","20","30"); 
    // print_r(array_keys($test,"10",true));//严格匹配模式 
    //输出： 
    //Array ( [0] => 3) 

    //判断要注销的用户是否在session里面,并得出下标
    // $isExist=array_keys($_SESSION['randomId'],$_COOKIE['uid']);
     if(!isset($_COOKIE['uid'])){
        $res->returnCode=false;
        $res->returnDes='用户不存在';
        die(json_encode($res));
     }
     $uid=$_COOKIE['uid'];
     $isLogout=false;
     $user_info = unserialize(base64_decode($_SESSION['userArr']));
     foreach($user_info as $key=>$val)  
     {  
         // echo $key.'=>';  
         // print_r($val);  
         // echo '<br>';  
         // print_r($val);
         // print_r($_SESSION['userArr']);
         // $res->$key=$val;
         if($val->randomId==$uid){
             //如果已经登录，先注销
            $isLogout=true;
            $res->randomId_del=gettype($user_info); //数组
             unset($user_info[$key]);
             // print_r(json_encode($res));
             // return ;
         }
     }
     $_SESSION['userArr']=base64_encode(serialize($user_info));  

    if($isLogout){
        
        $res->returnCode=true;
    }else{
        //注销失败
        $res->returnCode=false;
    }

    // print_r(json_encode($_SESSION['randomId']));
    print_r(json_encode($res));
    // print_r(json_encode($res));



   

 ?>
