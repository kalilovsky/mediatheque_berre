<template>
  <div class="home">
    <template v-if="articles.length>0 && categories.length>0">
      <tab-view>
        <tab-panel class="colorNone" v-for="(category, catKey) in categories" :key="catKey" :header="category.categorieName">
          <div class="catContainer">
           <template v-for="(article, articleKey) in articles" :key="articleKey">

            <Product v-if="article.categorieName === category.categorieName" :idArticle="article.idArticle" :url="article.filePath" :title="article.title" :subCat="article.categorieName" :author="article.author" @reloadArticles="getAllArticles" @click="showPopupFn(article)">
              <Tag class="myTag" value="Disponible" severity="success" rounded v-if="~~article.stock>0"></Tag>
              <Tag class="myTag" value="Indisponible" severity="danger" rounded v-else></Tag>
            </Product>
          </template>
          </div>
        </tab-panel>
      </tab-view>
      <ArticlePopupHome :loans="loans" :loan="selectedArticle" :loanPopup1="showPopup" @loanPopup="showPopup = !showPopup"></ArticlePopupHome>
      <!-- <template v-for="(category, catKey) in categories" :key="catKey">
        <div class="catName">
          <p>{{ category.categorieName }}</p>
        </div>
        <div class="catContainer">
          <template v-for="(article, articleKey) in articles" :key="articleKey">

            <Product v-if="article.categorieName === category.categorieName" :url="article.filePath"></Product>
          </template>
        </div>
      </template> -->
    </template>
    <template v-else>
      <ProgressSpinner/>
    </template>
  </div>
</template>


<script>
// @ is an alias to /src
import Product from "../components/ProductCard.vue"
import ArticlePopupHome from "../components/Admin/ArticlePopupHome.vue"
import fetchData from "../utils/fetchData"
import ProgressSpinner from 'primevue/progressspinner';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import Tag from 'primevue/tag';

export default {
  name: 'HomeView',
  components: {
    Product,
    ProgressSpinner,
    TabView,
    TabPanel,
    Tag,
    ArticlePopupHome,

  },
  data() {
    return ({
      articles: {},
      categories: {},
      selectedArticle:{},
      showPopup : false,
    })
  },
  created() {
    this.getAllArticles();
    this.getAllCat();

  },
  methods:{
    getAllCat(){
      let data = new Array();
      data['controller'] = "ArticlesController";
      data['action'] = "getAllCategories";
      fetchData(data,"get").then(data => this.categories = data).catch(error=> console.warn(error) );
    },
    getAllArticles(){
      let data = new Array();
      data['controller'] = "ArticlesController";
      data['action'] = "getAllArticles";
      fetchData(data,"get").then(data => this.articles = data).catch(error=> console.warn(error) );
    },
    showPopupFn(article){
      this.selectedArticle = article;
      this.showPopup = !this.showPopup;
    }
  },
  watch: {
    articles() {
    }
  }
}
</script>

<style lang="scss">
.home {
  position: relative;
  min-height: 100vh;
  min-width: 100%;
  padding: 40px 0px;
  left: 0;
  
  .p-tabview-panels{
    background: none !important;
  }
  .p-tabview-nav-container{
    width: 100%;
    position: fixed;
    z-index: 50  ;
    ul{
      display: flex;
      justify-content: space-around;
    }
  }
  .catContainer {
    position: relative;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    padding: 40px 0px;
    
  }
}
</style>
