<template>
    <template v-if="users.length>0">

        <DataTable ref="dt" :value="users" v-model:selection="selectedUser" dataKey="idLoan" :paginator="true" :rows="5" :filters="filters" paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5, 10, 25]" sortField="duration"
            :sortOrder="-1" currentPageReportTemplate="Showing {first} to {last} of {totalRecords} products" responsiveLayout="scroll">
            <template #header>
                <div class="table-header flex flex-column md:flex-row md:justiify-content-between">
                    <h5 class="mb-2 md:m-0 p-as-md-center">{{tableTitle}}</h5>
                    <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <Button icon="pi pi-plus" class="p-button-rounded p-button-success" @click="addUserPopup=!addUserPopup"/>
                        <InputText v-model="filters['global'].value" placeholder="Search..." />
                        <Button label="Export" icon="pi pi-upload" class="p-button-info mr-2"
                            @click="exportCSV($event)" />
                    </span>
                </div>
            </template>
            <Column header="Miniatur">
                <template #body="slotProps">
                    <img class="miniature1" :src="urlImage+'/userprofile/'+slotProps.data.profilPhoto" style="filter:invert(1)" v-if="slotProps.data.profilPhoto==='account_default.png'" />
                    <img class="miniature1" :src="urlImage+'/userprofile/'+slotProps.data.profilPhoto"  v-else />
                </template>
            </Column>
            <Column field="firstname" header="Nom" exportHeader="Titre" headerStyle="width: 20%">
                <template #body="slotProps">
                    <p>{{ (slotProps.data.firstname) }}</p>
                </template>
            </Column>
            <Column field="lastname" header="Prénom"></Column>
            <!-- <Column field="stock" header="Stock" :sortable="true">
                <template #body="slotProps">
                    <p v-if="~~slotProps.data.stock===0" style="color:red;">{{slotProps.data.stock}}</p>
                    <p v-else style="color:green;">{{(slotProps.data.stock)}}</p>
                </template>
            </Column> -->
            <Column field="email" header="Email"></Column>
            <Column :exportable="false" style="min-width:8rem">
                <template #body="slotProps">
                    <Button icon="pi pi-pencil" class="p-button-rounded p-button-success mr-2" @click="userDetail(slotProps.data)" />
                    <Button icon="pi pi-trash" class="p-button-rounded p-button-warning" @click="deleteUser(slotProps.data)" />
                </template>
            </Column>
        </DataTable>
        <UsersPopup :isAddArticle="false" :loans="users" :loan="user" :loanPopup1="userPopup" @updateArticles="this.$emit('update')" @loanPopup="userPopup = !userPopup"></UsersPopup>
        <UsersPopup :isAddArticle="true" :loans="users" :loan="newUser" :loanPopup1="addUserPopup" @addArticles="this.$emit('update')" @loanPopup="addUserPopup = !addUserPopup"></UsersPopup>
    </template>
</template>

<script>
import { FilterMatchMode } from 'primevue/api';
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import UsersPopup from "./UsersPopup.vue"
import InputText from 'primevue/inputtext';
import store from '@/store';
import fetchData from '@/utils/fetchData';

export default {
    props: ['allUsers','tableTitle'],
    components: {
        Button,
        DataTable,
        InputText,
        Column,
        UsersPopup,
    },
    methods: {
        exportCSV() {
            this.$refs.dt.exportCSV();
        },
        initFilters() {
            this.filters = {
                'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
            }
        },
        userDetail(user) {
            this.user = { ...user };
            this.userPopup = true;
        },
        deleteUser(data){
            console.log(data);
            this.$confirm.require({
                message: 'Êtes-vous sûre de vouloir supprimer cet utilisateur ?',
                header: 'Confirmation',
                icon: 'pi pi-exclamation-triangle',
                accept: () => {
                    fetchData({controller:'usersController',action:'deleteUser',idUser:data.idUser}).then(data=>{
                        console.log(data);
                        if(data==="delete done"){
                            this.$toast.add({severity:'warn', summary: 'Acomplie', detail:'Utilisateur supprimé.',group: 'tl', life: 3000});
                            this.$emit('update');
                        }else{
                            this.$toast.add({severity:'alert', summary: 'Erreur', detail:'Probeleme lors de la suppréssion.',group: 'tl', life: 3000});
                        }

                    })
                    //callback to execute when user confirms the action
                },
                reject: () => {
                    //callback to execute when user rejects the action
                }
            });
        },
    },
    data() {
        return {
            users: {},
            filters: {},
            selectedUser: {},
            user: {},
            userPopup: false,
            urlImage : '',
            addUserPopup:false,
            newUser:{
                firstname:"",
                lastname:"",
                email:"",
                pseudo:"",
                pwd:"",
                profilPhoto:'account_default(2).png',
                adresse:'',
                telephone:'',
            }
        }
    },
    created() {
        this.initFilters();
        this.urlImage = store.state.urlImage;
    },
    mounted() {
        this.users = this.allUsers;
    },
    watch: {
        allUsers() {
            this.users = this.allUsers;
            // this.loans = this.allUsers;
        }
    },
}
</script>

<style lang="scss">
.table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

}

.p-datatable .p-datatable-header {
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
}

.p-datatable .p-paginator-bottom {
    border-bottom-left-radius: 20px !important;
    border-bottom-right-radius: 20px !important;
}
.p-as-md-center{
    font-size: 1.5em;
}
.miniature1{
    max-width: 75px !important;
    border-radius: 20px;
}
</style>