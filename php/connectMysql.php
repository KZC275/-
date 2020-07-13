<?php 
    //php数据库操作
    //准备好数据连接对象
    // $con = new mysqli('127.0.0.1','root','yy789789','myproject'); //连接地址不可加上http协议开头
    $con = new mysqli('bdm682328549.my3w.com','bdm682328549','pP789789','bdm682328549_db'); 
    if (mysqli_connect_errno()){
        echo '数据库连接错误'.mysqli_connect_error();
        exit();
    }
    // 检测连接
    // if ($con->connect_error) {
    //     die("连接失败: " . $con->connect_error);
    // } 
    mysqli_query($con,"set names 'utf8'");
    // echo 'success';


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

     //对emoji表情转义
    function emoji_encode($str){
        $strEncode = '';

        $length = mb_strlen($str,'utf-8');

        for ($i=0; $i < $length; $i++) {
            $_tmpStr = mb_substr($str,$i,1,'utf-8');    
            if (strlen($_tmpStr) >= 4){
                $strEncode .= '[[EMOJI:'.rawurlencode($_tmpStr).']]';
            } else {
                $strEncode .= $_tmpStr;
            }
        }

        return $strEncode;
    }

    //对emoji表情转反义
    function emoji_decode($str){
        $strDecode = preg_replace_callback('|\[\[EMOJI:(.*?)\]\]|', function($matches){  
            return rawurldecode($matches[1]);
        }, $str);

        return $strDecode;
    }

        
   
 ?>
