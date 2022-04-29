<template>
    <DataTable :value="loansUser" ref="dt" responsiveLayout="scroll" sortField="loansDate" :sortOrder="1"
        :resizableColumns="true" columnResizeMode="expand" compareSelectionBy="" :loading="loading"  >
        <template #loading>
            <ProgressSpinner></ProgressSpinner>
        </template>

        <template #header>
            <div style="text-align: left">
                <Button icon="pi pi-external-link" label="Export" @click="exportCSV($event)" />
            </div>
        </template>
        <Column field="title" header="Titre" exportHeader="Titre" headerStyle="width: 20%">
            <template #body="slotProps">
                <p>{{ (slotProps.data.title.substring(0, 25) + "...") }}</p>
            </template>
        </Column>
        <Column field="categorieName" header="Catégorie"></Column>
        <Column field="SubcategorieName" header="Genre"></Column>
        <Column field="loansDate" header="Date" :sortable="true">
            <template #body="slotProps">
                <p>{{ toLocaleDate(slotProps.data.loansDate) }}</p>
            </template>
        </Column>
        <Column field="status" header="Status/Date Rendu">
            <template #body="slotProps">
                <Button v-if="slotProps.data.status === 'encours'" icon="pi pi-external-link" label="Rendre"
                    @click="returnArticle(slotProps.data.idLoan, slotProps.data.idArticle, slotProps.data.title)" />
                <p v-else> {{ toLocaleDate(slotProps.data.updateDateLoan) }} </p>
            </template>
        </Column>
        <Column field="loansDate" header="Retard">
            <template #body="slotProps">
                <template v-if="slotProps.data.status !== 'rendu'">
                    <Tag value="New" icon="pi pi-clock" severity="warning"
                        v-if="!isLate(slotProps.data.loansDate, slotProps.data.loanDuration)">En attente</Tag>
                    <Tag value="New" icon="pi pi-ban" severity="danger" v-else>En retard</Tag>
                </template>
                <template v-else>
                    <Tag value="New" icon="pi pi-check" severity="success">Rendu</Tag>

                </template>
            </template>
        </Column>
    </DataTable>
</template>

<script>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import ProgressSpinner from 'primevue/progressspinner';
import Tag from 'primevue/tag';
import fetchData from '@/utils/fetchData';
import store from '@/store';
export default {
    components: {
        DataTable,
        Column,
        Button,
        ProgressSpinner,
        Tag,

    },
    props:['loansUser','loading'],
    methods:{
        toLocaleDate(text) {
            let test = new Date(text).toLocaleDateString('fr-FR');
            return test;
        },
        exportCSV() {
            this.$refs.dt.exportCSV();
        },
        
        isLate(text, duration) {
            let loanDate = new Date(text)
            let currentDate = new Date();
            let result = (currentDate - loanDate) - (duration * 60 * 60 * 24 * 1000);
            if (result > 0) {

                return true
            }
            return false

        },

        returnArticle(idLoan, idArticle,title) {
            this.$confirm.require({
                message: `Confirmez-vous vouloir rendre ${title}`,
                header: 'Confirmation',
                icon: 'pi pi-exclamation-triangle',
                acceptLabel: "Oui",
                rejectLabel: "Non",
                rejectIcon: 'pi pi-trash',
                acceptIcon: 'pi pi-check-square',
                blockScroll: false,
                position: 'center',
                accept: () => {
                    let idUser = store.state.userInfo.idUser;
                    fetchData({ controller: "loansController", action: "returnLoan", idUser: idUser, idLoan: idLoan, idArticle: idArticle }).then(data => {
                        if (Object.keys(data).length) {
                            this.$toast.add({ severity: 'success', summary: 'Retour Réussie', detail: `${data.message}`, group: 'tl', life: 3000 });
                            this.$emit('loadData');
                        }
                    })
                    //callback to execute when user confirms the action
                },
                reject: () => {
                    //callback to execute when user rejects the action
                }
            });

        },
    }
}
</script>

<style>
</style>