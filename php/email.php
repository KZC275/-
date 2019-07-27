<?php
  
    header('content-type:application:json;charset=utf8');  
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:*');  
    header('Access-Control-Allow-Headers:x-requested-with,content-type');

    // echo  $_REQUEST['test'];
    include './Zend/Mail.php';
    include './Zend/Mail/Transport/Smtp.php';
    $tr=new Zend_Mail_Transport_Smtp("smtp.163.com",
                                  array('auth'=>'login',
                                     'port'=> '25',
                                        'username'=>'kzc275@163.com',
                                        'password'=>'aA5262325'));    //发件人邮箱和密码
          $mail = new Zend_Mail('UTF-8');
          $mail->setSubject('This is a test email');
          $mail->setFrom('<a href="mailto:kzc275@163.com">','aaa');       //发件人邮箱
          $mail->addTo('<a href="mailto:AQ2012AQ@163.com">','aaa');    //收件人邮箱
          $mail->setBodyText('');
          $mail->setBodyHtml("Test EmailTest email");
   
    if(false == $mail->send($tr) ) {
       echo ("fail");
    }
    else {
    
     echo ("success");
    }
          $tr->__destruct();

 

?> 