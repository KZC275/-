rem 注释语句 ftp自动上传bat脚本


@echo off
echo open 60.205.39.154 >> temp.txt
echo user bxu2442290509 aA5262325>> temp.txt
echo bin >> temp.txt
echo put "E:\MYPROJECT\dist\output.zip" "htdocs/output.zip" >> temp.txt
REM echo put "E:\MYPROJECT\php\reg.php" "htdocs/php/reg.php" >> temp.txt
echo bye >> temp.txt
ftp -n -s:"temp.txt"
rem del /q D:\MyData\Administrator\Desktop\dist-UAT.zip
pause
del /q temp.txt
