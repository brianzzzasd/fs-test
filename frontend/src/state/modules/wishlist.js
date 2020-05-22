import axios from 'axios';

export const state = {
  wishlists: null,
  wishlist: null,
  wishlist_item: null,
};

export const getters = {
  wishlists: (state) => state.wishlists,
  wishlist: (state) => state.wishlist,
  wishlist_item: (state) => state.wishlist_item,
};

export const mutations = {
  SET_WISHLISTS(state, wishlists) {
    state.wishlists = wishlists;
  },

  SET_WISHLIST(state, wishlist) {
    state.wishlist = wishlist;
  },

  SET_WISHLIST_ITEM(state, wishlist_item) {
    state.wishlist_item = wishlist_item;
  }
};

export const actions = {
  async fetchAll({ commit }, params) {
    const { data: { data } } = await axios.get('wishlist', params);

    commit('SET_WISHLISTS', data);
  },

  async add({ commit }, params) {
    try {
      await axios.post('wishlist', params)
      commit();
    } catch (err) {
      return false;
    }

    return true;
  },

  async fetch({ commit }, params) {
    try {
      const { data: { data }} = await axios.post('wishlist/view', params)

      commit('SET_WISHLIST', data[0]);
    } catch (err) {
      return false;
    }

    return true;
  },

  async delete({ commit }, id) {
    try {
      await axios.post(`wishlist/delete/${id}`)
    } catch (err) {
      return false;
    }

    commit();
    return true;
  },

  async buy({ commit }, params) {
    try {
      const { data: { data }} = await axios.post('wishlist/buy', params)
      
      commit('SET_WISHLIST', data[0]);
    } catch (err) {
      return false;
    }

    return true;
  }
};
