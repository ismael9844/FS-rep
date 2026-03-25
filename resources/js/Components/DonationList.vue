<template>
  <div class="my-4">
    <h3 class="font-semibold">Available Donations</h3>
    <ul>
      <li v-for="donation in donations" :key="donation.id">
        {{ donation.food_type }} - {{ donation.quantity }} portions
        <span v-if="donation.partner"> (by {{ donation.partner.name }})</span>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const donations = ref([])

onMounted(async () => {
  const response = await axios.get('/api/donations')
  donations.value = response.data
})
</script>
