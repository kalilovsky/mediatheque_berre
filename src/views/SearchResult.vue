<template>
    <div class="homeSearch">
        <div class="filterBar">
            <h2>Filtres Avancés</h2>
            <div class="tag">
                <Tag :value="categories[0].categorieName" icon="pi pi-times" v-if="filter.filterByCat.length>0 && categories.length>0" @click="filter.filterByCat=''"></Tag>
                <Tag :value="subCategories[0].SubcategorieName" icon="pi pi-times" v-if="filter.filterBySubCat.length>0 && subCategories.length>0" @click="filter.filterBySubCat=''"></Tag>
                <Tag :value="collections[0].collectionName" icon="pi pi-times" v-if="filter.filterByCol.length>0 && collections.length>0" @click="filter.filterByCol=''"></Tag>
                <Tag :value="authors[0].author" icon="pi pi-times" v-if="filter.filterByAuthor.length>0 && authors.length>0" @click="filter.filterByAuthor=''"></Tag>
                <Tag :value="editors[0].editor" icon="pi pi-times" v-if="filter.filterByEditor.length>0 && editors.length>0" @click="filter.filterByEditor=''"></Tag>
            </div>
            <Dropdown v-model="filter.filterByCat" :options="categories" optionValue="idCategorie"
                optionLabel="categorieName" placeholder="Par Catégorie" />
            <Dropdown v-model="filter.filterBySubCat" :options="subCategories" optionLabel="SubcategorieName"
                optionValue="idSubCategorie" placeholder="Par Genre" />
            <Dropdown v-model="filter.filterByCol" :options="collections" optionLabel="collectionName"
                optionValue="idCollection" placeholder="Par Collection" />
            <Dropdown v-model="filter.filterByAuthor" :options="authors" optionLabel="author" optionValue="author"
                placeholder="Par Autheur" />
            <Dropdown v-model="filter.filterByEditor" :options="editors" optionLabel="editor" optionValue="editor"
                placeholder="Par Editeurs" />
            <Button @click="resetFilter">Réinitialser les filtres</Button>
        </div>
        <template v-if="!isLoading">

            <template v-for="(article, articleKey) in articles" :key="articleKey">
                <Product :idArticle="article.idArticle" :url="article.filePath" :title="article.title"
                    :subCat="article.categorieName" :author="article.author" @reloadArticles="getFiltredArticles" @click="showPopupFn(article)">
                    <Tag class="myTag" value="Disponible" severity="success" rounded v-if="~~article.stock > 0"></Tag>
                    <Tag class="myTag" value="Indisponible" severity="danger" rounded v-else></Tag>
                </Product>
            </template>
            <ArticlePopupHome :loans="loans" :loan="selectedArticle" :loanPopup1="showPopup" @loanPopup="showPopup = !showPopup"></ArticlePopupHome>
        </template>
        
        <template v-else>
            <div class="progress">
               <ProgressSpinner />
            </div>
        </template>
    </div>
</template>

<script>
import store from "@/store/"
import fetchData from '@/utils/fetchData';
import ProgressSpinner from 'primevue/progressspinner';
import Product from "../components/ProductCard.vue"
import Tag from 'primevue/tag';
import Dropdown from 'primevue/dropdown';
import Button from "primevue/button";
import ArticlePopupHome from "../components/Admin/ArticlePopupHome.vue"

export default {
    components: {
        ProgressSpinner,
        Product,
        Tag,
        Dropdown,
        Button,
        ArticlePopupHome,
    },
    data() {
        return ({
            articles: {},
            categories: {},
            subCategories: {},
            collections: {},
            authors: {},
            editors: {},
            filter: {
                filterByText: "",
                filterByCat: "",
                filterBySubCat: "",
                filterByCol: "",
                filterByAuthor: "",
                filterByEditor: "",
            },
            isLoading : false,
            selectedArticle:{},
            showPopup : false,
        })
    },
    created() {
        this.filter = store.state.filterCriteria;
        this.unsubscribe = store.subscribe((mutation) => {
            if (mutation.type === "updateTextFilterCritera") {
                this.filter = store.state.filterCriteria;
            }
        })
    },
    beforeUnmount() {
        this.unsubscribe();
    },
    watch: {
        filter: {
            handler() {
                this.getFiltredArticles();
                
            },
            deep: true,
        },
    },
    methods: {
        showPopupFn(article){
      this.selectedArticle = article;
      this.showPopup = !this.showPopup;
    },
        getFiltredArticles() {
            this.isLoading=true;
            fetchData({ controller: "articlesController", action: "searchArticles", text: this.filter.filterByText, idCategory: this.filter.filterByCat, idSubCategorie: this.filter.filterBySubCat, author: this.filter.filterByAuthor, editor: this.filter.filterByEditor, idCollection: this.filter.filterByCol }).then(data => {
                if (data.length >= 0) {
                    this.articles = data;
                    this.categories = this.getCategoties(data);
                    this.subCategories = this.getSubCategoties(data);
                    this.collections = this.getCollections(data);
                    this.authors = this.getAuthors(data);
                    this.editors = this.getEditors(data);
                    this.isLoading=false;
                }
            })
        },
        getCategoties(data) {
            let cat = data.map(item => {
                return { idCategorie: item.idCategorie, categorieName: item.categorieName };
            })
            let cat2 = [...new Set(cat.map(a => JSON.stringify(a)))].map(a => JSON.parse(a));
            return cat2;
        },
        getSubCategoties(data) {
            let cat = data.map(item => {
                return { idSubCategorie: item.idSubCategorie, SubcategorieName: item.SubcategorieName };
            })
            let cat2 = [...new Set(cat.map(a => JSON.stringify(a)))].map(a => JSON.parse(a));
            return cat2;
        },
        getCollections(data) {
            let cat = data.map(item => {
                return { idCollection: item.idCollection, collectionName: item.collectionName };
            })
            let cat2 = [...new Set(cat.map(a => JSON.stringify(a)))].map(a => JSON.parse(a));
            return cat2;
        },
        getAuthors(data) {
            let cat = data.map(item => {
                return { author: item.author};
            })
            let cat2 = [...new Set(cat.map(a => JSON.stringify(a)))].map(a => JSON.parse(a));
            return cat2;
        },
        getEditors(data) {
            let cat = data.map(item => {
                return { editor: item.editor};
            })
            let cat2 = [...new Set(cat.map(a => JSON.stringify(a)))].map(a => JSON.parse(a));
            return cat2;

        },
        resetFilter(){
            this.filter = {
                filterByText: "",
                filterByCat: "",
                filterBySubCat: "",
                filterByCol: "",
                filterByAuthor: "",
                filterByEditor: "",
            }
            store.commit({type:'updateTextFilterCritera',filter:{filterByText:this.filter.filterByText}})
        },
    }
}
</script>

<style lang="scss">
.homeSearch {
    position: relative;
    min-height: 100vh;
    max-width: 80%;
    padding: 90px 0px;
    left: 20%;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    justify-items: center;
    align-content: center;

    .filterBar {
        position: fixed;
        background: white;
        width: 20%;
        height: calc(100% - 100px);
        z-index: 50;
        border-right: 1px solid #dee2e6;
        ;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        justify-content: center;
        top: 100px;
        left: 0;
        .tag{
            .p-tag{
                cursor: pointer;
            }
        }
        
        
    }
    .progress{
            grid-column-start: 1;
            grid-column-end: 3;
            display: flex;
            justify-content: center;
        }
}
</style>