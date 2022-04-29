<template>
    <div class="myTable" v-if="isConnected===true">
        <TabView>
            <TabPanel header="Emprunt en retard">
                <LoanUserTable :loansUser="allLateLoans" @loadData="loadAllLoans" :loading="isLoading"></LoanUserTable>
            </TabPanel>
            <TabPanel header="Emprunt en cours">
                <LoanUserTable :loansUser="allPendingLoans" @loadData="loadAllLoans" :loading="isLoading"></LoanUserTable>
            </TabPanel>
            <TabPanel header="Emprunt rendus">
                <LoanUserTable :loansUser="allFinishedLoans" @loadData="loadAllLoans" :loading="isLoading"></LoanUserTable>
            </TabPanel>
            <TabPanel header="Tous les emprunts">
                <LoanUserTable :loansUser="allLoansUser" @loadData="loadAllLoans" :loading="isLoading"></LoanUserTable>
            </TabPanel>
        </TabView>
       
    </div>
    <div class="myTable" v-else>
        <p style="color:antiquewhite" >Vous devez vous connecter pour pouvoir voir cette page.</p>
    </div>
</template>

<script>
// import DataTable from 'primevue/datatable';
// import Column from 'primevue/column';
// import Button from 'primevue/button';
// import ProgressSpinner from 'primevue/progressspinner';
// import Tag from 'primevue/tag';
import fetchData from '@/utils/fetchData';
import store from '@/store';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import LoanUserTable from '../components/LoanUserTable.vue';

export default {
    components: {
        // DataTable,
        // Column,
        // Button,
        // ProgressSpinner,
        // Tag,
        TabView,
        TabPanel,
        LoanUserTable,
        
    },
    data() {
        return {
            allLoansUser: {},
            allLateLoans:{},
            allFinishedLoans:{},
            allPendingLoans:{},
            isConnected : false,
            isLoading:false,
        }
    },
    methods: {
        loadAllLoans() {
            this.isLoading = true;
            let idUser = store.state.userInfo.idUser;
            fetchData({ controller: "loansController", action: "getAllLoansByUser", idUser: idUser }).then(data => {
                if (Object.keys(data).length) {
                    this.allLoansUser = data;
                    this.isLoading = false;
                }
            })
            this.isLoading = true;
            fetchData({ controller: "loansController", action: "getAllPendingLoans", idUser: idUser }).then(data => {
                if (Object.keys(data).length) {
                    this.allPendingLoans = data;
                    this.isLoading = false;
                }
            })
            this.isLoading = true;
            fetchData({ controller: "loansController", action: "getAllFinishedLoans", idUser: idUser }).then(data => {
                if (Object.keys(data).length) {
                    this.allFinishedLoans = data;
                    this.isLoading = false;
                }
            })
            this.isLoading = true;
            fetchData({ controller: "loansController", action: "getLateLoans", idUser: idUser }).then(data => {
                if (Object.keys(data).length) {
                    this.allLateLoans = data;
                    this.isLoading = false;
                }
            })
        },
        
    },
    watch:{
        isConnected(){
            if (this.isConnected===true) {
                this.loadAllLoans()
            }
        }
    },
    created(){
        this.isConnected = store.state.userInfo.isConnected;
        this.unsubscribe = store.subscribe((mutation)=>{
        if(mutation.type === "updateUserInfo"){
            this.isConnected = store.state.userInfo.isConnected;
        }
        })
        },
    beforeUnmount() {
        this.unsubscribe();
    },
}
</script>

<style lang="scss">
.myTable {
    top: 40px;
    position: relative;
    padding: 0 40px;
}
</style>