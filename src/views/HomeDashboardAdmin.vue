<template>
    <div class="homeAdmin">
        <CardBox></CardBox>
    </div>
    <div class="cardtest">
        <TableHome></TableHome>
    </div>
</template>

<script>
import CardBox from "../components/CardBox.vue"
import TableHome from "../components/Admin/TableHome.vue"
export default {
    components: {
        CardBox,
        TableHome,
    }
}
</script>
    
<style>
.homeAdmin {
    position: relative;
    /* left: 300px; */
    display: flex;
    justify-content: center;
    width: calc(100% - 300px);
}

.cardtest {
    position: relative;
    width: calc(100% - 300px);
    left: 300px;
    padding: 0 50px;
    margin-top: 40px;
}
</style>