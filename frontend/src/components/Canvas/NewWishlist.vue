<template>
<div class="bg-white py-16 px-4 overflow-hidden sm:px-6 lg:px-8 lg:py-24">
  <div class="relative max-w-xl mx-auto">
    <div class="text-center">
      <h2 class="text-3xl leading-9 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
        Add New Wishlist
      </h2>
    </div>
    <div class="mt-12">
      <div class="grid grid-cols-1 row-gap-6 sm:grid-cols-2 sm:col-gap-8">
        <div class="sm:col-span-2">
          <label for="wishlist_name" class="block text-base font-medium leading-5 text-gray-700">Wishlist Name *</label>
          <div class="mt-1 relative rounded-md">
            <input v-model="wishlist_name" id="wishlist_name" class="form-input py-3 px-4 block w-full transition ease-in-out duration-150 border border-gray-300 rounded" />
            <span class="text-red-600 text-sm" v-if="errors.wishlist_name">Wishlist Name is required</span>
          </div>
        </div>
        <div class="sm:col-span-2">
          <div class="border-b border-gray-500 pb-5 mt-5" v-for="(item, index) in items" :key="index">
            <div class="flex justify-end">
              <span class="text-sm cursor-pointer p-2" @click="removeItem(index)">x</span>
            </div>
            <div class="flex">
              <div class="w-1/2 pr-3">
                <div class="mt-1 relative">
                  <label for="item_name" class="block text-sm font-medium leading-5 text-gray-700 mt-2">Item Name *</label>
                  <input v-model="item.name" id="item_name" class="form-input py-3 px-4 block w-full transition ease-in-out duration-150 mt-4 border border-gray-300 rounded" />
                  <span class="text-red-600 text-sm" v-if="item.errors.name">Item name is required</span>
                </div>
                <div class="mt-1 relative">
                  <label for="item_price" class="block text-sm font-medium leading-5 text-gray-700 mt-2">Price *</label>
                  <input v-model="item.price" id="item_price" type="number" class="form-input py-3 px-4 block w-full transition ease-in-out duration-150 mt-4 border border-gray-300 rounded" />
                  <span class="text-red-600 text-sm" v-if="item.errors.price">Price is required</span>
                </div>
                <div class="mt-1 relative">
                  <label for="image_file" class="block text-sm font-medium leading-5 text-gray-700 mt-2">Image </label>
                  <input :key="index" id="image_file" type="file" :ref="{index}" class="form-input py-3 px-4 block w-full transition ease-in-out duration-150 mt-4 border border-gray-300 rounded" 
                  @change="onImageChange" @input="setCurrentInputing(index)" accept="image/*"/>
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
        <div>
            <button @click="addItem()" type="button" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-500 transition ease-in-out duration-150">
              Add New Item
            </button>
        </div>
        <div class="sm:col-span-2 mt-8">
          <span class="flex w-full justify-end">
            <button @click="create()" type="button" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
              Create
            </button>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
</template>
<script>
import { mapActions } from 'vuex';

export default {
  data () {
    return {
      formData: '',
      currentInputting: 0,
      submittable: true,
      wishlist_name: '',
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

  methods: {
    ...mapActions({
      addWishlist: 'wishlist/add',
    }),

    onImageChange(e) {
      this.items[this.currentInputting].image = e.target.files[0]
    },

    setCurrentInputing(index) {
      this.currentInputting = index
      console.log(this.items)
    },

    addItem() {
      this.items.push({
        price: '',
        name: '',
        description: '',
        image: '',
        errors: {
          price: false,
          name: false,
        },
      });
    },

    removeItem(index) {
      if (this.items.length > 1) {
        this.items.splice(index, 1)
      }
    },

    async create() {
      this.validate();

      if (this.submittable) {
        let params = {
          wishlist_name: this.wishlist_name,
          wishlist_items: JSON.stringify(this.items)
        }

        this.formData.append('wishlist', JSON.stringify(params));

        let data = this.addWishlist(this.formData)

        if (data) {
          this.$toasted.success('Wishlist Created Successfully!')
          this.clear()
        } else {
          this.$toasted.error('Something went wrong, please try again.')
        }
      }
    },

    validate() {
      let formData = new FormData();
      
      this.submittable = true;
      this.errors.wishlist_name = false;

      if (!this.wishlist_name) {
        this.submittable = false;
        this.errors.wishlist_name = true
      }

      this.items.forEach((item, index) => {
        Object.entries(item).forEach((value) => {
          let key = value[0]
          let item_value = value[1]

          if (!item_value && (key == 'price' || key == 'name')) {
            item.errors[key] = true;
            this.submittable = false;
          } else {
            item.errors[key] = false;
          }

          if (key == 'image') {
            formData.append(`image-${index}`, item_value)
          }
        })
      })

      this.formData = formData
    },

    clear () {
      this.items = []

      this.items = [{
        price: '',
        name: '',
        description: '',
        image: '',
        errors: {
          price: false,
          name: false,
        },
      }]

      this.wishlist_name = ''
    }
  }
}
</script>