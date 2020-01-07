var Client = require('node-ftp')
var fs = require('fs')
var path = require('path')

var c = new Client()
c.on('ready', function () {


  var tpath = path.resolve(__dirname, '..') + '/dist'
  getFile(tpath, function (err, results) {
    if (err) throw err
    results.forEach(function (filename) {
      ; (function (filename) {
        // var spath = '根据filename 获取文件名'
        // console.log('本地文件', filename)



        c.put(filename, getServerPath(filename), function (err) {
          if (err) {
            console.log('服务器不存在该文件夹', filename);
            var dir = getServerPath(filename).slice(0, getServerPath(filename).lastIndexOf('/') + 1)
            console.log(dir, 'dir');
            c.mkdir(dir, true, function (err1) {
              if (err1) {
                console.log('创建文件夹失败', err);
                throw err1
              }
              c.put(filename, getServerPath(filename), function (err) {
                if (err) {
                  console.log('创建文件夹成功，上传失败', err)
                }
                console.dir('创建文件夹并上传文件' + getServerPath(filename))
                c.end()
              })
            })
            return;
          }
          console.dir('上传文件' + getServerPath(filename))
          c.end()
        })
      })(filename)
    })
  })
})

var getServerPath = function (filename) {
  return `/htdocs${filename.split('dist')[1]}`
}
var getFile = function (dir, done) {
  var results = []
  fs.readdir(dir, function (err, list) {
    if (err) return done(err)
    var pending = list.length
    if (!pending) return done(null, results)
    list.forEach(function (file) {
      file = path.resolve(dir, file)
      fs.stat(file, function (err, stat) {
        if (stat && stat.isDirectory()) {
          getFile(file, function (err, res) {
            results = results.concat(res)
            if (!--pending) done(null, results)
          })
        } else {
          results.push(file)
          if (!--pending) done(null, results)
        }
      })
    })
  })
}

// connect to aliyun
c.connect({
  host: '60.205.39.154',
  user: 'bxu2442290509',
  password: 'aA5262325',
  remotePath: 'htdocs/',
  port: 21 // 端口
})
