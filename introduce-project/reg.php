<?php 
    // header("Content-type: text/html; charset=utf-8"); 
    //对数据进行校验
    // print_r($_SERVER['REQUEST_METHOD']);
    // print_r($_POST);
 //   if($_SERVER['REQUSET_METHOD'] )

header('content-type:application:json;charset=utf8');  
header('Access-Control-Allow-Origin:http://localhost:8080');
header('Access-Control-Allow-Methods:*');  
header('Access-Control-Allow-Headers:x-requested-with,content-type');
if($_SERVER['REQUEST_METHOD']=="POST"){

    //php数据库操作
    //准备好数据连接对象
    $con = new mysqli('bdm274246623.my3w.com','bdm274246623','aA852233','bdm274246623_db'); 
    // $con = new mysqli('127.0.0.1','root','','pro'); 
    mysqli_query($con,"set names 'utf8'");
    if(isset($_REQUEST['type'])){

        if($_REQUEST['type']=='add'){
            $name = ($_REQUEST['nickName']);
            $psw = ($_REQUEST['content']);
            $time = ($_REQUEST['time']);
            $number = ($_REQUEST['number']);

            //1获取当前所有信息
            $sql = 'select * from users';
            // mysqli_query($con,"set names 'utf8'");
            $sql = 'insert into users (id,username,password,age) values("'.$number.'","'.$name.'","'.$psw.'","'.$time.'")';
            // echo $sql;
            if($con->query($sql)){
                echo "true";
            }else{
                echo "false";
            }
            //关闭数据库
            $con->close();
        }else if($_REQUEST['type']=='check'){
            // mysqli_query($con,"set names 'utf8'");
            $sql = 'select * from users';
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
                    $cfg->content=$row['password'];
                    $cfg->time=$row['age'];
                    array_push($arr,$cfg);
                }
            }
            print_r(json_encode($arr));
            
        }else if($_REQUEST['type']=='addNote'){
            $name = ($_REQUEST['nickName']);
            $psw = ($_REQUEST['content']);
            $time = ($_REQUEST['time']);
            $number = ($_REQUEST['number']);

            //1获取当前所有信息
            $sql = 'select * from users';
            // mysqli_query($con,"set names 'utf8'");
            $sql = 'insert into users (id,username,password,age) values("'.$number.'","'.$name.'","'.$psw.'","'.$time.'")';
            // echo $sql;
            if($con->query($sql)){
                echo "true";
            }else{
                echo "false";
            }
            //关闭数据库
            $con->close();
        }


    }
}else{
    echo "request method false";
}
    
 ?>