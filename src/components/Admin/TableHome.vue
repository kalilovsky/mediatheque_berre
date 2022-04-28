<template>
    <!-- <Toolbar class="mb-4">
        <template #start>
            <Button label="New" icon="pi pi-plus" class="p-button-success mr-2" @click="test" />
            <Button label="Delete" icon="pi pi-trash" class="p-button-danger" @click="test"
                :disabled="!selectedProducts || !selectedProducts.length" />
        </template>

        <template #end>
            <FileUpload mode="basic" accept="image/*" :maxFileSize="1000000" label="Import" chooseLabel="Import"
                class="mr-2 inline-block" />
            <Button label="Export" icon="pi pi-upload" class="p-button-help" @click="exportCSV($event)" />
        </template>

    </Toolbar> -->
    <template v-if="loans.length">

    <DataTable ref="dt" :value="loans" v-model:selection="selectedLoan"  dataKey="idLoan" :paginator="true" :rows="5"
        :filters="filters"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        :rowsPerPageOptions="[5, 10, 25]" currentPageReportTemplate="Showing {first} to {last} of {totalRecords} products"
        responsiveLayout="scroll">
        <template #header>
            <div class="table-header flex flex-column md:flex-row md:justiify-content-between">
                <h5 class="mb-2 md:m-0 p-as-md-center">Prêts en retard</h5>
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText v-model="filters['global'].value" placeholder="Search..." />
                    <Button label="Export" icon="pi pi-upload" class="p-button-info mr-2" @click="exportCSV($event)" />
                </span>
            </div>
        </template>

        <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column>
        <!-- <Column field="idLoan" header="Code" :sortable="true" style="min-width:12rem"></Column>
        <Column field="idArticle" header="Name" :sortable="true" style="min-width:16rem"></Column> -->
        <Column field="title" header="Titre" exportHeader="Titre" headerStyle="width: 20%" >
                <template #body="slotProps">
                    <p>{{ (slotProps.data.title.substring(0, 25) + "...") }}</p>
                </template>
            </Column>
            <Column field="categorieName" header="Catégorie"></Column>
            <Column field="loanDuration" header="Durée max du Prêt" :sortable="true">
                <template #body="slotProps">
                    <p>{{ (slotProps.data.loanDuration)+ " jour(s)" }}</p>
                </template>
            </Column>
            <Column field="duration" header="Durée" :sortable="true">
            <template #body="slotProps">
                    <p style="color:red">{{ (slotProps.data.duration + " jour(s)") }}</p>
                </template>
            </Column>
            <Column field="email" header="Email"></Column>
        <!-- <Column header="Image">
                     <template #body="slotProps">
                        <img src="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png" :alt="slotProps.data.image" class="product-image" />
                    </template>
                </Column>
                <Column field="price" header="Price" :sortable="true" style="min-width:8rem">
                    <template #body="slotProps">
                        {{formatCurrency(slotProps.data.price)}}
                    </template>
                </Column>
                <Column field="category" header="Category" :sortable="true" style="min-width:10rem"></Column>
                <Column field="rating" header="Reviews" :sortable="true" style="min-width:12rem">
                    <template #body="slotProps">
                       <Rating :modelValue="slotProps.data.rating" :readonly="true" :cancel="false" />
                    </template>
                </Column>
                <Column field="inventoryStatus" header="Status" :sortable="true" style="min-width:12rem">
                    <template #body="slotProps">
                        <span :class="'product-badge status-' + (slotProps.data.inventoryStatus ? slotProps.data.inventoryStatus.toLowerCase() : '')">{{slotProps.data.inventoryStatus}}</span>
                    </template>
                </Column> -->
        <Column :exportable="false" style="min-width:8rem">
                    <template #body="slotProps">
                        <Button icon="pi pi-search" class="p-button-rounded p-button-info mr-2" @click="loanDetail(slotProps.data)" />
                        <!-- <Button icon="pi pi-trash" class="p-button-rounded p-button-warning" @click="confirmDeleteProduct(slotProps.data)" /> -->
                    </template>
                </Column>
    </DataTable>
    <LoanPopup :loan="loan" :loanPopup1="loanPopup" @loanPopup="loanPopup=!loanPopup" ></LoanPopup>
    </template>
</template>

<script>
import { FilterMatchMode } from 'primevue/api';
// import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
// import fetchData from '@/utils/fetchData';
import Column from 'primevue/column';
import LoanPopup from "./LoanPopup.vue"
import InputText from 'primevue/inputtext';
// import Dialog from 'primevue/dialog';
// import Tag from 'primevue/tag';
import store from '@/store';

export default {
    components: {
        // Tag,
        // Toolbar,
        Button,
        DataTable,
        InputText,
        Column,
        LoanPopup,
    },
    methods: {
        test() {
            // console.log("testtest");
        },
        getLoans() {
            
        },
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
        loanDetail(loan){
            this.loan = {...loan};
            this.loanPopup = true;
        },
        

    },
    data() {
        return {
            loans: {},
            filters: {},
            selectedLoan: {},
            loan:{},
            loanPopup:false,

        }
    },
    created() {
        this.getLoans();
        this.initFilters();
    },
    mounted() {
        this.loans = store.state.lateLoans;
        this.unsubscribe = store.subscribe((mutation)=>{
            if(mutation.type === "updateLateLoans"){
                this.loans = store.state.lateLoans;
            }
        })
    },
    beforeUnmount(){
        this.unsubscribe();
    }
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
.p-datatable .p-paginator-bottom{
    border-bottom-left-radius: 20px !important;
    border-bottom-right-radius: 20px !important;
}


</style>