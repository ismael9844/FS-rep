<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 relative overflow-hidden">
    
    <!-- Background Video with Fade Effect -->
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
        <source src="/vid3.mp4" type="video/mp4">
        <source src="/vid.webm" type="video/webm">
        Votre navigateur ne supporte pas la vidéo HTML5.
      </video>
      <!-- Dark overlay for better text readability -->
      <div class="absolute inset-0 bg-black/40"></div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-xl border-b border-gray-200/50 sticky top-0 z-20 shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-4">
        <div class="flex items-center justify-between">
          <!-- Logo Section -->
          <div class="flex items-center space-x-2 sm:space-x-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-full shadow-lg bg-gradient-to-br from-emerald-400 to-green-500">
              <img src="/logo2.webp" alt="FoodShare Logo" class="w-12 h-12 sm:w-15 sm:h-15 object-contain rounded-full" />
            </div>
            <div>
              <h1 class="text-xl sm:text-2xl font-bold text-gray-800">FoodShare</h1>
            </div>
          </div>
          
          <!-- User Actions -->
          <div class="flex items-center space-x-2 sm:space-x-4">
            <!-- User Greeting (hidden on very small screens) -->
            <p v-if="user" class="hidden md:block text-sm text-gray-600">Hello, {{ user.name }}</p>
            
            <!-- Notifications -->
            <Link 
              href="/notifications"
              class="relative p-2 sm:p-3 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200"
            >
              <img src="/notif1.webp" alt="Notifications" class="w-4 h-4 sm:w-5 sm:h-5 object-contain" />
              <!-- Badge rouge (non-lu) -->
              <span 
                v-if="unreadCount > 0"
                class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full animate-pulse">
              </span>
            </Link>
            
            <!-- Profile -->
            <Link 
              href="/profile/donor"
              class="relative p-2 sm:p-3 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200"
            >
              <img src="/profile1.png" alt="Profile" class="w-4 h-4 sm:w-5 sm:h-5 object-contain" />
            </Link>
            
            <!-- Logout Button -->
            <button
              @click="handleLogout"
              class="relative p-2 sm:p-3 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200"
            >
              <img src="/logout.svg" alt="Logout" class="w-4 h-4 sm:w-5 sm:h-5 object-contain" />
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section with Centered Title -->
    <div class="relative z-10 flex items-center justify-center min-h-screen px-4">
      <div class="text-center max-w-6xl mx-auto">
        <!-- Main Hero Title -->
        <div class="mb-8 sm:mb-16">
          <h2 class="text-4xl sm:text-5xl md:text-7xl lg:text-8xl font-bold text-white mb-4 sm:mb-6 leading-tight">
            Share Food,
            <span class="text-gradient bg-gradient-to-r from-emerald-400 to-green-400 bg-clip-text text-transparent">
              Share Hope
            </span>
          </h2>
          <p class="text-lg sm:text-xl md:text-2xl lg:text-3xl text-white/90 mb-6 sm:mb-8 max-w-4xl mx-auto leading-relaxed px-4">
            Connect with your community and make a difference, one meal at a time
          </p>
          
          <!-- Features List -->
          <div class="flex flex-col sm:flex-row items-center justify-center space-y-3 sm:space-y-0 sm:space-x-4 text-white/80 mb-8 sm:mb-12 px-4">
            <div class="flex items-center">
              <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span class="text-base sm:text-lg">Zero Waste</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
              </svg>
              <span class="text-base sm:text-lg">Community Impact</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-base sm:text-lg">Real-time Matching</span>
            </div>
          </div>
        </div>

        <!-- Quick Actions - Responsive Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:flex lg:flex-wrap lg:justify-center gap-3 sm:gap-4 lg:gap-6 mb-12 sm:mb-16 px-4">
          <Link 
            as="a" 
            class="px-6 sm:px-8 lg:px-12 py-4 sm:py-5 bg-gradient-to-r from-emerald-500 to-green-500 text-white rounded-2xl hover:from-emerald-600 hover:to-green-600 transition-all duration-300 font-bold text-base sm:text-lg lg:text-xl shadow-2xl hover:shadow-3xl transform hover:scale-105 flex items-center justify-center" 
            href="/donations/create"
          >
            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Donate Food Now
          </Link>
          
          <Link 
            as="a" 
            class="px-6 sm:px-8 lg:px-12 py-4 sm:py-5 bg-white/20 backdrop-blur-lg text-white rounded-2xl hover:bg-white/30 transition-all duration-300 font-bold text-base sm:text-lg lg:text-xl shadow-2xl hover:shadow-3xl border border-white/30 flex items-center justify-center" 
            href="/dashboard"
          >
            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Explore
          </Link>
          
          <Link 
            as="a" 
            class="px-6 sm:px-8 lg:px-12 py-4 sm:py-5 bg-white/10 backdrop-blur-lg text-white rounded-2xl hover:bg-white/20 transition-all duration-300 font-bold text-base sm:text-lg lg:text-xl shadow-2xl hover:shadow-3xl border border-white/20 flex items-center justify-center" 
            href="/volunteer/needs"
          >
            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            Volunteer
          </Link>
          
          <Link 
            as="a" 
            class="px-6 sm:px-8 lg:px-12 py-4 sm:py-5 bg-white/10 backdrop-blur-lg text-white rounded-2xl hover:bg-white/20 transition-all duration-300 font-bold text-base sm:text-lg lg:text-xl shadow-2xl hover:shadow-3xl border border-white/20 flex items-center justify-center" 
            href="/requests"
          >
            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            Food Requests
          </Link>
          
          <Link 
            as="a" 
            class="px-6 sm:px-8 lg:px-12 py-4 sm:py-5 bg-white/20 backdrop-blur-lg text-white rounded-2xl hover:bg-white/30 transition-all duration-300 font-bold text-base sm:text-lg lg:text-xl shadow-2xl hover:shadow-3xl border border-white/30 flex items-center justify-center" 
            href="/donations-map"
          >
            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
            </svg>
            Map View
          </Link>
        </div>

        <!-- Scroll Indicator (hidden on mobile) -->
        <div class="hidden sm:block absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white/60 animate-bounce">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
          </svg>
        </div>
      </div>
    </div>

    <!-- Impact Statistics -->
    <div class="relative z-10 bg-white/95 backdrop-blur-xl py-12 sm:py-20">
      <img
        src="/textured.png"
        alt="Impact Background"
        class="absolute inset-0 w-full h-full object-cover opacity-40 pointer-events-none select-none"
        style="z-index:1;"
      />
      <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8 sm:mb-16">
          <h3 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-800 mb-4">Our Impact</h3>
          <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-3xl mx-auto px-4">
            Together, we're building a world where no food goes to waste and no one goes hungry
          </p>
        </div>

        <!-- Statistics Grid - Responsive -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-8 mb-8 sm:mb-16">
          <div class="text-center p-4 sm:p-8 bg-white rounded-3xl shadow-xl border border-gray-100">
            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-emerald-400 to-green-500 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
              <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
            </div>
            <div class="text-2xl sm:text-4xl font-bold text-gray-800 mb-2">{{ donations.length }}</div>
            <div class="text-xs sm:text-sm text-gray-600 uppercase tracking-wide">Active Donations</div>
          </div>

          <div class="text-center p-4 sm:p-8 bg-white rounded-3xl shadow-xl border border-gray-100">
            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-blue-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
              <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
              </svg>
            </div>
            <div class="text-2xl sm:text-4xl font-bold text-gray-800 mb-2">{{ totalPortions }}</div>
            <div class="text-xs sm:text-sm text-gray-600 uppercase tracking-wide">Meals Available</div>
          </div>

          <div class="text-center p-4 sm:p-8 bg-white rounded-3xl shadow-xl border border-gray-100">
            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-purple-400 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
              <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h4a1 1 0 011 1v5m-6 0h6"></path>
              </svg>
            </div>
            <div class="text-2xl sm:text-4xl font-bold text-gray-800 mb-2">150+</div>
            <div class="text-xs sm:text-sm text-gray-600 uppercase tracking-wide">Partner Organizations</div>
          </div>

          <div class="text-center p-4 sm:p-8 bg-white rounded-3xl shadow-xl border border-gray-100">
            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-orange-400 to-red-500 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
              <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="text-2xl sm:text-4xl font-bold text-gray-800 mb-2">{{ expiringSoon }}</div>
            <div class="text-xs sm:text-sm text-gray-600 uppercase tracking-wide">Urgent Pickups</div>
          </div>
        </div>

        <!-- Motivational Cards - Responsive Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-8">
          <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xl border border-gray-100 text-center">
            <img src="/images/OIP.jpg" alt="Share Food" class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-2xl mx-auto mb-4 sm:mb-6 shadow-lg" />
            <h4 class="text-xl sm:text-2xl font-bold text-emerald-600 mb-3 sm:mb-4">Share, Don't Waste!</h4>
            <p class="text-sm sm:text-base text-gray-700 leading-relaxed">
              Every meal shared is a step towards a stronger, caring community. Give what you can and help reduce food waste while feeding those in need.
            </p>
          </div>

          <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xl border border-gray-100 text-center">
            <img src="/img13.jpg" alt="Make a Difference" class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-2xl mx-auto mb-4 sm:mb-6 shadow-lg" />
            <h4 class="text-xl sm:text-2xl font-bold text-green-600 mb-3 sm:mb-4">Make a Difference</h4>
            <p class="text-sm sm:text-base text-gray-700 leading-relaxed">
              Your donation can turn hunger into hope. Join us in fighting food waste and supporting those in need in your community.
            </p>
          </div>

          <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xl border border-gray-100 text-center">
            <img src="/images/R.jpeg" alt="Community Impact" class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-2xl mx-auto mb-4 sm:mb-6 shadow-lg" />
            <h4 class="text-xl sm:text-2xl font-bold text-orange-500 mb-3 sm:mb-4">Be the Change</h4>
            <p class="text-sm sm:text-base text-gray-700 leading-relaxed">
              Small actions create big impact. Inspire others by donating food and spreading kindness throughout your neighborhood.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- How It Works Section -->
    <div class="bg-gray-50 py-12 sm:py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8 sm:mb-16">
          <h3 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-800 mb-4">How It Works</h3>
          <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-3xl mx-auto px-4">
            Simple steps to make a meaningful impact in your community
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
          <div class="text-center">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-emerald-400 to-green-500 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
              <span class="text-xl sm:text-2xl font-bold text-white">1</span>
            </div>
            <h4 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3 sm:mb-4">Post Your Food</h4>
            <p class="text-sm sm:text-base text-gray-600 leading-relaxed px-4">
              Share details about the food you want to donate, including quantity, location, and pickup times.
            </p>
          </div>

          <div class="text-center">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-blue-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
              <span class="text-xl sm:text-2xl font-bold text-white">2</span>
            </div>
            <h4 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3 sm:mb-4">Get Matched</h4>
            <p class="text-sm sm:text-base text-gray-600 leading-relaxed px-4">
              Our smart matching system connects you with individuals who need your donations.
            </p>
          </div>

          <div class="text-center">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-purple-400 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
              <span class="text-xl sm:text-2xl font-bold text-white">3</span>
            </div>
            <h4 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3 sm:mb-4">Make an Impact</h4>
            <p class="text-sm sm:text-base text-gray-600 leading-relaxed px-4">
              Coordinate pickup and delivery to ensure your food reaches those who need it most in your community.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-gray-900 text-gray-200 py-8 sm:py-10 mt-0">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-col md:flex-row justify-between items-center gap-4 sm:gap-6">
        <div class="text-center md:text-left">
          <h4 class="text-base sm:text-lg font-bold mb-2">Contact</h4>
          <p class="text-sm sm:text-base">Email: <a href="mailto:isadiak98us@gmail.com" class="underline hover:text-emerald-400">foodshare@gmail.com</a></p>
        </div>
        <div class="text-center md:text-right">
          <p class="text-sm sm:text-base">&copy; 2026 FoodShare. All rights reserved.</p>
          <p class="text-sm sm:text-base"> Ismael Abba Diakite</p>
          <p class="text-sm sm:text-base">
            <!--<a href="/privacy" class="underline hover:text-emerald-400">Privacy Policy</a> &middot;
            <a href="/terms" class="underline hover:text-emerald-400">Terms of Service</a>-->
          </p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { computed, onMounted, onUnmounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const unreadCount = computed(() => page.props.auth.unread_notifications || 0)

const props = defineProps({
  user: Object,
  donations: Array,
  matchedDonations: Array
})

const totalPortions = computed(() => {
  return props.donations?.reduce((sum, donation) => sum + donation.quantity, 0) || 0
})

const expiringSoon = computed(() => {
  const today = new Date()
  const tomorrow = new Date(today)
  tomorrow.setDate(today.getDate() + 1)
  return props.donations?.filter(donation => new Date(donation.available_until) <= tomorrow).length || 0
})

// Fonction de logout corrigée
const handleLogout = () => {
  router.post('/logout', {}, {
    onSuccess: () => {
      // Redirige vers la page de login après succès
      router.visit('/login')
    },
    onError: (errors) => {
      console.error('Logout error:', errors)
    }
  })
}

let scrollHandler = null

onMounted(() => {
  const video = document.getElementById('background-video')
  const videoContainer = document.getElementById('video-container')
  
  if (video && videoContainer) {
    scrollHandler = () => {
      const scrollY = window.scrollY
      const windowHeight = window.innerHeight
      
      // Calculate opacity based on scroll (progressive fade out)
      const opacity = Math.max(0, 1 - (scrollY / windowHeight) * 1.2)
      
      video.style.opacity = opacity
      
      // Optionally hide video completely after certain scroll
      if (scrollY > windowHeight * 1.5) {
        videoContainer.style.display = 'none'
      } else {
        videoContainer.style.display = 'block'
      }
    }
    
    window.addEventListener('scroll', scrollHandler, { passive: true })
    
    // Handle video loading errors
    video.addEventListener('error', (e) => {
      console.warn('Video loading error:', e)
      videoContainer.style.display = 'none'
    })
  }
})

onUnmounted(() => {
  if (scrollHandler) {
    window.removeEventListener('scroll', scrollHandler)
  }
})
</script>

<style scoped>
.text-gradient {
  background: linear-gradient(135deg, #10b981, #059669);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

/* Prevent text selection on decorative images */
img[src*="textured"] {
  user-select: none;
  -webkit-user-select: none;
  -moz-user-select: none;
}
</style>