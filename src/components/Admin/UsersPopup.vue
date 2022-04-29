<template>
    <Dialog v-model:visible="loanPopup" :style="{ width: '600px' }" header="Detail de l'article" :modal="true"
        class="p-fluid">
        <FileUpload mode="basic" accept="image/*" :maxFileSize="1000000" label="Import Image" chooseLabel="Import"
                class="mr-2 inline-block" :customUpload="true" @uploader="upload" :auto="true" invalidFileLimitMessage='{0}: Taille du fichier incorect, la taille doit être inférieur à {1}.' >
        </FileUpload>
        <div class="imgArticle">
            <img v-if="myLoan.profilPhoto==='account_default.png'" ref="img1" :src="urlImage + 'userprofile/' + myLoan.profilPhoto" :alt="myLoan.filePath" class="product-image" style="filter:invert(1)"/>
            <img v-else ref="img1" :src="urlImage + 'userprofile/' + myLoan.profilPhoto" :alt="myLoan.filePath" class="product-image"/>
        </div>
        <div class="articleInfo">
            <span class="labelText">
                <label for="title">Nom</label>
                <InputText type="text" v-model="myLoan.firstname"  />
            </span>
            <span class="labelText">
                <label for="title">Prénom</label>
                <InputText type="text" v-model="myLoan.lastname"/>
            </span>
            <span class="labelText">
                <label for="title">Email</label>
                <InputText type="email" v-model="myLoan.email"  />
            </span>
            <span class="labelText">
                <label for="title">Pseudo</label>
                <InputText type="text" v-model="myLoan.pseudo"  />
            </span>
            <span class="labelText">
                <label for="title">Adresse</label>
                <InputText type="text" v-model="myLoan.adresse"  />
            </span>
            <span class="labelText">
                <label for="title">Téléphone</label>
                <InputMask v-model="myLoan.telephone" placeholder="Téléphone" mask="99-99-99-99-99" />
            </span>
            <span class="labelText">
                <label for="title">Mot de passe</label>
                <InputText type="text" v-model="myLoan.pwd"  />
            </span>
        </div>
        <div class="button">
            <Button v-if="!isAddArticle" type="button" label="Mise à jour" icon="pi pi-upload" :loading="updateLoading" @click="updateUser" />
            <Button v-else type="button" label="Ajouter" icon="pi pi-upload" :loading="updateLoading" @click="addUser" />
        </div>

    </Dialog>
</template>

<script>
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import store from '@/store';
import FileUpload from 'primevue/fileupload';
// import Textarea from 'primevue/textarea';
import fetchData from '@/utils/fetchData';
// import Dropdown from 'primevue/dropdown';
import Button from 'primevue/button';
import InputMask from 'primevue/inputmask';


export default {
    components: {
        Dialog,
        InputText,
        FileUpload,
        // Textarea,
        // Dropdown,
        Button,
        InputMask
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
                this.myLoan.pwd = "";
            }
        },
        loan(){
            this.myLoan = this.loan;
        },

    },
    methods:{
        addUser(){
            if(store.state.userInfo.isConnected ===true){
                this.updateLoading = !this.updateLoading;
                this.$confirm.require({
                    message: 'Êtes-vous sûre de vouloir ajouter cet utilisateur ?',
                    header: 'Confirmation',
                    icon: 'pi pi-exclamation-triangle',
                    accept: () => {
                        fetchData({controller : 'usersController', action:'addUser',...this.myLoan}).then(data=>{
                            console.log(data);
                            if(data==="user added"){
                                this.$toast.add({severity:'success', summary: 'Acomplie', detail:'utilisateur ajouté avec succées.',group: 'tl', life: 3000});
                                this.updateLoading = !this.updateLoading;
                                this.$emit('addArticles');
                                this.loanPopup = !this.loanPopup;
                            }else{
                                this.$toast.add({severity:'warn', summary: 'Erreur', detail:data,group: 'tl', life: 3000});
                                this.updateLoading = !this.updateLoading;
                            }
                        })
                        //callback to execute when user confirms the action
                    },
                    reject: () => {
                        //callback to execute when user rejects the action
                    }
                });
            }else{
                this.$toast.add({severity:'success', summary: 'Attention', detail:'Connectez vous pour pouvoir créer un utilisateur',group: 'tl', life: 3000});
            }
        },
        updateUser(){
            this.updateLoading = !this.updateLoading
            this.$confirm.require({
                message: 'Êtes-vous sûre de vouloir mettre à jour cet utilisateur ?',
                header: 'Confirmation',
                icon: 'pi pi-exclamation-triangle',
                accept: () => {
                    fetchData({controller : 'usersController', action:'updateUser',...this.myLoan}).then(data=>{
                        if(data.isConnected ===true){
                            this.$toast.add({severity:'success', summary: 'Acomplie', detail:'Utilisateur mise à jour.',group: 'tl', life: 3000});
                            this.updateLoading = !this.updateLoading;
                            this.$emit('updateArticles');
                            this.loanPopup = !this.loanPopup;
                            
                        }
                    })
                    //callback to execute when user confirms the action
                },
                reject: () => {
                    //callback to execute when user rejects the action
                }
            });
        },
        toLocaleDate(text) {
            let test = new Date(text).toLocaleDateString('fr-FR');
            return test;
        },
        upload(e){
            let reader = new FileReader();
            reader.addEventListener('load', this.handleReader);
            reader.readAsDataURL(e.files[0]);
            this.myLoan.profilPhoto = e.files[0].name;
            // console.log(e.files[0].name);
            let formData = new FormData;
            formData.append('file',e.files[0]);
            formData.append('controller','usersController');
            formData.append('action','uploadFileImg');
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