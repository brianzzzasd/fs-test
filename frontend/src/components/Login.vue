<template>
  <div class="min-h-screen bg-white flex">
    <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
      <div class="mb-2 font-bold text-4xl flex justify-center text-orange-500">
        Kadonation Test
      </div>
      <div class="mx-auto w-full max-w-sm">
        <div>
          <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
            Sign in to your <br> account
          </h2>

          <p class="mt-2 text-center text-sm leading-5 text-gray-600 max-w">
            Or
            <a href="/register" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
              Sign up here
            </a>
          </p>
        </div>

        <div class="mt-8">
          <div class="mt-6">
            <div>
              <div>
                <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
                  Email address
                </label>
                <div class="mt-1 rounded-md shadow-sm">
                  <input id="email" type="email"  v-model="form.email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                </div>
              </div>

              <div class="mt-6">
                <label for="password" class="block text-sm font-medium leading-5 text-gray-700">
                  Password
                </label>
                <div class="mt-1 rounded-md shadow-sm">
                  <input id="password" type="password" v-model="form.password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                </div>
              </div>

              <div class="mt-6">
                <span class="block w-full rounded-md shadow-sm">
                  <button @click="authenticate()" type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                    Sign in
                  </button>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="hidden lg:block relative w-0 flex-1 bg-green-300">

    </div>
  </div>
</template>
<script>
  import { login } from '../helpers/auth';
  import { mapActions } from 'vuex';

  export default {
    data () {
      return {
        form: {
          email: '',
          password: '',
        }
      }
    },

    methods: {
      ...mapActions({
        loginUser: 'auth/handleAuth'
      }),

      async authenticate() {
        login(this.form)
          .then((res) => {
            this.loginUser(res)

            this.$router.push({ path: '/'})
          })
      }
    }
  }
</script>