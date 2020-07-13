<?php 
    // header("Content-type: text/html; charset=utf-8"); 
    //对数据进行校验
    // print_r($_SERVER['REQUEST_METHOD']);
    // print_r($_POST);
 //   if($_SERVER['REQUSET_METHOD'] )

header('content-type:application:json;charset=utf8');  
// header('Access-Control-Allow-Origin:http://localhost:8080');
header('Access-Control-Allow-Methods:*');  
header('Access-Control-Allow-Headers:x-requested-with,content-type');



if($_SERVER['REQUEST_METHOD']){

    //php数据库操作
    //准备好数据连接对象
    require_once('connectMysql.php');
    if(isset($_REQUEST['type'])){

        if($_REQUEST['type']=='add'){
            $name = ($_REQUEST['nickName']);
            $psw = emoji_encode($_REQUEST['content']);
            $time = ($_REQUEST['time']);

            //1获取当前所有信息
            $sql = 'insert into users (username,password,age) values("'.$name.'","'.$psw.'","'.$time.'")';
            // echo $sql;
            if($con->query($sql)){
                echo "true";
            }else{
                echo "false";
            }
            
        }else if($_REQUEST['type']=='check'){
            // mysqli_query($con,"set names 'utf8'");
            $sql = 'select * from users ORDER BY id';
            $res = $con->query($sql);
            // print_r(json_encode($res));

            $arr=array();
            class Cat{  
              public $nickName;  
              public $content;  
              public $time;  
             } 
            //数据库查询结果的长度 $res->num_rows
            if($res->num_rows>0){
                //fetch_assoc() 执行第一次返回 第一条数据 执行第二次的时候返回第二数据
                // $row 当前获取到的每一行数据
                while ($row = $res->fetch_assoc()) {
                    // $cfg = new StdClass();
                    $cfg=new Cat(); 
                    $cfg->nickName=$row['username'];
                    $cfg->content=emoji_decode($row['password']);
                    $cfg->time=$row['age'];
                    array_push($arr,$cfg);
                }
            }
            print_r(json_encode($arr));
        
        //新增笔记
        }else if($_REQUEST['type']=='addNote'){
            include './checkLogin.php';
            $when = ($_REQUEST['when']);
            $who = ($_REQUEST['who']);
            $where = ($_REQUEST['where']);
            $what = ($_REQUEST['what']);

            // mysqli_query($con,"set names 'utf8'");
            $sql = 'insert into '.$userId.' (`when_`,`where_`,`who_`,`what_`) values("'.$when.'","'.$where.'","'.$who.'","'.$what.'")';

            // echo $sql;
            if($con->query($sql)){
                echo "true";
            }else{
                echo 'false';
            }
            

        //删除笔记
        }else if($_REQUEST['type']=='delNote'){
            include './checkLogin.php';
            $id = ($_REQUEST['id']);
            //删除
            //delete from 表 where id between 1 and 5 #id为1-3的
            $sql='delete from '.$userId.' where id="'.$id.'"';  
            if($con->query($sql)){
                echo "true";
            }else{
                echo 'false';
            }
            // print_r(json_encode($result));
            
        }else if($_REQUEST['type']=='analysis'){
            //数据统计
            include './checkLogin.php';
            //delete from 表 where id between 1 and 5 #id为1-3的
            $sql='SELECT * FROM information';  
            $result = $con->query($sql);
            // print_r(json_encode($result));
            $arr=array();
            class Note{};
            //数据库查询结果的长度 $res->num_rows
            if($result->num_rows>0){
                //fetch_assoc() 执行第一次返回 第一条数据 执行第二次的时候返回第二数据
                // $row 当前获取到的每一行数据
                while ($row = $result->fetch_assoc()) {
                    $cfg=new Note(); 
                    $cfg->userName=$row['userName'];
                    $cfg->email=$row['email'];
                    array_push($arr,$cfg);
                    
                }
            }
             print_r(json_encode($arr));
            
        }
        //查询笔记
        else if($_REQUEST['type']=='checkNote'){
            include './checkLogin.php';
            //每页15条数据
            $from = ($_REQUEST['from']);
            $to = ($_REQUEST['to']);
            //登录什么用户就查询那个表
            $sql = 'select * from '.$userId.' order by id asc'.' limit '.$from.','.$to; //返回从from下标开始，to这么多条数据
            $res = $con->query($sql);
            if(!$con->query($sql)){
                echo "false";
                echo $sql;
                return;
            }
            // print_r(json_encode($res));
            $arr=array();
            class Note{  
              public $when;  
              public $where;  
              public $who; 
              public $what;   
              public $id;   
             } 
            //数据库查询结果的长度 $res->num_rows
            if($res->num_rows>0){
                //fetch_assoc() 执行第一次返回 第一条数据 执行第二次的时候返回第二数据
                // $row 当前获取到的每一行数据
                while ($row = $res->fetch_assoc()) {
                    $cfg=new Note(); 
                    $cfg->when=$row['when_'];
                    $cfg->where=$row['where_'];
                    $cfg->who=$row['who_'];
                    $cfg->what=$row['what_'];
                    $cfg->id=$row['id'];
                    array_push($arr,$cfg);
                }
            }
            $result->data=$arr;
            print_r(json_encode($result));

        //查询图片
        }else if($_REQUEST['type']=='checkImg'){
            //每页15条数据
            $from = ($_REQUEST['from']);
            $to = ($_REQUEST['to']);
            $sql = 'select * from img limit '.$from.','.$to; //返回从from下标开始，to这么多条数据
            $res = $con->query($sql);
            if(!$con->query($sql)){
                echo "false";
                echo $sql;
                return;
            }
            // print_r(json_encode($res));
            $arr=array();
            class Img{  
              public $src;   
              public $id;   
             } 
            //数据库查询结果的长度 $res->num_rows
            if($res->num_rows>0){
                //fetch_assoc() 执行第一次返回 第一条数据 执行第二次的时候返回第二数据
                // $row 当前获取到的每一行数据
                while ($row = $res->fetch_assoc()) {
                    $cfg=new Img(); 
                    $cfg->src=$row['src'];
                    $cfg->id=$row['id'];
                    array_push($arr,$cfg);
                }
            }
            print_r(json_encode($arr));
        } else if($_REQUEST['type']=='addScore'){
            $name = ($_REQUEST['name']);
            $score = ($_REQUEST['score']);
            $browser = ($_SERVER['HTTP_USER_AGENT']);
            $ip = getclientip();

            //1获取当前所有信息
            $sql = 'insert into _game_ (name,score,browser,ip) values("'.$name.'","'.$score.'","'.$browser.'","'.$ip.'")';
            // echo $sql;
            if($con->query($sql)){
                echo "true";
            }else{
                echo "false";
            }
        } else if($_REQUEST['type']=='getScore'){
             // mysqli_query($con,"set names 'utf8'");
             $sql = 'select * from _game_ ORDER BY score';
             $res = $con->query($sql);
             // print_r(json_encode($res));
 
             $arr=array();
             class Score{  
               public $name;  
               public $score;  
               public $time;  
              } 
             //数据库查询结果的长度 $res->num_rows
             if($res->num_rows>0){
                 //fetch_assoc() 执行第一次返回 第一条数据 执行第二次的时候返回第二数据
                 // $row 当前获取到的每一行数据
                 while ($row = $res->fetch_assoc()) {
                     // $cfg = new StdClass();
                     $cfg=new Score(); 
                     $cfg->name=$row['name'];
                     $cfg->score=$row['score'];
                     $cfg->time=$row['time'];
                     array_push($arr,$cfg);
                 }
             }
             print_r(json_encode($arr));
        }

        //关闭数据库
        $con->close();


    }
}else{
    echo "request method false";
}
 /**
        * 获取客户端<a href="https://www.baidu.com/s?wd=IP%E5%9C%B0%E5%9D%80&tn=44039180_cpr&fenlei=mv6quAkxTZn0IZRqIHckPjm4nH00T1dBmhf4nW--ryFhPH6YrHK90ZwV5Hcvrjm3rH6sPfKWUMw85HfYnjn4nH6sgvPsT6KdThsqpZwYTjCEQLGCpyw9Uz4Bmy-bIi4WUvYETgN-TLwGUv3EnHbYPWcLPjfLn1R1rHfdn1czr0" target="_blank" class="baidu-highlight">IP地址</a>
        * @param integer $type
        * @return mixed
        */
    //     function getclientip() {
    //         static $realip = NULL;
              
    //         if($realip !== NULL){
    //             return $realip;
    //         }
    //         if(isset($_SERVER)){
    //             if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){ //但如果客户端是使用代理服务器来访问，那取到的就是代理服务器的 IP 地址，而不是真正的客户端 IP 地址。要想透过代理服务器取得客户端的真实 IP 地址，就要使用 $_SERVER["HTTP_X_FORWARDED_FOR"] 来读取。
    //                 $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    //                 /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
    //                 foreach ($arr AS $ip){
    //                     $ip = trim($ip);
    //                     if ($ip != 'unknown'){
    //                         $realip = $ip;
    //                         break;
    //                     }
    //                 }
    //             }else if(isset($_SERVER['HTTP_CLIENT_IP'])){//HTTP_CLIENT_IP 是代理服务器发送的HTTP头。如果是"超级匿名代理"，则返回none值。同样，REMOTE_ADDR也会被替换为这个代理服务器的IP。
    //                 $realip = $_SERVER['HTTP_CLIENT_IP'];
    //             }else{
    //                 if (isset($_SERVER['REMOTE_ADDR'])){ //正在浏览当前页面用户的 IP 地址
    //                     $realip = $_SERVER['REMOTE_ADDR'];
    //                 }else{
    //                     $realip = '0.0.0.0';
    //                 }
    //             }
    //         }else{
    //             //getenv<a href="https://www.baidu.com/s?wd=%E7%8E%AF%E5%A2%83%E5%8F%98%E9%87%8F&tn=44039180_cpr&fenlei=mv6quAkxTZn0IZRqIHckPjm4nH00T1dBmhf4nW--ryFhPH6YrHK90ZwV5Hcvrjm3rH6sPfKWUMw85HfYnjn4nH6sgvPsT6KdThsqpZwYTjCEQLGCpyw9Uz4Bmy-bIi4WUvYETgN-TLwGUv3EnHbYPWcLPjfLn1R1rHfdn1czr0" target="_blank" class="baidu-highlight">环境变量</a>的值
    //             if (getenv('HTTP_X_FORWARDED_FOR')){//但如果客户端是使用代理服务器来访问，那取到的就是代理服务器的 IP 地址，而不是真正的客户端 IP 地址。要想透过代理服务器取得客户端的真实 IP 地址
    //                 $realip = getenv('HTTP_X_FORWARDED_FOR');
    //             }elseif (getenv('HTTP_CLIENT_IP')){ //获取客户端IP
    //                 $realip = getenv('HTTP_CLIENT_IP');
    //             }else{
    //                 $realip = getenv('REMOTE_ADDR');  //正在浏览当前页面用户的 IP 地址
    //             }
    //         }
    //         preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    //         $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
    //         return $realip;
    //  }
  
 ?>