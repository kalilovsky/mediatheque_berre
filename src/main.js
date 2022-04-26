import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import PrimeVue from 'primevue/config'
import ToastService from 'primevue/toastservice';
import "primeflex/primeflex.css";
import "primevue/resources/themes/saga-blue/theme.css";
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";
import ConfirmationService from 'primevue/confirmationservice';


createApp(App).use(store).use(router).use(PrimeVue).use(ToastService).use(ConfirmationService).mount('#app')
