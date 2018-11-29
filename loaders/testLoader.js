const loaderUtils = require('loader-utils')
function replace (source, opt, callback) {
  // return source
  var arr = source.toString().match(/[\d.]*(px)/g) || []
  console.log(arr, 'hhhhhhh')
  // console.log(source)
  if (arr.length < 1) {
    callback(null, source)
  } else {
    for (var i = 0; i < arr.length; i++) {
      source = source.replace(arr[i], (arr[i].replace('px', '') / opt.base).toFixed(5) + 'remxxxxxxxpppp')
    }
    callback(null, source)
  }
}
var defs = {
  base: 40,
  sourceMaps: false
}
module.exports = function (content) {
  var cb = this.async()
  var opt = Object.assign(loaderUtils.getOptions(this), defs)
  // console.log(opt, 'kkkkkkkk')
  console.log(this.resourcePath, 'ppppkkkkkkkk')

  replace(content, opt, function (err, result) {
    if (err) return cb(err)
    cb(null, result, opt.sourceMaps ? this.sourceMaps : false)
  })
}
