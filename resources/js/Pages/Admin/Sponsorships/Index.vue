<template>
  <div class="p-6 max-w-7xl mx-auto">
    <Header />
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-gray-900">Sponsorship Requests</h1>
      <p class="text-gray-600 mt-2">Manage partnership sponsorship requests</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Partner
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Tier
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Requested Date
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Status
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Actions
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="request in requests" :key="request.id" class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900">
                {{ request.partner.user.name }}
              </div>
              <div class="text-sm text-gray-500">
                {{ request.partner.type }}
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                {{ request.tier?.name ?? 'Not specified' }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              {{ formatDate(request.created_at) }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span :class="getStatusClass(request.status)" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full">
                {{ formatStatus(request.status) }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
              <button
                v-if="request.status === 'pending'"
                @click="updateRequest(request.id, 'active')"
                class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors"
              >
                Accept
              </button>
              <button
                v-if="request.status === 'pending'"
                @click="updateRequest(request.id, 'cancelled')"
                class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
              >
                Reject
              </button>
              <span v-if="request.status !== 'pending'" class="text-gray-400 text-xs">
                No actions available
              </span>
            </td>
          </tr>
        </tbody>
      </table>
      
      <!-- Empty state -->
      <div v-if="!requests || requests.length === 0" class="text-center py-12">
        <div class="text-gray-400 text-lg">No sponsorship requests found</div>
        <div class="text-gray-500 text-sm mt-2">Requests will appear here when partners submit them</div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'


const { requests } = defineProps({ 
  requests: Array 
})

function updateRequest(id, status) {
  if (confirm(`Are you sure you want to ${status === 'active' ? 'accept' : 'reject'} this request?`)) {
    router.post(route('admin.sponsorships.update', id), { status }, )
  }  
}
 

function formatDate(dateString) {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

function formatStatus(status) {
  return status.charAt(0).toUpperCase() + status.slice(1)
}

function getStatusClass(status) {
  switch (status) {
    case 'pending':
      return 'bg-yellow-100 text-yellow-800'
    case 'active':
      return 'bg-green-100 text-green-800'
    case 'cancelled':
      return 'bg-red-100 text-red-800'
    default:
      return 'bg-gray-100 text-gray-800'
  }
}
</script>