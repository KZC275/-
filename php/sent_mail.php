
<?php
    header('content-type:application:json;charset=utf8');  
    require_once('email.class.php');
    
    class Res{ 
    } ;
    $res=new Res(); 
    if(!$_REQUEST['email']){
        //没有收到邮箱
        $res->returnCode=false;
        $res->returnDes='邮箱不能为空';
        print_r(json_encode($res));
        return;
    }
    //检查邮箱是否注册
    $temp=findEmail($_REQUEST['email'],$res);
    if(!$temp){
        print_r(json_encode($res));
        return;
    }
    //##########################################
    $smtpserver = "smtp.163.com";//SMTP服务器
    $smtpserverport = 25;//SMTP服务器端口
    $smtpusermail = "kzc275@163.com";//SMTP服务器的用户邮箱
    // $smtpemailto = "1142308041@qq.com";//发送给谁
    $smtpemailto = $_REQUEST['email'];//发送给谁
    $smtpuser = "kzc275@163.com";//SMTP服务器的用户帐号
    $smtppass = "ai789789";//SMTP服务器的用户密码  网易邮箱客户端授权码
    $mailsubject = "找回密码";//邮件主题
    $mailbody = "<h1> 你的密码是：".$temp."</h1>";//邮件内容
    $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
    ##########################################
    $smtp = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
    $smtp->debug = false;//是否显示发送的调试信息
    $returnDes=$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
    print_r(json_encode($res));

    //函数内部不能直接访问$res
    function findEmail($email,$res){
        require_once('connectMysql.php');
        //1获取当前所有的用户信息
        $sql = 'select * from information';
        $result = $con->query($sql);
        //2 获取的用户信息与当前注册信息进行
        $bool_email = false;
        //数据库查询结果的长度 $result->num_rows
        if($result->num_rows>0){
            //fetch_assoc() 执行第一次返回 第一条数据 执行第二次的时候返回第二数据
            // $row 当前获取到的每一行数据
            while ($row = $result->fetch_assoc()) {
                # code...
                //判断用户是否注册
                if($row['email'] == $email){
                    $bool_email = true; //用户邮箱已经注册
                    //取出密码
                    $psw=$row['psw'];
                    $res->returnCode=true;
                    break;
                }
            }
        }
        if($bool_email==false){
            $res->returnCode=false;
            $res->returnDes='邮箱没有注册';
        }
        //关闭数据库
        $con->close();

        return $psw;

    }
?>