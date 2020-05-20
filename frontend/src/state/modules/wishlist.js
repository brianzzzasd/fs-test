import axios from 'axios';

export const state = {
  wishlist: null,
};

export const getters = {
  wishlist: (state) => state.wishlist,
};

export const mutations = {
  setWishlist(state, wishlist) {
    state.wishlist = wishlist;
  }
};

export const actions = {
  async fetch({ commit }) {
    let data = await axios.get('wishlist')

    commit('setWishlist', { data })
  },

  async add({ }, params) {
    let data = axios.post('wishlist', params);

    console.log(data);
  }
};
