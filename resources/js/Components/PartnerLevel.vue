<template>
  <div class="my-4">
    <h3 class="font-semibold">Your Partner Level</h3>
    <p v-if="partner">Current Level: {{ partner.level }}</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const partner = ref(null)

onMounted(async () => {
  const response = await axios.get('/api/partner/me')
  partner.value = response.data
})
</script>
