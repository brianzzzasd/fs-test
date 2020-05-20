import Vue from 'vue';
import VueRouter from 'vue-router';
import HelloWorld from './components/HelloWorld';
import Login from './components/Login';

Vue.use(VueRouter);

export default new VueRouter({
	routes: [
		{
			path: '/',
			component: HelloWorld,
			meta: {
				requiresAuth: true,
			}
		},
		{
			path: '/login',
			component: Login
		}
	],
	mode: 'history',
})