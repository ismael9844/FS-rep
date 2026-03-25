<template>
  <div class="min-h-screen relative overflow-hidden">
    <!-- Background Video Section -->
    <div class="fixed inset-0 z-0">
      <video 
        class="w-full h-full object-cover opacity-90"
        autoplay 
        muted 
        loop
        playsinline
      >
        <source src="/vid2.mp4" type="video/mp4">
        <!-- Fallback gradient if video fails -->
      </video>
    </div>
    <Header/>
      
    <!-- Main Content -->
    <div class="relative z-20 min-h-screen">
      <div class="container mx-auto px-4 py-8">

        <!-- Header Section -->
        <div class="text-center mb-12">
          <div class="inline-block bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg px-8 py-6 mb-6">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-green-500 bg-clip-text text-transparent mb-2">
              Donations Needing Volunteers
            </h1>
            <p class="text-gray-600 text-lg">
              Help make a difference in your community
            </p>
          </div>
        </div>


        <!-- Donations Grid -->
        <div v-if="donations.length" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          <div
            v-for="donation in donations"
            :key="donation.id"
            class="group bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-emerald-100/50"
          >
            <!-- Card Header -->
           <div class="relative p-6 pb-4">
              
              <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                  <h2 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-emerald-600 transition-colors">
                    {{ donation.title }}
                  </h2>
                  <p class="text-gray-600 text-sm leading-relaxed">
                    {{ donation.description }}
                  </p>
                </div>
                
                <button
                  @click="copyLink(donation.id)"
                  class="ml-4 p-2 rounded-full bg-emerald-100 hover:bg-emerald-200 text-emerald-600 hover:text-emerald-700 transition-all duration-200 group/btn"
                  title="Copy shareable link"
                >
                  <svg class="w-4 h-4 group-hover/btn:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M12.232 4.232a2.5 2.5 0 013.536 3.536l-1.225 1.224a.75.75 0 001.061 1.06l1.224-1.224a4 4 0 00-5.656-5.656l-3 3a4 4 0 00.225 5.865.75.75 0 00.977-1.138 2.5 2.5 0 01-.142-3.667l3-3z"/>
                    <path d="M11.603 7.963a.75.75 0 00-.977 1.138 2.5 2.5 0 01.142 3.667l-3 3a2.5 2.5 0 01-3.536-3.536l1.225-1.224a.75.75 0 00-1.061-1.06l-1.224 1.224a4 4 0 105.656 5.656l3-3a4 4 0 00-.225-5.865z"/>
                  </svg>
                </button>
              </div>
            </div>

            <!-- Card Body -->
            <div class="px-6 pb-4">
              <!-- Info Pills -->
              <div class="flex flex-wrap gap-2 mb-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                  <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                  </svg>
                  {{ donation.quantity }} {{ donation.unit }}
                </span>
                
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                  <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                  </svg>
                  {{ formatDate(donation.available_until) }}
                </span>
                
                <span v-if="donation.city" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                  <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                  </svg>
                  {{ donation.city }}
                </span>
              </div>

              <!-- Volunteers Info -->
              <div class="bg-gradient-to-r from-emerald-50 to-green-50 rounded-lg p-4 mb-4">
                <div class="flex items-center justify-between mb-2">
                  <span class="text-sm font-semibold text-gray-700">Volunteers Needed</span>
                  <span class="text-lg font-bold text-emerald-600">
                    {{ donation.need_volunteers - donation.volunteers_count }}
                  </span>
                </div>
                
                <div class="flex items-center text-xs text-gray-500">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                  </svg>
                  {{ donation.volunteers_count }} already signed up
                </div>

                <!-- Progress Bar -->
                <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                  <div 
                    class="bg-gradient-to-r from-emerald-500 to-green-400 h-2 rounded-full transition-all duration-300"
                    :style="{ width: `${Math.min((donation.volunteers_count / donation.need_volunteers) * 100, 100)}%` }"
                  ></div>
                </div>
              </div>

              <!-- Volunteer Note -->
              <div v-if="donation.volunteer_note" class="bg-amber-50 border border-amber-200 rounded-lg p-3 mb-4">
                <div class="flex items-start">
                  <svg class="w-4 h-4 text-amber-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                  </svg>
                  <div>
                    <p class="text-sm font-medium text-amber-800 mb-1">Special Note:</p>
                    <p class="text-sm text-amber-700">{{ donation.volunteer_note }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card Footer - LOGIQUE CORRIGÉE -->
            <div class="px-6 pb-6">

              <!-- 1. Déjà volontaire pour cette donation -->
              <button
                v-if="donation.is_volunteered"
                class="w-full bg-gradient-to-r from-gray-100 to-gray-200 text-gray-500 cursor-not-allowed px-4 py-3 rounded-lg font-medium transition-all duration-200 flex items-center justify-center shadow-sm"
                disabled
              >
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                Already Volunteered
              </button>

              <!-- 2. Pas de profil volontaire -->
              <button
                v-else-if="!hasVolunteerProfile"
                @click="() => router.visit('/volunteer/complete-profile')"
                class="w-full px-4 py-3 rounded-lg font-medium flex items-center justify-center transition-all duration-200 shadow-md bg-gradient-to-r from-amber-400 to-orange-400 hover:from-amber-500 hover:to-orange-500 text-white"
              >
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Complete Your Profile First
              </button>

              <!-- 3. Profil en attente -->
              <button
                v-else-if="verificationStatus === 'pending'"
                class="w-full px-4 py-3 rounded-lg font-medium flex items-center justify-center transition-all duration-200 shadow-md bg-gray-100 text-gray-700 cursor-not-allowed"
                @click="() => showNotification('Your volunteer profile is under review. Please wait for approval.', 'info')"
                disabled
              >
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M13 16h-2v-2h2v2zm0-4h-2V6h2v6zM2 10a8 8 0 1016 0 8 8 0 00-16 0z" clip-rule="evenodd"/>
                </svg>
                Verification Pending
              </button>

              <!-- 4. Profil rejeté -->
              <button
                v-else-if="verificationStatus === 'suspended'"
                @click="() => { router.visit('/volunteer/edit'); showNotification('Your documents were rejected — please update them.', 'error') }"
                class="w-full px-4 py-3 rounded-lg font-medium flex items-center justify-center transition-all duration-200 shadow-md bg-red-500 text-white hover:bg-red-600"
              >
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9h2v5H9V9zM9 6h2v2H9V6z" clip-rule="evenodd"/>
                </svg>
                Verification Needed — Update Documents
              </button>

              <!-- 5. Profil approuvé - PEUT FAIRE DU VOLONTARIAT -->
              <button
                v-else-if="verificationStatus === 'approved'"
                @click="handleVolunteer(donation.id)"
                class="w-full px-4 py-3 rounded-lg font-medium flex items-center justify-center transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-600 hover:to-green-600 text-white"
              >
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Volunteer for this Donation
              </button>

              <!-- 6. Cas par défaut (ne devrait pas arriver) -->
              <button
                v-else
                class="w-full px-4 py-3 rounded-lg font-medium flex items-center justify-center transition-all duration-200 shadow-md bg-gray-300 text-gray-600 cursor-not-allowed"
                disabled
              >
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Cannot Volunteer (Status: {{ verificationStatus }})
              </button>
            </div>

          </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-20">
          <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-12 max-w-md mx-auto">
            <div class="w-20 h-20 bg-gradient-to-br from-emerald-100 to-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
              <svg class="w-10 h-10 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">No Volunteers Needed</h3>
            <p class="text-gray-600">
              There are no donations currently in need of volunteers. Check back later!
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Notification Container -->
    <div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2"></div>
  </div>
</template>

<script setup>
import { usePage, router } from '@inertiajs/vue3'
import { computed } from 'vue'
import Header from '@/Components/Header.vue'

// Props provenant du parent (liste de donations, etc.)
const props = defineProps({
  donations: Array,
  hasVolunteerProfile: Boolean,
  volunteer: Object,
})

// Accès aux props Inertia / auth
const page = usePage()

// Volunteer profile : extrait depuis auth.user (si présent)
const volunteerProfile = computed(() => page.props?.auth?.user?.volunteer ?? null)

// hasVolunteerProfile : priorise la prop envoyée par le parent, sinon dérive du volunteerProfile
const hasVolunteerProfile = computed(() => {
  // Priorité 1: prop directe du parent
  if (typeof props.hasVolunteerProfile === 'boolean') {
    return props.hasVolunteerProfile
  }
  
  // Priorité 2: depuis props.volunteer
  if (props.volunteer?.id) {
    return true
  }
  
  // Priorité 3: depuis page.props.auth.user.volunteer
  if (volunteerProfile.value?.id) {
    return true
  }
  
  return false
})

// verificationStatus : 'approved' | 'pending' | 'rejected' | 'not_submitted'
const verificationStatus = computed(() => {
  // Priorité 1: depuis props.volunteer
  if (props.volunteer?.verification_status) {
    return props.volunteer.verification_status
  }
  
  // Priorité 2: depuis page.props.auth.user.volunteer
  if (volunteerProfile.value?.verification_status) {
    return volunteerProfile.value.verification_status
  }
  
  return 'not_submitted'
})

// Computed pour savoir si l'utilisateur peut faire du volontariat
const canVolunteer = computed(() => {
  return hasVolunteerProfile.value && verificationStatus.value === 'approved'
})

// Fonction pour postuler comme volunteer
function handleVolunteer(donationId) {
  // Vérifications de sécurité
  if (!hasVolunteerProfile.value) {
    showNotification('Please complete your volunteer profile before applying.', 'info')
    return router.visit('/volunteer/complete-profile')
  }

  if (verificationStatus.value === 'pending') {
    showNotification('Your volunteer profile is under review. You cannot volunteer yet.', 'error')
    return
  }

  if (verificationStatus.value === 'rejected') {
    showNotification('Your documents were rejected. Please update them to be able to volunteer.', 'error')
    return router.visit('/volunteer/edit')
  }

  if (verificationStatus.value !== 'approved') {
    showNotification('You are not allowed to volunteer yet.', 'error')
    return
  }

  // Envoi de la demande de volontariat
  router.post(`/volunteer/${donationId}`, {}, {
    preserveScroll: true,
    onSuccess: () => {
      // Mise à jour locale de la donation (UX)
      const donation = props.donations.find(d => d.id === donationId)
      if (donation) {
        donation.is_volunteered = true
        donation.volunteers_count = (donation.volunteers_count || 0) + 1
      }
      showNotification('Thank you! The donor has been notified.', 'success')
    },
    onError: (errors) => {
      console.error('volunteer error', errors)
      showNotification('An error occurred. Please try again.', 'error')
    }
  })
}

// Helpers : format date, copyLink (inchangés)
const formatDate = dt => new Date(dt).toLocaleDateString('en-US', {
  year: 'numeric',
  month: 'short',
  day: 'numeric',
  hour: '2-digit',
  minute: '2-digit'
})

function copyLink(id) {
  const url = `${window.location.origin}/donations/${id}`
  navigator.clipboard.writeText(url).then(() => {
    showNotification('Link copied to clipboard!', 'info')
  }).catch(() => {
    showNotification('Failed to copy link', 'error')
  })
}

// Notification visual
function showNotification(message, type = 'info') {
  const container = document.getElementById('notification-container')
  if (!container) return

  const notification = document.createElement('div')
  notification.className = `transform transition-all duration-500 translate-x-full opacity-0 max-w-sm p-4 rounded-xl shadow-2xl backdrop-blur-sm border ${
    type === 'success' ? 'bg-emerald-500/90 text-white border-emerald-400/50' :
    type === 'error' ? 'bg-red-500/90 text-white border-red-400/50' :
    'bg-blue-500/90 text-white border-blue-400/50'
  }`

  notification.innerHTML = `
    <div class="flex items-center">
      <div class="flex-shrink-0">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          ${type === 'success' ?
            '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>' :
            type === 'error' ?
            '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>' :
            '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>'
          }
        </svg>
      </div>
      <div class="ml-3">
        <span class="font-medium text-sm">${message}</span>
      </div>
      <button class="ml-4 text-white/70 hover:text-white transition-colors" onclick="this.parentElement.parentElement.parentElement.remove()">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
        </svg>
      </button>
    </div>
  `

  container.appendChild(notification)
  setTimeout(() => notification.classList.remove('translate-x-full', 'opacity-0'), 100)
  setTimeout(() => {
    if (notification.parentNode) {
      notification.classList.add('translate-x-full', 'opacity-0')
      setTimeout(() => notification.parentNode && notification.parentNode.removeChild(notification), 500)
    }
  }, 5000)
}
</script>

<style scoped>
/* Custom scrollbar with improved styling */
::-webkit-scrollbar {
  width: 10px;
}

::-webkit-scrollbar-track {
  background: rgba(241, 245, 249, 0.5);
  border-radius: 6px;
  backdrop-filter: blur(10px);
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #34d399, #6ee7b7);
  border-radius: 6px;
  border: 2px solid rgba(255, 255, 255, 0.2);
}

::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(to bottom, #10b981, #34d399);
}

/* Enhanced animations */
@keyframes slideInFromRight {
  from {
    transform: translateX(100%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

@keyframes slideOutToRight {
  from {
    transform: translateX(0);
    opacity: 1;
  }
  to {
    transform: translateX(100%);
    opacity: 0;
  }
}

/* Smooth hover effects */
.group:hover .group-hover\:scale-110 {
  transform: scale(1.1);
}

/* Glass morphism effect enhancement */
.backdrop-blur-sm {
  backdrop-filter: blur(12px);
}

/* Button press effect */
button:active {
  transform: scale(0.98);
}

/* Loading state for buttons */
button:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}
</style>