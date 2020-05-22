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
                  Wishlist Item
                </h2>
              </div>
              <div class="mt-12">
                <div class="border-b border-gray-500 pb-5 mt-5">
                  <div class="flex">
                    <div class="w-1/2 pr-3">
                      <div class="mt-1 relative">
                        <label for="item_name" class="block text-sm font-medium leading-5 text-gray-700 mt-2">Item Name *</label>
                        <input v-model="item.name" id="item_name" class="form-input py-3 px-4 block w-full transition ease-in-out duration-150 mt-4 border border-gray-300 rounded"/>
                        <span class="text-red-600 text-sm" v-if="item.errors.name">Item name is required</span>
                      </div>
                      <div class="mt-1 relative">
                        <label for="item_price" class="block text-sm font-medium leading-5 text-gray-700 mt-2">Price *</label>
                        <input v-model="item.price" id="item_price" type="number" class="form-input py-3 px-4 block w-full transition ease-in-out duration-150 mt-4 border border-gray-300 rounded" />
                        <span class="text-red-600 text-sm" v-if="item.errors.price">Price is required</span>
                      </div>
                      <div class="mt-1 relative">
                        <label for="image_file" class="block text-sm font-medium leading-5 text-gray-700 mt-2">Image </label>
                        <input id="image_file" type="file" class="form-input py-3 px-4 block w-full transition ease-in-out duration-150 mt-4 border border-gray-300 rounded" 
                        @change="onImageChange" accept="image/*"/>
                        <span class="text-red-600 text-sm" v-if="item.errors.price">Price is required</span>
                      </div>
                    </div>
                    <div class="w-1/2">
                      <label for="item_description" class="block text-sm font-medium leading-5 text-gray-700 mt-2">Item Description</label>
                      <textarea v-model="item.description" id="item_description" rows="5" class="resize-none form-input py-3 px-4 block w-full transition ease-in-out duration-150 mt-4 border border-gray-300 rounded"></textarea>
                    </div>
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
import each from 'lodash/each';

export default {
  components: {
    Header
  },

  data () {
    return {
      formData: '',
      currentInputting: 0,
      submittable: true,
      item: {
        name: '',
        description: '',
        price: '',
        image: '',
        errors: {
          name: false,
          price: false,
        }
      },
      errors: {
        wishlist_name: false,
      }
    }
  },

  async beforeMount () {
    let id = this.$route.params.id

    await this.fetchWishlistItem({ id: id })

    this.initItem()
    
  },

  methods: {
    ...mapActions({
      fetchWishlistItem: 'wishlistitems/fetch',
    }),

    onImageChange(e) {
      this.item.image = e.target.files[0]
    },

    initItem() {
      each(this.wishlistitem, (item, key) => {
        this.item[key] = item
      })
    }
  },

  computed: {
    ...mapGetters({
      wishlistitem: 'wishlistitems/wishlist_item',
    }),
  },
}
</script>