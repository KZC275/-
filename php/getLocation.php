
<?php 
   

// header('content-type:application:json;charset=utf8');  
// header('Access-Control-Allow-Origin:http://localhost:8080');
// header('Access-Control-Allow-Methods:*');  
// header('Access-Control-Allow-Headers:x-requested-with,content-type');


function send_get($url) {
    $options = array(
        'http' => array(
            'method' => 'GET',
            'header' => 'Content-type:application/x-www-form-urlencoded',
            'content' => '',
            'timeout' => 15 * 60 // 超时时间（单位:s）
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}


 function getData(){
    require('connectMysql.php');
    $latitude = ($_REQUEST['latitude']);
    $longitude = ($_REQUEST['longitude']);
    $HTTP_USER_AGENT = ($_SERVER['HTTP_USER_AGENT']);
    $ip = getclientip();
    $data = send_get('https://api.map.baidu.com/geocoder?location='.$latitude.','.$longitude.'&output=json');
    $result = addslashes($data);
    //1获取当前所有信息
    $sql = 'insert into _location (latitude,longitude,browser,geo,ip) values("'.$latitude.'","'.$longitude.'","'.$HTTP_USER_AGENT.'","'.$result.'","'.$ip.'")';
    if($con->query($sql)){
        echo "true";
    }else{
        print_r($con);
        echo "false";
    }
 }
 getData();

    
 ?>