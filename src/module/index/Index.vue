<template>
  <div class="app_main">
    <div class="headerTop">
      <global-header ref='gheader'
                     leftName="myNote"
                     rightName="addNote">
        <span></span>
        <span>say something</span>
        <span class="right_hover"
              slot="right"
              @click='gotogame'>贪吃蛇</span>
        <span class="right_hover"
              slot="right"
              @click="mask=true">我要说</span>
      </global-header>
    </div>

    <div class="content">
      <div class="dialog"
           v-if="mask">
        <textarea class="textarea"
                  v-model="result"
                  placeholder="你想说什么"></textarea>
        <input type="text"
               name=""
               placeholder="你的昵称"
               v-model="name">
        <span class="btn"
              @click="send(result,name)">发送</span>
      </div>
      <ul>
        <li class="item"
            v-for="(item,index) in data"
            :key="index">
          <div class="top">
            <p class="name">{{item.nickName}} 说：</p>
            <span class="time">{{item.time}}</span>
          </div>
          <div class="bottom">
            <p>{{item.content}}</p>
          </div>
        </li>
      </ul>
    </div>
    <div class="mask"
         v-if="mask"
         @click.stop.prevent="mask=false"></div>

    <div class="moveUp"
         @click="moveUp">到顶部</div>
    <div class="moveDown"
         @click="move">到底部</div>

    <!-- <img src="@/assets/img/background.jpg"
         class="bgpic"> -->
    <canvas id="c1"
            class="bgpic"></canvas>

  </div>
</template>
<script>
export default {
  name: 'index',
  data () {
    return {
      isOx: navigator.appVersion.toLowerCase().indexOf('safari') > -1 && navigator.appVersion.toLowerCase().indexOf('chrome') == -1,
      isIe: navigator.appVersion.toLowerCase().indexOf('trident') > -1,
      data: [],
      mask: false,
      name: '',
      result: ''
    }
  },
  created () {
    app.post({
      url: '/php/reg.php',
      data: { type: 'check' }
    })
      .then(data => {
        this.data = data
      })
  },
  mounted () {
    function execFun () {
      var oC = document.getElementById('c1')
      var ctx = oC.getContext('2d')

      var getPixelRatio = function (context) {
        var backingStore = context.backingStorePixelRatio ||
          context.webkitBackingStorePixelRatio ||
          context.mozBackingStorePixelRatio ||
          context.msBackingStorePixelRatio ||
          context.oBackingStorePixelRatio ||
          context.backingStorePixelRatio || 1
        return (window.devicePixelRatio || 1) / backingStore
      }
      var ratio = getPixelRatio(ctx)
      var clientHeight = document.documentElement.clientHeight
      var clientWidth = document.documentElement.clientWidth
      oC.style.display = 'block'
      oC.style.height = clientHeight + 'px'
      oC.style.width = clientWidth + 'px'
      // oC.height = clientHeight;
      // oC.width = clientWidth;

      oC.height = clientHeight * ratio
      oC.width = clientWidth * ratio
      ctx.scale(ratio, ratio)  // 消除图形模糊边角问题

      var circleX = clientWidth / 2
      var circleY = clientHeight / 2

      var coreFun = function () {
        ctx.clearRect(0, 0, clientWidth, clientHeight)
        // ctx.save();

        const circleRadius = 200
        // 每秒刻度
        for (var i = 0; i < 60; i++) {
          // 扇形
          ctx.beginPath()
          ctx.moveTo(circleX, circleY)
          ctx.arc(circleX, circleY, circleRadius, i * 6 * Math.PI / 180, (i + 1) * 6 * Math.PI / 180, false)
          ctx.closePath()
          ctx.lineWidth = 1

          ctx.stroke()
        }

        // 每秒刻度盖盘
        ctx.beginPath()
        ctx.arc(circleX, circleY, circleRadius - 10, 0, 360 * Math.PI / 180, false)
        ctx.fillStyle = '#a57676'
        ctx.closePath()
        ctx.fill()
        // 每5秒刻度
        for (var i = 0; i < 12; i++) {
          // 扇形
          ctx.beginPath()
          ctx.moveTo(circleX, circleY)
          ctx.arc(circleX, circleY, circleRadius, i * 30 * Math.PI / 180, (i + 1) * 30 * Math.PI / 180, false)
          ctx.strokeStyle = 'green'
          ctx.closePath()
          ctx.lineWidth = 3

          ctx.stroke()
        }
        // 每5秒刻度盖盘
        ctx.beginPath()
        ctx.arc(circleX, circleY, circleRadius - 15, 0, 360 * Math.PI / 180, false)
        ctx.fillStyle = '#a57676'
        ctx.closePath()

        ctx.fill()

        // 秒针
        // ctx.clearRect(circleX, circleY, oC.width, oC.height);
        var date = new Date()
        var second = date.getSeconds()
        var millSecs = date.getMilliseconds()
        // console.log(second);
        var secMAtchPos = second * 6
        var millSecsMAtchPos = millSecs / 1000 * 6
        var SecSum = (secMAtchPos + millSecsMAtchPos) * 1
        // ctx.setLineDash([8, 8]);
        ctx.beginPath()
        ctx.moveTo(circleX, circleY)
        ctx.arc(circleX, circleY, circleRadius * 0.8, (SecSum + 270) * Math.PI / 180, (SecSum + 270) * Math.PI / 180, false)
        ctx.lineWidth = 1
        ctx.strokeStyle = 'black'
        ctx.closePath()
        ctx.stroke()

        // 分针
        var minutes = date.getMinutes()
        var minPos = minutes * 6 + second / 60 * 6

        ctx.beginPath()
        ctx.moveTo(circleX, circleY)
        ctx.arc(circleX, circleY, circleRadius / 2, (minPos + 270) * Math.PI / 180, (minPos + 270) * Math.PI / 180, false)
        ctx.lineWidth = 1.5
        ctx.strokeStyle = 'black'
        ctx.closePath()
        ctx.stroke()

        // 时针
        var hours = date.getHours()
        var hoursPos = (hours - 12) * 30 + minutes / 60 * 30

        ctx.beginPath()
        ctx.moveTo(circleX, circleY)
        ctx.arc(circleX, circleY, circleRadius / 3, (hoursPos + 270) * Math.PI / 180, (hoursPos + 270) * Math.PI / 180, false)
        ctx.lineWidth = 4
        ctx.strokeStyle = 'black'
        ctx.closePath()
        ctx.stroke()

        // 正方形
        ctx.beginPath()
        ctx.moveTo(circleX - (circleRadius + 20), circleY - (circleRadius + 20))
        ctx.lineTo(circleX + (circleRadius + 20), circleY - (circleRadius + 20))
        ctx.lineTo(circleX + (circleRadius + 20), circleY + (circleRadius + 20))
        ctx.lineTo(circleX - (circleRadius + 20), circleY + (circleRadius + 20))
        ctx.lineTo(circleX - (circleRadius + 20), circleY - (circleRadius + 20))
        ctx.lineWidth = 4
        ctx.strokeStyle = 'black'
        ctx.closePath()
        ctx.stroke()

        if (second % 15 === 0 && millSecs < 20) {
          // 重新生成boom
          var len = parseInt(Math.random() * 30) + 30
          boomArr = []
          for (var i = 0; i < len; i++) {
            boomArr.push({
              posX: circleX, // 开始位置
              posY: circleY,
              vx: parseInt(Math.random() * 201) - 100, // -100 --100
              vy: parseInt(Math.random() * 100) - 80,   // -80---20
              g: 2,
              radius: parseInt(Math.random() * 10) + 4,
              color: getColor(),
              t0: new Date().getTime()
            })
          }
        }

        // boom
        // Vt = V0+at
        boomArr.forEach(res => {
          res.posX = res.posX + res.vx * (date.getTime() - res.t0) / 1000
          res.posY = res.posY + res.vy * (date.getTime() - res.t0) / 1000
          ctx.beginPath()
          ctx.arc(res.posX, res.posY, res.radius, 0, 360 * Math.PI / 180, false)
          ctx.fillStyle = res.color
          ctx.closePath()
          ctx.fill()
          res.vy = res.vy + res.g * (date.getTime() - res.t0) / 1000
        })

        // ctx.restore();
        requestAnimationFrame(coreFun)
      }
      var arr = [
      ]
      // 加速度向下为正，Vy速度向下为正，Vx向右为正
      var boomArr = []
      coreFun()

      function getColor () {
        var str = '#'
        var arr = ['a', 'b', 'c', 'd', 'e', 'f', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
        for (var k = 0; k < 6; k++) {
          str += arr[parseInt(Math.random() * 17)]
        }
        return str
      }
    }
    window.addEventListener('load', execFun)
  },
  methods: {
    gotogame () {
      this.$router.push({ name: 'game' })
    },
    moveUp () {
      let scrollTop = this.isIe ? document.documentElement.scrollTop : window.scrollY
      let docHeight = this.isOx ? document.body.scrollHeight : document.documentElement.scrollHeight
      let clientHeight = document.documentElement.clientHeight

      setTimeout(() => {
        // 缓冲运动
        window.scrollTo(0, scrollTop = scrollTop - ((docHeight - clientHeight - scrollTop) / 6 < 1 ? 1 : (docHeight - clientHeight - scrollTop) / 6))
        if (scrollTop > 0) {
          this.moveUp()
        }
      }, 16)
    },
    move () {
      let scrollTop = this.isIe ? document.documentElement.scrollTop : window.scrollY
      let docHeight = this.isOx ? document.body.scrollHeight : document.documentElement.scrollHeight
      let clientHeight = document.documentElement.clientHeight
      // debugger
      setTimeout(() => {
        // 缓冲运动
        window.scrollTo(0, scrollTop = scrollTop + ((docHeight - clientHeight - scrollTop) / 6 < 1 ? 1 : (docHeight - clientHeight - scrollTop) / 6))
        if (scrollTop <= docHeight - clientHeight - 1) {
          this.move()
        }
      }, 16)
    },
    send (msg, name) {
      // 获取better-scroll实例
      if (msg) {
        name = name.trim() ? name.trim() : '匿名者'
        // name = "(" + ++self.i + " floor " + ")" + name;
        // 获取时间
        var date = new Date()
        var year = date.getFullYear()
        var month = date.getMonth()
        var day = date.getDate()
        var h = date.getHours()
        var m = date.getMinutes()
        var s = date.getSeconds()
        var TimeStr =
          year +
          '年' +
          (month + 1) +
          '月' +
          day +
          '日' +
          h +
          '时' +
          m +
          '分' +
          s +
          '秒'
        app.post({
          url: '/php/reg.php',
          data: {
            type: 'add',
            nickName: name,
            content: msg,
            time: TimeStr
          }
        })
          .then(data => {
            this.data.push({
              time: TimeStr,
              content: msg,
              nickName: name
            })
            app.toast('发送成功')
            this.mask = false
            this.move()
          })
          .catch(error => {
            this.mask = false
            app.toast('error')
          })
      } else {
        app.toast('信息不能为空噢')
      }
    }
  }
}
</script>

<style lang='scss' scoped>
@import './index.scss';
</style>
