<template>
  <nav>
    <AppHeader></AppHeader>
  </nav>
    <MainView>
      <router-view/>
    </MainView>
</template>
<script>
import AppHeader from "./components/AppHeader.vue"
import MainView from "./views/MainView.vue"
export default {
  components:{
    AppHeader,
    MainView,
}
}
</script>
<style lang="scss">
*
{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Ubuntu', sans-serif;
}
body 
{
  min-height: 100vh;
  background: #09161d;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
}

nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
