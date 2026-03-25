<template>
  <div class="flex flex-col min-h-screen relative bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
    
    <!-- Vidéo de fond -->
    <div id="video-container" class="fixed inset-0 z-0">
      <video 
        id="background-video"
        autoplay 
        muted 
        loop 
        playsinline
        class="w-full h-full object-cover transition-opacity duration-500"
        style="opacity: 1;"
      >
        <source src="/vid2.mp4" type="video/mp4">
        <source src="/vid.webm" type="video/webm">
      </video>
      <div class="absolute inset-0 bg-black/20"></div>
    </div>

    <!-- Texture SVG -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23e5e7eb%22%20fill-opacity%3D%220.1%22%3E%3Ccircle%20cx%3D%2230%22%20cy%3D%2230%22%20r%3D%224%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30 z-0"></div>

    <!-- Halo décoratif -->
    <div class="absolute top-0 right-0 w-64 h-64 sm:w-96 sm:h-96 bg-gradient-to-br from-emerald-50/30 to-green-50/30 rounded-full blur-3xl z-0"></div>

    <!-- Header Component -->
    <Header />

    <!-- Sponsors Section -->
    <section class="my-6 sm:my-10 relative z-20 px-4">
      <h2 class="text-xl sm:text-2xl font-bold mb-4 text-center text-white drop-shadow-lg">
        Our Sponsors
      </h2>
      <div class="max-w-screen-md mx-auto">
        <img
          :src="currentImage"
          :alt="`Sponsor ${currentIndex + 1}`"
          class="w-full max-h-32 sm:max-h-48 object-contain"
          @error="handleImageError"
        />
      </div>
    </section>

    <!-- CONTENU PRINCIPAL -->
    <div class="flex-grow relative z-10 w-full">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-8 relative z-10">

        <!-- Stats Dashboard - Responsive Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8 sm:mb-12">
          <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200">
            <div class="flex items-center justify-between mb-4 sm:mb-6">
              <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
              </div>
              <div class="text-right">
                <div class="text-2xl sm:text-3xl font-bold text-gray-800 mb-1">{{ donations.length }}</div>
                <div class="text-xs sm:text-sm text-gray-500">Available</div>
              </div>
            </div>
            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
              <div class="h-full bg-gradient-to-r from-emerald-400 to-green-500 rounded-full" style="width: 100%"></div>
            </div>
            <p class="text-gray-600 mt-3 text-xs sm:text-sm">Active donations</p>
          </div>

          <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200">
            <div class="flex items-center justify-between mb-4 sm:mb-6">
              <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
              </div>
              <div class="text-right">
                <div class="text-2xl sm:text-3xl font-bold text-gray-800 mb-1">{{ totalPortions }}</div>
                <div class="text-xs sm:text-sm text-gray-500">Servings</div>
              </div>
            </div>
            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
              <div class="h-full bg-gradient-to-r from-blue-400 to-blue-500 rounded-full" style="width: 100%"></div>
            </div>
            <p class="text-gray-600 mt-3 text-xs sm:text-sm">Total available meals</p>
          </div>

          <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 sm:col-span-2 lg:col-span-1">
            <div class="flex items-center justify-between mb-4 sm:mb-6">
              <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-orange-400 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div class="text-right">
                <div class="text-2xl sm:text-3xl font-bold text-gray-800 mb-1">{{ expiringSoon }}</div>
                <div class="text-xs sm:text-sm text-gray-500">Urgent</div>
              </div>
            </div>
            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
              <div class="h-full bg-gradient-to-r from-orange-400 to-red-500 rounded-full" style="width: 100%"></div>
            </div>
            <p class="text-gray-600 mt-3 text-xs sm:text-sm">Expires within 24h</p>
          </div>
        </div>

        <!-- All Donations Section -->
        <div class="bg-white p-4 sm:p-8 rounded-2xl shadow-lg border border-gray-200 mb-8">
          <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 gap-4">
            <div class="flex items-center">
              <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center mr-3 sm:mr-4 shadow-lg">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682
                           a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318
                           a4.5 4.5 0 00-6.364 0z" />
                </svg>
              </div>
              <h3 class="text-xl sm:text-2xl font-bold text-gray-800">All Donations</h3>
            </div>

            <div class="flex space-x-2 w-full sm:w-auto">
              <button 
                @click="filterType = 'all'; currentPage = 1"
                :class="filterType === 'all'
                  ? 'bg-gradient-to-r from-emerald-500 to-green-500 text-white'
                  : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                class="flex-1 sm:flex-none px-4 py-2 rounded-xl font-medium transition-all duration-300 border border-gray-200 text-sm sm:text-base"
              >
                All
              </button>
              <button 
                @click="filterType = 'urgent'; currentPage = 1"
                :class="filterType === 'urgent'
                  ? 'bg-gradient-to-r from-emerald-500 to-green-500 text-white'
                  : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                class="flex-1 sm:flex-none px-4 py-2 rounded-xl font-medium transition-all duration-300 border border-gray-200 text-sm sm:text-base"
              >
                Urgent
              </button>
            </div>
          </div>

          <!-- Donations Grid - Responsive -->
          <div v-if="paginatedDonations.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div
              v-for="donation in paginatedDonations"
              :key="donation.id"
              class="bg-gray-50 p-4 sm:p-6 rounded-2xl hover:bg-gray-100 transition-all duration-300 border border-gray-200 cursor-pointer transform hover:scale-105"
              @click="selectDonation(donation)"
            >
              <div class="flex items-center justify-between mb-4">
                <span class="px-3 py-1 bg-gradient-to-r from-emerald-500 to-green-500 text-white text-xs sm:text-sm font-medium rounded-full">
                  {{ donation.food_type || donation.category }}
                </span>
                <span v-if="isExpiringSoon(donation)" class="px-2 sm:px-3 py-1 bg-red-100 text-red-600 text-xs font-medium rounded-full animate-pulse">
                  Urgent
                </span>
              </div>

              <div class="mb-4">
                <div class="flex items-center mb-2">
                  <div class="text-xl sm:text-2xl font-bold text-gray-800">{{ donation.quantity }}</div>
                  <div class="text-sm sm:text-base text-gray-500 ml-2">servings</div>
                </div>
                <div class="text-base sm:text-lg font-semibold text-gray-700">{{ donation.title }}</div>
              </div>

              <div class="space-y-2 mb-4 sm:mb-6">
                <div class="flex items-center text-xs sm:text-sm text-gray-600">
                  <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  <span>City: {{ donation.city }}</span>
                </div>
                <div class="flex items-center text-xs sm:text-sm text-gray-600">
                  <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>Until {{ formatDate(donation.available_until) }}</span>
                </div>
              </div>

              <Link
                :href="`/donations/${donation.id}`"
                class="block w-full px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-emerald-500 to-green-500
                       text-white text-center rounded-xl hover:from-emerald-600 hover:to-green-600
                       transition-all duration-300 font-medium text-sm sm:text-base"
              >
                View Details
              </Link>
            </div>
          </div>

          <!-- Pagination Controls -->
          <div v-if="totalPages > 1" class="mt-6 sm:mt-8 flex justify-center items-center space-x-4">
            <button
              @click="prevPage"
              :disabled="currentPage === 1"
              class="px-3 sm:px-4 py-2 rounded-lg border disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 transition-colors text-sm sm:text-base"
            >
              ← Previous
            </button>
            <span class="text-sm sm:text-base text-gray-700">Page {{ currentPage }} / {{ totalPages }}</span>
            <button
              @click="nextPage"
              :disabled="currentPage === totalPages"
              class="px-3 sm:px-4 py-2 rounded-lg border disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 transition-colors text-sm sm:text-base"
            >
              Next →
            </button>
          </div>

          <!-- Empty State -->
          <div v-else-if="!filteredDonations.length" class="text-center py-12 sm:py-16">
            <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-4 sm:mb-6 bg-gray-100 rounded-full flex items-center justify-center">
              <svg class="w-10 h-10 sm:w-12 sm:h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0
                         01-2-2V5a2 2 0 012-2h5.586a1 1 0
                         01.707.293l5.414 5.414a1 1 0
                         01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2">No donations found</h3>
            <p class="text-sm sm:text-base text-gray-600 mb-6 sm:mb-8 max-w-md mx-auto px-4">
              {{ filterType === 'urgent'
                ? 'No urgent donations in your area at the moment.'
                : 'No donations found near you at the moment.'
              }}
            </p>
            <button
              @click="refreshDonations"
              class="px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-emerald-500 to-green-500 text-white rounded-xl
                     hover:from-emerald-600 hover:to-green-600 transition-all duration-300 font-medium flex items-center mx-auto text-sm sm:text-base"
            >
              <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 4v5h.582m15.356 2A8.001 8.001 0
                         004.582 9m0 0H9m11 11v-5h-.581m0
                         0a8.003 8.003 0 01-15.357-2m15.357
                         2H15" />
              </svg>
              Refresh
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- FOOTER - Full Width -->
    <footer class="relative bg-gray-900 text-gray-200 py-6 sm:py-10 mt-auto w-full z-10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 sm:gap-6">
          <div class="text-center md:text-left">
            <h4 class="text-base sm:text-lg font-bold mb-2">Contact</h4>
            <p class="text-sm sm:text-base">Email: <a href="mailto:isadiak98us@gmail.com" class="underline hover:text-emerald-400">contact@foodshare.com</a></p>
          </div>
          <div class="text-center md:text-right">
            <p class="text-sm sm:text-base">&copy; 2025 FoodShare. All rights reserved.</p>
            <p class="text-sm sm:text-base"> Ismael Abba Diakite</p>
            <p class="text-sm sm:text-base">
              <!--<a href="/privacy" class="underline hover:text-emerald-400">Privacy Policy</a> &middot;
            <a href="/terms" class="underline hover:text-emerald-400">Terms of Service</a>-->
            </p>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'

const props = defineProps({
  user: Object,
  donations: Array,
  matchedDonations: Array,
  sponsorsByLevel: Object,
  sponsors: Array,
})

const images = ref([
  //'/final.png', 
  '/final2.png',
  //'/final4.png', 

])
const currentIndex = ref(0)
const currentImage = ref('')
let interval = null

const nextImage = () => {
  currentIndex.value = (currentIndex.value + 1) % images.value.length
  currentImage.value = images.value[currentIndex.value]
}

const handleImageError = () => {
  console.log('Erreur de chargement pour:', currentImage.value)
}

onMounted(() => {
  if (images.value.length > 0) {
    currentImage.value = images.value[0]
    interval = setInterval(nextImage, 3000)
  }
  router.reload({ only: ['matchedDonations'] })
})

watch(() => props.user.preference, () => {
  router.reload({ only: ['matchedDonations'] })
})

onUnmounted(() => {
  if (interval) {
    clearInterval(interval)
  }
})

// Pagination
const currentPage = ref(1)
const perPage = 6
const totalPages = computed(() => Math.ceil(filteredDonations.value.length / perPage))
const paginatedDonations = computed(() => {
  const start = (currentPage.value - 1) * perPage
  return filteredDonations.value.slice(start, start + perPage)
})

const filterType = ref('all')

function prevPage() {
  if (currentPage.value > 1) currentPage.value--
}

function nextPage() {
  if (currentPage.value < totalPages.value) currentPage.value++
}

const totalPortions = computed(() => {
  return props.donations?.reduce((sum, d) => sum + d.quantity, 0) || 0
})

const expiringSoon = computed(() => {
  const now = new Date()
  const nextDay = new Date(now)
  nextDay.setDate(now.getDate() + 1)
  return props.donations?.filter(d => new Date(d.available_until) <= nextDay).length || 0
})

function formatDate(dateStr) {
  const date = new Date(dateStr)
  return date.toLocaleDateString('fr-FR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const filteredDonations = computed(() => {
  if (!props.donations) return []
  if (filterType.value === 'urgent') {
    const now = new Date()
    const nextDay = new Date(now)
    nextDay.setDate(now.getDate() + 1)
    return props.donations.filter(d => new Date(d.available_until) <= nextDay)
  }
  return props.donations
})

function isExpiringSoon(donation) {
  if (!donation?.available_until) return false
  const now = new Date()
  const nextDay = new Date(now)
  nextDay.setDate(now.getDate() + 1)
  return new Date(donation.available_until) <= nextDay
}

function selectDonation(donation) {
  console.log('Selected donation:', donation)
}

function refreshDonations() {
  router.reload()
}
</script>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>