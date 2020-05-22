import axios from 'axios';

export const state = {
  wishlist_item: null,
  wishlist_items: null,
};

export const getters = {
  wishlist_item: (state) => state.wishlist_item,
  wishlist_items: (state) => state.wishlist_items,
};

export const mutations = {
  SET_WISHLIST_ITEM(state, wishlist_item) {
    state.wishlist_item = wishlist_item;
  },

  SET_WISHLIST_ITEMS(state, wishlist_items) {
    state.wishlist_items = wishlist_items;
  }
};

export const actions = {
  async fetchAll({ commit }, params) {
    const { data: { data } } = await axios.get('wishlist/items', params);

    commit('SET_WISHLIST_ITEMS', data);
  },

  async fetch({ commit }, params) {
    try {
      const { data: { data }} = await axios.post('wishlist/item', params)

      commit('SET_WISHLIST_ITEM', data[0]);
    } catch (err) {
      return false;
    }

    return true;
  },

  async update({ commit }, params) {
    try {
      await axios.post('wishlist/item/update', params)

      commit();
    } catch (err) {
      return false;
    }

    return true;
  }
};
