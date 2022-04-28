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
            <Column field="title" header="Titre" exportHeader="Titre" headerStyle="width: 20%">
                <template #body="slotProps">
                    <p>{{ (slotProps.data.title.substring(0, 25) + "...") }}</p>
                </template>
            </Column>
            <Column field="categorieName" header="Catégorie"></Column>
            <Column field="loanDuration" header="Durée max du Prêt" :sortable="true">
                <template #body="slotProps">
                    <p  style="color:green;">{{ (slotProps.data.loanDuration) + " jour(s)" }}</p>
                </template>
            </Column>
            <Column field="duration" header="Durée" :sortable="true">
                <template #body="slotProps">
                    <p v-if="~~slotProps.data.duration>~~slotProps.data.loanDuration" style="color:red;">{{ (slotProps.data.duration + " jour(s)") }}</p>
                    <p v-else style="color:green;">{{ (slotProps.data.duration) + " jour(s)" }}</p>
                </template>
            </Column>
            <Column field="email" header="Email"></Column>
            <Column :exportable="false" style="min-width:8rem">
                <template #body="slotProps">
                    <Button icon="pi pi-search" class="p-button-rounded p-button-info mr-2"
                        @click="loanDetail(slotProps.data)" />
                </template>
            </Column>
        </DataTable>
        <LoanPopup :loan="loan" :loanPopup1="loanPopup" @loanPopup="loanPopup = !loanPopup"></LoanPopup>
    </template>
</template>

<script>
import { FilterMatchMode } from 'primevue/api';
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import LoanPopup from "./LoanPopup.vue"
import InputText from 'primevue/inputtext';

export default {
    props: ['selectedLoans','tableTitle'],
    components: {
        Button,
        DataTable,
        InputText,
        Column,
        LoanPopup,
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


    },
    data() {
        return {
            loans: {},
            filters: {},
            selectedLoan: {},
            loan: {},
            loanPopup: false,

        }
    },
    created() {
        this.initFilters();
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
</style>