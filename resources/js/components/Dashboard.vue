<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <div class="flex-shrink-0 flex items-center">
              <h1 class="text-xl font-bold text-gray-900">Todo List</h1>
            </div>
          </div>
          <div class="flex items-center">
            <button
              @click="handleLogout"
              class="ml-4 px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <div class="bg-white shadow rounded-lg p-6">
          <h2 class="text-lg font-medium text-gray-900 mb-4">Welcome, {{ user?.name }}</h2>
          
          <div class="mb-6">
            <form @submit.prevent="addTask" class="flex gap-4">
              <input
                v-model="newTask.title"
                type="text"
                placeholder="Task title"
                class="flex-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"
                required
              />
              <input
                v-model="newTask.body"
                type="text"
                placeholder="Task description"
                class="flex-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"
                required
              />
              <button
                type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                Add Task
              </button>
            </form>
          </div>

          <div class="space-y-4">
            <div
              v-for="task in tasks"
              :key="task.id"
              class="border p-4 rounded shadow hover:shadow-md transition-shadow"
              :class="{ 'bg-gray-50': task.completed }"
            >
              <div class="flex justify-between items-start">
                <div>
                  <h3 class="text-lg font-semibold" :class="{ 'line-through text-gray-500': task.completed }">
                    {{ task.title }}
                  </h3>
                  <p class="text-gray-600" :class="{ 'line-through': task.completed }">
                    {{ task.body }}
                  </p>
                </div>
                <div class="flex gap-2">
                  <button
                    @click="toggleTask(task)"
                    class="px-3 py-1 rounded text-sm font-medium"
                    :class="task.completed ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                  >
                    {{ task.completed ? 'Completed' : 'Mark Complete' }}
                  </button>
                  <button
                    @click="deleteTask(task)"
                    class="bg-red-500 text-white px-3 py-1 rounded text-sm font-medium hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                  >
                    Delete
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const user = ref(null);
const tasks = ref([]);
const newTask = ref({
  title: '',
  body: '',
});

onMounted(async () => {
  try {
    const response = await axios.get('/api/user');
    user.value = response.data.user;
    await fetchTasks();
  } catch (error) {
    console.error('Error fetching user data:', error);
    router.push('/login');
  }
});

const fetchTasks = async () => {
  try {
    const response = await axios.get('/api/tasks');
    tasks.value = response.data;
  } catch (error) {
    console.error('Error fetching tasks:', error);
  }
};

const addTask = async () => {
  try {
    const response = await axios.post('/api/tasks', newTask.value);
    tasks.value.push(response.data);
    newTask.value = { title: '', body: '' };
  } catch (error) {
    console.error('Error adding task:', error);
  }
};

const toggleTask = async (task) => {
  try {
    const response = await axios.put(`/api/tasks/${task.id}`, {
      ...task,
      completed: !task.completed,
    });
    const index = tasks.value.findIndex((t) => t.id === task.id);
    tasks.value[index] = response.data;
  } catch (error) {
    console.error('Error updating task:', error);
  }
};

const deleteTask = async (task) => {
  try {
    await axios.delete(`/api/tasks/${task.id}`);
    tasks.value = tasks.value.filter((t) => t.id !== task.id);
  } catch (error) {
    console.error('Error deleting task:', error);
  }
};

const handleLogout = async () => {
  try {
    await axios.get('/sanctum/csrf-cookie');
    await axios.post('/api/logout');
    
    user.value = null;
    tasks.value = [];
    
    localStorage.clear();
    sessionStorage.clear();
    
    await new Promise(resolve => setTimeout(resolve, 100));
    
    window.location.replace('/login');
  } catch (error) {
    console.error('Logout error:', error);
    window.location.replace('/login');
  }
};
</script> 