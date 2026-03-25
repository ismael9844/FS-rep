<template>
  <div class="my-4">
    <h3 class="font-semibold">Expiring Donations</h3>
    <ul>
      <li v-for="item in expiring" :key="item.id">
        {{ item.food_type }} - expires on {{ item.expiration_date }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const expiring = ref([])

onMounted(async () => {
  const response = await axios.get('/api/donations/expiring')
  expiring.value = response.data
})
</script>
