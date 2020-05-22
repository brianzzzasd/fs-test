<template>
  <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
    <div class="flex-1 flex justify-between sm:hidden">
      <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
        Previous
      </a>
      <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
        Next
      </a>
    </div>
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
      <div>
        <p class="text-sm leading-5 text-gray-700" v-if="total">
          Showing
          <span class="font-medium">{{ (currentPage * 10) - 9 }}</span>
          to
          <span class="font-medium">{{ currentPage * 10}}</span>
          of
          <span class="font-medium">{{ total }}</span>
          results
        </p>
      </div>
      <div>
        <nav class="relative z-0 inline-flex shadow-sm">
          <button type="button" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Previous" @click="firstPage()">
            &lt;&lt;
          </button>

          <button type="button" class="px-3 relative inline-flex items-center py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Previous" @click="prevPage()">
            &lt;
          </button>
          <div :key="i" v-for="i in pageCount">
            <button v-if="(i > displayedPages) && i <= (displayedPages + maxButtons)" type="button" class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" @click="jumpPage(i)">
              {{ i }}
            </button>
          </div>

          <button type="button" class="px-3 relative inline-flex items-center py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Previous" @click="nextPage()">
            >
          </button>
          <button type="button" class="-ml-px relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Next" @click="lastPage()">
            >>
          </button>
        </nav>
      </div>
    </div>
  </div>
</template>
<script>
  import axios from 'axios';
  import floor from 'lodash/floor';
  import ceil from 'lodash/ceil';
  import { mapActions } from 'vuex';

  export default {
    data () {
      return {
        total: '',
        paginationData: '',
        maxButtons: 5,
        displayedPages: 1,
        currentPage: 1,
      }
    },

    async beforeMount() {

      await this.getPaginationData();
      await this.pageTrackLimit()
      console.log(this.pageCount)
    },

    methods: {
      ...mapActions({
        fetch: 'wishlist/fetchAll',
      }),

      jumpPage(value) {
        this.currentPage = value;
      },

      firstPage() {
        this.jumpPage(1);
      },

      lastPage() {
        this.jumpPage(this.pageCount);
      },

      nextPage() {
        let page = this.currentPage < this.pageCount ? this.currentPage + 1 : this.pageCount;
        this.jumpPage(page);
      },

      prevPage() {
        let page = this.currentPage > 1 ? this.currentPage - 1 : 1;

        this.jumpPage(page);
      },

      async getPaginationData() {
        const { data: { data } } = await axios.post('get-paginate-data')
        
        this.total = data.total
      },

      async pageTrackLimit () {
        const groupCount = floor((this.currentPage - 1)  / this.maxButtons)
        this.displayedPages = (groupCount) * this.maxButtons
      }
    },

    computed: {
      pageCount () {
        return ceil(this.total / 10);
      }
    },

    watch: {
      async currentPage(current) {
        if (current) {
          this.pageTrackLimit()
          this.fetch({ page: this.currentPage })
        }
      }
    }
  }
</script>