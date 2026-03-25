<template>
  <div class="flex flex-col min-h-screen relative bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
    
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-xl border-b border-gray-200/50 sticky top-0 z-20 shadow-sm">
      <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-4">
            <div class="w-12 h-12 flex items-center justify-center rounded-full shadow-lg bg-gradient-to-br from-emerald-400 to-green-500">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">FoodShare - Map</h1>
          </div>
          
          <div class="flex items-center space-x-4">
            <Link 
              :href="route('dashboard')" 
              class="px-4 py-2 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200"
            >
              ← Back to Dashboard
            </Link>
          </div>
        </div>
      </div>
    </nav>

    <!-- Contenu Principal -->
    <div class="flex-grow relative z-10">
      <div class="max-w-7xl mx-auto px-6 py-8">
        
        <!-- Header Section -->
        <div class="bg-white p-6 rounded-2xl mb-6 shadow-lg border border-gray-200">
          <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center">
              <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
              </div>
              <div>
                <h2 class="text-2xl font-bold text-gray-800">Donations Map</h2>
                <p class="text-gray-600">{{ filteredDonations.length }} donations available near you</p>
              </div>
            </div>
            
            <!-- Filters -->
            <div class="flex space-x-2 flex-wrap">
              <button 
                @click="setFilter('all')"
                :class="filterType === 'all' 
                  ? 'bg-gradient-to-r from-blue-500 to-blue-500 text-white' 
                  : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                class="px-4 py-2 rounded-xl font-medium transition-all duration-300 border border-gray-200"
              >
                All ({{ donations.length }})
              </button>

            </div>
          </div>
        </div>

        <!-- Map Container -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
          <div id="map" class="w-full h-96 md:h-[600px] relative">
            <!-- Loading indicator -->
            <div v-if="!mapLoaded" class="absolute inset-0 flex items-center justify-center bg-gray-100 z-10">
              <div class="text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto mb-4"></div>
                <p class="text-gray-600">Loading map...</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Legend -->


        <!-- Donation List (Mobile-friendly) -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 mt-6 md:hidden">
          <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Donation List</h3>
            <div class="space-y-4 max-h-96 overflow-y-auto">
              <div 
                v-for="donation in filteredDonations" 
                :key="donation.id"
                @click="selectDonation(donation)"
                class="p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors"
              >
                <div class="flex items-start justify-between">
                  <div class="flex-1">
                    <h4 class="font-semibold text-gray-800">{{ donation.title }}</h4>
                    <p class="text-sm text-gray-600 mt-1">{{ donation.description }}</p>
                    <div class="flex items-center mt-2 text-xs text-gray-500">
                      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      </svg>
                      {{ donation.distance }}km away
                    </div>
                  </div>
                  <div class="flex flex-col items-end">
                    <span 
                      :class="isUrgent(donation) ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'"
                      class="px-2 py-1 rounded-full text-xs font-medium"
                    >
                      {{ isUrgent(donation) ? 'Urgent' : 'Available' }}
                    </span>
                    <span class="text-xs text-gray-500 mt-1">{{ formatExpiryDate(donation.expires_at) }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for donation details -->
    <div v-if="selectedDonation" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50" @click="closeModal">
      <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl max-h-[90vh] overflow-y-auto" @click.stop>
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-xl font-bold text-gray-800">Donation Details</h3>
          <button @click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>

        <div class="space-y-4">
          <!-- Donation Image -->
          <div v-if="selectedDonation.image" class="w-full h-48 bg-gray-200 rounded-xl overflow-hidden">
            <img :src="selectedDonation.image" :alt="selectedDonation.title" class="w-full h-full object-cover">
          </div>

          <!-- Title and Status -->
          <div class="flex items-start justify-between">
            <h4 class="text-lg font-semibold text-gray-800 flex-1">{{ selectedDonation.title }}</h4>
            <span 
              :class="isUrgent(selectedDonation) ? 'bg-red-100 text-red-800 animate-pulse' : 'bg-green-100 text-green-800'"
              class="px-3 py-1 rounded-full text-sm font-medium ml-3"
            >
              {{ isUrgent(selectedDonation) ? 'Urgent' : 'Available' }}
            </span>
          </div>

          <!-- Description -->
          <div>
            <p class="text-gray-700">{{ selectedDonation.description }}</p>
          </div>

          <!-- Details -->
          <div class="space-y-3">


            <div class="flex items-center text-sm text-gray-600">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              By: {{ selectedDonation.donor_name }}
            </div>

            <div v-if="selectedDonation.quantity" class="flex items-center text-sm text-gray-600">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7Z"></path>
              </svg>
              Quantity: {{ selectedDonation.quantity }}
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex space-x-3 pt-4">
  <button
    @click="goToDonation(selectedDonation)"
    class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl font-medium hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg"
  >
    Request Donation
  </button>
            <button 
              @click="getDirections(selectedDonation)"
              class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m0 0L9 7"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Toast Notification -->
    <div v-if="toast.show" class="fixed bottom-4 right-4 z-50">
      <div 
        :class="toast.type === 'success' ? 'bg-green-500' : toast.type === 'error' ? 'bg-red-500' : 'bg-blue-500'"
        class="text-white px-6 py-3 rounded-xl shadow-lg flex items-center space-x-2"
      >
        <svg v-if="toast.type === 'success'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <svg v-else-if="toast.type === 'error'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
        <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>{{ toast.message }}</span>
      </div>
    </div>
  </div>
</template>

<script>
import { Head, Link, router } from '@inertiajs/vue3'
import{onMounted, onBeforeUnmount, ref} from 'vue'
import Header from '@/Components/Header.vue'


//function goToDonation(donation) {
//  router.visit(`/donations/${donation.id}`)
//}

export default {
  name: 'DonationsMap',
  components: {
    Head,
    Link,
  },
  props: {
    donations: {
      type: Array,
      default: () => []
    },
    userLocation: {
      type: Object,
      default: null
    },
    availableUntil: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      map: null,
      mapLoaded: false,
      markers: [],
      selectedDonation: null,
      filterType: 'all',
      processing: false,
      toast: {
        show: false,
        message: '',
        type: 'info'
      }
    }
  },
  computed: {
    urgentDonations() {
      return this.donations.filter(donation => this.isUrgent(donation))
    },
    nearbyDonations() {
      return this.donations.filter(donation => donation.distance <= 5) // Within 5km
    },
    filteredDonations() {
      switch (this.filterType) {
        case 'urgent':
          return this.urgentDonations
        case 'nearby':
          return this.nearbyDonations
        default:
          return this.donations
      }
    }
  },
  async mounted() {
    await this.$nextTick()
    await this.initMap()
    this.updateMarkers()
    if (!this.userLocation) {
      this.getUserLocation()
    } else {
      this.addUserLocationMarker()
    }
  },
  created() {
    // Make selectDonation available globally for popup buttons
    window.selectDonationFromMap = (donationId) => {
      const donation = this.donations.find(d => d.id === donationId)
      if (donation) {
        this.selectDonation(donation)
      }
    }
  },
  beforeUnmount() {
    if (this.map) {
      this.map.remove()
    }
    // Clean up global function
    if (window.selectDonationFromMap) {
      delete window.selectDonationFromMap
    }
  },
  methods: {

    goToDonation(donation) {
      // redirection Inertia vers la page de détail
      router.visit(`/donations/${donation.id}`)
    },
    async initMap() {
      // Wait for DOM to be ready
      await this.$nextTick()
      
      // Check if map container exists
      const mapContainer = document.getElementById('map')
      if (!mapContainer) {
        console.error('Map container not found')
        return
      }

      // Load Leaflet CSS and JS
      if (!window.L) {
        await this.loadLeaflet()
      }

      // Default center (Tunis, Tunisia coordinates) or user location
      const defaultCenter = this.userLocation 
        ? [this.userLocation.lat, this.userLocation.lng]
        : [36.8065, 10.1815]
      
      try {
        this.map = L.map('map', {
          zoomControl: true,
          scrollWheelZoom: true,
          doubleClickZoom: true,
          boxZoom: true,
          keyboard: true,
          dragging: true,
          touchZoom: true
        }).setView(defaultCenter, 12)
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
          maxZoom: 19
        }).addTo(this.map)

        this.mapLoaded = true
        
        // Add a small delay to ensure map is fully initialized
        setTimeout(() => {
          if (this.map) {
            this.map.invalidateSize()
          }
        }, 500)
        
      } catch (error) {
        console.error('Error initializing map:', error)
        this.showToast('Error initializing map', 'error')
      }
    },

      

    loadLeaflet() {
      return new Promise((resolve) => {
        // Load CSS
        const link = document.createElement('link')
        link.rel = 'stylesheet'
        link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css'
        document.head.appendChild(link)

        // Load JS
        const script = document.createElement('script')
        script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js'
        script.onload = resolve
        document.head.appendChild(script)
      })
    },

    updateMarkers() {
      if (!this.map) {
        console.warn('Map not initialized yet')
        return
      }

      // Clear existing markers (except user location)
      this.markers.forEach(marker => {
        if (marker && this.map.hasLayer(marker)) {
          this.map.removeLayer(marker)
        }
      })
      this.markers = []

      // Add new markers for filtered donations
      this.filteredDonations.forEach(donation => {
        if (!donation.latitude || !donation.longitude) {
          console.warn('Invalid coordinates for donation:', donation.id)
          return
        }

        const isUrgentDonation = this.isUrgent(donation)
        
        try {
          const marker = L.marker([donation.latitude, donation.longitude], {
            icon: L.divIcon({
              className: 'custom-marker',
              html: `<div class="marker-inner ${isUrgentDonation ? 'urgent' : 'regular'}"></div>`,
              iconSize: [20, 20],
              iconAnchor: [10, 10]
            })
          }).addTo(this.map)

          // Add popup with donation info
          marker.bindPopup(`
            <div class="p-2">
              <h4 class="font-semibold text-sm">${donation.title}</h4>
              <p class="text-xs text-gray-600 mt-1">${donation.description}</p>
              <button class="mt-2 px-2 py-1 bg-blue-500 text-white text-xs rounded" onclick="window.selectDonationFromMap(${donation.id})">
                View Details
              </button>
            </div>
          `)

          marker.on('click', () => {
            this.selectDonation(donation)
          })

          this.markers.push(marker)
        } catch (error) {
          console.error('Error creating marker for donation:', donation.id, error)
        }
      })

      // Adjust map view to show all markers if there are any
      if (this.markers.length > 0) {
        try {
          const group = new L.featureGroup(this.markers)
          this.map.fitBounds(group.getBounds().pad(0.1))
        } catch (error) {
          console.error('Error fitting bounds:', error)
        }
      }
    },

    addUserLocationMarker() {
      if (!this.map || !this.userLocation) return

      // Add user location marker
      const userMarker = L.marker([this.userLocation.lat, this.userLocation.lng], {
        icon: L.divIcon({
          className: 'user-marker',
          html: `<div class="user-marker-inner"></div>`,
          iconSize: [24, 24],
          iconAnchor: [12, 12]
        })
      }).addTo(this.map).bindPopup('Your Location')

      // Center map on user location
      this.map.setView([this.userLocation.lat, this.userLocation.lng], 13)
    },

    async getUserLocation() {
      if (!navigator.geolocation) {
        this.showToast('Geolocation is not supported by this browser', 'error')
        return
      }

      try {
        const position = await new Promise((resolve, reject) => {
          navigator.geolocation.getCurrentPosition(resolve, reject, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 300000 // 5 minutes
          })
        })

        const userLocation = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        }

        // Send location to backend via Inertia
        router.post(route('donations.map.updateLocation'), {
          latitude: userLocation.lat,
          longitude: userLocation.lng
        }, {
          preserveState: true,
          preserveScroll: true,
          onSuccess: () => {
            this.addUserLocationMarker()
          }
        })
        
      } catch (error) {
        console.error('Geolocation error:', error)
        this.showToast('Could not get your location. Using default location.', 'info')
      }
    },

    isUrgent(donation) {
      const now = new Date()
      const expiryDate = new Date(donation.expiration_date)
      const hoursUntilExpiry = (expiryDate - now) / (1000 * 60 * 60)
      return hoursUntilExpiry <= 24
    },

    formatExpiryDate(dateString) {
      const date = new Date(dateString)
      const now = new Date()
      const diffInHours = (date - now) / (1000 * 60 * 60)
      
      if (diffInHours < 1) {
        const diffInMinutes = Math.round((date - now) / (1000 * 60))
        return `${diffInMinutes} minutes`
      } else if (diffInHours < 24) {
        return `${Math.round(diffInHours)} hours`
      } else {
        return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
      }
    },

    setFilter(type) {
      this.filterType = type
      this.$nextTick(() => {
        this.updateMarkers()
      })
    },

    selectDonation(donation) {
      this.selectedDonation = donation
      
      // Pan map to selected donation if map is available
      if (this.map && donation.latitude && donation.longitude) {
        this.map.setView([donation.latitude, donation.longitude], 15, {
          animate: true
        })
      }
    },

    closeModal() {
      this.selectedDonation = null
    },

    nation(donation) {
      this.processing = true
      
    },

    getDirections(donation) {
      const url = `https://www.google.com/maps/dir/?api=1&destination=${donation.latitude},${donation.longitude}`
      window.open(url, '_blank')
    },

    showToast(message, type = 'info') {
      this.toast = {
        show: true,
        message,
        type
      }
      
      setTimeout(() => {
        this.toast.show = false
      }, 4000)
    }
  }
}
onMounted(() => {
  initCharts()
  console.log('User:', props.donation)
  console.log('User Location:', props.userLocation)})
</script>

<style scoped>
/* Custom marker styles */
:deep(.custom-marker) {
  background: transparent !important;
  border: none !important;
}

:deep(.marker-inner) {
  width: 16px;
  height: 16px;
  border-radius: 50%;
  border: 2px solid white;
  box-shadow: 0 2px 4px rgba(0,0,0,0.3);
  display: block;
}

:deep(.marker-inner.regular) {
  background-color: #10b981; /* green-500 */
}

:deep(.marker-inner.urgent) {
  background-color: #ef4444; /* red-500 */
  animation: pulse 2s infinite;
}

:deep(.user-marker) {
  background: transparent !important;
  border: none !important;
}

:deep(.user-marker-inner) {
  width: 24px;
  height: 24px;
  background-color: #3b82f6; /* blue-500 */
  border-radius: 50%;
  border: 3px solid white;
  box-shadow: 0 2px 8px rgba(0,0,0,0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}

:deep(.user-marker-inner::after) {
  content: '';
  width: 8px;
  height: 8px;
  background-color: white;
  border-radius: 50%;
  display: block;
}

/* Leaflet popup customization */
:deep(.leaflet-popup-content-wrapper) {
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

:deep(.leaflet-popup-tip) {
  background: white;
}

:deep(.leaflet-popup-content) {
  margin: 8px 12px;
  line-height: 1.4;
}

/* Pulse animation for urgent donations */
@keyframes pulse {
  0%, 100% {
    transform: scale(1);
    opacity: 1;
  }
  50% {
    transform: scale(1.1);
    opacity: 0.8;
  }
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
  .max-w-7xl {
    padding-left: 1rem;
    padding-right: 1rem;
  }
  
  .flex-wrap {
    flex-direction: column;
    gap: 0.5rem;
  }
  
  .flex-wrap > * {
    width: 100%;
  }

  /* Adjust map height on mobile */
  #map {
    height: 300px !important;
  }
}

/* Loading animation */
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}

/* Toast animation */
.fixed.bottom-4.right-4 > div {
  animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
  from {
    transform: translateX(100%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

</style>