import axios from 'axios';
import store from '../state/store'
import { getSavedState } from '../helpers/localStorage'

axios.defaults.baseURL = process.env.VUE_APP_API_URL;

axios.interceptors.request.use((request) => {
    const user = getSavedState('user')

    if (user) {
        request.headers.common['Authorization'] = `Bearer ${user.token}`
    }

    return request;
});

axios.interceptors.response.use((response) => response, (error) => {
    if (error.response.status == 401) {
        store.dispatch('auth/handleDeauth')

        this.$router.push('/')
    }
});


