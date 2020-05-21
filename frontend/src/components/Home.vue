<template>
  <div>
    <Header />
    <div>
      <header class="bg-white shadow">
      </header>
      <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
          <span class="inline-flex rounded-md shadow-sm mb-5">
            <router-link
              to="/wishlist/new"
            >
              <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                Add Wishlist
              </button>
            </router-link>
          </span>
          <Wishlist />
        </div>
      </main>
    </div>
  </div>
</template>
<script>
  import Header from './Header';
  import Wishlist from './Canvas/Wishlist';

  export default {
    components: { 
      Header,
      Wishlist
    }
  }
</script>