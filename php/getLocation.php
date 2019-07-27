
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
    echo $result;
    return $result;
}

send_get('https://api.map.baidu.com/geocoder?location=22.912416990282885,113.20451426251753&output=json');
    
 ?>