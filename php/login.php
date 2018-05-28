<?php 

    header('content-type:application:json;charset=utf8');  
    header('Access-Control-Allow-Origin:http://localhost:8080');
    header('Access-Control-Allow-Methods:*');  
    header('Access-Control-Allow-Headers:x-requested-with,content-type');
    // header("Access-Control-Allow-Credentials:true");

    $name=$_REQUEST['username'];
    $psw=$_REQUEST['psw'];
    class Res{  
       public $status;
     } ;
     class Uid{  
       public $name;  
       public $randomId;  
      } ;
      class Put_session{  
       } ;

     $res=new Res(); 
     $res->status=404;
    if($name&&$psw){
         $res->status=200;
         //php数据库操作
         //准备好数据连接对象
         $con = new mysqli('bdm274246623.my3w.com','bdm274246623','aA852233','bdm274246623_db'); 
         mysqli_query($con,"set names 'utf8'");

         //1获取当前所有的用户信息
         $sql = 'select * from information';
         $res = $con->query($sql);

         //2 获取的用户信息与当前注册信息进行
         $bool_name = false;
         $bool_psw = false;
         //数据库查询结果的长度 $res->num_rows
         if($res->num_rows>0){
             //fetch_assoc() 执行第一次返回 第一条数据 执行第二次的时候返回第二数据
             // $row 当前获取到的每一行数据
             while ($row = $res->fetch_assoc()) {
                 # code...
                 //判断用户是否注册
                 if($row['userName'] == $name){
                     $bool_name = true; //用户已经注册
                     if($row['psw'] == $psw){
                           $bool_psw = true; //密码正确
                     }
                 }
          
             }
         }

         

         if(!isset($_SESSION)){
             session_start();
         }
           // session_destroy();
         //通过判断注册的bool 去插入当前的注册用户的信息
         if($bool_name&&$bool_psw){
                // echo "true"; //登录成功
                $res->returnCode=true;
                 $cfg=new Uid(); 
                 $cfg->name=$name;
                 $cfg->randomId=generate_uid();
                
                //随机UID返回给客户端，首次登录
                if(!isset($_SESSION['userArr'])){
                    

                     $_SESSION['userArr']=base64_encode(serialize(array($cfg)));

                }else{
                    // 非首次登录
                    $user_info = unserialize(base64_decode($_SESSION['userArr']));
                    foreach($user_info as $key=> $val)  
                    {  
                        
                        if($val->name==$name){
                            //如果已经登录，先注销
                            unset($user_info[$key]);
                            
                            
                        }
                    }
                    array_push($user_info,$cfg);//
                    $_SESSION['userArr']=base64_encode(serialize($user_info));
                    
                }

                //登录成功只返回随机uid，设置客户端cookie  24小时过期
                setcookie("uid",$cfg->randomId, time()+3600*24,'/');
                // setcookie("uid",$cfg->randomId, time()+3600*24,'/','localhost:8080');
                $res->currentUid=$cfg->randomId;
                $res->sess=$user_info;
                $res->cookie=$_COOKIE;

         }else{
            $res->returnCode= $bool_name?'密码错误':'用户没有注册';
         }
         //jsonp跨域方法
         // $callback_test=json_encode($res);
         // print_r('success_jsonpcallbak'.'('.$callback_test.')');
         
         print_r(json_encode($res));
         // session_destroy();

         //关闭数据库
         $con->close();
    }

    function generate_uid( $length = 10 ) { 
        // 密码字符集，可任意添加你需要的字符 
        // $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|'; 
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; 

        $uid = ''; 
        for ( $i = 0; $i < $length; $i++ ) 
        { 
        // 这里提供两种字符获取方式 
        // 第一种是使用 substr 截取$chars中的任意一位字符； 
        // 第二种是取字符数组 $chars 的任意元素 
        // $uid .= substr($chars, mt_rand(0, strlen($chars) – 1), 1); 
        $uid .= $chars[ mt_rand(0, strlen($chars) - 1) ]; 
        } 
        return $uid; 
    } 
   
 ?>
