<template>
  <div>
    <Header />
    <div>
      <header class="bg-white shadow">
      </header>
      <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
          <div class="bg-white py-16 px-4 overflow-hidden sm:px-6 lg:px-8 lg:py-24">
            <div class="relative max-w-3xl mx-auto">
              <div class="text-left">
                <h2 class="text-3xl leading-9 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
                  Wishlist
                </h2>
              </div>
              <div class="mt-12">
                <div class="grid grid-cols-1 row-gap-6 sm:grid-cols-2 sm:col-gap-8">
                  <div class="sm:col-span-2">
                    <label for="wishlist_name" class="block text-base font-medium leading-5 text-gray-700">Wishlist Name</label>
                    <div class="mt-1 relative rounded-md">
                      <input id="wishlist_name" class="form-input py-3 px-4 block w-full transition ease-in-out duration-150 border border-gray-300 rounded" disabled :value="wishlist_name"/>
                      <span class="text-red-600 text-sm" v-if="errors.wishlist_name">Wishlist Name is required</span>
                    </div>
                  </div>
                  <!-- WISHLIST ITEM CARD -->
                  <div class="max-w-sm wishlist-card cursor-pointer" v-for="item in wishlist.wishlist_items" :key="item.id" @click="edit(item.id)">
                    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                      <div class="flex-shrink-0">
                        <img class="h-48 w-full object-cover bg-gray-50" :src="item.image_url" alt="" />
                      </div>
                      <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                        <div class="flex-1">
                          <p class="leading-5 font-medium text-indigo-600">
                            <a href="#" class="hover:underline">
                              {{ item.name }}
                            </a>
                          </p>
                          <a href="#" class="block">
                            <h3 class="mt-2 text-xl leading-7 font-semibold text-gray-900">
                              {{ '$' }} {{ (item.price).toFixed(2) }}
                            </h3>
                            <p class="mt-3 text-base leading-6 text-gray-500">
                              {{ item.description}}
                            </p>
                          </a>
                        </div>
                      </div>
                    </div>
                    <!-- WISHLIST ITEM CARD END -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

</template>
<script>
import Header from '../Header';
import { mapActions, mapGetters } from 'vuex';
import get from 'lodash/get';

export default {
  components: {
    Header
  },

  data () {
    return {
      formData: '',
      currentInputting: 0,
      submittable: true,
      items: [{
        price: '',
        name: '',
        description: '',
        image: '',
        errors: {
          price: false,
          name: false,
        },
      }],
      errors: {
        wishlist_name: false,
      }
    }
  },

  async mounted () {
    let id = this.$route.params.id

    await this.fetchWishlist({ id: id })

    console.log(this.wishlist)
  },

  methods: {
    ...mapActions({
      fetchWishlist: 'wishlist/fetch',
      buyWishlist: 'wishlist/buy',
    }),

    edit(id) {
      this.$router.push({ path: `/wishlist/item/edit/${id}` })
    }
  },

  computed: {
    ...mapGetters({
      wishlist: 'wishlist/wishlist',
    }),

    wishlist_name () {
      return get(this.wishlist, 'name', '')
    },

    wishlist_items () {
      return get(this.wishlist, 'wishlist_items', [])
    }
  }
}
</script>