<template>
  <div>
    <h2 class="text-xl font-bold mb-4">Requests for {{ place.title }}</h2>

    <div v-for="req in place.requests" :key="req.id" class="border p-4 rounded mb-2">
      <p><strong>User:</strong> {{ req.user.name }}</p>
      <p><strong>Message:</strong> {{ req.message }}</p>
      <p><strong>Status:</strong> {{ req.status }}</p>

      <div v-if="isOwner">
        <button @click="updateStatus(req.id, 'approved')" class="px-3 py-1 bg-green-500 text-white rounded mr-2">Approve</button>
        <button @click="updateStatus(req.id, 'rejected')" class="px-3 py-1 bg-red-500 text-white rounded">Reject</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  place: Object,
  isOwner: Boolean
})

function updateStatus(requestId, status) {
  router.put(`/requests/${requestId}`, { status }, {
    onSuccess: () => alert('Status updated!')
  })
}
</script>
