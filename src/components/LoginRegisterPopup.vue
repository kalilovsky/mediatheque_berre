<template>
    <div class="container">
        <Toast position="top-right" group="tl" />
        <div class="blueBg" :class="{ active: registerFormFocused }">
            <div class="box signin">
                <h2>Vous avez déja un compte ?</h2>
                <button class="signinBtn"
                    @click="loginFormToggle">Connection</button>
            </div>
            <div class="box signup">
                <h2>Vous n'avez pas encore de compte ?</h2>
                <button class="signupBtn"
                    @click="this.registerFormFocused = !this.registerFormFocused">Inscription</button>
            </div>
        </div>
        <div class="formBx" :class="{ active: registerFormFocused }">
            <div class="form signinForm">
                <form>
                    <h3>Connection</h3>
                    <input type="text" v-model="v$.loginUserInfo.email.$model" name="" placeholder="Pseudo ou Email" >
                    <!-- @input="check" -->
                    <Password v-model="v$.loginUserInfo.pwd.$model" toggleMask :feedback="false"  placeholder="Mots de passe"></Password>
                    <input type="submit" name="" value="Connection" @click="handleLogin">
                </form>
            </div>
            <div class="form signupForm" :class="{hide : !toggleFormPage1}">
                <form>
                    <h3>Inscription 1/2</h3>
                    <span class="p-input-icon-right">
                        <InputText type="text" v-model="v$.registerUserInfo.pseudo.$model" placeholder="Pseudo"/>
                        <i class="pi pi-user" />
                    </span>
                    <span class="p-input-icon-right">
                        <InputText type="email" v-model="v$.registerUserInfo.email.$model" placeholder="Email"/>
                        <i class="pi pi-envelope" />
                    </span>
                    <Password v-model="v$.registerUserInfo.pwd.$model" toggleMask placeholder="Mots de passe">
                        <template #header>
                            <h6>Entrez votre mot de passe</h6>
                        </template>
                        <template #footer>
                            <Divider />
                            <p class="mt-2">Suggestions</p>
                            <ul class="pl-2 ml-2 mt-0" style="line-height: 1.5">
                                <li>Au moins une miniscule</li>
                                <li>Au moins une majuscule</li>
                                <li>Au moins un nombre</li>
                                <li>Minimume de 8 characters</li>
                            </ul>
                        </template>
                    </Password>
                    <!-- <Password v-model="v$.registerUserInfo.pwd2.$model" toggleMask :feedback="false"  placeholder="Mots de passe"></Password> -->
                    <input type="submit" id="nextButton" name="" value="Suivant" @click="signupFormPage2">
                </form>
            </div>
            <div class="form signupFormPage2" :class="{active : toggleFormPage2}">
                <form>
                    <h3>Inscription 2/2</h3>
                    <span class="p-input-icon-right">
                        <InputText type="text" v-model="v$.registerUserInfo.lastname.$model" placeholder="Nom" />
                        <i class="pi pi-user" />
                    </span>
                    <span class="p-input-icon-right">
                        <InputText type="text" v-model="v$.registerUserInfo.firstname.$model" placeholder="Prénom" />
                        <i class="pi pi-user" />
                    </span>
                    <span class="p-input-icon-right">
                        <InputText type="text" v-model="v$.registerUserInfo.adresse.$model" placeholder="Adresse" />
                        <i class="pi pi-map" />
                    </span>
                    <span class="p-input-icon-right">
                        <InputMask v-model="v$.registerUserInfo.telephone.$model" placeholder="Téléphone" mask="99-99-99-99-99" />
                        <i class="pi pi-phone" />
                    </span>
                    <span id="buttonSpan">
                        <input type="submit" id="previousButton" name="" value="Précédent" @click="signupFormPage2">
                        <input type="submit" name="" value="Inscription" @click="handleRegister">
                    </span>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import useVuelidate from '@vuelidate/core'
import { required, email} from '@vuelidate/validators'
import Password from 'primevue/password';
import InputText from 'primevue/inputtext';
import InputMask from 'primevue/inputmask';
import fetchData from '@/utils/fetchData';
import Toast from 'primevue/toast';
import store from '@/store';


export default {
    setup() {
        return {
            v$: useVuelidate(),
        }
    },
    components: {
        Password,
        InputText,
        InputMask,
        Toast,
    },

    data() {
        return ({
            loginFormFocused: true,
            registerFormFocused: false,
            toggleFormPage2 : false,
            toggleFormPage1 : true,
            registerUserInfo: {
                firstname: "",
                lastname: "",
                email: "",
                pseudo: "",
                pwd: "",
                // pwd2: "",
                adresse: "",
                telephone: "",
            },
            loginUserInfo :{
                email :"",
                pwd: "",
            },
            userInfo:{},
        })
    },
    methods: {
        // check() {
        //     this.v$.$validate().then(data => console.log(data))
        // },
        signupFormPage2(){
            this.toggleFormPage2 = !this.toggleFormPage2;
            this.toggleFormPage1 = !this.toggleFormPage1;
        },
        loginFormToggle(){
            this.registerFormFocused = !this.registerFormFocused;
            this.toggleFormPage2 = false;
            this.toggleFormPage1 = true;
        },
        handleRegister(){
            if(!this.v$.registerUserInfo.$errors.length){
                fetchData({controller : 'UsersController', action : 'register',...this.registerUserInfo},"post").then(data=>{
                    if(data.isConnected){
                    this.userInfo = data;
                    this.$toast.add({severity: 'info', summary: 'Inscription Réussie', detail: `Bienvenue ${data.pseudo}`, group: 'tl', life: 3000});
                    }else{
                        this.userInfo = data;
                        this.$toast.add({severity: 'error', summary: 'Erreur', detail: `${data.messageRegister}`, group: 'tl', life: 5000});
                    }
                }).catch(e=>console.warn(e));
            }else{
                for (let error of this.v$.registerUserInfo.$errors){
                    this.$toast.add({severity: 'error', summary: 'Erreur', detail: `${error.$property} : ${error.$message}`, group: 'tl', life: 5000});
                }
            }
        },
        handleLogin(){
            if(!this.v$.loginUserInfo.$errors.length){
                fetchData({controller : 'UsersController', action : 'login',...this.loginUserInfo},"post").then(data=>{
                    if(data.isConnected){

                        // this.$emit("logged",data);
                        this.userInfo = data;
                        this.$toast.add({severity: 'success', summary: 'Connection Réussie', detail: `Bienvenue ${data.pseudo}`, group: 'tl', life: 3000});
                    }else{
                        this.userInfo = data;
                        this.$toast.add({severity: 'error', summary: 'Erreur', detail: `${data.messageLogin}`, group: 'tl', life: 5000});
                    }
                    // setTimeout(this.test(),3000);

                }).catch(e=>console.warn(e));
            }else{
                for (let error of this.v$.loginUserInfo.$errors){
                    this.$toast.add({severity: 'error', summary: 'Erreur', detail: `${error.$property} : ${error.$message}`, group: 'tl', life: 5000});
                }
            }
        },
        // test(){
        //     this.$emit("click1","login");
        // },
    },
    validations() {
        return {
            registerUserInfo :{
                firstname: { required },
                lastname :{ required },
                email: { required, email },
                pseudo :{ required },
                pwd: { required },
                // pwd2: {sameAs:sameAs(this.pwd)},
                adresse :{ required },
                telephone :{ required },
            },
            loginUserInfo :{
                email :{ required },
                pwd: { required },
            }
        }
    },
    watch:{
        userInfo(){
            store.commit({type : "updateUserInfo", userInfo : this.userInfo});

        }
    },
    
    
}
</script>

<style lang="scss">
.container {
    position: relative;
    width: 800px;
    height: 500px;
    margin: 20px;
}

.container .blueBg {
    position: absolute;
    top: 40px;
    width: 100%;
    height: 420px;
    background: #1c80cf;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 5px 45px rgba(0, 0, 0, 0.15);
    transition: 0.5s;

    &.active {
        background: #1769aa;
    }
}

.container .box {
    position: relative;
    width: 50%;
    height: 100%;
    z-index: 1000;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    padding: 40px;
}

.container .box h2 {
    color: #fff;
    font-size: 1.2em;
    font-weight: 500;
    margin-bottom: 10px;
}

.container .box button {
    cursor: pointer;
    padding: 10px 20px;
    background: #fff;
    color: #333;
    font-size: 16px;
    font-weight: 500;
    border: none;
}

.formBx {
    position: absolute;
    top: 0;
    left: 0;
    width: 50%;
    height: 100%;
    background: #fff;
    z-index: 10000;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 5px 45px rgba(0, 0, 0, 0.25);
    transition: 0.5s ease-in-out;
    overflow: hidden;
    .signupFormPage2{
        left: 100% !important;
        transition-delay: 0s;
    }
    &.active{
        .signupFormPage2.active{
            left: 0 !important;
            transition-delay: 0s;
        }
        .signupForm{
            &.signupForm.hide{
                transition: 0.3s;
                opacity: 0;
            }
        }
    }
}

.formBx.active {
    left: 50%;
}


.formBx .form {
    position: absolute;
    left: 0;
    width: 100%;
    padding: 50px;
    transition: 0.5s;
}

.formBx .signinForm {
    transition-delay: 0.25s;
}

.formBx.active .signinForm {
    left: -100%;
    transition-delay: 0s;
}

.formBx .signupForm {
    left: 100%;
    transition-delay: 0s;
}

.formBx.active .signupForm {
    left: 0;
    transition-delay: 0.25s;
}

.formBx form {
    width: 100%;
    display: flex;
    flex-direction: column;
    #nextButton,#previousButton{
        background: #03a9f4;
        align-self: flex-end;
    }
    #buttonSpan{
        display: flex;
        justify-content: space-between;
    }
    
}

.formBx form h3 {
    font-size: 1.5em;
    color: #333;
    margin-bottom: 20px;
    font-weight: 500;
}

.formBx form input {
    width: 100%;
    margin: 10px 0;
    padding: 10px 10px;
    outline: none;
    font-size: 16px;
    border: 1px solid #333;
}

.formBx form input[type="submit"] {
    background: #03a9f4;
    border: none;
    color: #fff;
    max-width: 100px;
    cursor: pointer;
}

.formBx .signupForm form input[type="submit"] {
    background: #f43648;
}
.formBx .signupFormPage2 form input[type="submit"] {
    background: #f43648;
}

.formBx form a {
    color: #333;
}

@media (max-width: 991px) {
    .container {
        max-width: 400px;
        height: 650px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container .blueBg {
        top: 0;
        height: 100%;
        height: 500px;
    }

    .formBx {
        width: 100%;
        height: 500px;
        top: 0;
        box-shadow: none;
    }

    .formBx.active {
        left: 0;
        top: 150px;
    }

    .container .blueBg {
        height: 650px;
    }

    .container .box {
        position: absolute;
        width: 100%;
        height: 150px;
        bottom: 0;
    }

    .container .box.signin {
        top: 0;
    }
}
</style>