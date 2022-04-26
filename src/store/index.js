import { createStore } from 'vuex'

export default createStore({
  state: {
    url: 'http://localhost:3000/index.php',
    userInfo: { isConnected: 'false', },
    filterCriteria: {
      filterByText: "",
      filterByCat: "",
      filterBySubCat: "",
      filterByCol: "",
      filterByAuthor: "",
      filterByEditor: "",
    },
  },
  getters: {
  },
  mutations: {
    updateTextFilterCritera(state, payload) {
      state.filterCriteria.filterByText = payload.filter.filterByText;
    },
    // updateMyTags(state,payload){
    //   state.myTags = Object.keys(payload.myTags);
    // },
    updateUserInfo(state, payload) {
      state.userInfo = payload.userInfo;
    },
    // setScrollVisibility(state,payload){
    //   state.scrollMenuVisibility = payload.scroll;
    // }
  },
  actions: {
  },
  modules: {
  }
})
