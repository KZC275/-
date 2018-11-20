const loaderUtils = require('loader-utils')
function replace (source) {
  // 使用正则把 // @require '../style/index.css' 转换成 require('../style/index.css');
  return source
}

module.exports = function (content) {
  let opt = loaderUtils.getOptions(this)
  console.log(opt, 'kkkkkkkk')
  console.log(this.resourcePath)

  return replace(content)
}
