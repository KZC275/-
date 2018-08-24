#从FTP上下载单文件到本地
#!/bin/sh
# ftp -v -n 60.205.39.154<<EOF
# user bxu2442290509 aA5262325
# binary
# cd htdocs
# lcd ./
# prompt
# #get down.txt
# get index.html
# bye
# EOF
# echo "download from ftp successfully"


#从本地向FTP批量上传文档  需要赋予该.shell文件权限才能成为可执行文件
#!/bin/sh
ftp -v -n 60.205.39.154<<EOF
user bxu2442290509 aA5262325
binary
hash
# 服务器的目录
cd htdocs
# cd htdocs/php
# 本地的目录
lcd /Users/kezengcai/Documents/myproject/dist
# lcd /Users/kezengcai/Documents/myproject/php
prompt
# 上传的文件名
# mput login.php

mput output.zip
bye
#here document
EOF
echo "commit to ftp successfully"
