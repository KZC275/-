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
        // console.log(filename)
        c.put(filename, getServerPath(filename), function (err) {
          if (err) throw err
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
