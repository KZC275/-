<template>
  <div class="PPPPPSSS">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="http://www.kzc275.top/img/1.jpg"
               alt=""></div>
        <div class="swiper-slide"><img src="http://www.kzc275.top/img/2.jpg"
               alt=""></div>
        <div class="swiper-slide"><img src="http://www.kzc275.top/img/3.jpg"
               alt=""></div>
        <div class="swiper-slide"><img src="http://www.kzc275.top/img/4.jpg"
               alt=""></div>
        <div class="swiper-slide"><img src="http://www.kzc275.top/img/5.jpg"
               alt=""></div>
      </div>
      <!-- Add Pagination -->
      <div class="swiper-pagination"></div>
    </div>

    <viewer :images="imgList"
            class="imgWrapper">
      <div v-for="(item,index) in imgList"
           :key="index+'item'">
        <img :src="item.src"
             style="width:40px;"
             :alt="index+1" />
      </div>
    </viewer>

    <div>
      <img src="http://www.kzc275.top/img/profile.jpg"
           alt="profile"
           style="height:100px;">
    </div>

    <div>
      <i-attachment :onSuccess="fileSuccess"
                    :uploadFiles="fileList"></i-attachment>

    </div>
    <!-- <div>
      <input type="file"
             name=""
             multiple
             accept="image/*"
             id="input">
    </div> -->

  </div>

</template>

<script>
import Swiper, { Pagination, EffectCoverflow, Scrollbar } from 'swiper'
import iAttachment from './i-attachment'
Swiper.use([Pagination, EffectCoverflow, Scrollbar])
export default {
  name: 'Experience',
  data () {
    return {
      msg: 'Welcome',
      fileList: [],
      imgList: [
        { src: 'http://www.kzc275.top/img/1.jpg' },
        { src: 'http://www.kzc275.top/img/2.jpg' },
        { src: 'http://www.kzc275.top/img/3.jpg' },
        { src: 'http://www.kzc275.top/img/4.jpg' },
        { src: 'http://www.kzc275.top/img/5.jpg' }
      ],
      previewList: [
        { src: 'http://www.kzc275.top/img/1.jpg' },
        { src: 'http://www.kzc275.top/img/1.jpg' },
        { src: 'http://www.kzc275.top/img/1.jpg' },
        { src: 'http://www.kzc275.top/img/1.jpg' },
        { src: 'http://www.kzc275.top/img/1.jpg' }
      ]

    }
  },
  components: {
    iAttachment
  },
  methods: {
    fileSuccess (file) {
      // debugger
    }

  },
  created () { },
  destroyed () {
  },
  mounted () {
    var swiper = new Swiper('.swiper-container', {
      pagination: { el: '.swiper-pagination' },
      effect: 'coverflow',
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: 'auto',
      coverflowEffect: {
        rotate: 20,
        stretch: 0,
        depth: 30,
        modifier: 1,
        slideShadows: false
      }
    })
    console.log(swiper)
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
body {
  background: #fff;
  font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
  font-size: 14px;
  color: #000;
  margin: 0;
  padding: 0;
}
.swiper-container {
  width: 100%;
  padding-top: 50px;
  padding-bottom: 50px;
}
.swiper-slide {
  background-position: center;
  background-size: cover;
  width: 300px;
  height: 300px;
  padding: 5px;
  img {
    width: 100%;
    height: 100%;
  }
}
.PPPPPSSS {
  position: relative;
  height: 200px;
}
</style>
