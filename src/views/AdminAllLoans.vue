<template>
  <div class="cardBoxLoans">
    <CardKPI :number="count.allLoans" :cardName="'Prêts'" :icon="'pi-telegram'" @click="focusLoans(allLoans,'Tous les prêts')"></CardKPI>
    <CardKPI :number="count.finishedLoans" :cardName="'Rendu'" :icon="'pi-check-circle'" @click="focusLoans(finishedLoans,'Prêts rendus')"></CardKPI>
    <CardKPI :number="count.pendingLoans" :cardName="'En Attente'" :icon="'pi-clock'" @click="focusLoans(pendingLoans,'Prêts en cours')"></CardKPI>
    <CardKPI :number="count.lateLoans" :cardName="'En Retard'" :icon="'pi-exclamation-circle'" @click="focusLoans(lateLoans,'Prêts en retard')"></CardKPI>
  </div>
  <div class="TableAllLoans">
    <TableLoans :selectedLoans="selectedLoans" :tableTitle="tableTitle" ></TableLoans>
  </div>
</template>

<script>
import fetchData from '@/utils/fetchData'
import TableLoans from "../components/Admin/TableLoans.vue"
import CardKPI from "../components/Admin/CardKPI.vue"
export default {
  components: {
    CardKPI,
    TableLoans
  },
  data() {
    return {
      count: {
        lateLoans: 0,
        pendingLoans: 0,
        finishedLoans: 0,
        allLoans: 0
      },
      lateLoans: {},
      pendingLoans: {},
      finishedLoans: {},
      allLoans: {},
      selectedLoans: {},
      tableTitle:""
    }
  },
  created() {
    this.getLateLoans();
    this.getAllLoans();
    this.getPendingLoans();
    this.getFinishedLoans();
  },
  methods: {
    getLateLoans() {
      fetchData({ controller: "loansController", action: "getLateLoans" }).then(data => {
        if (Object.keys(data).length) {
          this.lateLoans = data;
          this.count.lateLoans = Object.keys(data).length;
        }
      })
    },
    getAllLoans() {
      fetchData({ controller: "loansController", action: "getAllLoans" }).then(data => {
        if (Object.keys(data).length) { 
          this.allLoans = data;
          this.count.allLoans = data.length;
          this.selectedLoans = data;
          this.tableTitle = "Tous les prêts";
        }
      })
    },
    getPendingLoans() {
      fetchData({ controller: "loansController", action: "getAllPendingLoans" }).then(data => {
        if (Object.keys(data).length) {
          this.pendingLoans = data;
          this.count.pendingLoans = data.length;
        }
      })
    },
    getFinishedLoans() {
      fetchData({ controller: "loansController", action: "getAllFinishedLoans" }).then(data => {
        if (Object.keys(data).length) {
          this.finishedLoans = data;
          this.count.finishedLoans = data.length;
        }
      })
    },
    focusLoans(data,title){
      this.selectedLoans = data;
      this.tableTitle = title;
    },
  },
}
</script>

<style>
/* .div4 {
  position: relative;
  min-height: 100vh;
  min-width: 100%;
  background: green;
  z-index: -1;
} */
.cardBoxLoans {
  position: relative;
  width: calc(100% - 300px);
  top: 40px;
  left: 300px;
  padding: 20px 30px;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  grid-gap: 30px;
}
.TableAllLoans {
  position: relative;
  width: calc(100% - 300px);
  left: 300px;
  padding: 0 50px;
  margin-top: 40px;
}
</style>