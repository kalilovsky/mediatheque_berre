<template>
    <header class="shadow-5">
        <router-link to="/">
            <img src="../assets/logo_2.png" />
        </router-link>
        <div class="field col-12 md:col-4">
            <span class="p-float-label p-input-icon-right">
                <i class="pi pi-search" />
                <InputText id="inputtext-right" type="text" v-model="valueIconRight" />
                <label for="inputtext-right">Rechercher</label>
                
            </span>
        </div>
        <span class="dropDownMenu">
            <DropDownMenuVue></DropDownMenuVue>
        </span>
    </header>
</template>

<script>
import InputText from 'primevue/inputtext';
import DropDownMenuVue from './DropDownMenu.vue';
export default {
    components: {
        InputText,
        DropDownMenuVue,

    },
    data() {
	return {
	}
}
}
</script>

<style lang="scss">
header {
    z-index: 100;
    position: fixed;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100px;
    background: #FFFFFF;
    display: flex;
    justify-content: space-between;

    img {
        position: relative;
        height: 100%;
    }

    .p-input-icon-left,
    .field {
        align-self: center;
    }

    .dropDownMenu {
        width: 130px;
    }
}
</style>