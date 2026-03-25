<template>
  <Header/>
  <div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 flex items-center justify-center p-4">
    <div class="max-w-2xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
      <!-- Success Header -->
      <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-8 sm:p-12 text-center">
        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
          <svg class="w-12 h-12 sm:w-16 sm:h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">Pickup Confirmed!</h1>
        <p class="text-green-100 text-sm sm:text-base">Thank you for confirming the pickup</p>
      </div>

      <!-- Content -->
      <div class="p-6 sm:p-8 lg:p-12">
        <div class="text-center mb-8">
          <p class="text-lg sm:text-xl text-gray-700 mb-4">
            {{ message }}
          </p>
          <p class="text-sm sm:text-base text-gray-600">
            The donation has been successfully removed from the site to prevent duplicate pickups.
          </p>
        </div>

        <!-- Pickup Details -->
        <div class="bg-gray-50 rounded-xl p-4 sm:p-6 mb-6">
          <h2 class="font-semibold text-gray-800 mb-4 flex items-center text-base sm:text-lg">
            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Pickup Details
          </h2>
          
          <div class="space-y-3">
            <div class="flex flex-col sm:flex-row sm:items-center">
              <span class="font-medium text-gray-700 mb-1 sm:mb-0 sm:min-w-32 text-sm sm:text-base">Donation:</span>
              <span class="text-gray-900 text-sm sm:text-base">{{ pickup.donation.category }} ({{ pickup.donation.quantity }} portions)</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center">
              <span class="font-medium text-gray-700 mb-1 sm:mb-0 sm:min-w-32 text-sm sm:text-base">Recipient:</span>
              <span class="text-gray-900 text-sm sm:text-base">{{ pickup.user.name }}</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center">
              <span class="font-medium text-gray-700 mb-1 sm:mb-0 sm:min-w-32 text-sm sm:text-base">Scheduled:</span>
              <span class="text-gray-900 text-sm sm:text-base">{{ formatDate(pickup.scheduled_at) }}</span>
            </div>
            <div v-if="pickup.notes" class="flex flex-col sm:flex-row sm:items-start">
              <span class="font-medium text-gray-700 mb-1 sm:mb-0 sm:min-w-32 text-sm sm:text-base">Notes:</span>
              <span class="text-gray-900 text-sm sm:text-base">{{ pickup.notes }}</span>
            </div>
          </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 sm:p-6 rounded-lg mb-6">
          <h3 class="font-semibold text-blue-900 mb-3 flex items-center text-sm sm:text-base">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            What's Next?
          </h3>
          <ul class="space-y-2 text-blue-800 text-sm sm:text-base">
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
              </svg>
              <span>The recipient has been notified of your confirmation</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
              </svg>
              <span>Please be available at the scheduled time</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
              </svg>
              <span>Thank you for helping reduce food waste!</span>
            </li>
          </ul>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
          <a 
            href="/dashboard" 
            class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white py-3 sm:py-4 rounded-xl font-medium transition-all duration-200 flex items-center justify-center text-sm sm:text-base shadow-lg hover:shadow-xl"
          >
            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Go to Dashboard
          </a>
          
          <a 
            href="/my-donations" 
            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 sm:py-4 rounded-xl font-medium transition-all duration-200 flex items-center justify-center text-sm sm:text-base"
          >
            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            My Donations
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Header from '@/Components/Header.vue'

const props = defineProps({
  pickup: Object,
  message: String
})

const formatDate = (dateStr) => {
  const date = new Date(dateStr)
  return date.toLocaleString('en-US', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}
</script>