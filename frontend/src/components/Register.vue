<template>
  <div class="min-h-screen bg-white flex">
    <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
      <div class="mb-2 font-bold text-4xl flex justify-center text-orange-500">
        Kadonation Test
      </div>
      <div class="mx-auto w-full max-w-sm">
        <div>
          <h2 class="mt-6 text-3xl leading-9 font-bold text-gray-900 text-center">
            Register
          </h2>
        </div>

        <div class="mt-8">
          <div class="mt-6">
            <div>
              <div>
                <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                  Name
                </label>
                <div class="mt-1">
                  <input id="name" type="text" v-model="form.name" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                  <span class="text-red-600 text-sm" v-if="errors.name">Name is required</span>
                </div>
              </div>
              <div class="mt-6">
                <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
                  Email Address
                </label>
                <div class="mt-1">
                  <input id="email" type="text" v-model="form.email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                  <span class="text-red-600 text-sm" v-if="errors.email">Email is required and must be valid</span>
                </div>
              </div>

              <div class="mt-6">
                <label for="password" class="block text-sm font-medium leading-5 text-gray-700">
                  Password
                </label>
                <div class="mt-1">
                  <input id="password" type="password" v-model="form.password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                  <span class="text-red-600 text-sm" v-if="errors.email">Password is required</span>
                </div>
              </div>

              <div class="mt-6">
                <span class="block w-full rounded-md shadow-sm">
                  <button @click="register()" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                    Register
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
  import axios from 'axios';

  export default {
    data () {
      return {
        form: {
          name: '',
          email: '',
          password: '',
        },

        errors: {
          name: false,
          email: false,
          password: false,
        },
      }
    },

    methods: {
      register () {
        this.validate()

        axios.post('register', this.form).then((res) => {
          if (res.status == 200) {
            this.$toasted.success('Register Successfully! Redirecting to Login Page . .')

            setTimeout(() => {
              this.$router.push({ path: '/login' })
            }, 3000)
          }
        })
      },

      validate () {
        let data = this.form

        Object.entries(data).forEach((item) => {
          let key = item[0]
          let value = item[1]

          this.errors[key] = false

          if (key == 'email' && !this.validateEmail(value)) {
            this.errors[key] = true
          }

          if (!value) {
            this.errors[key] = true
          }
        })
      },

       validateEmail(email) {
          var re = /\S+@\S+\.\S+/;
          return re.test(email);
      },
    }
  }
</script>