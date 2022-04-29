<template>
  <div class="setting">
    <TabView>
      <TabPanel header="Page Produit">
        <div class="mesSwitch" v-for="(elem, key) in articleSetting" :key="key">
          <h5>{{ elem.name }}</h5>
          <InputSwitch v-model="articleSetting[key].value"></InputSwitch>
        </div>
      </TabPanel>
      <TabPanel header="Page Utilisateur">
        <div class="mesSwitch" v-for="(elem, key) in userSetting" :key="key">
          <h5>{{ elem.name }}</h5>
          <InputSwitch v-model="userSetting[key].value"></InputSwitch>
        </div>
      </TabPanel>
    </TabView>
  </div>
</template>

<script>
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import InputSwitch from 'primevue/inputswitch';
import fetchData from '@/utils/fetchData';

export default {
  components: {
    TabView,
    TabPanel,
    InputSwitch,
  },
  data() {
    return {
      articleSetting: {
        title: { name: "Titre", value: false },
        smallDesc: { name: "Description", value: false },
        filePath: { name: "Image", value: false },
        author: { name: "Autheur", value: false },
        stock: { name: "Stock", value: false },
        editor: { name: "Editeur", value: false },
        loanDuration: { name: "Durée du prêt", value: false },
        idCategory: { name: "Catégorie", value: false },
        idSubCategorie: { name: "Genre", value: false },
        idCollection: { name: "Collection", value: false },
        idUser: { name: "Utilisateur", value: false },
        format: { name: "Format", value: false },
        datePublished: { name: "Date de publication", value: false }
      },
      userSetting: {
        firstname: { name: "Prénom", value: false },
        lastname: { name: "Nom", value: false },
        email: { name: "Email", value: false },
        pseudo: { name: "Pseudo", value: false },
        pwd: { name: "Mot de passe", value: false },
        profilPhoto: { name: "Photo", value: false },
        adresse: { name: "Adresse", value: false },
        telephone: { name: "Téléphone", value: false },
      }
    }
  },
  watch: {
    userSetting: {
      handler() {
        this.updateUserSetting();
      },
      deep: true,
    },
    articleSetting: {
      handler() {
        this.updateArticleSetting();
      },
      deep: true,
    },
  },
  methods: {
    updateUserSetting() {
      let updatedKeys = {};
      Object.keys(this.userSetting).map(item => {
        updatedKeys[item] = this.userSetting[item].value;
      });
      fetchData({ controller: 'usersController', action: 'updateUserSettings', ...updatedKeys }).then(data => {
        if (data === 'Update Done') {
          this.$toast.add({ severity: 'success', summary: 'Acomplie', detail: 'Paramétres mise à jour.', group: 'tl', life: 3000 });
        }
      })
    },
    updateArticleSetting() {
      let updatedKeys = {};
      Object.keys(this.articleSetting).map(item => {
        updatedKeys[item] = this.articleSetting[item].value;
      });
      fetchData({ controller: 'articlesController', action: 'updateArticleSettings', ...updatedKeys }).then(data => {
        if (data === 'Update Done') {
          this.$toast.add({ severity: 'success', summary: 'Acomplie', detail: 'Paramétres mise à jour.', group: 'tl', life: 3000 });
        }
      })
    }
  },
  created() {
    fetchData({ controller: 'articlesController', action: 'getArticleSetting' }).then(data => {
      // this.articleSetting = data;
      Object.keys(data).map(item=>{
        if(data[item]==='1'){
          this.articleSetting[item].value = true;
        }else{
          this.articleSetting[item].value = false;
        }
      })
    })

    fetchData({ controller: 'usersController', action: 'getUserSetting' }).then(data => {
      Object.keys(data).map(item=>{
        if(data[item]==='1'){
          this.userSetting[item].value = true;
        }else{
          this.userSetting[item].value = false;
        }
      })
    })
  }
}
</script>

<style lang="scss">
.setting {
  position: relative;
  width: calc(100% - 300px);
  top: 40px;
  left: 300px;
  padding: 20px 30px;

  .mesSwitch {
    // display: flex;

  }
}

.p-tabview-nav-content {
  border-top-right-radius: 20px;
  border-top-left-radius: 20px;
}
</style>