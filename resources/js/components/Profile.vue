<template>
  <div class="profile">
    <h1>Foydalanuvchi Profil</h1>
    <div v-if="user">
      <p><strong>Ism:</strong> {{ user.name }}</p>
      <p><strong>Email:</strong> {{ user.email }}</p>
      <p><strong>Telefon:</strong> {{ user.phone }}</p>
    </div>
    <div v-else>
      <p>Foydalanuvchi ma'lumotlari mavjud emas.</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: null, // foydalanuvchi ma'lumotlari
    };
  },
  created() {
    // Bu yerda foydalanuvchi ma'lumotlarini olish
    this.fetchUserProfile();
  },
  methods: {
    fetchUserProfile() {
      // API chaqirig'ini bajarish
      // Hozirgi vaqt uchun, oddiy namunani yaratamiz
      this.user = {
        name: 'Mirshod',
        email: 'mirshod@example.com',
        phone: '+998901234567',
      };
    },
  },
};
</script>

<style scoped>
.profile {
  padding: 20px;
}

.profile h1 {
  font-size: 24px;
}

.profile p {
  font-size: 18px;
  margin: 5px 0;
}
</style>
