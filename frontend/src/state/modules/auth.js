import { getLocalUser } from '../../helpers/auth'
import router from '../../router'

const user = getLocalUser();

export const state = {
  currentUser: user,
  isLoggedIn: !! user,
};

export const getters = {
  currentUser: (state) => state.currentUser,
  isLoggedIn: (state) => state.isLoggedIn,
};

export const mutations = {
  loginUser(state, currentuser) {
    state.currentuser = currentuser;
    state.isLoggedIn = true;
    localStorage.setItem('user', JSON.stringify(state.currentuser))

    router.push(router.currentRoute.query.redirectFrom || { name: 'home' })

    localStorage.removeItem('redirectPath');
  },

  logout(state) {
    localStorage.removeItem('user');
    state.isLoggedIn = false;
    state.currentUser = null;
  }
};

export const actions = {
  async handleAuth({ commit }, payload) {
    let currentUser = Object.assign({}, payload.user, { token: payload.access_token });

    commit('loginUser', currentUser);
  },

  async handleDeauth({ commit }) {
    commit('logout')
  }
};
