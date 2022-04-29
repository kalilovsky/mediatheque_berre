<template>
    <Dialog v-model:visible="loanPopup" :style="{ width: '600px' }" header="Detail de l'article" :modal="true"
        class="p-fluid">
        <div class="imgArticle" v-if="articleSetting.filePath.value===true">
            <img ref="img1" :src="urlImage + 'articlefile/' + myLoan.filePath" :alt="myLoan.filePath"
                class="product-image" />
        </div>
        <div class="articleInfo">
            <span class="labelText" v-if="articleSetting.title.value===true">
                <label for="title">Titre</label>
                <InputText type="text" v-model="myLoan.title" disabled />
            </span>
            <span class="textArea" v-if="articleSetting.smallDesc.value===true">
                <label for="title">Description</label>
                <Textarea v-model="myLoan.smallDesc" :autoResize="true" rows="5" cols="30" disabled />
            </span>
            <span class="labelText" v-if="articleSetting.idCategory.value===true">
                <label for="title">Catégorie</label>
                <InputText type="text" v-model="myLoan.categorieName" disabled />
            </span>
            <span class="labelText" v-if="articleSetting.idSubCategorie.value===true">
                <label for="title">Genre</label>
                <InputText type="text" v-model="myLoan.SubcategorieName" disabled />
            </span>
            <span class="labelText" v-if="articleSetting.idCollection.value===true">
                <label for="title">Collection</label>

                <InputText type="text" v-model="myLoan.collectionName" disabled />
            </span>
            <span class="labelText" v-if="articleSetting.author.value===true">
                <label for="title">Autheur</label>
                <InputText type="text" v-model="myLoan.author" disabled />
            </span>
            <span class="labelText" v-if="articleSetting.editor.value===true">
                <label for="title">Editeur</label>
                <InputText type="text" v-model="myLoan.editor" disabled />
            </span>
            <span class="labelText" v-if="articleSetting.format.value===true">
                <label for="title">Format</label>
                <InputText type="text" v-model="myLoan.format" disabled />
            </span>
            <span class="labelText" v-if="articleSetting.datePublished.value===true">
                <label for="title">Date de publication</label>
                <InputText type="date" v-model="myLoan.datePublished" disabled />
            </span>
            <span class="labelText" v-if="articleSetting.editor.value===true">
                <label for="title">Editeur</label>
                <InputText type="text" v-model="myLoan.editor" disabled />
            </span>
            <span class="labelText" v-if="articleSetting.loanDuration.value===true">
                <label for="title">Durée max de prêt 'Jour(s)'</label>
                <InputText type="number" v-model="myLoan.loanDuration" disabled />
            </span>
            <span class="labelText" v-if="articleSetting.stock.value===true">
                <label for="title">Stock</label>
                <InputText type="number" v-model="myLoan.stock" disabled />
            </span>
        </div>

    </Dialog>
</template>

<script>
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import store from '@/store';
import Textarea from 'primevue/textarea';
import fetchData from '@/utils/fetchData';

export default {
    components: {
        Dialog,
        InputText,
        Textarea,

    },
    props: ['loan', 'loanPopup1', 'loans', 'isAddArticle'],
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
            updateLoading: false,
            articleSetting: {
                title: { name: "Titre", value: false },
                smallDesc: { name: "Description", value: false },
                filePath: { name: "Image", value: false },
                author: { name: "Autheur", value: false },
                stock: { name: "Stock", value: false },
                editor: { name: "Editeur", value: false },
                loanDuration: { name: "Durée du prêt", value: false },
                idCategory: { name: "Catégorie", value: false },
                idSubCategorie: { name: "Genre", value: false },
                idCollection: { name: "Collection", value: false },
                idUser: { name: "Utilisateur", value: false },
                format: { name: "Format", value: false },
                datePublished: { name: "Date de publication", value: false }
            },
        }
    },
    created() {
        this.urlImage = store.state.urlImage;
        // this.loanPopup = this.loanPopup1;
        this.myLoan = this.loan;
        fetchData({ controller: 'articlesController', action: 'getArticleSetting' }).then(data => {
            // this.articleSetting = data;
            Object.keys(data).map(item => {
                if (data[item] === '1') {
                    this.articleSetting[item].value = true;
                } else {
                    this.articleSetting[item].value = false;
                }
            })
        })
        

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
            if (this.loanPopup === true) {
                this.myLoan = this.loan;
                fetchData({ controller: 'articlesController', action: 'getArticleSetting' }).then(data => {
            // this.articleSetting = data;
            Object.keys(data).map(item => {
                if (data[item] === '1') {
                    this.articleSetting[item].value = true;
                } else {
                    this.articleSetting[item].value = false;
                }
            })
        })
            }
        },
        loan() {
            this.myLoan = this.loan;
        },
        myLoan() {
        }

    },
    methods: {
        toLocaleDate(text) {
            let test = new Date(text).toLocaleDateString('fr-FR');
            return test;
        },
    },
}
</script>

<style lang="scss">
.imgArticle {
    width: 100%;
    overflow: hidden;

    display: flex;
    justify-content: center;

    img {
        width: 150px;
        border-radius: 20px;
    }
}

.articleInfo {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin: 20px 0;

    .textArea {
        grid-column-start: 1;
        grid-column-end: 3;

    }

    .labelText {
        display: flex;
        flex-direction: column;

        input {
            color: #495057;
        }

        label {
            padding-bottom: 10px;
        }
    }
}

.loanInfo {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;

    input {
        color: #495057;
    }

    label {
        padding-bottom: 10px;
    }
}

.button {
    width: 100%;
    justify-content: center;
    display: flex;

    button {
        width: 30% !important;
    }
}
</style>