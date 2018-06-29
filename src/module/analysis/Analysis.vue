<template>
	<div class="analysis">
		<global-header>
			<!-- <span slot='left'>back</span> -->
			<span>analysis</span>
		</global-header>
        <div id="main" style="width: 100%;height:400px;"></div>
        
		
		
	</div>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from 'vuex'
export default {
  name: 'analysis',
  data () {
    return {}
  },

  methods: {
    init () {
      // 基于准备好的dom，初始化echarts实例
      var myChart = echarts.init(document.getElementById('main'))

      // 指定图表的配置项和数据
      var option1 = {
        backgroundColor: 'white',
        title: {
          text: '用户数据统计',
          left: 'center',
          top: 20,
          textStyle: {
            color: 'red'
          }
        },
        tooltip: {
          trigger: 'item',
          formatter: '{a} <br/>{b} : {d}%'
        },

        // visualMap: {
        //     show: false,
        //     min: 500,
        //     max: 600,
        //     inRange: {
        //         colorLightness: [0, 1]
        //     }
        // },
        series: [
          {
            name: '注册邮箱',
            type: 'pie',
            clockwise: 'true',
            startAngle: '0',
            radius: '50%',
            // center: ['50%', '50%'],
            data: [
              {
                value: 70,
                name: '网易邮箱'
              },
              {
                value: 10,
                name: 'qq邮箱'
              },
              {
                value: 5,
                name: '其他邮箱'
              },
              {
                value: 15,
                name: '无邮箱'
              }
            ]
          }
        ]
      }
      myChart.setOption(option1)
    }
  },
  mounted () {
    this.init()
    app
        .post({
          url: '/php/reg.php',
          data: { type: 'analysis' }
        })
        .then(data => {
          console.log(data)
        })
  },
  components: {
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang='scss' scoped>
@import "./analysis.scss";
</style>