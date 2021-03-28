<template>
  <div>
    <div class="weui-uploader"
         style="padding:15px;">
      <!-- <div class="weui-uploader__hd">
          <div class="weui-uploader__info">{{uploadFiles.length}}/{{limit}}</div>
      </div> -->
      <div class="weui-uploader__bd">
        <ul class="weui-uploader__files"
            id="uploaderFiles">
          <li v-for="(file, idx) in uploadFiles"
              :key="idx"
              class="file"
              @click="showRemove(file)">
            <span>{{file.name}}</span>
            <inline-loading v-if="file.status === 'uploading'"></inline-loading>
            <i v-else
               class="weui-icon weui_icon_success weui-icon-success"></i>
          </li>
        </ul>
        <div class="weui-uploader__input-box"
             v-if="uploadFiles.length < limit">
          <input ref="input"
                 id="uploaderInput"
                 class="weui-uploader__input"
                 type="file"
                 multiple
                 @change="handleChange" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Icon, InlineLoading } from 'vux'
// import req from 'api/attendance.js'
// import { BASE_URL } from 'common/js/config'
const BASE_URL = ''
// import { getToken } from 'api/util/auth'
const getToken = () => ({})
function getBody (xhr) {
  const text = xhr.responseText || xhr.response
  if (!text) {
    return text
  }

  try {
    return JSON.parse(text)
  } catch (e) {
    return text
  }
}
function getError (action, option, xhr) {
  let msg
  if (xhr.response) {
    msg = `${xhr.response.error || xhr.response}`
  } else if (xhr.responseText) {
    msg = `${xhr.responseText}`
  } else {
    msg = `fail to post ${action} ${xhr.status}`
  }

  const err = new Error(msg)
  err.status = xhr.status
  err.method = 'post'
  err.url = action
  return err
}
function noop () { }
export default {
  props: {
    fileList: {
      type: Array,
      default: () => { return [] }
    },
    limit: {
      type: Number,
      default: 9
    },
    onExceed: Function,
    multiple: true,
    onStart: Function,
    autoUpload: true,
    onChange: {
      type: Function,
      default: noop
    },
    onProgress: {
      type: Function,
      default: noop
    },
    onRemove: {
      type: Function,
      default: noop
    },
    onError: {
      type: Function,
      default: noop
    },
    onSuccess: {
      type: Function,
      default: noop
    },
    uploadFiles: {
      type: Array,
      default: () => { return [] }
    }
  },
  data () {
    return {
      // action: `${BASE_URL}/system/attachments/file`,
      action: `${BASE_URL}/php/IMG.php`,
      tempIndex: 1
      // uploadFiles: []
    }
  },
  components: {
    Icon,
    InlineLoading
  },
  methods: {
    getFile (rawFile) {
      let fileList = this.uploadFiles
      let target
      fileList.every(item => {
        target = rawFile.uid === item.uid ? item : null
        return !target
      })
      return target
    },
    handleChange (ev) {
      const files = ev.target.files

      if (!files) return
      this.uploadFilesFun(files)
    },
    handleStart (rawFile) {
      rawFile.uid = Date.now() + this.tempIndex++
      let file = {
        status: 'uploading',
        name: rawFile.name,
        size: rawFile.size,
        percentage: 0,
        uid: rawFile.uid,
        raw: rawFile
      }

      try {
        file.url = URL.createObjectURL(rawFile)
      } catch (err) {
        console.error(err)
        return
      }

      this.uploadFiles.push(file)
      this.onChange(file, this.uploadFiles)
    },
    handleProgress (ev, rawFile) {
      const file = this.getFile(rawFile)
      file.status = 'uploading'
      this.onProgress(ev, file, this.uploadFiles)
      file.percentage = ev.percent || 0
    },
    handleSuccess (res, rawFile) {
      const file = this.getFile(rawFile)

      if (file) {
        file.status = 'success'
        file.response = res

        this.onSuccess(res, file, this.uploadFiles)
        this.onChange(file, this.uploadFiles)
      }
    },
    handleError (err, rawFile) {
      const file = this.getFile(rawFile)
      const fileList = this.uploadFiles

      file.status = 'fail'

      fileList.splice(fileList.indexOf(file), 1)

      this.onError(err, file, this.uploadFiles)
      this.onChange(file, this.uploadFiles)
    },
    handleRemove (file, raw) {
      if (raw) {
        file = this.getFile(raw)
      }
      let doRemove = () => {
        let fileList = this.uploadFiles
        fileList.splice(fileList.indexOf(file), 1)
        this.onRemove(file, fileList)
      }

      doRemove()
    },
    showRemove (file, _this = this) {
      this.$vux.confirm.show({
        title: '提示',
        content: `确定要删除${file.name}吗`,
        onConfirm () {
          _this.handleRemove(file)
        }
      })
    },
    uploadFilesFun (files) {
      if (this.limit && this.fileList.length + files.length > this.limit) {
        this.onExceed && this.onExceed(files, this.fileList)
        return
      }

      let postFiles = Array.prototype.slice.call(files)
      if (!this.multiple) { postFiles = postFiles.slice(0, 1) }

      if (postFiles.length === 0) { return }

      postFiles.forEach(rawFile => {
        this.handleStart(rawFile)
        this.upload(rawFile)
      })
    },
    upload (rawFile) {
      this.$refs.input.value = null

      if (!this.beforeUpload) {
        return this.post(rawFile)
      }

      const before = this.beforeUpload(rawFile)
      if (before && before.then) {
        before.then(processedFile => {
          const fileType = Object.prototype.toString.call(processedFile)

          if (fileType === '[object File]' || fileType === '[object Blob]') {
            if (fileType === '[object Blob]') {
              processedFile = new File([processedFile], rawFile.name, {
                type: rawFile.type
              })
            }
            for (const p in rawFile) {
              if (rawFile.hasOwnProperty(p)) {
                processedFile[p] = rawFile[p]
              }
            }
            this.post(processedFile)
          } else {
            this.post(rawFile)
          }
        }, () => {
          this.onRemove(null, rawFile)
        })
      } else if (before !== false) {
        this.post(rawFile)
      } else {
        this.onRemove(null, rawFile)
      }
    },
    post (rawFile) {
      console.log('进来上传了')

      // const { uid } = rawFile
      const options = {
        headers: { ihrAdminAuthorization: getToken() },
        withCredentials: true,
        file: rawFile,
        data: this.data,
        filename: 'file',
        action: this.action,
        onProgress: e => {
          this.handleProgress(e, rawFile)
        },
        onSuccess: res => {
          this.handleSuccess(res, rawFile)
          // delete this.reqs[uid]
        },
        onError: err => {
          this.handleError(err, rawFile)
          // delete this.reqs[uid]
        }
      }
      const req = this.httpRequest(options)
      // this.reqs[uid] = req;
      if (req && req.then) {
        req.then(options.onSuccess, options.onError)
      }
    },
    httpRequest (option) {
      if (typeof XMLHttpRequest === 'undefined') {
        return
      }
      const xhr = new XMLHttpRequest()
      const action = option.action

      if (xhr.upload) {
        xhr.upload.onprogress = function progress (e) {
          if (e.total > 0) {
            e.percent = e.loaded / e.total * 100
          }
          option.onProgress(e)
        }
      }
      const formData = new FormData()
      if (option.data) {
        Object.keys(option.data).forEach(key => {
          formData.append(key, option.data[key])
        })
      }

      formData.append(option.filename, option.file, option.file.name)

      xhr.onerror = function error (e) {
        option.onError(e)
      }

      xhr.onload = function onload () {
        if (xhr.status < 200 || xhr.status >= 300) {
          return option.onError(getError(action, option, xhr))
        }

        option.onSuccess(getBody(xhr))
      }

      xhr.open('post', action, true)

      if (option.withCredentials && 'withCredentials' in xhr) {
        xhr.withCredentials = true
      }

      const headers = option.headers || {}

      for (let item in headers) {
        if (headers.hasOwnProperty(item) && headers[item] !== null) {
          xhr.setRequestHeader(item, headers[item])
        }
      }
      xhr.send(formData)
      return xhr
    }
  }
}
</script>

<style lang="less" scoped>
@import '~vux/src/styles/weui/widget/weui-uploader/index.less';
.file {
  transition: all 0.5s cubic-bezier(0.55, 0, 0.1, 1);
  font-size: 14px;
  color: #606266;
  line-height: 1.8;
  margin-top: 5px;
  position: relative;
  box-sizing: border-box;
  border-radius: 4px;
  width: 100%;
}
.change {
  &:hover::before {
    content: '\EA0F';
  }
}
</style>
