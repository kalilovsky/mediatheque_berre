<template>
    <Toast position="top-right" group="tl" />
  <div class="navigation" :class="{active : toggleDropDownMenu }" @click="toggleDropDownMenu= !toggleDropDownMenu" v-if="userInfo.isConnected===true">
      <div class="userBx">
        <div class="imgBx">
          <img src="../assets/user.jpg">
        </div>
        <p class="username">Alina Smith</p>
      </div>
      <div class="menuToggle"></div>
      <ul class="menu">
        <li><router-link to="/"> <i class="pi pi-home"></i> Accueil</router-link></li>
        <li><router-link to="/loans"> <i class="pi pi-bell"></i> Mes Emprunts</router-link></li>
        <li><a href="#"> <i class="pi pi-user"></i> My Profile</a></li>
        <li><a href="#"> <i class="pi pi-comment"></i> Messages</a></li>
        <li><a href="#"> <i class="pi pi-cog"></i> Settings</a></li>
        <li><a href="#"> <i class="pi pi-question"></i> Help & Support</a></li>
        <li @click="disconnect"><a href="#"> <i class="pi pi-sign-out"></i>Logout</a></li>
      </ul>
  </div>
    <div class="login" v-else>
        <Button label="Connection" icon="pi pi-sign-in" iconPos="right" class="p-button-secondary p-button-outlined p-button-rounded" @click="toggleLoginForm = ! toggleLoginForm"/>
        <transition name="login">
          <div class="loginContainer" v-if="toggleLoginForm" @click="toggleLoginForm = ! toggleLoginForm">
          <LoginRegisterPopup @click.prevent.stop="preventClick" @logged="logged"></LoginRegisterPopup>
          </div>
        </transition>
    </div>
</template>

<script>
import store from "@/store";
import Button from 'primevue/button';
import LoginRegisterPopup from "./LoginRegisterPopup.vue";
import fetchData from '@/utils/fetchData';
import Toast from 'primevue/toast';

export default {
  components:{
    Button,
    LoginRegisterPopup,
    Toast,
},
    data(){
        return ({
            toggleLoginForm : false,
            toggleDropDownMenu : false,
            userInfo :{},
    })
    },
    created(){
      this.userInfo = store.state.userInfo;
      this.unsubscribe = store.subscribe((mutation)=>{
            if(mutation.type === "updateUserInfo"){
                this.userInfo = store.state.userInfo;
            }
        })
    },
    beforeUnmount() {
        this.unsubscribe();
    },
    methods:{
      preventClick(){
      },
      disconnect(){
        fetchData({controller : 'UsersController', action : 'disconnect'},"post").then(data=>{
          if(data==="disconnected"){
            store.commit({type : "updateUserInfo", userInfo :  {isConnected : 'false',}});
            this.$toast.add({severity: 'info', summary: 'Déconnection Réussie', detail: `Au Revoir!`, group: 'tl', life: 3000});
            this.toggleLoginForm = false;
            console.log(data);
          }
        });
      },
      logged(data){
        console.log(data);
        // this.$toast.add({severity: 'info', summary: 'Connection Réussie', detail: `Bienvenue ${data.pseudo}`, group: 'tl', life: 3000});
      }
    },
}
</script>

<style lang="scss">
.login{
  position: absolute;
  top: 20px;
  right: 20px;
  width: 150px;
  height: 60px;
  display: flex;
  button{
    align-self: center;
  }
}
.loginContainer{
  position: fixed;
  left: 0;
  top: 0;
  min-height: 100%;
  min-width: 100%;
  display: flex;
  justify-content: center;
  align-content: center;
}
.login-enter-active,.login-leave-active{
  transition: opacity 0.5s ease , transform 0.3s ease;
}
.login-enter-from,
.login-leave-to {
  opacity: 0;
  transform: scale(0);
}

.navigation 
{
  position: absolute;
  top: 20px;
  right: 20px;
  width: 120px;
  height: 60px;
  background: #fff;
  display: flex;
  justify-content: space-between;
  transition: height 0.5s, width 0.5s;
  transition: 0.5s;
  transition-delay: 0s,0.75s;
  overflow: hidden;
  box-shadow: 0 25px 35px rgba(0,0,0,0.1);
  border: 1px solid rgba(0,0,0,0.3);
  border-radius: 20px;
}
.navigation.active 
{
  // transform: scaleY(4) scaleX(2);
  width: 300px;
  height: 390px;
  transition: 0.5s;
  transition: width 0.5s, height 0.5s;
  transition-delay: 0s,0.75s;
}
.navigation .menuToggle 
{
  position: relative;
  width: 60px;
  height: 60px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}
.navigation .menuToggle::before  
{
  content: '';
  position: absolute;
  width: 32px;
  height: 2px;
  background: #555;
  transform: translateY(-10px);
  box-shadow: 0 10px #555;
  transition: 0.5s;
}
.navigation.active .menuToggle::before  
{
  transform: translateY(0px) rotate(45deg);
  box-shadow: 0 0 #555;
}
.navigation .menuToggle::after  
{
  content: '';
  position: absolute;
  width: 32px;
  height: 2px;
  background: #555;
  transform: translateY(10px);
  transition: 0.5s;
}
.navigation.active .menuToggle::after  
{
  transform: translateY(0px) rotate(-45deg);
}
.navigation .userBx 
{
  position: relative;
  width: 60px;
  height: 60px;
  transition: 0.5s;
  transition-delay: 0.5s;
  overflow: hidden;
  display: flex;
  align-items: center;
}
.navigation.active .userBx 
{
  width: calc(100% - 60px);
  transition-delay: 0s;
}
.navigation .userBx .imgBx 
{
  position: relative;
  min-width: 60px;
  height: 60px;
  border: 10px solid #fff;
  background: #555;
  border-radius: 50%;
  overflow: hidden;
}
.navigation .userBx .imgBx img 
{
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.navigation .userBx .username 
{
  white-space: nowrap;
  color: #555;
  font-size: 1.1em;
} 
.menu 
{
  position: absolute;
  width: 100%;
  height: calc(100% - 60px);
  margin-top: 60px;
  padding: 20px;
  border-top: 1px solid rgba(0,0,0,0.1);
}
.menu li 
{
  list-style: none;
}
.menu li a
{
  display: inline-block;
  text-decoration: none;
  margin: 20px 0;
  font-size: 1em;
  display: flex;
  align-items: center;
  gap: 10px;
  color: #555;
}
.menu li a:hover 
{
  color: #4E65FF;
}
.menu li a ion-icon 
{
  font-size: 1.5em;
}
</style>