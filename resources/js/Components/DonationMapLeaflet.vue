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
              <button 
                @click="setFilter('urgent')"
                :class="filterType === 'urgent' 
                  ? 'bg-gradient-to-r from-red-500 to-red-500 text-white' 
                  : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                class="px-4 py-2 rounded-xl font-medium transition-all duration-300 border border-gray-200"
              >
                Urgent ({{ urgentDonations.length }})
              </button>
              <button 
                @click="setFilter('nearby')"
                :class="filterType === 'nearby' 
                  ? 'bg-gradient-to-r from-green-500 to-green-500 text-white' 
                  : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                class="px-4 py-2 rounded-xl font-medium transition-all duration-300 border border-gray-200"
              >
                Nearby ({{ nearbyDonations.length }})
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
        <div class="bg-white p-4 rounded-2xl mt-6 shadow-lg border border-gray-200">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Legend</h3>
          <div class="flex flex-wrap gap-4">
            <div class="flex items-center">
              <div class="w-4 h-4 bg-green-500 rounded-full mr-2"></div>
              <span class="text-sm text-gray-600">Regular donations</span>
            </div>
            <div class="flex items-center">
              <div class="w-4 h-4 bg-red-500 rounded-full mr-2 animate-pulse"></div>
              <span class="text-sm text-gray-600">Urgent donations (expires within 24h)</span>
            </div>
            <div class="flex items-center">
              <div class="w-4 h-4 bg-blue-500 rounded-full mr-2"></div>
              <span class="text-sm text-gray-600">Your location</span>
            </div>
          </div>
        </div>

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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Expires: {{ formatExpiryDate(selectedDonation.expires_at) }}
            </div>
            
            <div class="flex items-center text-sm text-gray-600">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              {{ selectedDonation.address }} ({{ selectedDonation.distance }}km away)
            </div>

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
              @click="requestDonation(selectedDonation)"
              :disabled="selectedDonation.status === 'reserved'"
              class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl font-medium hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {{ selectedDonation.status === 'reserved' ? 'Reserved' : 'Request Donation' }}
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
import axios from 'axios'

export default {
  name: 'DonationsMap',
  data() {
    return {
      map: null,
      mapLoaded: false,
      donations: [],
      markers: [],
      selectedDonation: null,
      filterType: 'all',
      userLocation: null,
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
  mounted() {
    this.initMap()
    this.loadDonations()
    this.getUserLocation()
  },
  beforeUnmount() {
    if (this.map) {
      this.map.remove()
    }
  },
  methods: {
    async initMap() {
      // Load Leaflet CSS and JS
      if (!window.L) {
        await this.loadLeaflet()
      }

      // Default center (you can adjust these coordinates)
      const defaultCenter = [36.8, 10.18] // Tunisia coordinates as fallback
      
      this.map = L.map('map').setView(defaultCenter, 13)
      
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
      }).addTo(this.map)

      this.mapLoaded = true
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

    async loadDonations() {
      try {
        const response = await axios.get('/api/donations/map')
        this.donations = response.data.map(donation => ({
          ...donation,
          distance: this.calculateDistance(donation)
        }))
        this.updateMarkers()
      } catch (error) {
        console.error('Error loading donations:', error)
        this.showToast('Error loading donations', 'error')
        
        // Mock data for development
        this.donations = this.getMockDonations()
        this.updateMarkers()
      }
    },

    getMockDonations() {
      return [
        {
          id: 1,
          title: 'Fresh Vegetables',
          description: 'Mixed vegetables from my garden',
          latitude: 36.8065,
          longitude: 10.1815,
          address: '123 Avenue Habib Bourguiba, Tunis',
          donor_name: 'Ahmed Ben Ali',
          expires_at: '2025-07-20T18:00:00Z',
          quantity: '5kg',
          status: 'available',
          image: null,
          distance: 2.3
        },
        {
          id: 2,
          title: 'Bakery Items',
          description: 'Bread and pastries from this morning',
          latitude: 36.8189,
          longitude: 10.1658,
          address: '456 Rue de la Liberté, Tunis',
          donor_name: 'Fatima Zahra',
          expires_at: '2025-07-19T20:00:00Z',
          quantity: '20 pieces',
          status: 'available',
          image: null,
          distance: 1.8
        },
        {
          id: 3,
          title: 'Cooked Meals',
          description: 'Traditional Tunisian couscous for families',
          latitude: 36.7984,
          longitude: 10.1912,
          address: '789 Avenue Mohamed V, Tunis',
          donor_name: 'Restaurant Diwan',
          expires_at: '2025-07-19T21:30:00Z',
          quantity: '10 portions',
          status: 'available',
          image: null,
          distance: 3.1
        }
      ]
    },

    updateMarkers() {
      // Clear existing markers
      this.markers.forEach(marker => {
        this.map.removeLayer(marker)
      })
      this.markers = []

      // Add new markers for filtered donations
      this.filteredDonations.forEach(donation => {
        const isUrgentDonation = this.isUrgent(donation)
        
        const marker = L.marker([donation.latitude, donation.longitude], {
          icon: L.divIcon({
            className: 'custom-marker',
            html: `<div class="w-4 h-4 ${isUrgentDonation ? 'bg-red-500 animate-pulse' : 'bg-green-500'} rounded-full border-2 border-white shadow-lg"></div>`,
            iconSize: [16, 16],
            iconAnchor: [8, 8]
          })
        }).addTo(this.map)

        marker.on('click', () => {
          this.selectDonation(donation)
        })

        this.markers.push(marker)
      })

      // Adjust map view to show all markers
      if (this.markers.length > 0) {
        const group = new L.featureGroup(this.markers)
        this.map.fitBounds(group.getBounds().pad(0.1))
      }
    },

    async getUserLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          (position) => {
            this.userLocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            }
            
            // Add user location marker
            L.marker([this.userLocation.lat, this.userLocation.lng], {
              icon: L.divIcon({
                className: 'user-marker',
                html: `<div class="w-6 h-6 bg-blue-500 rounded-full border-3 border-white shadow-lg flex items-center justify-center">
                  <div class="w-2 h-2 bg-white rounded-full"></div>
                </div>`,
                iconSize: [24, 24],
                iconAnchor: [12, 12]
              })
            }).addTo(this.map).bindPopup('Your Location')

            // Center map on user location
            this.map.setView([this.userLocation.lat, this.userLocation.lng], 13)
            
            // Recalculate distances
            this.donations = this.donations.map(donation => ({
              ...donation,
              distance: this.calculateDistance(donation)
            }))
          },
          (error) => {
            console.error('Geolocation error:', error)
            this.showToast('Could not get your location', 'error')
          }
        )
      }
    },

    calculateDistance(donation) {
      if (!this.userLocation) {
        return 0 // Default distance if user location is not available
      }

      const R = 6371 // Radius of the Earth in kilometers
      const dLat = this.deg2rad(donation.latitude - this.userLocation.lat)
      const dLon = this.deg2rad(donation.longitude - this.userLocation.lng)
      const a = 
        Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(this.deg2rad(this.userLocation.lat)) * Math.cos(this.deg2rad(donation.latitude)) * 
        Math.sin(dLon/2) * Math.sin(dLon/2)
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a))
      const distance = R * c // Distance in kilometers
      
      return Math.round(distance * 10) / 10 // Round to 1 decimal place
    },

    deg2rad(deg) {
      return deg * (Math.PI/180)
    },

    isUrgent(donation) {
      const now = new Date()
      const expiryDate = new Date(donation.expires_at)
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
      this.updateMarkers()
    },

    selectDonation(donation) {
      this.selectedDonation = donation
      
      // Pan map to selected donation
      if (this.map) {
        this.map.setView([donation.latitude, donation.longitude], 15)
      }
    },

    closeModal() {
      this.selectedDonation = null
    },

    async requestDonation(donation) {
      try {
        const response = await axios.post(`/api/donations/${donation.id}/request`)
        this.showToast('Donation request sent successfully!', 'success')
        this.closeModal()
        
        // Update donation status
        const donationIndex = this.donations.findIndex(d => d.id === donation.id)
        if (donationIndex !== -1) {
          this.donations[donationIndex].status = 'reserved'
        }
      } catch (error) {
        console.error('Error requesting donation:', error)
        this.showToast('Error sending donation request', 'error')
      }
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
</script>

<style scoped>
/* Custom marker styles */
:deep(.custom-marker) {
  background: transparent !important;
  border: none !important;
}

:deep(.user-marker) {
  background: transparent !important;
  border: none !important;
}

/* Leaflet popup customization */
:deep(.leaflet-popup-content-wrapper) {
  @apply rounded-xl shadow-lg;
}

:deep(.leaflet-popup-tip) {
  @apply text-white;
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
  .max-w-7xl {
    @apply px-4;
  }
  
  .flex-wrap {
    @apply flex-col space-x-0 space-y-2;
  }
  
  .flex-wrap button {
    @apply w-full;
  }
}
</style>