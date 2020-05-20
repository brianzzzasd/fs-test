import Vue from 'vue';
import App from './App.vue';
import router from './router';

import './assets/styles/index.css';
import './plugins';

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
  router,
}).$mount('#app') 
