import { createStore } from 'vuex'

export default createStore({
  state: {
    url: 'http://localhost:3000/index.php',
    urlImage:'http://localhost:3000/public/',
    userInfo: { isConnected: 'false', },
    filterCriteria: {
      filterByText: "",
      filterByCat: "",
      filterBySubCat: "",
      filterByCol: "",
      filterByAuthor: "",
      filterByEditor: "",
    },
    lateLoans:{},
    toggleLoginForm:false,
  },
  getters: {
  },
  mutations: {
    updateTextFilterCritera(state, payload) {
      state.filterCriteria.filterByText = payload.filter.filterByText;
    },
    updateLateLoans(state, payload){
      state.lateLoans = payload.lateLoans;
    },
    updateToggleLoginForm(state,payload){
      state.toggleLoginForm = payload.toggleLoginForm;
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
