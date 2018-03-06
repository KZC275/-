<template>
  <div ref="wrapper" class="slider-menu">
    <ul ref="content" class="slider-content">
      <slot></slot>
    </ul>
  </div>
</template>

<script>
  import BScroll from 'better-scroll'

  export default {
    name: 'slider',

    props: {
      menu: {
        type: Array,
        default: []
      },
      probeType: {
        type: Number,
        default: 1
      },
      click: {
        type: Boolean,
        default: true
      },
      scrollX: {
        type: Boolean,
        default: true
      },
      refreshDelay: {
        type: Number,
        default: 20
      }
    },

    watch: {
      menu() {
        setTimeout(() => {
          this.refresh()
        }, this.refreshDelay)
      }
    },
    methods: {
      _initScroll() {
        if (!this.$refs.wrapper) {
          return
        }

        this.calculateWidth()

        // better-scroll的初始化
        this.scroll = new BScroll(this.$refs.wrapper, {
          probeType: this.probeType,
          click: this.click,
          scrollX: this.scrollX
        });
      },
      calculateWidth() {
        let child = this.$refs.content.children;
        let width = 0;
        for (let i = 0; i < child.length; i++) {
          let elWidth = parseFloat(this.getStyle(child[i], 'width'));
          let paddingLeft = parseFloat(this.getStyle(child[i], 'paddingLeft'));
          let paddingRight = parseFloat(this.getStyle(child[i], 'paddingRight'));
          let marginLeft = parseFloat(this.getStyle(child[i], 'marginLeft'));
          let marginRight = parseFloat(this.getStyle(child[i], 'marginRight'));
          width += (elWidth + paddingLeft + paddingRight + marginLeft + marginRight)
        }
        this.$refs.content.style.width = `${width}px`
      },
      getStyle(dom, attr) {
        if (dom.currentStyle) {
          return dom.currentStyle[attr];
        } else {
          return document.defaultView.getComputedStyle(dom, null)[attr];
        }
      },
      refresh() {
        this.calculateWidth()
        this.scroll && this.scroll.refresh()
      }
    },

    mounted() {
      console.log(this)
      setTimeout(() => {
        this._initScroll();
      }, 20)
    }
  }
</script>

<style lang="scss" scoped>
 .slider-menu {
    height: 0.9rem;
    background: #fff;
    overflow: hidden;
    .slider-content {
      height: 0.9rem;
      overflow: hidden;
      li {
        display: inline-block;
        height: 0.9rem;
        line-height: 0.9rem;
        white-space: nowrap;
        margin-right:0.5rem;
        span{
          display:inline-block;
          line-height:0.9rem;
        }
      }
      li:nth-child(1){
        margin-left:0.5rem;
      }
      .li_active{
        border-bottom: 2px solid red;
        box-sizing: border-box;
      }
    }
  }
</style>
