
<?php
header('content-type:application:json;charset=utf8');  
require_once('email.class.php');
//##########################################
$smtpserver = "smtp.163.com";//SMTP服务器
$smtpserverport = 25;//SMTP服务器端口
$smtpusermail = "kzc275@163.com";//SMTP服务器的用户邮箱
// $smtpemailto = "1142308041@qq.com";//发送给谁
$smtpemailto = $_REQUEST['email'];//发送给谁
$smtpuser = "kzc275@163.com";//SMTP服务器的用户帐号
$smtppass = "ai789789";//SMTP服务器的用户密码  网易邮箱客户端授权码
$mailsubject = "PHP测试邮件系统";//邮件主题
$mailbody = "<h1> 这是一个测试程序</h1>";//邮件内容
$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
##########################################
$smtp = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
$smtp->debug = false;//是否显示发送的调试信息
$returnDes=$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
print_r($returnDes);
?>