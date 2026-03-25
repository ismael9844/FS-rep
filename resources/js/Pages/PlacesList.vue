<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-green-50 py-4 sm:py-8 px-4">
    <Header/>
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-8 sm:mb-12">
        <h1 class="text-3xl sm:text-4xl font-bold text-slate-800 mb-2">Available Places</h1>
        <p class="text-sm sm:text-lg text-slate-600">Discover and book amazing locations</p>
      </div>

      <!-- Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        <div 
          v-for="place in places" 
          :key="place.id" 
          class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-slate-100 hover:border-green-200"
        >
          <!-- Images Carousel -->
          <div class="relative h-48 bg-slate-100 overflow-hidden">
            <div 
              v-if="place.photos && place.photos.length > 0" 
              class="flex gap-1 h-full"
            >
              <img
                v-for="(photo, index) in place.photos.slice(0, 3)"
                :key="photo.id"
                :src="photo.url || photo.path"
                :class="[
                  'object-cover transition-transform duration-300 group-hover:scale-105',
                  place.photos.length === 1 ? 'w-full' : 
                  place.photos.length === 2 ? 'w-1/2' : 
                  index === 0 ? 'w-1/2' : 'w-1/4'
                ]"
                :alt="`${place.title} - Photo ${index + 1}`"
                loading="lazy"
                @error="handleImageError"
              />
              <div 
                v-if="place.photos.length > 3"
                class="w-1/4 bg-slate-900/70 flex items-center justify-center text-white font-semibold text-sm"
              >
                +{{ place.photos.length - 3 }}
              </div>
            </div>
            <div v-else class="h-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
              <svg class="w-12 sm:w-16 h-12 sm:h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            </div>
          </div>

          <!-- Content -->
          <div class="p-4 sm:p-6">
            <!-- Title -->
            <h3 class="font-bold text-lg sm:text-xl text-slate-800 mb-3 group-hover:text-green-700 transition-colors">
              {{ place.title }}
            </h3>
            
            <!-- Description -->
            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed mb-4 line-clamp-3">
              {{ place.description }}
            </p>

            <!-- Info Grid -->
            <div class="space-y-2 sm:space-y-3 mb-4 sm:mb-6">
              <div class="flex items-center gap-2 sm:gap-3">
                <div class="w-2 h-2 bg-green-500 rounded-full flex-shrink-0"></div>
                <span class="text-slate-700 text-xs sm:text-sm font-medium">Available:</span>
                <span class="text-slate-600 text-xs sm:text-sm truncate">{{ place.availability }}</span>
              </div>
              
              <div class="flex items-center gap-2 sm:gap-3">
                <div class="w-2 h-2 bg-slate-400 rounded-full flex-shrink-0"></div>
                <span class="text-slate-700 text-xs sm:text-sm font-medium">Contact:</span>
                <span class="text-slate-600 text-xs sm:text-sm truncate">{{ place.contact_info }}</span>
              </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
              <button
                @click="openRequestModal(place)"
                class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-2 sm:py-3 px-4 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center gap-2 text-sm sm:text-base"
              >
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Request
              </button>
              
              <a 
                v-if="place.google_maps_link" 
                :href="place.google_maps_link" 
                target="_blank" 
                class="flex items-center justify-center px-3 sm:px-4 py-2 sm:py-3 border-2 border-slate-200 hover:border-green-300 text-slate-600 hover:text-green-700 rounded-xl transition-all duration-200 hover:bg-green-50"
              >
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-if="!places || places.length === 0" class="text-center py-16">
        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-10 h-10 sm:w-12 sm:h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
          </svg>
        </div>
        <h3 class="text-lg sm:text-xl font-semibold text-slate-700 mb-2">No places available</h3>
        <p class="text-sm sm:text-base text-slate-500">Check back later for new locations.</p>
      </div>
    </div>

    <!-- Request Modal -->
    <Teleport to="body">
      <div 
        v-if="showRequestModal" 
        class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4"
        @click.self="closeRequestModal"
      >
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
          <!-- Modal Header -->
          <div class="sticky top-0 bg-white border-b border-slate-200 px-4 sm:px-6 py-4 flex items-center justify-between rounded-t-2xl">
            <h3 class="text-lg sm:text-xl font-bold text-slate-800">Request Place</h3>
            <button 
              @click="closeRequestModal"
              class="text-slate-400 hover:text-slate-600 transition-colors"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>

          <!-- Modal Body -->
          <form @submit.prevent="submitRequest" class="p-4 sm:p-6 space-y-4 sm:space-y-6">
            <!-- Place Info -->
            <div class="bg-green-50 border border-green-200 rounded-xl p-4">
              <h4 class="font-semibold text-slate-800 mb-2 text-sm sm:text-base">{{ selectedPlace?.title }}</h4>
              <p class="text-xs sm:text-sm text-slate-600 line-clamp-2">{{ selectedPlace?.description }}</p>
            </div>

            <!-- Message -->
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">
                Your Message <span class="text-red-500">*</span>
              </label>
              <textarea
                v-model="requestForm.message"
                rows="4"
                required
                placeholder="Why do you want to use this place? Provide details about your needs..."
                class="w-full border border-slate-200 rounded-xl px-3 sm:px-4 py-2 sm:py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all resize-none text-sm sm:text-base"
              ></textarea>
              <p class="text-xs text-slate-500 mt-2">Minimum 20 characters</p>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 sm:p-4">
              <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-xs sm:text-sm text-blue-800">
                  <p class="font-semibold mb-1">What happens next?</p>
                  <ul class="space-y-1 list-disc list-inside">
                    <li>The owner will receive your request</li>
                    <li>They'll review and respond via email</li>
                    <li>If approved, you'll get scheduling details</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-3">
              <button
                type="button"
                @click="closeRequestModal"
                class="px-4 sm:px-6 py-2 sm:py-3 border-2 border-slate-200 text-slate-600 rounded-xl font-semibold hover:bg-slate-50 transition-all text-sm sm:text-base"
              >
                Cancel
              </button>
              
              <button
                type="submit"
                :disabled="requestForm.processing || requestForm.message.length < 20"
                class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 disabled:from-slate-400 disabled:to-slate-500 text-white font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-xl transition-all shadow-sm hover:shadow-md disabled:cursor-not-allowed flex items-center justify-center gap-2 text-sm sm:text-base"
              >
                <svg v-if="requestForm.processing" class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>{{ requestForm.processing ? 'Sending...' : 'Send Request' }}</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>

    <!-- Success Toast -->
    <Teleport to="body">
      <Transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="transform translate-x-full opacity-0"
        enter-to-class="transform translate-x-0 opacity-100"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="transform translate-x-0 opacity-100"
        leave-to-class="transform translate-x-full opacity-0"
      >
        <div 
          v-if="showSuccessToast"
          class="fixed top-4 right-4 bg-green-600 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-xl shadow-lg z-50 flex items-center gap-3 max-w-sm"
        >
          <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
          </svg>
          <span class="font-medium text-sm sm:text-base">Request sent successfully!</span>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'

const props = defineProps({
  places: Array
})

const showRequestModal = ref(false)
const selectedPlace = ref(null)
const showSuccessToast = ref(false)

const requestForm = useForm({
  message: ''
})

function handleImageError(e) {
  console.error('Image failed to load:', e.target.src)
  e.target.style.display = 'none'
}

function openRequestModal(place) {
  selectedPlace.value = place
  requestForm.message = ''
  requestForm.clearErrors()
  showRequestModal.value = true
}

function closeRequestModal() {
  showRequestModal.value = false
  selectedPlace.value = null
  requestForm.reset()
}

function submitRequest() {
  if (requestForm.message.length < 20) {
    return
  }

  requestForm.post(`/places/${selectedPlace.value.id}/request`, {
    onSuccess: () => {
      closeRequestModal()
      showSuccessToast.value = true
      
      setTimeout(() => {
        showSuccessToast.value = false
      }, 3000)
    },
    onError: (errors) => {
      console.error('Request error:', errors)
    }
  })
}
</script>

<style scoped>
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>