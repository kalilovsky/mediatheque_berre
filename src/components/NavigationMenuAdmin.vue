<template>
    <div class="navigationDashboard">
        <ul>
            <li>
                <a href="#">
                    <span class="icon">
                        <i class="pi pi-server"></i>
                    </span>
                    <router-link to="/admindashboard" class="title">Tableau de Bord</router-link>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="icon">
                        <i class="pi pi-users"></i> </span>
                    <router-link to="/admindashboard/users" class="title">Utilisateurs</router-link>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="icon">
                        <i class="pi pi-clone"></i> </span>
                    <router-link to="/admindashboard/articles" class="title">Articles</router-link>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="icon">
                        <i class="pi pi-calendar"></i> </span>
                    <router-link to="/admindashboard/loans" class="title">Gestion des Prêts</router-link>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="icon">
                        <i class="pi pi-cog"></i> </span>
                    <router-link to="/admindashboard/settings" class="title">Paramètres</router-link>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
import 'primeicons/primeicons.css';
export default {

}
</script>

<style lang="scss">
:root {
    --blue: #287bff;
    --white: #fff;
    --grey: #f5f5f5;
    --black1: #222;
    --black2: #999;
    --mainColor: #09161d;
}

.navigationDashboard {
    position: fixed;
    top: 100px;
    width: 300px;
    height: calc(100% - 100px);
    background: var(--grey);
    // border-left: 10px solid var(--blue);
    transition: 0.5s;
    overflow: hidden;
    
}

.navigationDashboard.active {
    width: 80px;
}

.navigationDashboard ul {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-content: center;
    flex-direction: column;
}

.navigationDashboard ul li {
    position: relative;
    width: 100%;
    list-style: none;
    border-top-left-radius: 30px;
    border-bottom-left-radius: 30px;
    font-weight: bold;
}

.navigationDashboard ul li:hover,
.navigationDashboard ul li.hovered {
    background: var(--mainColor);
}

// .navigationDashboard ul li:nth-child(1) {
//     margin-bottom: 40px;
//     pointer-events: none;
// }

.navigationDashboard ul li a {
    position: relative;
    display: block;
    width: 100%;
    display: flex;
    text-decoration: none;
    color: #6c757d;
}

.navigationDashboard ul li:hover a,
.navigationDashboard ul li.hovered a ,.router-link-exact-active {
    color: #42b983 !important;
}

.navigationDashboard ul li a .icon {
    position: relative;
    display: block;
    min-width: 60px;
    height: 60px;
    line-height: 70px;
    text-align: center;
}

.navigationDashboard ul li a .icon i {
    font-size: 1.75em;
}

.navigationDashboard ul li a .title {
    position: relative;
    display: block;
    padding: 0 10px;
    height: 60px;
    line-height: 60px;
    text-align: start;
    white-space: nowrap;
}

/* curve outside */

.navigationDashboard ul li:hover a::before,
.navigationDashboard ul li.hovered a::before {
    content: '';
    position: absolute;
    right: 0;
    top: -50px;
    width: 50px;
    height: 50px;
    background: transparent;
    border-radius: 50%;
    box-shadow: 35px 35px 0 10px var(--mainColor);
    pointer-events: none;
}

.navigationDashboard ul li:hover a::after,
.navigationDashboard ul li.hovered a::after {
    content: '';
    position: absolute;
    right: 0;
    bottom: -50px;
    width: 50px;
    height: 50px;
    background: transparent;
    border-radius: 50%;
    box-shadow: 35px -35px 0 10px var(--mainColor);
    pointer-events: none;
}
</style>