<?php
header("Content-Type: text/html;charset=utf-8"); 
define('ROOT',dirname(__FILE__).'/');  

if (($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
&& ($_FILES["file"]["size"] < 20000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    // // 上传图片重命名
    // $profile=$_FILES["file"]["name"];
    if (file_exists("../img/" . "profile.jpg"))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      unlink( "../img/" . "profile.jpg" );

      $stored_path = ROOT.'../img/'.basename("profile.jpg");  
      move_uploaded_file($_FILES["file"]["tmp_name"], $stored_path);
      }
    else
      {
      // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
      //注意：如果没有 ROOT全路径的话,就会上传失败，切记。
      $stored_path = ROOT.'../img/'.basename("profile.jpg");  
      move_uploaded_file($_FILES["file"]["tmp_name"], $stored_path);

      echo "Stored in: " . "../img/" . $_FILES["file"]["name"];
      }
    }
  }
else
  {
  echo "Invalid file";
  }
?>