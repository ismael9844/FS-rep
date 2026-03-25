<template>
  <Header/>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
    <!-- Hero Header avec video background -->
    <div class="relative bg-gradient-to-r from-indigo-600 via-blue-600 to-indigo-700 text-white overflow-hidden">
      <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23fff%22%20fill-opacity%3D%220.4%22%3E%3Ccircle%20cx%3D%2230%22%20cy%3D%2230%22%20r%3D%222%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
      </div>
      
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="flex items-center mb-4">
          <button 
            @click="goBack" 
            class="mr-4 p-2 sm:p-3 rounded-full hover:bg-white/20 transition-all duration-200 flex items-center justify-center"
            aria-label="Retour"
          >
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
          </button>
          <div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold">Schedule Pickup</h1>
            <p class="text-blue-100 text-sm sm:text-base mt-1">Organize your food donation pickup</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content - Full Width Layout -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-12">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
        
        <!-- Left Column: Donation Info (Sidebar on desktop, top on mobile) -->
        <div class="lg:col-span-1 space-y-6">
          
          <!-- Donation Card -->
          <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-emerald-500 to-green-600 p-4 sm:p-6 text-white">
              <h2 class="text-lg sm:text-xl font-bold flex items-center">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                </svg>
                Donation Details
              </h2>
            </div>
            
            <div class="p-4 sm:p-6 space-y-4">
              <div class="flex items-start space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                  <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                  </svg>
                </div>
                <div class="flex-1">
                  <p class="text-xs sm:text-sm text-gray-500 font-medium">Category</p>
                  <p class="text-base sm:text-lg font-semibold text-gray-900">{{ donation.category }}</p>
                </div>
              </div>

              <div class="flex items-start space-x-3">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                  <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                  </svg>
                </div>
                <div class="flex-1">
                  <p class="text-xs sm:text-sm text-gray-500 font-medium">Portions</p>
                  <p class="text-base sm:text-lg font-semibold text-gray-900">{{ donation.quantity }} servings</p>
                </div>
              </div>

              <div class="flex items-start space-x-3">
                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                  <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                  </svg>
                </div>
                <div class="flex-1">
                  <p class="text-xs sm:text-sm text-gray-500 font-medium">Donor</p>
                  <p class="text-base sm:text-lg font-semibold text-gray-900">{{ donation.user.name }}</p>
                </div>
              </div>

              <div class="flex items-start space-x-3">
                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                  <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                  </svg>
                </div>
                <div class="flex-1">
                  <p class="text-xs sm:text-sm text-gray-500 font-medium">Location</p>
                  <p class="text-base sm:text-lg font-semibold text-gray-900">{{ donation.city || 'Not specified' }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Warning Message -->
          <div v-if="showQuantityError" class="bg-red-50 border-2 border-red-200 rounded-2xl p-4 sm:p-6">
            <div class="flex items-start space-x-3">
              <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
              </div>
              <div>
                <h3 class="text-sm sm:text-base font-semibold text-red-800 mb-1">Quantity Limit Exceeded</h3>
                <p class="text-xs sm:text-sm text-red-700">
                  As a recipient, you can only collect donations of 5 portions maximum.
                </p>
              </div>
            </div>
          </div>

          <!-- Info Card -->
          <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-4 sm:p-6">
            <div class="flex items-start space-x-3">
              <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <div>
                <h3 class="text-sm sm:text-base font-semibold text-blue-800 mb-2">What happens next?</h3>
                <ul class="text-xs sm:text-sm text-blue-700 space-y-2">
                  <li class="flex items-start">
                    <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Both you and the donor will receive confirmation emails</span>
                  </li>
                  <li class="flex items-start">
                    <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>The donor will confirm the pickup via email link</span>
                  </li>
                  <li class="flex items-start">
                    <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Once confirmed, you will be notified via email</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Column: Pickup Form (Main content) -->
        <div class="lg:col-span-2">
          <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-indigo-500 to-blue-600 p-4 sm:p-6 text-white">
              <h2 class="text-lg sm:text-xl font-bold flex items-center">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Pickup Information
              </h2>
              <p class="text-blue-100 text-xs sm:text-sm mt-1">Fill in the details for your pickup</p>
            </div>

            <form @submit.prevent="submit" class="p-4 sm:p-6 lg:p-8 space-y-6">
              
              <!-- Date & Time -->
              <div class="space-y-3">
                <label class="block text-sm sm:text-base font-semibold text-gray-700 flex items-center">
                  <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                  Pickup Date & Time
                </label>
                <input 
                  type="datetime-local" 
                  v-model="form.scheduled_at"
                  class="w-full border-2 border-gray-200 rounded-xl p-3 sm:p-4 text-sm sm:text-base focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200" 
                  required 
                  :min="minDateTime"
                />
                <p class="text-xs sm:text-sm text-gray-500 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  Choose a convenient time for both parties
                </p>
              </div>

              <!-- Notes -->
              <div class="space-y-3">
                <label class="block text-sm sm:text-base font-semibold text-gray-700 flex items-center">
                  <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                  </svg>
                  Additional Notes
                  <span class="ml-2 text-xs text-gray-500 font-normal">(Optional)</span>
                </label>
                <textarea 
                  v-model="form.notes" 
                  rows="4"
                  placeholder="Add any special instructions, questions, or contact info..."
                  class="w-full border-2 border-gray-200 rounded-xl p-3 sm:p-4 text-sm sm:text-base focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 resize-none"
                ></textarea>
              </div>

              <!-- Action Buttons -->
              <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 pt-4">
                <button 
                  type="button"
                  @click="goBack"
                  class="order-2 sm:order-1 flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 sm:py-4 rounded-xl font-medium transition-all duration-200 flex items-center justify-center text-sm sm:text-base"
                >
                  <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                  Cancel
                </button>
                
                <button 
                  type="submit"
                  :disabled="isSubmitDisabled"
                  :class="[
                    'order-1 sm:order-2 flex-1 py-3 sm:py-4 rounded-xl font-medium transition-all duration-200 flex items-center justify-center text-sm sm:text-base',
                    isSubmitDisabled 
                      ? 'bg-gray-300 text-gray-500 cursor-not-allowed' 
                      : 'bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white shadow-lg hover:shadow-xl transform hover:scale-[1.02]'
                  ]"
                >
                  <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                  </svg>
                  {{ form.processing ? 'Scheduling...' : 'Schedule Pickup' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { computed, onMounted } from 'vue'
import Header from '@/Components/Header.vue'

const props = defineProps({
  donation: Object,
  user: Object,
  auth: Object
})

const form = useForm({
  donation_id: props.donation.id,
  scheduled_at: '',
  notes: ''
})

const currentUser = computed(() => props.user || props.auth?.user)
const isReceiver = computed(() => currentUser.value?.role === 'receiver')
const showQuantityError = computed(() => 
  isReceiver.value && props.donation.quantity > 5
)

const isSubmitDisabled = computed(() => 
  form.processing || showQuantityError.value
)

const minDateTime = computed(() => {
  const now = new Date()
  now.setMinutes(now.getMinutes() - now.getTimezoneOffset())
  return now.toISOString().slice(0, 16)
})

const goBack = () => {
  if (window.history.length > 1) {
    window.history.back()
  } else {
    window.location.href = '/donations'
  }
}

const submit = () => {
  if (showQuantityError.value) {
    return
  }
  form.post('/pickups')
}

onMounted(() => {
  const defaultDate = new Date()
  defaultDate.setHours(defaultDate.getHours() + 2)
  defaultDate.setMinutes(0, 0, 0)
  form.scheduled_at = defaultDate.toISOString().slice(0, 16)
})
</script>

<style scoped>
/* Smooth transitions */
* {
  transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
  transition-duration: 200ms;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}
</style>