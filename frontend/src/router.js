import Vue from 'vue';
import VueRouter from 'vue-router';
import EditWishlist from './components/Canvas/EditWishlist';
import NewWishlist from './components/Canvas/NewWishlist';
import ViewWishlist from './components/Canvas/ViewWishlist';
import Home from './components/Home';
import Login from './components/Login';

Vue.use(VueRouter);

export default new VueRouter({
	routes: [
		{
			path: '/',
			component: Home,
			meta: {
				requiresAuth: true,
			},
		},
		{
			path: '/login',
			component: Login
		},
		{
			path: '/wishlist/new',
			component: NewWishlist,
			meta: {
				requiresAuth: true,
			},
		},
		{
			path: '/wishlist/:id',
			component: EditWishlist,
			meta: {
				requiresAuth: true,
			},
		},
		{
			path: '/wishlist/view/:id',
			component: ViewWishlist,
			meta: {
				requiresAuth: true,
			},
		}
	],
	mode: 'history',
})