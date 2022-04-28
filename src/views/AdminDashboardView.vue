<template>
  <NavigationMenuAdmin></NavigationMenuAdmin>
  <Toast position="top-right" group="tl" />
  <router-view ></router-view>
</template>

<script>
import NavigationMenuAdmin from "../components/NavigationMenuAdmin.vue"
import Toast from 'primevue/toast';
import fetchData from '@/utils/fetchData'
import store from '@/store';
export default {
  components:{
    NavigationMenuAdmin,
    Toast,
  },
  data(){
    return{
    }
  },
  created(){
    this.getLateLoans();
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

</style>