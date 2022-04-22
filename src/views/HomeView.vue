<template>
  <div class="home">
    <template v-if="articles.length>0 && categories.length>0">
      <tab-view>
        <tab-panel class="colorNone" v-for="(category, catKey) in categories" :key="catKey" :header="category.categorieName">
          <div class="catContainer">
           <template v-for="(article, articleKey) in articles" :key="articleKey">

            <Product v-if="article.categorieName === category.categorieName" :url="article.filePath" :title="article.title" :subCat="article.categorieName" :author="article.author">
              <Tag class="myTag" value="Disponible" severity="primary" rounded v-if="~~article.stock>0"></Tag>
              <Tag class="myTag" value="Indisponible" severity="danger" rounded v-else></Tag>
            </Product>
          </template>
          </div>
        </tab-panel>
      </tab-view>
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

  },
  data() {
    return ({
      articles: {},
      categories: {},
    })
  },
  created() {
    let data = new Array();
    data['controller'] = "ArticlesController";
    data['action'] = "getAllArticles";
    fetchData(data).then(data => this.articles = data);
    data['action'] = "getAllCategories";
    fetchData(data).then(data => this.categories = data);

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
