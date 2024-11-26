<template>
    <div class="lg:container mx-auto mt-10 p-4">
      <div class="bg-white shadow-md rounded-md p-6">
        <!-- Profile Header -->
        <div class="flex items-center justify-between mb-6">
          <div class="flex items-center">
            <!-- User Avatar -->
            <!-- <img :src="filelink(user.avatar || 'default.jpeg')" alt="User Avatar" class="w-24 h-24 rounded-full border-2 border-blue-300"> -->
            <div class="ml-4">
              <h2 class="text-2xl font-semibold">Mirshod</h2>
              <p class="text-sm text-gray-600">mirshod@gmail</p>
            </div>
          </div>
          <button @click="editProfile" class="bg-blue-500 text-white px-4 py-2 rounded-md">Edit Profile</button>
        </div>
  
        <!-- Profile Information -->
        <div v-if="!isEditing">
          <div class="mb-4">
            <label class="text-sm font-medium text-gray-700">Name</label>
            <p class="text-lg">{{ }}</p>
          </div>
          <div class="mb-4">
            <label class="text-sm font-medium text-gray-700">Email</label>
            <p class="text-lg">{{  }}</p>
          </div>
          <div class="mb-4">
            <label class="text-sm font-medium text-gray-700">Joined</label>
            <!-- <p class="text-lg">{{ | formatDate }}</p> -->
          </div>
        </div>
  
        <!-- Edit Profile Form -->
        <div v-else>
          <div class="mb-4">
            <label for="name" class="text-sm font-medium text-gray-700">Name</label>
            <input type="text" v-model="editableUser.name" id="name" class="w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="mb-4">
            <label for="email" class="text-sm font-medium text-gray-700">Email</label>
            <input type="email" v-model="editableUser.email" id="email" class="w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="mb-4">
            <label for="avatar" class="text-sm font-medium text-gray-700">Profile Image</label>
            <input type="file" @change="uploadAvatar" id="avatar" class="w-full p-2 border border-gray-300 rounded-md">
          </div>
          <button @click="saveProfile" class="bg-green-500 text-white px-4 py-2 rounded-md">Save Changes</button>
          <button @click="cancelEdit" class="bg-gray-500 text-white px-4 py-2 rounded-md ml-2">Cancel</button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  import axios from 'axios';
  
  // Props
  const props = defineProps({
    user: { type: Object, required: true }
  });
  
  const isEditing = ref(false);
  const editableUser = ref({ ...props.user });
  
  const editProfile = () => {
    isEditing.value = true;
  };
  
  const cancelEdit = () => {
    editableUser.value = { ...props.user }; // Reset changes
    isEditing.value = false;
  };
  
  const saveProfile = () => {
    // Save the edited profile information
    axios.post('/api/profile', editableUser.value)
      .then(response => {
        props.user = { ...editableUser.value }; // Update the original user data
        isEditing.value = false;
      })
      .catch(error => {
        console.error("Error saving profile:", error);
      });
  };
  
  const uploadAvatar = (event) => {
    const file = event.target.files[0];
    if (file) {
      const formData = new FormData();
      formData.append('avatar', file);
      
      axios.post('/api/upload-avatar', formData)
        .then(response => {
          editableUser.value.avatar = response.data.avatar; // Update avatar path
        })
        .catch(error => {
          console.error("Error uploading avatar:", error);
        });
    }
  };
  
  // Format Date Helper
  const formatDate = (date) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(date).toLocaleDateString(undefined, options);
  };
  
  // Computed property for image path
  const filelink = (file) => `/assets/images/${file}`;
  </script>
  
  <style scoped>
  /* Custom styles for the profile page */
  </style>
  