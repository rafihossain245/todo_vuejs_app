<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Sign in to your account
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Or
          <a href="#" @click.prevent="$emit('switch-view', 'register')" class="font-medium text-indigo-600 hover:text-indigo-500">
            create a new account
          </a>
        </p>
      </div>
      <form class="mt-8 space-y-6" @submit.prevent="handleLogin">
        <div class="rounded-md shadow-sm -space-y-px">
          <div>
            <label for="email" class="sr-only">Email address</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              placeholder="Email address"
            />
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              placeholder="Password"
            />
          </div>
        </div>

        <div>
          <button
            type="submit"
            :disabled="loading"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            <span v-if="loading">Signing in...</span>
            <span v-else>Sign in</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const emit = defineEmits(['login-success', 'switch-view']);

const form = ref({
  email: '',
  password: '',
});

const loading = ref(false);

const handleLogin = async () => {
  try {
    loading.value = true;

    await axios.get('/sanctum/csrf-cookie');
    
    const response = await axios.post('/api/login', {
      email: form.value.email,
      password: form.value.password
    });
    
    emit('login-success', response.data);
    router.push('/dashboard');
  } catch (error) {
    console.error('Login error:', error);
    alert(error.response?.data?.message || 'Login failed. Please check your credentials.');
  } finally {
    loading.value = false;
  }
};

async function checkSession() {
    try {
        const response = await axios.get('/api/user');
        console.log('User session:', response.data);
    } catch (error) {
        console.error('Session check error:', error);
    }
}
</script> 