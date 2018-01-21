<template>
	<div class="app_main">
		<div class="left">
			<div class="top">
				<div class="h2"><img src="../../assets/img/logo.jpg" height="38" width="260" alt=""></div>
				<div class="login" @touchend="gotoLogin">
                    <span>
                        <img v-if="!login" src="../../assets/img/headbg.png" height="60" width="60" alt="">
                        <img v-if="login" src="../../assets/img/3.jpg" height="60" width="60" alt="">
                    </span>
					<span v-if="login">{{username}}欢迎您</span>
					<span v-if="!login">请登录{{this.$store.state.count}}</span>
				</div>
				<div class="switch">
					<span>知识库</span>
					<span><img src="../../assets/img/home.jpg" height="25" width="32" alt=""></span>
					<span>资料</span>
				</div>
			</div>
			<div class="tab">
				<p :class="{'active_tab':tab.index==1}" @touchend='switchTab(1)'>1.现场开卡基本信息</p>
				<p :class="{'active_tab':tab.index==2}" @touchend='switchTab(2)'>2.影像采集</p>
				<p :class="{'active_tab':tab.index==3}" @touchend='switchTab(3)'>3.信息确认</p>
			</div>
		</div>
		<div class="fixlogin" v-if="showBox" @touchend.prevent.stop="shutdown"></div>
		<div class="loginBox" v-if="showBox">
			<div class="clear">
                <span>用户名：</span>
                <input type="text" v-model="ssss" placeholder="输入用户名"></div>
			<div class="clear">
                <span>密码：</span>
                <input type="password" v-model="psss" placeholder="输入密码"></div>
			<div class="clear"><span @touchend="justify" class="confirm">确认</span></div>
		</div>

		<div class="mid"></div>
		<div class="right">
			<div class="header">
				<span @touchend="back"> <img class="backImg" src="../../assets/img/back.jpg" alt=""> </span>
				<h2>{{title}}</h2>
				<span><img class="more" src="../../assets/img/more.jpg" height="30" width="40" alt=""></span>
			</div>
			<div class="main">
				<div v-if="tab.index==1" class="card">
					<div class="mainLeft clear">
						<div class="input">
							<span>证件号码</span>
							<input type="text">
						</div>
						<div class="input">
							<span>姓名</span>
							<input type="text">
						</div>
						<div class="input">
							<span>性别</span>
							<input type="text">
						</div>
						<div class="input">
							<span>姓名拼音</span>
							<input type="text">
						</div>
					</div>

					<div class="cardNo clear">
						<p>读取证件号</p>
						<span @touchend="shootPic(6)"> 
                            <img v-if="src.num6" :src="src.num6" alt="图片">
                            <img v-if="!src.num6" src="../../assets/img/bg.png" alt="">
                        </span>
					</div>
					<div class="address clear">
						<span>住址</span>
						<div>
							<input v-if="!locationStr" type="text" placeholder="可点击右侧图标获取客户地址" v-model="adress" >
                            <input v-if="locationStr"   ref="input" @change="cahngeStr()" type="text" :value="locationStr" >
							<span class="text"><img src="../../assets/img/loc.jpg" alt=""></span>
							<input @touchend="location" readonly  type="text" placeholder="点击选择地址">
							<br/>
							<p >**省**市**区/县**街道/路/镇**小区</p>
						</div>
					</div>
					<div class="send">
						<span>发证机构</span>
						<div>
							<input type="text">
							<span>固定电话</span>
							<input type="text" placeholder="如：0755-5262328"><br/>
						</div>
					</div>
					<div class="name">
						<span>公司名称</span>
						<div>
							<input type="text" v-model="companyName">
							<input type="text" placeholder="点击选择公司"><br/>
						</div>
					</div>
					<div class="next" @touchend="switchTab(2)">下一步</div>
				</div>
				<div v-if="tab.index==2" class="img">
					<div class="box">
						<div class="item">
							<img @touchend="shootPic(1)" v-if="!src.num1" src="" alt="点击拍照">
							<img v-if="src.num1" :src="src.num1" alt="">
							<p>身份证正面</p>
							<p><span @touchend="zoomIn(1)">(查看)</span><span @touchend="delPic(1)">(删除)</span></p>
						</div>
						<div class="item">
							<img @touchend="shootPic(2)" v-if="!src.num2" src="" alt="点击拍照">
							<img v-if="src.num2" :src="src.num2" alt="">
							<p>身份证反面</p>
							<p><span @touchend="zoomIn(2)">(查看)</span><span @touchend="delPic(2)">(删除)</span></p>
						</div>
						<div class="item">
							<img @touchend="shootPic(3)" v-if="!src.num3" src="" alt="点击拍照">
							<img v-if="src.num3" :src="src.num3" alt="">
							<p>客户手持身份证和客户经理合影</p>
							<p><span @touchend="zoomIn(3)">(查看)</span><span @touchend="delPic(3)">(删除)</span></p>
						</div>
						<div class="item">
							<img @touchend="locate" v-if="!src.num4" src="" alt="点击拍照">
							<img @touchend="locate" v-if="src.num4" :src="src.num4" alt="">
							<p>定位地图</p>
						</div>
					</div>
					<div class="btn">
						<span @touchend="switchTab(1)">上一页</span>
						<span @touchend="switchTab(3)">下一页</span>
					</div>
				</div>
				<div v-if="tab.index==3" class="info">
					<div class="top">
						<div class="clear">
							<span>住址</span>
							<input v-if="!locationStr" type="text" disabled="disabled" v-model="adress">
                            <input v-if="locationStr" type="text"  disabled="disabled" v-model="locationStr" >
						</div>
						<div class="clear">
							<span>公司名称</span>
							<input type="text" disabled="disabled" v-model="companyName">
						</div>
						<div class="clear">
							<span>授权客户经理</span>
							<input class="last" type="text">
						</div>
					</div>
					<p class="sign">请客户在下方签名版处签名</p>
					<div class="board">
						<canvas width="200px" height="200px" id="canvasline">你的pad不支持canvas</canvas>
					</div>
					<div class="btn">
						<span @touchend="switchTab(2)">上一页</span>
                        <span @touchend="">指纹验证</span>
						<!-- <span @touchend="rewrite">rewrite</span> -->
					</div>

				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import { mapGetters, mapActions, mapMutations } from 'vuex'
	export default {
		name: 'index',
		data() {
			return {
				tab: {
					index: 1,

				},
				// src:{
				//     num1:'',
				//     num2:'./static/img/1.jpg',
				//     num3:'./static/img/1.jpg',
				//     num4:'./static/img/2.jpg',
				// },
				title: '现场开卡基本信息',
				companyName: '',
				username: '',
				password: '',
				login: false,
				showBox: false,
				adress: '',
				_pswd: '',
				_name: '',
                ssss:'',
                psss:''

			}
		},
		created() {},
		computed: mapGetters({
            'src': 'getSrc',
            'path': 'getPath',
			'locationStr': 'getlocationStr'
		}),
		methods: {
			switchTab(index) {
				this.tab.index = index;
				if(index == 1) {
					this.title = '现场开卡基本信息';
				} else if(index == 2) {
					this.title = '影像采集';

				} else if(index == 3) {
					this.title = '信息确认';
					setTimeout(() => {
						var h = $('.board').height()
						var w = $('.board').width()
						$('canvas').attr('width', w + 'px')
						$('canvas').attr('height', h + 'px')
						this.drawer();
					}, 200)

				}

			},
			gotoLogin() {
                if(this.login){
                    let r=confirm('退出登录？');
                    if(r){
                        this.login=false;
                        return false;
                    }
                }
				if(!this.login) {
					this.showBox = true;
				}

			},
			shutdown() {
				this.showBox = false
			},
			back() {

			},
            //签名画图
			drawer() {
				var oC = document.getElementById("canvasline");
				// var $oc=$('#canvasline');
				var cxt = oC.getContext("2d");
				var k = 0,
					x = 0,
					y = 0,
					initX = 0,
					initY = 0;
				oC.addEventListener('touchstart', (function(ev) {
					// event.preventDefault();
					/* Act on the event */
					initX = ev.touches[0].screenX - oC.offsetLeft;
					initY = ev.touches[0].screenY - oC.offsetTop;
					//console.log(ev.touches[0])
					console.log(oC.offsetLeft)
					console.log(oC.offsetTop)
					//console.log(ev.touches[0].screenX)
					//console.log(ev.touches[0].screenY)
					cxt.beginPath();
					cxt.moveTo(initX, initY);
				}))
				oC.addEventListener('touchmove', function(ev) {
					event.preventDefault();
					/* Act on the event */
					x = ev.touches[0].screenX - oC.offsetLeft;
					y = ev.touches[0].screenY - oC.offsetTop;

					console.log(oC.offsetLeft)
					console.log(oC.offsetTop)
					//console.log(ev.touches[0].screenX)
					//console.log(ev.touches[0].screenY)
					if(k == 0) {

						cxt.lineTo(x, y);
						cxt.stroke();
					} else if(k == 1) {
						cxt.clearRect(x, y, 20, 20);
					}
				});
				oC.addEventListener('touchend', function(ev) {
					oC.onmousemove = null;
					oC.onmouseup = null;
					cxt.closePath();
				});

			},
			//查看大图
			zoomIn(num) {
                if(!this.path['num' + num]){
                    alert('没有路径')
                    return false;
                }
                if(app.isBrowser) {
                    console.log(this.path['num' + num])
                    alert('test')
                    return false;
                }
				JSInterface.zoomIn(this.path['num' + num]);

			},
			//删除图片
			delPic(num) {
				this.src['num' + num] = '';
			},
            //拍照
            shootPic(type) {
                if(app.isBrowser) {
                    alert('locate')
                    return false;
                }
                JSInterface.openCamera(type);
            },
            //定位返回地址
			location() {
				// console.log('location')
                // setLocation('ffff')
                if(app.isBrowser) {
                    // alert('location')
                    return false;
                }
                JSInterface.getLocation('5');
			},
            //定位，显示地图
            locate(){
                if(app.isBrowser) {
                    alert('locate')
                    return false;
                }
                JSInterface.getLocation('4');
            },
            //定位得到的地址再修改
            cahngeStr(){
                console.log(this.$refs.input.value)
                this.$store.state.locationStr=this.$refs.input.value;
            },
			//登录
			justify() {
				if(this.ssss && this.psss) {
					this.login = true;
					this.showBox = false;
                    this.username=this.ssss;

				}else{
                    alert('请先输入信息');
                }
			},
            rewrite(){
                // this.switchTab(3)
            }
		},
		watch: {
            locationStr(n,o){
                this.address=n;
                console.log(n,o)

            }
        }
	}
</script>

<style lang='scss'>
	@import './index.scss'
</style>