import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './state/store';

import './assets/styles/index.css';
import './plugins';

Vue.config.productionTip = false

router.beforeEach((to, from, next) => {
	const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
	const currentUser = localStorage.getItem('user')

	if (requiresAuth && !currentUser) {
		next('/login');
	} else if ((to.path == '/login' || to.path == '/register') && currentUser) {
		next('/');
	} else {
		next();
	}
});

new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount('#app');
