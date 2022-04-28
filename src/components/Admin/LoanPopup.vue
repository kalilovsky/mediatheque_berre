<template>
    <Dialog v-model:visible="loanPopup" :style="{ width: '600px' }" header="Detail du prêt" :modal="true"
        class="p-fluid">
        <div class="imgArticle">
            <img :src="urlImage + 'articlefile/' + myLoan.filePath" :alt="myLoan.filePath" class="product-image" />
        </div>
        <div class="articleInfo">
            <span class="labelText">
                <label for="title">Titre</label>
                <InputText id="title" type="text" v-model="myLoan.title" disabled />
            </span>
            <span class="labelText">
                <label for="title">Catégorie</label>
                <InputText id="title" type="text" v-model="myLoan.categorieName" disabled />
            </span>
            <span class="labelText">
                <label for="title">Genre</label>
                <InputText id="title" type="text" v-model="myLoan.SubcategorieName" disabled />
            </span>
            <span class="labelText">
                <label for="title">Collection</label>
                <InputText id="title" type="text" v-model="myLoan.collectionName" disabled />
            </span>
        </div>
        <div class="loanInfo">
            <span class="labelText">
                <label for="title">Date du prêt</label>
                <InputText id="title" type="text" :value="toLocaleDate(myLoan.loansDate)" disabled />
            </span>
            <span class="labelText">
                <label for="title">Durée depuis le prêt</label>
                <InputText id="title" type="text" :value="myLoan.duration+' jour(s)'" disabled />
            </span>
            <span class="labelText">
                <label for="title">Durée max de prêt</label>
                <InputText id="title" type="text" :value="myLoan.loanDuration+' jour(s)'" disabled />
            </span>
            <span class="labelText">
                <label for="title">Statut du prêt</label>
                <InputText id="title" type="text" :value="myLoan.status" disabled />
            </span>
            <span class="labelText">
                <label for="title">Nom et Prenom</label>
                <InputText id="title" type="text" :value="myLoan.firstname+' '+myLoan.lastname" disabled />
            </span>
            <span class="labelText">
                <label for="title">Téléphone</label>
                <InputText id="title" type="text" :value="myLoan.telephone" disabled />
            </span>
        </div>

    </Dialog>
</template>

<script>
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import store from '@/store';
export default {
    components: {
        Dialog,
        InputText,
    },
    props: ['loan', 'loanPopup1'],
    data() {
        return {
            urlImage: "",
            loanPopup: false,
            myLoan: null,
        }
    },
    created() {
        this.urlImage = store.state.urlImage;

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
        },
        loan(){
            this.myLoan = this.loan;
        }

    },
    methods:{
        toLocaleDate(text) {
            let test = new Date(text).toLocaleDateString('fr-FR');
            return test;
        },
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
</style>