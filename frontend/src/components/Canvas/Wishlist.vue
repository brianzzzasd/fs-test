<template>
  <div class="flex flex-col">
    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
      <modal name="delete-modal" width="500px">
        <div class="px-12 pt-4">
          <transition
            enter-active-class="ease-out duration-300"
            enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to-class="opacity-100 translate-y-0 sm:scale-100"
            leave-active-class="ease-in duration-200"
            leave-class="opacity-100 translate-y-0 sm:scale-100"
            leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <div class="bg-white rounded-lg px-4 pt-5 pb-4 overflow-hidden transform transition-all sm:w-full">
            <div>
              <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                  <svg class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                  </svg>
                </div>
                <div class="mt-3 text-center sm:mt-5">
                  <h3 class="text-2xl font-medium text-gray-900">
                    Are you sure you want to delete this Wishlist?
                  </h3>
                </div>
              </div>
              <div class="mt-5 sm:mt-6 flex justify-center pt-10">
                <span class="flex w-1/2 rounded-md shadow-sm pr-5">
                  <button type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5" @click="remove()">
                    Yes
                  </button>
                </span>
                <span class="flex w-1/2 rounded-md shadow-sm pl-5">
                  <button type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-gray-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-gray-500 focus:outline-none focus:border-gray-700 focus:shadow-outline-gray transition ease-in-out duration-150 sm:text-sm sm:leading-5" @click="$modal.hide('delete-modal')">
                    No
                  </button>
                </span>
              </div>
            </div>
          </transition>
        </div>
      </modal>
      <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
        <table class="min-w-full">
          <thead>
            <tr>
              <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                Id
              </th>
              <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                Name
              </th>
              <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                Shareable Link
              </th>
              <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
            </tr>
          </thead>
          <tbody>
            <tr class="bg-white" v-for="wishlist in wishlists" :key="wishlist.id">
              <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">
                {{ wishlist.id }}
              </td>
              <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                <router-link
                  :to="`/wishlist/view/${wishlist.id}`"
                >
                  <span class="cursor-pointer hover:underline ">
                    {{ wishlist.name }}
                  </span>
                </router-link>
              </td>
              <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                {{ wishlist.shareable_link }}
              </td>
              <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                <router-link
                  :to="`/wishlist/edit/${wishlist.id}`"
                >
                  <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                </router-link>
                <a href="#" class="pl-3 text-red-600 hover:text-indigo-900" @click="show(wishlist.id)">Remove</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <Pagination />
    </div>
  </div>
</template>
<script>
  import { mapActions, mapGetters } from 'vuex'
  import Pagination from '../Pagination';

  export default {
    components: {
      Pagination,
    },

    data () {
      return {
        currentWishlist: '',
      }
    },

    async mounted () {
      await this.fetchWishlists()
    },

    methods: {
      ...mapActions({
        fetchWishlists: 'wishlist/fetchAll',
        deleteWishlist: 'wishlist/delete',
      }),

      show(id) {
        this.currentWishlist = id;
        this.$modal.show('delete-modal');
      },

      async remove() {
        this.$modal.hide('delete-modal');

        if (this.deleteWishlist(this.currentWishlist)) {
          await this.fetchWishlists();
        }
      }
    },

    computed: {
      ...mapGetters({
        wishlists: 'wishlist/wishlists',
      })
    }
  }
</script>