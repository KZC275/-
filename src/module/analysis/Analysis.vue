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
	import Pheader from '../../components/Pheader'
	import { mapGetters, mapActions, mapMutations } from 'vuex'
	export default {
		name: 'analysis',
		data() {
			return {

			}
		},
		
		methods: {
            init(){
                 // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));

        // 指定图表的配置项和数据
       var option1 = {
         backgroundColor: 'yellow',
 
         title: {
             text: '课程内容分布',
             left: 'center',
             top: 20,
             textStyle: {
                 color: 'red'
             }
         },
         tooltip : {
             trigger: 'item',
             formatter: "{a} <br/>{b} : {d}%"
         },
 
         // visualMap: {
         //     show: false,
         //     min: 500,
         //     max: 600,
         //     inRange: {
         //         colorLightness: [0, 1]
         //     }
         // },
         series : [
             {
                 name:'课程内容分布',
                 type:'pie',
                 clockwise:'true',
                 startAngle:'0',
                 radius : '50%',
                 // center: ['50%', '50%'],
                 data:[
                     {
                         value:70,
                         name:'语言',
           
                     },
                     {
                         value:10,
                         name:'美国科学&社会科学',
    
                     },
                     {
                         value:20,
                         name:'美国数学',
                     }
 
                 ],
             }
         ]
     };
     myChart.setOption(option1);
            }
		},
		mounted() {
            this.init()
		},
		components: {
			'global-header': Pheader
		},
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang='scss' scoped>
	@import './analysis.scss';
</style>