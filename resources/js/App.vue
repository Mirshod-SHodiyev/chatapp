<template>
  <div class="bg-white border border-gray-300 fixed top-0 w-full shadow">
    <div class="lg:container mx-auto p-4">
      <div class="grid grid-cols-3 gap-4">
        <div class="col-span-1 min-w-[250px]">
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <img :src="filelink('default.jpeg')" alt="User Avatar" class="w-12 h-10 rounded-full border-2 border-blue-300">
              <span class="font-semibold text-xl pl-1">{{ auth.name }}</span>
            </div>
            <div class="relative inline-block text-left">
              <three-dots-icon class="w-6 h-6 cursor-pointer" @click="toggleDropdown"></three-dots-icon>
              <div v-if="isDropdownOpen" class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                <div class="py-1">
                  <a href="/my-profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 cursor-pointer" @click="openProfile">Profile</a>
                  <a href="logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 cursor-pointer" @click="logout">Logout</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-span-2 text-right">
          <button class="bg-red-500 text-white px-4 py-2 rounded-md" @click="logout">Logout</button>
        </div>
      </div>
    </div>
  </div>

  <div class="lg:container mx-auto mt-[90px] px-4 mb-4">
    <div class="grid grid-cols-3 gap-4">
      <div class="col-span-1 min-w-[300px] bg-white p-4 shadow-md rounded-md">
        <input type="text" placeholder="Search" class="w-full p-2 rounded-md border border-gray-300 focus:outline-none focus:ring focus:border-blue-400 mb-4">
        <div class="max-h-96 overflow-y-auto">
          <div v-for="user in users" :key="user.id" @click="selectUser(user)" class="flex items-center mb-3 cursor-pointer rounded-md p-2 hover:bg-gray-100">
            <div class="relative">
              <img :src="filelink('default.jpeg')" alt="User Avatar" class="w-12 h-10 rounded-full border-2 border-blue-300">
              <div class="absolute top-0 left-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
            </div>
            <div class="ml-4">
              <p class="font-semibold">{{ user.name }}</p>
              <p class="text-sm text-gray-500">Hello</p>
            </div>
          </div>
        </div>
      </div>

      <div class="col-span-2 bg-stone-50 p-4 shadow-md rounded-md">
        <div v-if="isChatOpen">
          <div class="flex items-center justify-between mb-4 bg-slate-200 px-4 pt-4 pb-2 rounded-tl-md rounded-tr-md">
            <div class="flex items-center">
              <img :src="filelink('default.jpeg')" alt="User Avatar" class="w-12 h-10 rounded-full border-2 border-blue-300">
              <div>
                <p class="font-semibold">{{ user.name }}</p>
                <p class="text-sm text-gray-500">Hello</p>
              </div>
            </div>
            <div class="relative inline-block text-left group">
              <three-dots-icon class="w-6 h-6 cursor-pointer"></three-dots-icon>
              <div class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 hidden group-hover:block">
                <div class="py-1">
                  <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 cursor-pointer">Close Chat</a>
                  <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 cursor-pointer">Clear Chat</a>
                </div>
              </div>
            </div>
          </div>
             
          <div class="overflow-y-auto max-h-64 h-[19rem] px-4">
            <div 

              v-for="message in messages" 
              :key="messages.id" 
              :class="{ 'justify-end': message.sender_id === auth.id }" 
              class="flex items-center mb-4"
            >
              <!-- Foydalanuvchi xabari (chapda) -->
              <img 
                v-if="message.sender_id !== auth.id" 
                :src="filelink('default.jpeg')" 
                alt="User Avatar" 
                class="w-6 h-6 rounded-full border-2 border-white mr-2"
              >
              <div 
                :class="{ 
                  'bg-white': message.sender_id === auth.id, 
                  'bg-indigo-100': message.sender_id !== auth.id 
                }" 
                class="text-sm py-2 px-4 shadow rounded-md max-w-xs"
              >
                <p>{{ message.message }}</p>
                <div class="text-right text-xs text-gray-500">{{ message.time }}</div>
              </div>
          
              <img 
                v-if="message.sender_id === auth.id" 
                :src="filelink('default.jpeg')" 
                alt="User Avatar" 
                class="w-6 h-6 rounded-full border-2 border-white ml-2"
              >
            </div>
          </div>

          <div  class="flex items-center bg-white rounded-bl-md rounded-br-md">
            <input type="text" v-model="newMessage" @keyup.enter.prevent="sendMessage" placeholder="Type a message..." class="w-full p-2 rounded-md border border-gray-300 focus:outline-none focus:ring focus:border-blue-400">
            <button :disabled="!newMessage.trim()" @click="sendMessage" class="bg-blue-500 text-white px-4 py-2 rounded-md disabled:bg-gray-400 ml-2">Send</button>
          </div>
        </div>
        <div v-else class="flex items-center justify-center min-h-[19rem]">
          <img :src="filelink('najot.png')" alt="">
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>

import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import ThreeDotsIcon from './components/ThreeDotsIcon.vue';

const props = defineProps({
  user: { type: Object, required: true },
  auth: { type: Object, required: true }
});

const isDropdownOpen = ref(false);

const toggleDropdown = () => { isDropdownOpen.value = !isDropdownOpen.value; };
const openProfile = () => { router.push('/my-profile'); };

const isChatOpen = ref(false);
const users = ref([]);
const user = ref({});
const messages = ref([]);
const newMessage = ref("");

onMounted(() => {
  axios.get('/api/users').then(response => {
    users.value = response.data.users;
  })
  window.Echo.private('room.1')
    .listen('GotMessage', (event) => {
        console.log('New message:', event.message);
        messages.value.push(event.message); 
    });
});

const fetchMessages = (userId) => {
  axios.get(`/api/messages/${userId}`).then(response => {
    messages.value = response.data;
  }).catch(error => { console.error("Xabarlarni olishda xatolik:", error); });
};



const selectUser = (selectedUser) => {
  user.value = selectedUser;
  isChatOpen.value = true;
  fetchMessages(selectedUser.id);
};


const sendMessage = () => {
  
  if (newMessage.value.trim()) {
    
    axios
      .post('/api/messages', {
        sender_id: props.auth.id, 
        receiver_id: user.value.id, 
        message: newMessage.value, 
      })
      .then((response) => {
      
        messages.value.push(response.data);
        newMessage.value = '';
      })
  }
};

const filelink = (file) => `/assets/images/${file}`;
const router = useRouter();

function logout() {
    axios.post('/logout') 
        .then(() => {
            window.location.href = '/login'; 
        })
        .catch(error => {
            console.error('Logout failed:', error); 
        });
}

</script>

<style scoped>


</style>
