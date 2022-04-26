<template>
  <div class="card" >
		<div class="imgBx">
			<!-- <img src="../assets/Apocalypto-DVD.jpg"> -->
			<!-- <img src="../assets/Bach-The-Art-Of-Life.jpg"> -->
			<!-- <img src="../assets/Demon-Slayer.jpg"> -->
			<img :src="'http://localhost:3000/public/articlefile/'+url">
		</div>
		<div class="contentBx">
            <slot></slot>
			<h3>{{title}}</h3>
            <hr>
			<h2 class="price">'{{author}}'</h2>
			<div class="buy" @click="handelLoan">Prendre</div> 
		</div>
        <p>{{subCat}}</p>
	</div>
</template>

<script>
import store from '@/store'
import fetchData from '@/utils/fetchData';

export default {
    props:['idArticle','url','title','subCat','author'],
    data(){
        return({
            text:"test",
        })
    },
    component:{
    },
    methods:{
        handelLoan(){
            let userInfo = store.state.userInfo;
            if (userInfo.isConnected){
                this.$confirm.require({
                message: `Confirmez-vous vouloir emprunter ${this.title}` ,
                header: 'Confirmation',
                icon: 'pi pi-exclamation-triangle',
                acceptLabel: "Oui",
                rejectLabel : "Non",
                rejectIcon:'pi pi-trash',
                acceptIcon:'pi pi-check-square',
                blockScroll: false,
                position:'center',
                accept: () => {
                    fetchData({controller : 'loansController',action:'addLoans',idArticle:this.idArticle,idUser : userInfo.idUser}).then(data=>{
                        if (data.message==="Article emprunté correctement"){
                            this.$toast.add({severity: 'success', summary: 'Emprunt Réussie', detail: `${data.message}`, group: 'tl', life: 3000});
                            this.$emit('reloadArticles');
                        }else if(data.message==="Stock de l'article insuffisant!"){
                            this.$toast.add({severity: 'error', summary: 'Problème', detail: `${data.message}`, group: 'tl', life: 3000});
                        }
                    })
                    //callback to execute when user confirms the action
                },
                reject: () => {
                    //callback to execute when user rejects the action
                }
            });
            }else{
                this.$confirm.require({
                message: 'Vous devez être connecté pour emprunter cet article, voulez vous connecter ?',
                header: 'Prêt bloqué',
                icon: 'pi pi-lock',
                acceptLabel: "Oui",
                rejectLabel : "Non",
                rejectIcon:'pi pi-trash',
                acceptIcon:'pi pi-check-square',
                blockScroll: false,
                accept: () => {
                    //callback to execute when user confirms the action
                },
                reject: () => {
                    //callback to execute when user rejects the action
                }
            });
            }
        }
    }


}
</script>

<style lang="scss">
.card
{
    position: relative;
    width: 250px;
    height: 420px;
    background: #122936;
    border-radius: 20px;
    overflow: hidden;
    margin: 20px 0;
    justify-self: center;
    p
    {
        z-index: 0;
        position: absolute;
        bottom: 0;
        left: 0;
        color: rgba(0,0,0,0.1);
        font-weight: 600;
        font-size: 8em;
        transition: 0.5s;
    }
}
.card:before
{
    content: '';
    position: absolute;
    top: -50%;
    left: 0;
    width: 100%;
    height: 100%;
    background: #2196f3;
    transform: skewY(345deg);
    transition: 0.5s;
}
.card:hover:before
{
    transform: rotate(390deg);
}

.card .imgBx
{
    position: relative;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    /* padding-top: 20px; */
    z-index: 2;
    height: 310px;
    overflow: hidden;
    transition: 0.5s;
    
}
.card .imgBx img
{
    position: absolute;
    max-width: 100%;
    transition: 0.5s;
}
.card:hover 
{
    .imgBx
    {
        height: 260px;
        img{
            transform: scale(50%);

        }
    }
    .contentBx{
        .buy{
            opacity: 1;
            transform: translateY(-200px);
        }
        .myTag{
            position: absolute;
            transform: translateY(-100px);
            opacity: 1;
        }
    }
}
.card .contentBx
{
    position: relative;
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    z-index: 1;
    .myTag{
        position: absolute;
        transform: translateY(-200px);
        transition: 0.5s;
        opacity: 0;
    }
    hr {
        border-top: 0px solid #fff;
        overflow: visible;
        text-align: center;
        height: 0px;
        width: 100%;
        margin: 10px 0;
    }
}
.card .contentBx h3
{
    font-size: 18px;
    color: #fff;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
    overflow: hidden;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    display: -webkit-box;
    text-overflow: ellipsis;
}
.card .contentBx .price
{
    font-size: 16px;
    color: #fff;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.card .contentBx .buy
{
    position: relative;
    top: 200px;
    padding: 10px 30px;
    margin-top: 15px;
    color: #fff;
    text-decoration: none;
    border-radius: 30px;
    background: #2196f3;
    opacity: 0;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: 0.5s;
    cursor: pointer;
}

</style>