<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-green-50 py-4 sm:py-8 px-4">
    <div class="max-w-2xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-6 sm:mb-8">
        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 sm:w-10 sm:h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 mb-2">Accept Place Request</h1>
        <p class="text-sm sm:text-base text-slate-600">Schedule the visit for {{ placeRequest.user.name }}</p>
      </div>

      <!-- Request Info Card -->
      <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-4 sm:p-6 mb-6">
        <h3 class="font-bold text-lg sm:text-xl text-slate-800 mb-4">📍 {{ place.title }}</h3>
        
        <div class="space-y-3 text-sm sm:text-base">
          <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <div>
              <p class="font-semibold text-slate-700">Requested by</p>
              <p class="text-slate-600">{{ placeRequest.user.name }}</p>
              <p class="text-slate-500 text-xs sm:text-sm">{{ placeRequest.user.email }}</p>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
            <div>
              <p class="font-semibold text-slate-700">Message</p>
              <p class="text-slate-600">{{ placeRequest.message }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Accept Form -->
      <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-4 sm:p-6">
        <form @submit.prevent="submit">
          <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              Schedule Date & Time <span class="text-red-500">*</span>
            </label>
            <input 
              v-model="form.scheduled_date" 
              type="datetime-local"
              :min="minDateTime"
              required
              class="w-full border border-slate-200 rounded-xl px-3 sm:px-4 py-2 sm:py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm sm:text-base"
            />
            <p class="text-xs sm:text-sm text-slate-500 mt-2">When should {{ placeRequest.user.name }} visit?</p>
          </div>

          <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              Additional Note <span class="text-slate-500 font-normal">(optional)</span>
            </label>
            <textarea 
              v-model="form.partner_note"
              rows="4"
              placeholder="Any special instructions..."
              class="w-full border border-slate-200 rounded-xl px-3 sm:px-4 py-2 sm:py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all resize-none text-sm sm:text-base"
            ></textarea>
          </div>

          <div class="flex flex-col sm:flex-row gap-3">
            <button 
              type="button"
              @click="router.visit(`/places/${place.id}`)"
              class="px-6 py-3 border-2 border-slate-200 text-slate-600 rounded-xl font-semibold hover:bg-slate-50 transition-all"
            >
              Cancel
            </button>
            
            <button 
              type="submit"
              :disabled="form.processing"
              class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold py-3 px-6 rounded-xl transition-all shadow-sm hover:shadow-md disabled:opacity-50 flex items-center justify-center gap-2"
            >
              <span>{{ form.processing ? 'Accepting...' : '✓ Accept & Notify' }}</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useForm, router } from '@inertiajs/vue3'

const props = defineProps({
  placeRequest: Object,
  place: Object
})

const form = useForm({
  scheduled_date: '',
  partner_note: ''
})

const minDateTime = computed(() => {
  const now = new Date()
  now.setMinutes(now.getMinutes() - now.getTimezoneOffset())
  return now.toISOString().slice(0, 16)
})

function submit() {
  const token = window.location.pathname.split('/').pop()
  form.post(`/place-requests/accept/${token}`)
}
</script>