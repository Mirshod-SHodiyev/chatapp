<template>
    <div class="container mx-auto p-4">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Edit Profile</h2>
        <form @submit.prevent="updateProfile">
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input 
              type="text" 
              id="name" 
              v-model="user.name" 
              class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:ring-blue-500"
              placeholder="Enter your name"
            />
          </div>
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input 
              type="email" 
              id="email" 
              v-model="user.email" 
              class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:ring-blue-500"
              placeholder="Enter your email"
              :disabled="true"
            />
          </div>
          <div class="flex justify-between">
            <button 
              type="submit" 
              class="bg-blue-500 text-white px-4 py-2 rounded-md disabled:bg-gray-400"
              :disabled="isLoading"
            >
              Update
            </button>
            <button 
              type="button" 
              @click="deleteAccount" 
              class="bg-red-500 text-white px-4 py-2 rounded-md"
            >
              Delete Account
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  
  const user = ref({});
  const isLoading = ref(false);
  const router = useRouter();
  
  // Fetch user data when the component mounts
  onMounted(() => {
    user.value = JSON.parse(document.getElementById('app').getAttribute('data-auth')); // Get the authenticated user data
  });
  
  // Update profile
  const updateProfile = () => {
    if (isLoading.value) return;
  
    isLoading.value = true;
  
    axios
      .put(`/api/users/${user.value.id}`, {
        name: user.value.name,
        email: user.value.email, // You can allow users to update email if needed
      })
      .then((response) => {
        alert('Profile updated successfully');
        isLoading.value = false;
      })
      .catch((error) => {
        console.error('Error updating profile:', error);
        alert('Error updating profile');
        isLoading.value = false;
      });
  };
  
  // Delete account
  const deleteAccount = () => {
    if (confirm('Are you sure you want to delete your account?')) {
      axios
        .delete(`/api/users/${user.value.id}`)
        .then(() => {
          alert('Account deleted successfully');
          router.push('/login'); // Redirect to login page after deletion
        })
        .catch((error) => {
          console.error('Error deleting account:', error);
          alert('Error deleting account');
        });
    }
  };
  </script>
  
  <style scoped>
  /* Add any additional styling if needed */
  </style>
  