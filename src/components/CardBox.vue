<template>
  <div class="cardBox">
				<div class="cardkpi">
					<router-link to="/admindashboard/users"></router-link>
					<div>
						<div class="numbers">{{nbrUsers}}</div>
						<div class="cardName">Utilisateurs</div>
					</div>
					<div class="iconBx">
						<i class="pi pi-users"></i>
					</div>
				</div>
				<div class="cardkpi">
					<router-link to="/admindashboard/articles"></router-link>
					<div>
						<div class="numbers">{{nbrArticles}}</div>
						<div class="cardName">Articles</div>
					</div>
					<div class="iconBx">
						<i class="pi pi-clone"></i>
					</div>
				</div>
				<div class="cardkpi">
					<router-link to="/admindashboard/loans"></router-link>
					<div>
						<div class="numbers">{{nbrLoans}}</div>
						<div class="cardName">Prêts</div>
					</div>
					<div class="iconBx">
						<i class="pi pi-calendar"></i>
					</div>
				</div>
			</div>
</template>

<script>
import fetchData from '@/utils/fetchData'
export default {
	data(){
		return{
			nbrUsers:0,
			nbrLoans:0,
			nbrArticles:0,
		}
	},
	created(){
		fetchData({ controller: "loansController", action: "getCountLoans" }).then(data => {
                if (Object.keys(data).length) {
                    this.nbrLoans = data.count;
                }
            })
		fetchData({ controller: "usersController", action: "getCountUsers" }).then(data => {
                if (Object.keys(data).length) {
                    this.nbrUsers = data.count;
                }
            })
		fetchData({ controller: "articlesController", action: "getCountArticles" }).then(data => {
                if (Object.keys(data).length) {
                    this.nbrArticles = data.count;
                }
            })
	}
	
}
</script>

<style lang="scss">
.cardBox 
{
	position: relative;
	width: 100%;
    top: 40px;
    left: 300px;
	padding: 20px 150px;
	display: grid;
	grid-template-columns: repeat(3,1fr);
	grid-gap: 30px;
}
.cardBox .cardkpi 
{
	position: relative;
	background: var(--white);
	padding: 20px 10px;
	border-radius: 20px;
	display: flex;
	justify-content: space-between;
	cursor: pointer;
	a{
		position: absolute;
		height: 100%;
		width: 100%;
		left: 0;
		top : 0;
		z-index: 10;
	}
}
.cardBox .cardkpi .numbers 
{
	position: relative;
	font-weight: 500;
	font-size: 2.5em;
	color: var(--blue);
}
.cardBox .cardkpi .cardName 
{
	color: var(--black2);
	font-size: 1.1em;
	margin-top: 5px;
    font-weight: bold;
}
.cardBox .cardkpi .iconBx i
{
	font-size: 3.5em;
	color: var(--black2);
}
.cardBox .cardkpi:hover 
{
	background: var(--blue);
}
.cardBox .cardkpi:hover .numbers,
.cardBox .cardkpi:hover .cardName,
.cardBox .cardkpi:hover .iconBx i
{
	color: var(--white);
}
</style>