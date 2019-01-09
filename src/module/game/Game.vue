<template>
    <div class="header">
      <div class="box">
        <div class="left">
          <h3>得分榜：</h3>
          <p v-for="(item, index) in arrScore" :key="index">{{item.name}}：<strong>{{item.score}}分</strong></p>
        </div>
        <div class="right">
            <h2>键盘上下左右键控制</h2>
            <canvas style="border:1px solid #ccc;" height="400px" width="400px" id="canvas">你的浏览器不支持canvas</canvas>
          <h2>你的分数：{{score}}</h2>
          <button @click="reset"> 重新开始</button>
        </div>
    </div>
  </div>
</template>
<script>

export default {
  name: 'game',
  data() {
    return {
      score: 0,
      name: '',
      $snake: null,
      arrScore: [{ name: 'ssdsd', score: 222 }]

    }
  },
  methods: {
    reset() {
      // clearTimeout(this.$snake.timer)
      this.$snake.reset()
    },
    record() {
      app.post({
        url: 'php/reg.php',
        data: {
          type: 'addScore',
          name: this.name,
          score: this.score
        }
      })
        .then(data => {
          console.log(data)
          this.getst()

        })
    },
    getst() {
      app.post({
        url: 'php/reg.php',
        data: {
          type: 'getScore',
        }
      })
        .then(data => {
          this.arrScore = data
          console.log(data)

        })
    }
  },
  mounted() {
    let self = this
    function Snake(opt) {
      opt = opt || {}
      this.defaultOpt = {
        byColor: 'red',
        fdColor: 'green',
        id: 'canvas',
        width: '300',
        height: '300',
        size: 10,
        lens: 3,
        direction: 'bottom',
        speed: 150
      }
      this.params = Object.assign(JSON.parse(JSON.stringify(this.defaultOpt)), opt)
      this.keydoenFun = (event) => {
        if (this.isStop) {
          return
        }
        // 向左
        if (event.keyCode === 37) {
          if (this.params.direction !== 'left' && this.params.direction !== 'right') {
            this.params.direction = 'left'
            this.draw()
          }
        }
        // 向上
        if (event.keyCode === 38) {
          if (this.params.direction !== 'top' && this.params.direction !== 'bottom') {
            this.params.direction = 'top'
            this.draw()
          }
        }
        // 向右
        if (event.keyCode === 39) {
          if (this.params.direction !== 'right' && this.params.direction !== 'left') {
            this.params.direction = 'right'
            this.draw()
          }
        }
        // 向下
        if (event.keyCode === 40) {
          if (this.params.direction !== 'bottom' && this.params.direction !== 'top') {
            this.params.direction = 'bottom'
            this.draw()
          }
        }
      }
    }
    Snake.prototype.init = function () {
      this.ctx = null
      this.timer = null
      this.isStop = false
      this.bodyArr = []  // 身体元素
      this.foodPos = {}  // 食物位置
      let $ctx = document.getElementById(this.params.id)
      if ($ctx) {
        $ctx.width = this.params.width
        $ctx.height = this.params.height
        this.ctx = $ctx.getContext('2d')
        this.initBody()
      }
      document.addEventListener('keydown', this.keydoenFun)
    }
    Snake.prototype.initBody = function () {
      this.ctx.fillStyle = this.params.byColor
      for (let i = 0; i < this.params.lens; i++) {
        if (this.params.direction === 'right') {
          this.bodyArr.push({ x: i * this.params.size, y: 0 })
          this.ctx.fillRect(i * this.params.size, 0, this.params.size, this.params.size)
        } else if (this.params.direction === 'bottom') {
          this.bodyArr.push({ x: 0, y: i * this.params.size })
          this.ctx.fillRect(0, i * this.params.size, this.params.size, this.params.size)
        }
      }
      this.generateFood()
    }
    Snake.prototype.generateFood = function () {
      this.ctx.fillStyle = this.params.fdColor
      this.foodPos.x = parseInt(Math.random() * (this.params.width / this.params.size)) * this.params.size
      this.foodPos.y = parseInt(Math.random() * (this.params.height / this.params.size)) * this.params.size
      this.ctx.fillRect(this.foodPos.x, this.foodPos.y, this.params.size, this.params.size)
    }
    Snake.prototype.move = function () {
      // console.log(this.bodyArr)

      this.timer = setTimeout(() => {
        // debugger
        // this.ctx.save()
        // this.draw()
        if (!this.draw()) {
          return false
        }
        // this.ctx.restore()
        this.move()
      }, this.params.speed)
    }
    Snake.prototype.eat = function () {
      if (JSON.stringify(this.bodyArr[this.bodyArr.length - 1]) === JSON.stringify(this.foodPos)) {
        // this.bodyArr.unshift(JSON.parse(JSON.stringify(this.bodyArr[0])))
        this.generateFood()
        return true
      }
      return false
    }
    Snake.prototype.draw = function () {
      var temp = null
      for (let n = 0; n < this.bodyArr.length - 1; n++) {
        temp = JSON.parse(JSON.stringify(this.bodyArr[0]))
        this.bodyArr[n] = JSON.parse(JSON.stringify(this.bodyArr[n + 1]))
      }
      // 向右
      let len = this.bodyArr.length
      if (this.params.direction === 'right') {
        this.bodyArr[len - 1].x += this.params.size
      }
      // 向左
      if (this.params.direction === 'left') {
        this.bodyArr[len - 1].x -= this.params.size
      }
      // 向上
      if (this.params.direction === 'top') {
        this.bodyArr[len - 1].y -= this.params.size
      }
      // 向下
      if (this.params.direction === 'bottom') {
        this.bodyArr[len - 1].y += this.params.size
      }
      if (this.eat()) {
        // console.log(temp)
        self.score++
        this.bodyArr.unshift(temp)
      }
      // 是否碰撞
      if (this.collapse()) {
        clearTimeout(this.timer)
        this.isStop = true
        app.toast('游戏结束')
        // var rrt = prompt('留下你的呢称：')
        // if (rrt) {
        //   self.name = rrt
        //   self.record()
        // } else {
        //   self.name = '游客-' + new Date().toLocaleString()
        //   self.record()
        // }
        return false
      }

      this.ctx.clearRect(0, 0, this.params.width, this.params.height) // 清空所有的内容
      this.bodyArr.map((item) => {
        this.ctx.fillStyle = this.params.byColor
        this.ctx.fillRect(item.x, item.y, this.params.size, this.params.size)
        // this.ctx.strokeStyle = this.params.byColor;;
        // this.ctx.strokeRect(item.x, item.y, this.params.size, this.params.size)
      })
      this.ctx.fillStyle = this.params.fdColor
      this.ctx.fillRect(this.foodPos.x, this.foodPos.y, this.params.size, this.params.size)
      return true
    }
    Snake.prototype.reset = function () {
      debugger
      clearTimeout(this.timer)
      this.ctx.clearRect(0, 0, this.params.width, this.params.height) // 清空所有的内容
      document.removeEventListener('keydown', this.keydoenFun)
      // var obj = new Snake({})
      this.params = JSON.parse(JSON.stringify(this.defaultOpt))
      this.init()
      this.move()
    }
    Snake.prototype.score = function () {
      // debugger
      return this.bodyArr.length - this.params.lens
    }
    Snake.prototype.stop = function () {
      // debugger
      clearTimeout(this.timer)
    }
    Snake.prototype.collapse = function () {
      // 碰墙
      let len = this.bodyArr.length
      if (this.bodyArr[len - 1].x >= this.params.width ||
        this.bodyArr[len - 1].y >= this.params.height ||
        this.bodyArr[len - 1].y < 0 ||
        this.bodyArr[len - 1].x < 0) {
        return true
      }
      // 碰自己
      let tempArr = JSON.parse(JSON.stringify(this.bodyArr))
      for (let n = 0; n < len - 1; n++) {
        if (JSON.stringify(tempArr[len - 1]) === JSON.stringify(tempArr[n])) {
          return true
        }
      }
      return false
    }
    this.$snake = new Snake({})
    this.$snake.init()
    this.$snake.move()
  },
  created() {
    this.getst()
  },
  destroyed() {
    console.log(3333)
    this.$snake.stop()
  },


}
</script>

<style lang='scss' scoped>
.box {
  display: flex;
  // flex-direction: column;
  height: 100%;
  overflow: auto;
  .left {
    font-size: 0.9rem;
    padding: 1rem;
    text-align: left;
    width: 30%;
    height: 100%;
    overflow: auto;
    box-sizing: border-box;
  }
  .right {
    margin: 1rem 2rem;
  }
}
</style>
