<template>
  <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-green-100">
    
    <Header/>

    <div class="max-w-4xl mx-auto py-10 px-4">
      <h1 class="text-3xl font-bold mb-6 text-gray-800">All Food Requests</h1>
      
      <div v-if="requests.length" class="space-y-4">
        <div
          v-for="r in requests"
          :key="r.id"
          class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition"
        >
          <h2 class="text-xl font-semibold">{{ r.title }}</h2>
          <p class="text-gray-600 mb-2">{{ r.description }}</p>
          <p class="text-sm text-gray-500">
            Needed before: {{ formatDate(r.needed_before) }}
          </p>
          <Link
            :href="`/food-requests/${r.id}`"
            class="mt-3 inline-block text-emerald-600 hover:underline"
          >
            View Request
          </Link>
        </div>
      </div>

      <p v-else class="text-gray-500">No food requests at the moment.</p>
    </div>

  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'

const props = defineProps({ requests: [Array, Object] })

const formatDate = (dt) => {
  if (!dt) return ''
  return new Date(dt).toLocaleString('en-GB', {
    day: 'numeric', month: 'short', year: 'numeric',
    hour: '2-digit', minute: '2-digit'
  })
}
</script>