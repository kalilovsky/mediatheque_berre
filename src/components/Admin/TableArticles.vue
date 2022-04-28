<template>
    <template v-if="loans.length>0">

        <DataTable ref="dt" :value="loans" v-model:selection="selectedLoan" dataKey="idLoan" :paginator="true" :rows="5" :filters="filters" paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5, 10, 25]" sortField="duration"
            :sortOrder="-1" currentPageReportTemplate="Showing {first} to {last} of {totalRecords} products" responsiveLayout="scroll">
            <template #header>
                <div class="table-header flex flex-column md:flex-row md:justiify-content-between">
                    <h5 class="mb-2 md:m-0 p-as-md-center">{{tableTitle}}</h5>
                    <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <InputText v-model="filters['global'].value" placeholder="Search..." />
                        <Button label="Export" icon="pi pi-upload" class="p-button-info mr-2"
                            @click="exportCSV($event)" />
                    </span>
                </div>
            </template>
            <!-- <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column> -->
            <Column header="Miniatur">
                <template #body="slotProps">
                    <img class="miniature" :src="urlImage+'/articlefile/'+slotProps.data.filePath" style="max-width:150px">
                    <!-- <img src="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png" :alt="slotProps.idArticle"> -->
                </template>
            </Column>
            <Column field="title" header="Titre" exportHeader="Titre" headerStyle="width: 20%">
                <template #body="slotProps">
                    <p>{{ (slotProps.data.title.substring(0, 80) + "...") }}</p>
                </template>
            </Column>
            <Column field="categorieName" header="Catégorie"></Column>
            <Column field="stock" header="Stock" :sortable="true">
                <template #body="slotProps">
                    <p v-if="~~slotProps.data.stock===0" style="color:red;">{{slotProps.data.stock}}</p>
                    <p v-else style="color:green;">{{(slotProps.data.stock)}}</p>
                </template>
            </Column>
            <Column field="email" header="Email"></Column>
            <Column :exportable="false" style="min-width:8rem">
                <template #body="slotProps">
                    <Button icon="pi pi-pencil" class="p-button-rounded p-button-success mr-2" @click="loanDetail(slotProps.data)" />
                    <Button icon="pi pi-trash" class="p-button-rounded p-button-warning" @click="deleteArticle(slotProps.data)" />
                </template>
            </Column>
        </DataTable>
        <ArticlePopup :loans="loans" :loan="loan" :loanPopup1="loanPopup" @updateArticles="this.$emit('updateArticles')" @loanPopup="loanPopup = !loanPopup"></ArticlePopup>
    </template>
</template>

<script>
import { FilterMatchMode } from 'primevue/api';
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ArticlePopup from "./ArticlePopup.vue"
import InputText from 'primevue/inputtext';
import store from '@/store';
import fetchData from '@/utils/fetchData';

export default {
    props: ['selectedLoans','tableTitle'],
    components: {
        Button,
        DataTable,
        InputText,
        Column,
        ArticlePopup,
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
        toLocaleDate(text) {
            let test = new Date(text).toLocaleDateString('fr-FR');
            return test;
        },
        loanDetail(loan) {
            this.loan = { ...loan };
            this.loanPopup = true;
        },
        deleteArticle(data){
            this.$confirm.require({
                message: 'Êtes-vous sûre de vouloir supprimer '+data.title+' ?',
                header: 'Confirmation',
                icon: 'pi pi-exclamation-triangle',
                accept: () => {
                    fetchData({controller:'articlesController',action:'deleteArticle',idArticle:data.idArticle}).then(data=>{
                        console.log(data);
                        this.$toast.add({severity:'warn', summary: 'Acomplie', detail:'Article supprimé.', life: 3000});
                        this.$emit('updateArticles');

                    })
                    //callback to execute when user confirms the action
                },
                reject: () => {
                    //callback to execute when user rejects the action
                }
            });
        },
        updateArticle(){
            console.log("khalil");
        }


    },
    data() {
        return {
            loans: {},
            filters: {},
            selectedLoan: {},
            loan: {},
            loanPopup: false,
            urlImage : ''
        }
    },
    created() {
        this.initFilters();
        this.urlImage = store.state.urlImage;
    },
    mounted() {
        this.loans = this.selectedLoans;
    },
    watch: {
        selectedLoans() {
            this.loans = this.selectedLoans;
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
.miniature{
    max-width: 150px;
    border-radius: 20px;
}
</style>