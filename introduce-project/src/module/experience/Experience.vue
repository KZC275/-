<template>
  <div class="experience">
    <global-header>
        <span slot='left'>back</span>
    </global-header>
    <div class="msg">
        <p>时间{{}}</p>
        <p>地点{{}}</p>
        <p>设备信息{{}}</p>
    </div>
    
  </div>
</template>

<script>
import Pheader from '../../components/Pheader'
export default {
  name: 'Experience',
  data () {
    return {
      msg: 'Welcome'
    }
    
  },
  components:{
      'global-header':Pheader
  },
  created(){
      $.ajax({
        url: 'http://www.kzc275.top/php/reg.php',
        type: 'post',
        data:{type:'check'}
       
      })
      .done(function(data) {
        // console.log(data)
        console.log("success");
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });

    },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
        @import './experience.scss'
</style>
