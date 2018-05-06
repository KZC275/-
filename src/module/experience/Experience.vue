<template>
  <div class="experience">
    <global-header>
        <span >组件</span>
    </global-header>
    <div class="second">
        <h2>左右滑动组件</h2>
    <slider style="background:red;" :menu="arrList">
      <li  v-for="(item,index) in arrList">
        <span>{{item.text}}</span>
      </li>
    </slider>
    <h2>轮播图组件</h2>
    <div class="lunbo">
      <div class="wrapper">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <!-- vuex test -->
    <div>
       <button @touchstart='add' style="height:0.5rem;background:#ccc;margin-top:0.5rem">click me to add</button>
       <h1>state：{{$store.state.count}}</h1>
       <h1>{{evenOrOdd}}</h1>
    </div>
    

    <div class="videotag">
      <video id='video' preload="auto" src="@static/video/movie.mp4" controls="controls"></video>
    </div>
    </div>
    
    
  </div>
</template>

<script>
import Pheader from "../../components/Pheader";
import Slider from "./slider.vue";
import { mapGetters, mapActions, mapMutations } from "vuex";
export default {
  name: "Experience",
  data() {
    return {
      msg: "Welcome",
      timer_ac: null,
      arrList: [
        { text: 123 },
        { text: 456 },
        { text: 66 },
        { text: 123 },
        { text: 66666 },
        { text: 456 },
        { text: 66 },
        { text: 123 },
        { text: 66666 },
        { text: 456 },
        { text: 66 },
        { text: 123 },
        { text: "大师傅似的" },
        { text: 456 },
        { text: "gdfg" },
        { text: "sdsds" },
        { text: "asdas" }
      ]
    };
  },
  components: {
    "global-header": Pheader,
    slider: Slider
  },
  computed: mapGetters(["evenOrOdd"]),
  methods: {
    ...mapActions(["increment_add", "decrement_add"]),
    ...mapMutations(["increment", "decrement"]),
    add() {
      //    console.log(this.$store.dispatch({type:'incrementIfOdd'}))
      this.increment_add();
    }
  },
  created() {},
  destroyed() {
    clearInterval(this.timer_ac);
    // console.log('fllfllf')
  },
  mounted() {
    var _this = this;
    (function($) {
      // console.log(_this)
      $.slide = function(opts) {
        obj.init(opts);
      };
      var timer_ac = null; //定時器
      var params = null; //全局参数
      var status_img = 0; //輪播位置初始化
      var start_time = 0; //手指接触屏幕时间点
      var end_time = 0; //手指离开屏幕时间点
      var obj = {
        init: function(opts) {
          var _default = {
            wrapper: null,
            item: {
              width: "300px",
              height: "150px"
            }
          };
          params = $.extend(true, {}, _default, opts);
          if (!params.item || !params.wrapper) {
            alert("参数错误");
            return false;
          }
          this.shapeUp(params);

          this.auto_move(params, status_img);
          // this.go_to_destination(params);
          setTimeout(() => {
            this.intervene(params);
          }, 2000);
        },
        shapeUp: function(params) {
          // item元素浮动同时重设宽高
          params.wrapper.children().css({
            float: "left",
            width: params.item.width,
            height: params.item.height
          });
          // 计算wrapper长度
          var length =
            parseInt(params.item.width) *
            (params.wrapper.children().length + 1);
          //复制一张图片在最后达到无缝连接的效果
          params.wrapper.append(
            params.wrapper
              .children()
              .eq(0)
              .clone(true)
              .css("background", "yellow")
          );

          params.wrapper.css({
            width: length,
            height: params.item.height
          });
          // content宽高
          params.wrapper
            .parents("div")
            .eq(0)
            .css({
              width: params.item.width,
              height: params.item.height,
              overflow: "hidden",
              position: "relative"
            });
        },
        auto_move: function(params, status) {
          if (_this.timer_ac) clearInterval(_this.timer_ac);
          //根据offset().left判断轮播图的当前位置
          // 轮播
          var i = parseInt(Math.abs(status) / parseInt(params.item.width));
          params.wrapper.css("position", "absolute");
          var self = this;
          if (i == 0) {
            self.isDot(params, i);
          }
          _this.timer_ac = setInterval(function() {
            i++;
            // if(i>=4){
            //  i=1;
            //  // 回到开始位置
            //  params.wrapper.css('transition', "none");
            //  params.wrapper.css('transform', 'translateX('+ ( 0 +'px' )  +')');
            //  // return;
            // }
            // params.wrapper.css('transform', 'translateX('+ ( -parseInt(params.item.width)*i +'px' )  +')');
            // params.wrapper.css('transition', "0.7s ease");
            // i++;

            if (i >= params.wrapper.children().length) {
              i = 1;
              // 回到开始位置
              params.wrapper.css({
                left: 0
              });
              // return;
            }

            params.wrapper.animate(
              {
                left: -parseInt(params.item.width) * i
              },
              100,
              "linear",
              function() {
                self.isDot(params, i);
              }
            );
          }, params.time);
        },
        intervene: function(params) {
          var self = this;

          var initX = 0;
          var status_left = 0;
          var current = 0;
          params.wrapper[0].addEventListener("touchstart", function(event) {
            if (event.touches.length > 1) {
              //多根手指触摸干扰排除
              clearInterval(_this.timer_ac); //清除定時器
              if (navigator.userAgent.toLowerCase().indexOf("iphone") > -1) {
                obj.auto_move(params, status_left);
              }
              return false;
            }
            current = 0; //每次点击都需要把差值置零，防止快速点击频繁触发轮播

            start_time = new Date().getTime(); //记录时间点
            initX = event.touches[0].pageX;
            params.wrapper.css("transition", "none");
            clearInterval(_this.timer_ac); //清除定時器

            status_left = parseInt(params.wrapper.css("left")); //记录wrapper位置，拖动时实时改变
          });
          params.wrapper[0].addEventListener("touchmove", function(event) {
            if (event.touches.length > 1) {
              clearInterval(_this.timer_ac); //清除定時器
              return false;
            }
            //光标移出有效范围
            if (
              event.touches[0].pageX >
                params.wrapper
                  .parents("div")
                  .eq(0)
                  .offset().left +
                  parseInt(params.item.width) ||
              event.touches[0].pageY >
                params.wrapper
                  .parents("div")
                  .eq(0)
                  .offset().top +
                  parseInt(params.item.height)
            ) {
              return false;
            }
            //安卓手机不加上阻止默认事件，无法拖动
            event.preventDefault();
            current = event.touches[0].pageX - initX;

            // 当前是第一张图片而且是滑动到上一张的时候，马上把wrapper的克隆的那张图片置于可视区域
            if (current > 0 && status_left == 0) {
              status_left =
                -(params.wrapper.children().length - 1) *
                parseInt(params.item.width);
              params.wrapper.css("left", status_left);
            }
            // 当前是最后一张（克隆）图片而且是滑动到下一张的时候，马上把wrapper的第一张图片置于可视区域
            if (
              current < 0 &&
              status_left ==
                -(params.wrapper.children().length - 1) *
                  parseInt(params.item.width)
            ) {
              status_left = 0;
              params.wrapper.css("left", status_left);
            }

            //css3方式
            // params.wrapper.css('transform', "translateX(" + (current + 'px') + ")");
            params.wrapper.css("left", current + status_left);
          });
          params.wrapper[0].addEventListener("touchend", function(event) {
            if (event.touches.length > 1) {
              clearInterval(_this.timer_ac); //清除定時器
              return false;
            }

            if (_this.timer_ac) clearInterval(_this.timer_ac); //清除定時器

            end_time = new Date().getTime(); //记录时间点
            var distance = end_time - start_time; //记录时间差,判断是否是快速滑动
            //没有移动，不做任何处理
            if (current == 0) {
              obj.auto_move(params, status_left);
              return false;
            }
            //切换到下一张
            if (
              (distance < params.quickSlide && current < 0) ||
              (Math.abs(current) > parseInt(params.item.width) / 2 &&
                current < 0)
            ) {
              //css3方式
              // params.wrapper.css('transform', "translateX(" + (-parseInt(params.item.width)*status_img + 'px') + ")");

              // 最后的图片强制不切换
              // if(Math.abs(status_left-parseInt(params.item.width))/parseInt(params.item.width)>=
              //  (params.wrapper.children().length)){
              //  // 此时params.wrapper.children()的长度包括了克隆的那个
              //  params.wrapper.css('left',  status_left);
              //  obj.auto_move(params , status_left);
              //  return false;
              // }

              //状态点随动
              self.isDot(
                params,
                parseInt(
                  Math.abs(parseInt(params.wrapper.css("left"))) /
                    parseInt(params.item.width)
                ) + 1
              );
              params.wrapper.css(
                "left",
                status_left - parseInt(params.item.width)
              );

              obj.auto_move(params, status_left - parseInt(params.item.width));
            } else if (
              Math.abs(current) <= parseInt(params.item.width) / 2 &&
              distance >= params.quickSlide
            ) {
              // 回到原位
              params.wrapper.css("left", status_left);

              obj.auto_move(params, status_left);
            } else if (
              (distance < params.quickSlide && current > 0) ||
              (Math.abs(current) > parseInt(params.item.width) / 2 &&
                current > 0)
            ) {
              //切换到上一张
              //css3方式
              // params.wrapper.css('transform', "translateX(" + (-parseInt(params.item.width)*status_img + 'px') + ")");

              // 第一张图片强制不切换
              // if(status_left+parseInt(params.item.width)>0){

              //  params.wrapper.css('left',  status_left);
              //  obj.auto_move(params , status_left);
              //  return false;
              // }

              //状态点随动
              self.isDot(
                params,
                parseInt(
                  Math.abs(parseInt(params.wrapper.css("left"))) /
                    parseInt(params.item.width)
                )
              );

              params.wrapper.css(
                "left",
                status_left + parseInt(params.item.width)
              );

              obj.auto_move(params, status_left + parseInt(params.item.width));
            }
          });
          params.wrapper[0].addEventListener("touchcancel", function(event) {});
        },
        isDot: function(params, num) {
          if (params.is_point == false) {
            return false;
          }
          if ($(".dot_wrapper")[0]) {
            $(".dot_wrapper em").css("background-color", "white");
            num = num >= params.wrapper.children().length - 1 ? 0 : num;
            $(".dot_wrapper em")
              .eq(num)
              .css("background-color", "purple");
            return false;
          }
          var dot_num = params.wrapper.children().length - 1;
          var html = '<div class="dot_wrapper">';
          for (var n = 0; n < dot_num; n++) {
            html += "<em></em>";
          }
          html += "</div>";
          params.wrapper
            .parents("div")
            .eq(0)
            .append(html);
          $(".dot_wrapper em").css({
            "background-color": "white",
            "border-radius": "50%",
            display: "inline-block",
            width: "10px",
            height: "10px"
          });

          $(".dot_wrapper").css({
            width: "50%",
            position: "absolute",
            bottom: "20px",
            left: "50%",
            "-webkit-transform": "translateX(-50%)",
            display: "-webkit-flex",
            "flex-wrap": "nowrap",
            "justify-content": "space-around"
          });
          $(".dot_wrapper em").css("background-color", "white");
          num = num >= params.wrapper.children().length - 1 ? 0 : num;
          $(".dot_wrapper em")
            .eq(num)
            .css("background-color", "purple");
        }
        // go_to_destination: function(params) {
        //  var target=params.wrapper.children()[0].nodeName.toLowerCase();
        //  params.wrapper.on('touchend',target,function(event){
        //    if($(this).index()==0){
        //    }

        //  })

        // }
      };
    })(jQuery);
    setTimeout(() => {
      $.slide({
        wrapper: $(".wrapper"),
        item: {
          width: window.screen.width,
          height: window.screen.height / 4
        },
        // url: ['http://www.baidu.com/', 'http://www.qq.com/'],
        quickSlide: 200,
        time: 1500,
        is_point: true
      });
    }, 200);
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
@import "./experience.scss";
</style>
