
var gulp = require('gulp'),
    // project = require('./package.json').project,
    // revAppend = require('gulp-rev-append'),
    // rename = require('gulp-rename'),
    sftp = require('gulp-sftp');
   
    getCurrentDate = function () {
      var currentDate = new Date();
      if (!String.prototype.padStart) {
          String.prototype.padStart = function padStart(targetLength, padString) {
              targetLength = targetLength >> 0; //floor if number or convert non-number to 0;
              padString = String(padString || ' ');
              if (this.length > targetLength) {
                  return String(this);
              }
              else {
                  targetLength = targetLength - this.length;
                  if (targetLength > padString.length) {
                      padString += padString.repeat(targetLength / padString.length); //append to original to ensure we are longer than needed
                  }
                  return padString.slice(0, targetLength) + String(this);
              }
          };
      }
      return '' + currentDate.getFullYear() + '-' + ('' + (currentDate.getMonth() + 1)).padStart(2, 0) + '-' + ('' + currentDate.getDate()).padStart(2, 0) + ' ' + ('' + currentDate.getHours()).padStart(2, 0) + ':' + ('' + currentDate.getMinutes()).padStart(2, 0) + ':' + ('' + currentDate.getSeconds()).padStart(2, 0);
  };

// 添加发版时间 (发版时调用)
gulp.task('add:release-time', function () {
  return gulp.src([
      'dist/index.html'
  ])
      .pipe(each(function (content, file, callback) {
          var versionContent = content.replace(/release-time/g, function (result) {
              if (result.indexOf('release') > -1) {
                  return project + ' ' + ' ' + getCurrentDate() + ' 发版成功';
              }
          });
          callback(null, versionContent);
      }))
      .pipe(revAppend())
      .pipe(rename('index.html'))
      .pipe(gulp.dest('dist/'))
})
gulp.task('ftpToaliyun', function (err,h,j,k) {
    console.log(err,h,j,k)
    return gulp.src('dist/**')
        .pipe(sftp({
            host: '60.205.39.154',
            user: 'bxu2442290509',
            pass: 'aA5262325',
            remotePath: 'htdocs',
            remotePlatform: 'windows'
        }))
});


// 发版 盈峰 SIT环境 
gulp.task('ftpToYFSit', ['add:release-time'], function () {
  return gulp.src('dist/**')
      .pipe(sftp({
          host: '10.17.155.32',
          user: 'apps',
          pass: 'Apps@123',
          remotePath: '/apps/svr/tomcat8080/webapps/jiebao-plus'
      }))
});

// 发版 美的 SIT环境
gulp.task('ftpToXsSit', ['add:release-time'], function () {
    return gulp.src('dist/**')
        .pipe(sftp({
            host: '10.16.41.161',
            user: 'root',
            pass: 'Xs1!2@3#',
            remotePath: '/apps/svr/front-web/tomcat/webapps/jiebao-plus'
        }))
});

// 发版 销司 UAT环境
gulp.task('ftpToXsUat', ['add:release-time'], function () {
    return gulp.src('dist/**')
        .pipe(sftp({
            host: '172.16.16.36',
            user: 'root',
            pass: 'Xsuat1!2@3#',
            remotePath: '/apps/svr/front-web/tomcat8080/webapps/jiebao-plus'
        }))
});

// 发版 美的 UAT环境
gulp.task('ftpToEMSUat', ['add:release-time'], function () {
    return gulp.src('dist/**')
        .pipe(sftp({
            host: '10.17.153.76',
            user: 'apps',
            pass: 'Apps@123',
            remotePath: '/apps/svr/frontPage-web/tomcat8080/webapps/jiebao-plus'
        }))
});

// 发版 销司 PRO环境
gulp.task('ftpToEMSProd', ['add:release-time'], function () {
    return gulp.src('dist/**')
        .pipe(sftp({
            host: '10.17.163.9',
            user: 'apps',
            pass: 'cGy&NajL7Y',
            remotePath: '/apps/svr/front-web/tomcat8080/webapps/jiebao-plus'
        }))
        .pipe(sftp({
            host: '10.17.163.10',
            user: 'apps',
            pass: 'cGy&NajL7Y',
            remotePath: '/apps/svr/front-web/tomcat8080/webapps/jiebao-plus'
        }))
});

// 发版 阳光城 SIT环境
gulp.task('ftpToYGSit', ['add:release-time'], function () {
    return gulp.src('dist/**')
        .pipe(sftp({
            host: '10.17.149.33',
            user: 'apps',
            pass: 'Apps@123',
            remotePath: '/apps/svr/tomcat8080/webapps/jiebao-plus'
        }))
});

// 发版 欧菲 SIT环境
gulp.task('ftpToOFSit', ['add:release-time'], function () {
    return gulp.src('dist/**')
        .pipe(sftp({
            host: '10.17.149.14',
            user: 'apps',
            pass: 'Apps@123',
            remotePath: '/apps/svr/tomcat8080/webapps/jiebao-plus'
        }))
});

// 发版 欧菲 远程 SIT环境
gulp.task('ftpToRemoteOFSit', ['add:release-time'], function () {
    return gulp.src('dist/**')
        .pipe(sftp({
            host: '192.168.120.13',
            user: 'root',
            pass: 'Of123456',
            remotePath: '/apps/svr/tomcat-8081/webapps/jiebao-plus'
        }))
});