<template>
    <Dialog v-model:visible="loanPopup" :style="{ width: '600px' }" header="Detail de l'article" :modal="true"
        class="p-fluid">
        <FileUpload mode="basic" accept="image/*" :maxFileSize="1000000" label="Import Image" chooseLabel="Import"
                class="mr-2 inline-block" :customUpload="true" @uploader="upload" :auto="true" invalidFileLimitMessage='{0}: Taille du fichier incorect, la taille doit être inférieur à {1}.' >
        </FileUpload>
        <div class="imgArticle">
            <img ref="img1" :src="urlImage + 'articlefile/' + myLoan.filePath" :alt="myLoan.filePath" class="product-image" />
        </div>
        <div class="articleInfo">
            <span class="labelText">
                <label for="title">Titre</label>
                <InputText type="text" v-model="myLoan.title"  />
            </span>
            <span class="textArea">
                <label for="title">Description</label>
                <Textarea v-model="myLoan.smallDesc" :autoResize="true" rows="5" cols="30" />
            </span>
            <span class="labelText">
                <label for="title">Catégorie</label>
                <Dropdown v-model="myLoan.idCategory" :options="categories" optionLabel="categorieName" optionValue="idCategorie" placeholder="Selectionner une catégorie" @change="updateSubCat"></Dropdown>
            </span>
            <span class="labelText">
                <label for="title">Genre</label>
                <Dropdown v-model="myLoan.idSubCategorie" :options="subCategories" optionLabel="SubcategorieName" optionValue="idSubCategorie" placeholder="Selectionner un genre"></Dropdown>
            </span>
            <span class="labelText">
                <label for="title">Collection</label>
                <Dropdown v-model="myLoan.idCollection" :options="collections" optionLabel="collectionName" optionValue="idCollection" placeholder="Selectionner une collection" ></Dropdown>
            </span>
            <span class="labelText">
                <label for="title">Autheur</label>
                <InputText type="text" v-model="myLoan.author"  />
            </span>
            <span class="labelText">
                <label for="title">Editeur</label>
                <InputText type="text" v-model="myLoan.editor"  />
            </span>
            <span class="labelText">
                <label for="title">Format</label>
                <InputText type="text" v-model="myLoan.format"  />
            </span>
            <span class="labelText">
                <label for="title">Date de publication</label>
                <InputText type="date" v-model="myLoan.datePublished"  />
            </span>
            <span class="labelText">
                <label for="title">Editeur</label>
                <InputText type="text" v-model="myLoan.editor"  />
            </span>
            <span class="labelText">
                <label for="title">Durée max de prêt 'Jour(s)'</label>
                <InputText type="number" v-model="myLoan.loanDuration"  />
            </span>
             <span class="labelText">
                <label for="title">Stock</label>
                <InputText type="number" v-model="myLoan.stock"  />
            </span>
        </div>
        <div class="button">
            <Button v-if="!isAddArticle" type="button" label="Mise à jour" icon="pi pi-upload" :loading="updateLoading" @click="updateArticle" />
            <Button v-else type="button" label="Ajouter" icon="pi pi-upload" :loading="updateLoading" @click="addArticle" />
        </div>

    </Dialog>
</template>

<script>
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import store from '@/store';
import FileUpload from 'primevue/fileupload';
import Textarea from 'primevue/textarea';
import fetchData from '@/utils/fetchData';
import Dropdown from 'primevue/dropdown';
import Button from 'primevue/button';

export default {
    components: {
        Dialog,
        InputText,
        FileUpload,
        Textarea,
        Dropdown,
        Button,
    },
    props: ['loan', 'loanPopup1','loans', 'isAddArticle'],
    data() {
        return {
            urlImage: "",
            loanPopup: false,
            myLoan: null,
            categories: {},
            subCategories: {},
            collections: {},
            authors: {},
            editors: {},
            updateLoading : false,
        }
    },
    created() {
        this.urlImage = store.state.urlImage;
        // this.loanPopup = this.loanPopup1;
        this.myLoan = this.loan; 

    },
    // mounted(){
    //     this.myLoan = this.loan;

    // },
    watch: {
        loanPopup1() {
            this.loanPopup = this.loanPopup1;
        },
        loanPopup() {
            if (!this.loanPopup) {
                this.$emit('loanPopup')
            }
            if(this.loanPopup===true){
                this.myLoan = this.loan;
                this.getCategories();
                this.getSubCategoties();
                this.getAuthors();
                this.getEditors();
                this.getCollections();
            }
        },
        loan(){
            this.myLoan = this.loan;
            this.getCategories();
            this.getSubCategoties();
            this.getAuthors();
            this.getEditors();
            this.getCollections();
        },
        myLoan(){
            this.getCategories();
            this.getSubCategoties();
            this.getAuthors();
            this.getEditors();
            this.getCollections();
        }

    },
    methods:{
        addArticle(){
            if(store.state.userInfo.isConnected ===true){
                this.updateLoading = !this.updateLoading;
                this.$confirm.require({
                    message: 'Êtes-vous sûre de vouloir ajouter cet article ?',
                    header: 'Confirmation',
                    icon: 'pi pi-exclamation-triangle',
                    accept: () => {
                        fetchData({controller : 'articlesController', action:'addArticle',...this.myLoan}).then(data=>{
                            if(data==="Article inséré correctement"){
                                this.$toast.add({severity:'success', summary: 'Acomplie', detail:'Article ajouté avec succées.',group: 'tl', life: 3000});
                                this.updateLoading = !this.updateLoading;
                                this.$emit('addArticles');
                                this.loanPopup = !this.loanPopup;
                            }
                        })
                        //callback to execute when user confirms the action
                    },
                    reject: () => {
                        this.updateLoading = !this.updateLoading;
                        //callback to execute when user rejects the action
                    }
                });
            }else{
                this.$toast.add({severity:'success', summary: 'Attention', detail:'Connectez vous pour pouvoir inserez un article',group: 'tl', life: 3000});
            }
        },
        updateArticle(){
            this.updateLoading = !this.updateLoading
            this.$confirm.require({
                message: 'Êtes-vous sûre de vouloir mettre à jour cet article ?',
                header: 'Confirmation',
                icon: 'pi pi-exclamation-triangle',
                accept: () => {
                    fetchData({controller : 'articlesController', action:'updateArticle',...this.myLoan}).then(data=>{
                        if(data==="good"){
                            this.$toast.add({severity:'success', summary: 'Acomplie', detail:'Article mise à jour.',group: 'tl', life: 3000});
                            this.updateLoading = !this.updateLoading;
                            this.$emit('updateArticles');
                            this.loanPopup = !this.loanPopup;
                            
                        }
                    })
                    //callback to execute when user confirms the action
                },
                reject: () => {
                    this.updateLoading = !this.updateLoading;
                    //callback to execute when user rejects the action
                }
            });
        },
        getCategories(){
            let cat = this.loans.map(item => {
                return { idCategorie: item.idCategorie, categorieName: item.categorieName };
            })
            let cat2 = [...new Set(cat.map(a => JSON.stringify(a)))].map(a => JSON.parse(a));
            this.categories = cat2;
        },
        getSubCategoties() {
            if (this.loan.idCategory){
                fetchData({controller :'articlesController', action:'getAllSubCategories', idCategorie: this.loan.idCategory}).then(data=>{
                    this.subCategories = data;
                })
            }else{
                fetchData({controller :'articlesController', action:'getAllSubCategories'}).then(data=>{
                    this.subCategories = data;
                })
            }
        },
        updateSubCat(){
            fetchData({controller :'articlesController', action:'getAllSubCategories', idCategorie: this.myLoan.idCategory}).then(data=>{
                this.subCategories = data;
            })
        },
        getCollections() {
            let cat = this.loans.map(item => {
                return { idCollection: item.idCollection, collectionName: item.collectionName };
            })
            let cat2 = [...new Set(cat.map(a => JSON.stringify(a)))].map(a => JSON.parse(a));
            this.collections = cat2;
        },
        getAuthors() {
            let cat = this.loans.map(item => {
                return { author: item.author};
            })
            let cat2 = [...new Set(cat.map(a => JSON.stringify(a)))].map(a => JSON.parse(a));
            this.authors = cat2;
        },
        getEditors() {
            let cat = this.loans.map(item => {
                return { editor: item.editor};
            })
            let cat2 = [...new Set(cat.map(a => JSON.stringify(a)))].map(a => JSON.parse(a));
            this.editors = cat2;

        },
        toLocaleDate(text) {
            let test = new Date(text).toLocaleDateString('fr-FR');
            return test;
        },
        upload(e){
            let reader = new FileReader();
            reader.addEventListener('load', this.handleReader);
            reader.readAsDataURL(e.files[0]);
            this.myLoan.filePath = e.files[0].name;
            // console.log(e.files[0].name);
            let formData = new FormData;
            formData.append('file',e.files[0]);
            formData.append('controller','articlesController');
            formData.append('action','uploadFile');
            fetchData(formData,'formdata').then(data=>{
                console.log(data);
            })
        },
        handleReader(ee){
            this.$refs.img1.src = ee.target.result;
        }
    },
}
</script>

<style lang="scss">
.imgArticle{
    width: 100%;
    overflow: hidden;
    
    display: flex;
    justify-content: center;
    img{
        width: 150px;
        border-radius: 20px;
    }
}
    .articleInfo{
        display: grid;
        grid-template-columns: repeat(2,1fr);
        gap: 20px;
        margin: 20px 0;
        .textArea{
        grid-column-start: 1;
        grid-column-end: 3;

    }
        .labelText{
            display: flex;
            flex-direction: column;
            input{
                color: #495057;
            }
            label{
                padding-bottom: 10px;
            }
        }
    }
    .loanInfo{
        display: grid;
        grid-template-columns: repeat(2,1fr);
        gap: 20px;
        input{
            color: #495057;
        }
        label{
            padding-bottom: 10px;
        }
    }
    .button{
        width: 100%;
        justify-content: center;
        display: flex;
        button{
            width: 30% !important;
        }
    }
    
</style>