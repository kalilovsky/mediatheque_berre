<template>
  <div class="cardBoxArticles">
    <CardKPI :number="count.allArticles" :cardName="'Produits'" :icon="'pi-telegram'" ></CardKPI>
  </div>
  <div class="TableAllLoans">
    <TableArticles :selectedLoans="allArticles" tableTitle="Tous les Articles" @updateArticles="getAllArticles" ></TableArticles>
  </div>
</template>

<script>
import fetchData from '@/utils/fetchData'
import TableArticles from "../components/Admin/TableArticles.vue"
import CardKPI from "../components/Admin/CardKPI.vue"

export default {
  components: {
    CardKPI,
    TableArticles
  },
  data(){
    return{
      count:{
        allArticles:0
      },
      allArticles:{},
      selectedArticle : {},
      tableTitle:'',
      urlImage:'',
    }
  },
  methods: {
    getAllArticles() {
      console.log("testestest");
      fetchData({ controller: "articlesController", action: "getAllArticles" }).then(data => {
        if (Object.keys(data).length) {
          this.allArticles = data;
          this.count.allArticles = Object.keys(data).length;
        }
      })
    },
    focusArticles(data,title){
      this.selectedArticle = data;
      this.tableTitle = title;
    },
  },
  created(){
    this.getAllArticles();
  }
}
</script>

<style>
    .cardBoxArticles {
  position: relative;
  width: calc(100% - 300px);
  top: 40px;
  left: 300px;
  padding: 20px 30px;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
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