<?php

 	header('content-type:application:json;charset=utf8');  
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:*');  
    header('Access-Control-Allow-Headers:x-requested-with,content-type');
	require_once  'Zend/Mail.php';
	require_once  'Zend/Mail/Transport/Smtp.php';
	class sendMail
	{
	    private static $_config =array(
	        'auth' => 'login',
	        'username' => 'kzc275@163.com',
	        'password' => 'aA5262325'

	    ); // 定义SMTP的验证参数，设置正确的邮箱和登录密码
	    private static $_mail =null;
	    private static $_transport =null;
	    public static function send($title, $body, $address)
	    {
	        try {
	            $transport = new Zend_Mail_Transport_Smtp('smtp.163.com',self::$_config);//实例化验证的对象
	            $mail = new Zend_Mail('UTF-8'); // 实例化发送邮件对象
	            $mail->setBodyHtml($body); // 发送邮件的主体
	            $mail->setFrom('kzc275@163.com','');// 定义邮件发送使用的邮箱
	            $mail->addTo($address,'');// 定义邮件的接收邮箱
	            $mail->setSubject($title); // 定义邮件主题
	            $mail->send($transport); // 执行发送操作
	            return true;
	        } catch (Exception $e) {
	            $e->getTrace();
	            return false;
	        }
	    }
	}

	$title="测试";
	$body='<h1>这是一封来自MarkTao的测试PHP邮件发送邮件!</h1><a href="#">请确认</a>';
	$address = '1142308041@qq.com';
	$sendMail = new sendMail();
	$sendMail->send($title, $body, $address);
?>