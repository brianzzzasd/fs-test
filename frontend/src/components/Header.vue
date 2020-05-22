<template>
<div>
  <nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <div class="block">
            <div class="ml-3 flex items-baseline">
              <router-link
                to="/"
              >
                <a href="#" class="ml-4 px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Wishlists</a>
              </router-link>
            </div>
          </div>
        </div>
        <div class="block">
          <div class="ml-4 flex items-center md:ml-6">
            <!-- Profile dropdown -->
            <div class="ml-3 relative">
              <div>
                <button class="max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none focus:shadow-solid" id="user-menu" aria-label="User menu" aria-haspopup="true">
                  <div class="h-8 w-8 bg-green-600 rounded-full" @click="isOn = !isOn">
                  </div>
                </button>
              </div>
              <transition
                enter-active-class="transition ease-out duration-100 transform"
                enter-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75 transform"
                leave-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-95"
              >
                <div 
                  v-if="isOn"
                  class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg"
                  >
                  <div class="py-1 rounded-md bg-white shadow-xs" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                    <a @click="logoutUser()" class="cursor-pointer block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Sign out</a>
                  </div>
                </div>
              </transition>
            </div>
          </div>
        </div>
      </div>
    </div>

  </nav>
</div>
</template>
<script>
  import { mapActions } from 'vuex';

  export default {
    data () {
      return {
        isOn: false,
      }
    },

    methods: {
      ...mapActions({
        handleDeauth: 'auth/handleDeauth',
      }),

      logoutUser() {
        this.handleDeauth()

        this.$router.push({ path: '/login' })
      }
    }
  }
</script>