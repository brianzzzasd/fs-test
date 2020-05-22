import Vue from 'vue';
import VueRouter from 'vue-router';
import EditWishlist from './components/Canvas/EditWishlist';
import EditWishlistItem from './components/Canvas/EditWishlistItem';
import NewWishlist from './components/Canvas/NewWishlist';
import ViewWishlist from './components/Canvas/ViewWishlist';
import Home from './components/Home';
import Login from './components/Login';
import Register from './components/Register';

Vue.use(VueRouter);

export default new VueRouter({
	routes: [
		{
			name: 'home',
			path: '/',
			component: Home,
			meta: {
				requiresAuth: true,
			},
		},
		{
			name: 'login',
			path: '/login',
			component: Login
		},
		{
			name: 'Register',
			path: '/register',
			component: Register
		},
		{
			path: '/wishlist/new',
			component: NewWishlist,
			meta: {
				requiresAuth: true,
			},
		},
		{
			path: '/wishlist/edit/:id',
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
		},
		{
			path: '/wishlist/item/edit/:id',
			component: EditWishlistItem,
			meta: {
				requiresAuth: true,
			}
		}
	],
	mode: 'history',
})