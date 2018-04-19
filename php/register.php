<?php 

    header('content-type:application:json;charset=utf8');  
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:*');  
    header('Access-Control-Allow-Headers:x-requested-with,content-type');

    $name=$_REQUEST['username'];
    $psw=$_REQUEST['psw'];
    class Res{  
       
     } 
    

     $res=new Res(); 
     $res->status=404;
    if($name&&$psw){
         $res->status=200;
         //php数据库操作
         //准备好数据连接对象
         $con = new mysqli('bdm274246623.my3w.com','bdm274246623','aA852233','bdm274246623_db'); 
         mysqli_query($con,"set names 'utf8'");
         // 检测连接
         if ($con->connect_error) {
             die("连接失败: " . $con->connect_error);
         } 

        //防止恶意注册，对比ip地址TODO
        $res->ipAddress=getclientip();
        session_start();
        if(!isset($_SESSION['ipArr'])){
            // echo "string";
            $_SESSION['ipArr']=array($res->ipAddress);
        }else{
            array_push($_SESSION['ipArr'],$res->ipAddress);
        }

         $temp=array_count_values($_SESSION['ipArr']);//统计元素个数
         $res->ipCount=$temp[$res->ipAddress];
         if($res->ipCount>=10){
            $res->returnCode='ip已经多次注册，存在恶意注册行为';
            print_r(json_encode($res));
            return ;
         }



        //已经注册的用户名不能使用
        $sql = 'select * from information';
        $result = $con->query($sql);
        //数据库查询结果的长度 $res->num_rows
        if($result->num_rows>0){
            //fetch_assoc() 执行第一次返回 第一条数据 执行第二次的时候返回第二数据
            // $row 当前获取到的每一行数据
            while ($row = $result->fetch_assoc()) {
                if($name==$row['userName']){
                    //用户名已经占用
                    $res->returnCode='用户名已经占用';
                    print_r(json_encode($res));
                    return ;
                }
            }
        }
        //1获取当前所有信息
        $sql = 'insert into information (userName,psw) values("'.$name.'","'.$psw.'")';
        // echo $sql;
        if($con->query($sql)){
            

            //每注册一个用户都注册一个表
            $sql = 'CREATE TABLE '.$name.' (
            id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
            when_ VARCHAR(30),
            where_ VARCHAR(30),
            who_ VARCHAR(50),
            what_ TEXT(255),
            reg_date TIMESTAMP
            )';

            if ($con->query($sql) === TRUE) {
                $res->createTable= "Table created successfully";

                $res->returnCode=true;

                $res->otherDes='通知成功';
            } else {
                $res->createTable= "创建数据表错误: " . $con->error;
                $res->returnCode=false;
            }
        }else{
            $res->returnCode='注册失败';
        }
            print_r(json_encode($res));
         //关闭数据库
         $con->close();
    }




        /**
        * 获取客户端<a href="https://www.baidu.com/s?wd=IP%E5%9C%B0%E5%9D%80&tn=44039180_cpr&fenlei=mv6quAkxTZn0IZRqIHckPjm4nH00T1dBmhf4nW--ryFhPH6YrHK90ZwV5Hcvrjm3rH6sPfKWUMw85HfYnjn4nH6sgvPsT6KdThsqpZwYTjCEQLGCpyw9Uz4Bmy-bIi4WUvYETgN-TLwGUv3EnHbYPWcLPjfLn1R1rHfdn1czr0" target="_blank" class="baidu-highlight">IP地址</a>
        * @param integer $type
        * @return mixed
        */
       function getclientip() {
              static $realip = NULL;
                
              if($realip !== NULL){
                  return $realip;
              }
              if(isset($_SERVER)){
                  if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){ //但如果客户端是使用代理服务器来访问，那取到的就是代理服务器的 IP 地址，而不是真正的客户端 IP 地址。要想透过代理服务器取得客户端的真实 IP 地址，就要使用 $_SERVER["HTTP_X_FORWARDED_FOR"] 来读取。
                      $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                      /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
                      foreach ($arr AS $ip){
                          $ip = trim($ip);
                          if ($ip != 'unknown'){
                              $realip = $ip;
                              break;
                          }
                      }
                  }else if(isset($_SERVER['HTTP_CLIENT_IP'])){//HTTP_CLIENT_IP 是代理服务器发送的HTTP头。如果是"超级匿名代理"，则返回none值。同样，REMOTE_ADDR也会被替换为这个代理服务器的IP。
                      $realip = $_SERVER['HTTP_CLIENT_IP'];
                  }else{
                      if (isset($_SERVER['REMOTE_ADDR'])){ //正在浏览当前页面用户的 IP 地址
                          $realip = $_SERVER['REMOTE_ADDR'];
                      }else{
                          $realip = '0.0.0.0';
                      }
                  }
              }else{
                  //getenv<a href="https://www.baidu.com/s?wd=%E7%8E%AF%E5%A2%83%E5%8F%98%E9%87%8F&tn=44039180_cpr&fenlei=mv6quAkxTZn0IZRqIHckPjm4nH00T1dBmhf4nW--ryFhPH6YrHK90ZwV5Hcvrjm3rH6sPfKWUMw85HfYnjn4nH6sgvPsT6KdThsqpZwYTjCEQLGCpyw9Uz4Bmy-bIi4WUvYETgN-TLwGUv3EnHbYPWcLPjfLn1R1rHfdn1czr0" target="_blank" class="baidu-highlight">环境变量</a>的值
                  if (getenv('HTTP_X_FORWARDED_FOR')){//但如果客户端是使用代理服务器来访问，那取到的就是代理服务器的 IP 地址，而不是真正的客户端 IP 地址。要想透过代理服务器取得客户端的真实 IP 地址
                      $realip = getenv('HTTP_X_FORWARDED_FOR');
                  }elseif (getenv('HTTP_CLIENT_IP')){ //获取客户端IP
                      $realip = getenv('HTTP_CLIENT_IP');
                  }else{
                      $realip = getenv('REMOTE_ADDR');  //正在浏览当前页面用户的 IP 地址
                  }
              }
              preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
              $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
              return $realip;
       }
    
   
 ?>
