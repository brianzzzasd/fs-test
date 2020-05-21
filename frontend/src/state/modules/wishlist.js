import axios from 'axios';

export const state = {
  wishlists: null,
};

export const getters = {
  wishlists: (state) => state.wishlists,
};

export const mutations = {
  setWishlists(state, wishlists) {
    state.wishlists = wishlists;
  }
};

export const actions = {
  async fetch({ commit }, params) {
    await axios.get('wishlist', params)

    commit();
  },

  async add({ commit }, params) {
    try {
      await axios.post('wishlist', params)
      commit();
    } catch (err) {
      return false
    }

    return true;
  }
};
