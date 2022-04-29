<template>
    <header class="shadow-5" >
        <router-link to="/">
            <img src="../assets/logo_2.png" />
        </router-link>
        <div class="field col-12 md:col-4">
            <span class="p-float-label p-input-icon-right">
                <i class="pi pi-search" />
                <InputText id="inputtext-right" type="text" v-model="filterByText" @keydown.enter="handelSearchText"/>
                <label for="inputtext-right">Rechercher</label>
                
            </span>
        </div>
        <span class="dropDownMenu" >
            <DropDownMenuVue></DropDownMenuVue>
        </span>
    </header>
</template>

<script>
import InputText from 'primevue/inputtext';
import DropDownMenuVue from './DropDownMenu.vue';
import store from '@/store';
export default {
    components: {
        InputText,
        DropDownMenuVue,
    },
    data() {
        return {
            userInfo:{},
            filterByText:'',
        }    
    },
    methods: {
        readCookie(){
            //récupération des donnés session eventuelles de l'utilisateur.
            let cookieInfo = decodeURIComponent(document.cookie).split(";");
            let userInfoTmp = { isConnected: false };
            for (let i = 0; i < cookieInfo.length; i++) {
            let c = cookieInfo[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }
            if (c.indexOf("userInfo=") === 0) {
                userInfoTmp = JSON.parse(c.substring("userInfo=".length, c.length));
            }
            }
            if (Object.keys(userInfoTmp).length === 0) {
            userInfoTmp = { isConnected: false }
            }
            this.userInfo = userInfoTmp;
        },
        handelSearchText(e){
            // console.log(e.target.value);
            store.commit({type :'updateTextFilterCritera', filter :{filterByText: e.target.value} });
            this.$router.push({name:'searchView'});
        }

    },
    mounted(){
        this.readCookie();
    },
    created(){
        this.unsubscribe = store.subscribe((mutation) => {
            if (mutation.type === "updateTextFilterCritera") {
                this.filterByText = store.state.filterCriteria.filterByText;
            }
        })
    },
    beforeUnmount(){
        this.unsubscribe();
    },
    watch:{
        userInfo(){
            store.commit({type : "updateUserInfo", userInfo : this.userInfo});
        },
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