<template>
  <div class="info">
    <global-header>
        <span slot='left'>back</span>
    </global-header>
    <div class="msg">
        <h2>info</h2>
        <input type="text" placeholder="username">
        <input type="password" placeholder="password">
        <div>
          <button>register</button>
          <button>login</button>
        </div>
    </div>
    
  </div>
</template>

<script>
import Pheader from '../../components/Pheader'
export default {
  name: 'info',
  data () {
    return {
      msg: 'info'
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
        @import './info.scss'
</style>
