<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-blue-50">
    <Header />

    <!-- CONTENU PRINCIPAL -->
    <div class="pt-24 pb-16 px-4">
      <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-12">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl mb-4 animate-bounce-slow">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
          </div>
          <h1 class="text-5xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-4">
            Your Preferences
          </h1>
          <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Set up your filters to receive donations that match your needs perfectly
          </p>
        </div>

        <!-- Preferences Form -->
        <div class="bg-white/60 backdrop-blur-lg rounded-3xl shadow-xl border border-white/20 p-8 mb-12">
          <form @submit.prevent="submit" class="space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
              <!-- Categories -->
              <div class="space-y-2">
                <label class="flex items-center space-x-2 text-gray-700 font-semibold text-lg">
                  <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                  </svg>
                  <span>Preferred Categories</span>
                </label>
                <select 
                  v-model="form.preferred_categories" 
                  multiple
                  class="w-full mt-2 p-4 bg-white/80 border-2 border-gray-200 rounded-2xl focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-200 min-h-[120px]">
                  <option v-for="opt in categories" :key="opt" :value="opt" class="p-2">{{ opt }}</option>
                </select>
                <p class="text-sm text-gray-500">Hold Ctrl/Cmd to select multiple categories</p>
              </div>

              <!-- Min Quantity -->
              <div class="space-y-2">
                <label class="flex items-center space-x-2 text-gray-700 font-semibold text-lg">
                  <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                  </svg>
                  <span>Minimum Quantity</span>
                </label>
                <input 
                  type="number" 
                  v-model="form.min_quantity" 
                  min="1"
                  class="w-full mt-2 p-4 bg-white/80 border-2 border-gray-200 rounded-2xl focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-200 text-lg" 
                />
              </div>

              <!-- Max Distance 
              <div class="space-y-2">
                <label class="flex items-center space-x-2 text-gray-700 font-semibold text-lg">
                  <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                  </svg>
                  <span>Maximum Distance (km)</span>
                </label>
                <input 
                  type="number" 
                  v-model="form.max_distance" 
                  min="1"
                  class="w-full mt-2 p-4 bg-white/80 border-2 border-gray-200 rounded-2xl focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-200 text-lg" 
                />
              </div>-->

              
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 pt-8 border-t border-gray-200">
              <button 
                type="button" 
                @click="remove" 
                v-if="hasPreferences"
                class="px-8 py-4 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-2xl hover:from-red-600 hover:to-red-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                <span class="flex items-center space-x-2">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                  </svg>
                  <span>Delete</span>
                </span>
              </button>
              <button 
                type="submit"
                class="px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-2xl hover:from-green-600 hover:to-emerald-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                <span class="flex items-center space-x-2">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                  </svg>
                  <span>{{ hasPreferences ? 'Update' : 'Save' }}</span>
                </span>
              </button>
            </div>
          </form>
        </div>

        <!-- Matched Donations -->
        <div v-if="matched.length" class="mb-12">
          <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Matched Donations</h2>
            <p class="text-gray-600">{{ matched.length }} donation(s) match your criteria</p>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            <div 
              v-for="donation in matched" 
              :key="donation.id"
              class="group bg-white/60 backdrop-blur-lg rounded-3xl shadow-lg border border-white/20 p-8 transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 cursor-pointer relative overflow-hidden"
              @click="viewDonation(donation.id)">
              
              <!-- Gradient d'arrière-plan animé -->
              <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-blue-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
              
              <!-- Card Header -->
              <div class="flex items-center justify-between mb-6 relative z-10">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200">
                  {{ donation.category || 'Other' }}
                </span>
                <span 
                  v-if="isExpiringSoon(donation)"
                  class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-red-100 to-orange-100 text-red-800 border border-red-200 animate-pulse">
                  🚨 Urgent
                </span>
              </div>
              
              <!-- Quantity -->
              <div class="mb-6 flex items-center relative z-10">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mr-4">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                  </svg>
                </div>
                <div>
                  <span class="text-3xl font-bold text-gray-800">{{ donation.quantity }}</span>
                  <span class="text-gray-600 ml-2 text-lg">{{ donation.unit }}</span>
                </div>
              </div>
              
              <!-- Information -->
              <div class="space-y-3 text-gray-600 relative z-10">
                <div class="flex items-center">
                  <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  <span class="font-medium">Until {{ formatDate(donation.available_until) }}</span>
                </div>
              </div>-600 relative z-10">
                <div class="flex items-center">
                  <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  <span class="font-medium">Jusqu'au {{ formatDate(donation.available_until) }}</span>
                </div>
              </div>

              <!-- Indicateur de hover -->
              <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
              </div>
            </div>
          </div>
        

        <!-- Message vide -->
        <div v-else class="text-center py-16">
          <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
          </div>
          <h3 class="text-2xl font-semibold text-gray-600 mb-2">No match found</h3>
          <p class="text-gray-500">Add your preferences to see matched donation</p>
        </div>
      </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-200 py-10 mt-8 z-10">
      <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="text-center md:text-left">
          <h4 class="text-lg font-bold mb-2">Contact</h4>
          <p>Email: <a href="mailto:contact@foodshare.com" class="underline hover:text-emerald-400">contact@foodshare.com</a></p>
          <p>Phone: <a href="tel:+1234567890" class="underline hover:text-emerald-400">+1 234 567 890</a></p>
        </div>
        <div class="text-center md:text-right">
          <p>&copy; 2025 FoodShare. All rights reserved.</p>
          <p>
            <a href="/privacy" class="underline hover:text-emerald-400">Privacy Policy</a> &middot;
            <a href="/terms" class="underline hover:text-emerald-400">Terms of Service</a>
          </p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { reactive, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'
import Header from '@/Components/Header.vue'


const props = defineProps({
  preferences: Object,
  categories: Array,
  matched: Array
})

const form = useForm({
  preferred_categories: props.preferences?.preferred_categories || [],
  min_quantity: props.preferences?.min_quantity || 1,
  max_distance: props.preferences?.max_distance || 10,
  available_from: props.preferences?.available_from || '',
  available_until: props.preferences?.available_until || '',
})

const hasPreferences = !!props.preferences

const submit = () => {
  if (hasPreferences) {
    form.patch(`/preferences/${props.preferences.id}`)
  } else {
    form.post('/preferences')
  }
}

const remove = () => {
  Inertia.delete(`/preferences/${props.preferences.id}`)
}

const goBack = () => {
  window.history.back()
}

const formatDate = dt => new Date(dt).toLocaleString('fr-FR', {
  month: 'short', 
  day: 'numeric', 
  hour: '2-digit', 
  minute: '2-digit'
})

const isExpiringSoon = d => new Date(d.available_until) <= new Date(Date.now() + 86400000)

const viewDonation = id => Inertia.visit(`/donations/${id}`)
</script>

<style scoped>
@keyframes bounce-slow {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
}

.animate-bounce-slow {
  animation: bounce-slow 3s ease-in-out infinite;
}

/* Effet de glassmorphisme */
.backdrop-blur-lg {
  backdrop-filter: blur(16px);
}

/* Animation personnalisée pour les cartes */
@keyframes card-hover {
  0% { transform: translateY(0) scale(1); }
  100% { transform: translateY(-8px) scale(1.02); }
}

.group:hover {
  animation: card-hover 0.3s ease-out forwards;
}

/* Scrollbar personnalisée */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #10b981, #059669);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(to bottom, #059669, #047857);
}
</style>