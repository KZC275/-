<template>
    <div class="header">
      <global-header>
        <span >得分榜：</span>
    </global-header>
      <div class="box">
        <div class="left">
          <p v-for="(item, index) in arrScore" :key="index">{{item.name}}：<strong>{{item.score}}分</strong></p>
        </div>
    </div>
  </div>
</template>
<script>

export default {
  name: 'rank',
  data() {
    return {
      score: 0,
      name: '',
      arrScore: []

    }
  },
  methods: {
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
  created() {
    this.getst()
  },
  destroyed() {
  },


}
</script>

<style lang='scss' scoped>
.box {
  text-align: left;
  display: flex;
  // flex-direction: column;
  height: 100%;
  overflow: auto;
  -webkit-overflow-scrolling: touch;
  #canvas{
    border-top:1px solid #ba61ba;
    border-bottom:1px solid #ba61ba;
  }
  .buttons {
    display: flex;
    justify-content: center;
    text-align: center;
    flex-wrap: wrap;
    flex-direction: column;
    align-items: flex-end;
    .resetclass{
      align-self: center;
      margin-bottom: .1rem;
    }
    span{
      border: none;
      height: 0.8rem;
      line-height: 0.8rem;
      background: #ba61ba;
      padding: .1rem .3rem;
      box-sizing: border-box;
    }
    div{
      display: flex;
      width:100%;
      justify-content: flex-end;
    }
    .top{
      width: 30%;
      margin-right:10%; 
    }
    .left{
      width: 25%;
    }
    .right{
      width: 25%;
    }
    .bottom{
      margin-right:10%; 
      width: 30%;
    }
  }
}
</style>
