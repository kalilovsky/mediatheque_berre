<template>
  <div class="TableAllLoans">
    <TableUsers :allUsers="allUsers" tableTitle="Tous les Utilisateurs" @update="getAllUsers" ></TableUsers>
  </div>
</template>

<script>
import fetchData from '@/utils/fetchData'
import TableUsers from "../components/Admin/TableUsers.vue"
// import CardKPI from "../components/Admin/CardKPI.vue"

export default {
  components: {
    // CardKPI,
    TableUsers
  },
  data(){
    return{
      allUsers:{},
      userPopup:false,
    }
  },
  methods:{
    getAllUsers(){
      fetchData({ controller: "usersController", action: "getAllUsers" }).then(data => {
        if (Object.keys(data).length) {
          this.allUsers = data;
        }
      })
    },
  },
  created(){
    this.getAllUsers();
  }

}
</script>

<style>
      .cardBoxLoans {
  position: relative;
  width: calc(100% - 300px);
  top: 40px;
  left: 300px;
  padding: 20px 30px;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  grid-gap: 30px;
}
.TableAllLoans {
  position: relative;
  width: calc(100% - 300px);
  left: 300px;
  padding: 0 50px;
  margin-top: 40px;
}
</style>