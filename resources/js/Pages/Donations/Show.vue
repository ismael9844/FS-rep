<template>
  <!-- Conteneur parent en relative pour positionner le bg en absolute -->
  <div class="relative min-h-screen overflow-hidden">
    <img
  src="/textured.png"
  alt="Impact Background"
  class="fixed inset-0 w-full h-full object-cover opacity-40 pointer-events-none select-none"
  style="z-index: -1;"
/>
    <Header />
    <!-- L'arrière‑plan avec overlay -->
    <div class="absolute inset-0">

      <!-- Overlay gradient pour améliorer la lisibilité -->
      <div class="absolute inset-0 bg-gradient-to-br from-green-900/20 via-emerald-800/30 to-teal-700/40"></div>
      <!-- Fade bottom effect -->
      <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-green-50/80 to-transparent"></div>
    </div>

    <!-- Main content -->
    <div class="relative z-10 min-h-screen flex items-center justify-center p-4 md:p-6">
      <div class="w-full max-w-5xl">
        <!-- Header breadcrumb -->
        <div class="mb-8 text-center">


        </div>

        <!-- Carte principale -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden border border-green-100/50">
          <!-- Header de la carte -->
          <div class="bg-gradient-to-r from-green-500 to-emerald-500 p-6 text-white">
            <div class="flex items-center justify-between">
              <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">
                  {{ donation.food_type }} Donation
                </h1>
                <p class="text-green-100 text-lg">
                  Help distribute food to those in need
                </p>
              </div>
              <div class="hidden md:block">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                  <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <!-- Contenu principal -->
          <div class="p-6 md:p-8">
            <!-- Informations du donateur -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 mb-8 border border-green-100">
              <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4">
                  <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                  </svg>
                </div>
                <div>
                  <h2 class="text-xl font-bold text-gray-800">Donor Information</h2>
                  <p class="text-gray-600">Provided by a generous community member</p>
                </div>
              </div>
              
              <div class="grid md:grid-cols-2 gap-4">
                <div class="bg-white/80 rounded-lg p-4">
                  <p class="text-sm text-gray-500 mb-1">Donor Name</p>
                  <p class="font-semibold text-gray-800 text-lg">{{ donation.user.name }}</p>
                </div>
                <div class="bg-white/80 rounded-lg p-4">
                  <p class="text-sm text-gray-500 mb-1">Food Type</p>
                  <p class="font-semibold text-gray-800 text-lg">{{ donation.category}}</p>
                </div>
              </div>
            </div>

            <!-- Détails de la donation -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
              <!-- Quantité -->
              <div class="bg-white rounded-xl p-6 shadow-lg border border-green-100 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                  <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                  </div>
                  <span class="text-2xl font-bold text-green-600">{{ donation.quantity }}</span>
                </div>
                <h3 class="font-semibold text-gray-800 mb-1">Quantity</h3>
                <p class="text-gray-600 text-sm">Portions available</p>
              </div>

              <!-- Date de début -->
              <div class="bg-white rounded-xl p-6 shadow-lg border border-green-100 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                  <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                  </div>
                  <span class="text-xs bg-emerald-100 text-emerald-800 px-2 py-1 rounded-full font-medium">Available</span>
                </div>
                <h3 class="font-semibold text-gray-800 mb-1">Available From</h3>
                <p class="text-gray-600 text-sm">{{ formatDate(donation.available_from) }}</p>
              </div>

              <!-- Date de fin -->
              <div class="bg-white rounded-xl p-6 shadow-lg border border-green-100 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                  <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                  </div>
                  <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full font-medium">Expires</span>
                </div>
                <h3 class="font-semibold text-gray-800 mb-1">Available Until</h3>
                <p class="text-gray-600 text-sm">{{ formatDate(donation.available_until) }}</p>
              </div>
            </div>

            <!-- Description -->
            <div class="bg-gradient-to-r from-teal-50 to-green-50 rounded-xl p-6 mb-8 border border-teal-100">
              <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-teal-500 rounded-full flex items-center justify-center mr-3">
                  <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                  </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Description</h2>
              </div>
              <p class="text-gray-700 leading-relaxed bg-white/60 rounded-lg p-4">
                {{ donation.description }}
              </p>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row gap-4">
<button
  :disabled="props.donation.need_volunteers === 0"
  @click="goToVolunteerPage"
  class="group flex-1 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white px-6 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-xl flex items-center justify-center"
  :class="props.donation.need_volunteers === 0 ? 'opacity-60 cursor-not-allowed hover:scale-100 hover:shadow-none' : ''"
>
  <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
  </svg>
  {{ props.donation.need_volunteers > 0 ? 'Volunteer for Distribution' : 'No Volunteers Needed' }}
</button>

              
              <button
                @click="goToPickupForm"
                class="group flex-1 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-white px-6 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-xl flex items-center justify-center"
              >
                <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
                Schedule Pickup
              </button>
            </div>

            <!-- Informations supplémentaires -->
            <div class="mt-8 bg-green-50 rounded-xl p-6 border border-green-200">
              <div class="flex items-center mb-3">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <h3 class="font-semibold text-green-800">Important Information</h3>
              </div>
              <ul class="text-sm text-green-700 space-y-1">
                <li>• Please ensure food safety guidelines are followed during pickup and distribution</li>
                <li>• Add a note if you have any questions about the donation</li>
                <li>• Volunteers will be notified of pickup location and time details</li>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import { defineProps } from 'vue'
import Header from '@/Components/Header.vue'


const goBack = () => {
  window.history.length > 1 ? window.history.back() : window.location.href = '/dashboard'
}
const props = defineProps({
  donation: Object,
})

// Helpers
const formatDate = (dateStr) => {
  const date = new Date(dateStr)
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const volunteerForDistribution = () => {
  router.post(`/volunteer/${props.donation.id}`, {}, {
    onSuccess: () => {
      showNotification('Thank you for volunteering! You will be contacted with details.', 'success')
    },
    onError: () => {
      showNotification('Something went wrong. Please try again.', 'error')
    }
  })
}

const goToPickupForm = () => {
  router.visit(`/pickups/create?donation_id=${props.donation.id}`)
}

function goToVolunteerPage() {
  if (props.donation.need_volunteers > 0) {
    router.visit('/volunteer/needs')
  }
}

// Enhanced notification system
function showNotification(message, type = 'info') {
  const notification = document.createElement('div')
  notification.className = `fixed top-4 right-4 z-50 max-w-sm p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${
    type === 'success' ? 'bg-green-500 text-white' : 
    type === 'error' ? 'bg-red-500 text-white' : 
    'bg-blue-500 text-white'
  }`
  notification.innerHTML = `
    <div class="flex items-center">
      <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
        ${type === 'success' ? 
          '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>' :
          '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>'
        }
      </svg>
      <span class="font-medium">${message}</span>
    </div>
  `
  
  document.body.appendChild(notification)
  
  setTimeout(() => {
    notification.classList.remove('translate-x-full')
  }, 100)
  
  setTimeout(() => {
    notification.classList.add('translate-x-full')
    setTimeout(() => {
      document.body.removeChild(notification)
    }, 300)
  }, 3000)
}
</script>

<style scoped>
/* Animation pour les cartes */
@keyframes slideInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.bg-white {
  animation: slideInUp 0.6s ease-out;
}

/* Effets de hover personnalisés */
.hover\:shadow-xl:hover {
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Scrollbar personnalisée */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
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