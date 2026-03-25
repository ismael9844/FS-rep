<template>
  <Header/>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">My Pickups</h1>
        <p class="mt-2 text-gray-600">Manage your scheduled food pickups</p>
      </div>

      <!-- Success Message -->
      <div v-if="$page.props.flash?.success" class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
          </svg>
          <p class="text-green-700 font-medium">{{ $page.props.flash.success }}</p>
        </div>
      </div>

      <!-- Pickups List -->
      <div v-if="pickups.data && pickups.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="pickup in pickups.data"
          :key="pickup.id"
          class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-all"
        >
          <div class="p-6">
            <!-- Status Badge -->
            <div class="flex items-center justify-between mb-4">
              <span
                :class="{
                  'bg-yellow-100 text-yellow-800': pickup.status === 'pending',
                  'bg-green-100 text-green-800': pickup.status === 'confirmed',
                  'bg-red-100 text-red-800': pickup.status === 'cancelled'
                }"
                class="px-3 py-1 rounded-full text-xs font-semibold uppercase"
              >
                {{ pickup.status }}
              </span>
            </div>

            <!-- Donation Info -->
            <h3 class="text-lg font-bold text-gray-900 mb-2">
              {{ pickup.donation.category }}
            </h3>
            <p class="text-sm text-gray-600 mb-4">
              {{ pickup.donation.quantity }} portions
            </p>

            <!-- Donor Info -->
            <div class="flex items-center mb-4 text-sm text-gray-700">
              <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
              Donor: {{ pickup.donation.user.name }}
            </div>

            <!-- Scheduled Time -->
            <div class="flex items-center mb-4 text-sm text-gray-700">
              <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
              {{ formatDate(pickup.scheduled_at) }}
            </div>

            <!-- Notes -->
            <div v-if="pickup.notes" class="mt-4 p-3 bg-gray-50 rounded-lg">
              <p class="text-sm text-gray-600">{{ pickup.notes }}</p>
            </div>
          </div>

          <!-- Actions -->
          <div v-if="pickup.status === 'pending'" class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <p class="text-xs text-gray-500 text-center">
              Awaiting donor confirmation
            </p>
          </div>
          <div v-else-if="pickup.status === 'confirmed'" class="bg-green-50 px-6 py-4 border-t border-green-200">
            <p class="text-xs text-green-700 text-center font-medium">
              ✓ Confirmed - Be ready for pickup!
            </p>
              <!-- AJOUTER CE BOUTON ↓ -->
  <a 
    v-if="pickup.donation.latitude && pickup.donation.longitude"
    :href="getGoogleMapsUrl(pickup.donation)"
    target="_blank"
    class="block w-full px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-medium text-center transition-all flex items-center justify-center"
  >
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
    </svg>
    Get Directions
  </a>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="text-center py-16">
        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
          <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">No pickups yet</h3>
        <p class="text-gray-600 mb-6">Schedule a pickup to get started</p>
        <a
          href="/dashboard"
          class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-blue-600 text-white rounded-xl font-medium hover:from-indigo-600 hover:to-blue-700 transition-all"
        >
          Browse Donations
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
import Header from '@/Components/Header.vue'

const props = defineProps({
  pickups: Object
})

const formatDate = (dateStr) => {
  const date = new Date(dateStr)
  return date.toLocaleString('en-US', {
    weekday: 'short',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}
const getGoogleMapsUrl = (donation) => {
  if (donation.latitude && donation.longitude) {
    // Si l'utilisateur a une localisation, créer un itinéraire
    // Sinon, juste montrer la destination
    return `https://www.google.com/maps/dir/?api=1&destination=${donation.latitude},${donation.longitude}`
  }
  // Fallback : recherche par adresse
  return `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(donation.city || donation.address || 'Pickup location')}`
}
</script>