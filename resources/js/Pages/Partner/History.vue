<template>
  <div class="min-h-screen bg-gradient-to-br from-yellow-50 to-green-50 p-6">
    <div class="max-w-6xl mx-auto">
      <h1 class="text-3xl font-bold text-gray-800 mb-6">Your Donation History</h1>
      <div v-if="donations.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="don in donations"
          :key="don.id"
          class="bg-white rounded-xl shadow hover:shadow-lg transition p-6"
        >
          <h2 class="text-xl font-semibold mb-2">{{ don.title }}</h2>
          <p class="text-gray-600 mb-1">{{ don.description }}</p>
          <p class="text-sm text-gray-700 mb-1">Qty: {{ don.quantity }} {{ don.unit }}</p>
          <p class="text-sm text-gray-700 mb-1">Date: {{ formatDate(don.created_at) }}</p>
        </div>
      </div>
      <div v-else class="text-center text-gray-500 py-10">
        <p>You have no donation history yet.</p>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  donations: Array
})

const formatDate = (dt) =>
  new Date(dt).toLocaleString('en-US', {
    day: 'numeric', month: 'short', year: 'numeric'
  })
</script>
