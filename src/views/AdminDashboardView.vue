<template >
  <NavigationMenuAdmin v-if="isConnected === true && userType==='admin'"></NavigationMenuAdmin>
  <!-- <Toast position="top-right" group="tl" /> -->
  <router-view v-if="isConnected === true && userType==='admin'"></router-view>
  <div v-else>
    <p class="errorMsg">Vous n'avez les privilèges pour pouvoir accéder à cet ressources!!</p>
  </div>
</template>


<script>
import NavigationMenuAdmin from "../components/NavigationMenuAdmin.vue"
// import Toast from 'primevue/toast';
import fetchData from '@/utils/fetchData'
import store from '@/store';
export default {
  components:{
    NavigationMenuAdmin,
    // Toast,
  },
  data(){
    return{
      isConnected : false,
      userType : '',
    }
  },
  created(){
    this.getLateLoans();
    this.userType = store.state.userInfo.userType;
    this.isConnected = store.state.userInfo.isConnected;
    this.unsubscribe = store.subscribe((mutation)=>{
      if(mutation.type === "updateUserInfo"){
          this.isConnected = store.state.userInfo.isConnected;
          this.userType = store.state.userInfo.userType;
        }
        })
  },
  beforeUnmount(){
    this.unsubscribe();
  },
  methods: {
    getLateLoans(){
      fetchData({ controller: "loansController", action: "getLateLoans" }).then(data => {
                if (Object.keys(data).length) {
                    store.commit({type:'updateLateLoans',lateLoans:data});
                    this.$toast.add({severity: 'error', summary: 'Attention', detail: `Il y'a ${data.length} de retard de prêt`, group: 'tl', life: 5000});
                }
            })
    },
  },
}
</script>

<style>
  .errorMsg{
    top: 50%;
    left: 50%;
  }
</style>