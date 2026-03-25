<template>
  <Header/>
  <div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
      
      <!-- Header -->
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 mb-6">
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 text-white">
          <h1 class="text-2xl sm:text-3xl font-bold mb-2">Accept Food Contribution</h1>
          <p class="text-green-100">Schedule pickup details for the contributor</p>
        </div>

        <!-- Offer Details -->
        <div class="p-6 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Contribution Offer
          </h2>
          
          <div class="grid md:grid-cols-2 gap-4">
            <div class="bg-white rounded-lg p-4">
              <p class="text-sm text-gray-500 mb-1">Contributor</p>
              <p class="font-semibold text-gray-900">{{ foodOffer.user.name }}</p>
            </div>
            <div class="bg-white rounded-lg p-4">
              <p class="text-sm text-gray-500 mb-1">Quantity</p>
              <p class="font-semibold text-gray-900">{{ foodOffer.quantity }} portions</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Form Container -->
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
        <div class="grid lg:grid-cols-2 gap-0">
          
          <!-- Form Section -->
          <div class="p-6 lg:p-8">
            <form @submit.prevent="submit" class="space-y-6">
              
              <!-- Scheduled Date -->
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                  <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                  Pickup Date & Time
                </label>
                <input 
                  type="datetime-local" 
                  v-model="form.scheduled_date"
                  required
                  :min="minDateTime"
                  class="w-full border-2 border-gray-200 rounded-xl p-3 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all"
                />
              </div>

              <!-- Location (Auto-filled) -->
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                  <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                  </svg>
                  Pickup Location
                  <span class="ml-2 text-xs text-gray-500">(Click on map)</span>
                </label>
                <input 
                  type="text" 
                  v-model="form.location"
                  readonly
                  required
                  placeholder="Click on the map to select location"
                  class="w-full border-2 border-gray-200 rounded-xl p-3 bg-gray-50 cursor-not-allowed focus:outline-none"
                />
                
                <div v-if="form.location" class="mt-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                  <p class="text-sm text-green-800">
                    <strong>Selected:</strong> {{ form.location }}
                  </p>
                  <p class="text-xs text-green-600 mt-1">
                    Lat: {{ form.latitude?.toFixed(6) }}, Lng: {{ form.longitude?.toFixed(6) }}
                  </p>
                </div>
              </div>

              <!-- Note -->
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                  <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                  </svg>
                  Note for Contributor (Optional)
                </label>
                <textarea 
                  v-model="form.partner_note"
                  rows="3"
                  placeholder="Add any special instructions, parking details, or other information..."
                  class="w-full border-2 border-gray-200 rounded-xl p-3 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all resize-none"
                ></textarea>
              </div>

              <!-- Buttons -->
              <div class="flex gap-3 pt-4">
                <button 
                  type="button"
                  @click="$inertia.visit('/food-requests/manage-contributions')"
                  class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-xl font-medium transition-all"
                >
                  Cancel
                </button>
                
                <button 
                  type="submit"
                  :disabled="form.processing || !form.location"
                  class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white py-3 rounded-xl font-medium transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  {{ form.processing ? 'Accepting...' : 'Accept & Send Details' }}
                </button>
              </div>
            </form>
          </div>

          <!-- Map Section -->
          <div class="bg-gradient-to-br from-blue-50 to-indigo-100 p-6 lg:p-8">
            <div class="mb-6">
              <h3 class="text-xl font-bold text-gray-800 mb-2">📍 Select Pickup Location</h3>
              <p class="text-gray-600 mb-4">
                Click on the map to define the exact pickup location.
              </p>
              
              <button
                type="button"
                @click="detectLocation"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-all duration-200 mb-4 flex items-center"
              >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                Use My Position
              </button>

              <div v-if="detectedAddress" class="bg-white/80 backdrop-blur-sm rounded-lg p-4 flex items-center space-x-3 mb-4">
                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                  <span class="text-white text-sm">📍</span>
                </div>
                <div>
                  <p class="font-semibold text-gray-800">Position detected:</p>
                  <p class="text-gray-600 text-sm">{{ detectedAddress }}</p>
                </div>
              </div>
            </div>

            <!-- Map Container -->
            <div id="map" class="h-96 rounded-2xl shadow-lg border-2 border-white"></div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { computed, onMounted, onUnmounted, ref } from 'vue'
import Header from '@/Components/Header.vue'

const props = defineProps({
  foodOffer: Object,
  foodRequest: Object
})

const form = useForm({
  scheduled_date: '',
  location: '',
  latitude: null,
  longitude: null,
  partner_note: ''
})

const detectedAddress = ref('')

// Map variables
let map = null
let marker = null

const minDateTime = computed(() => {
  const now = new Date()
  now.setMinutes(now.getMinutes() - now.getTimezoneOffset())
  return now.toISOString().slice(0, 16)
})

const submit = () => {
  if (!form.location) {
    alert('Please select a location on the map')
    return
  }
  form.post(`/food-offers/accept/${props.foodOffer.confirmation_token}`)
}

// Initialize Leaflet map
const initMap = () => {
  // Load Leaflet CSS
  const link = document.createElement('link')
  link.rel = 'stylesheet'
  link.href = 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css'
  document.head.appendChild(link)

  // Load Leaflet JS
  const script = document.createElement('script')
  script.src = 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js'
  script.onload = () => {
    // Initialize map centered on default location
    map = L.map('map').setView([36.8065, 10.1815], 13) // Tunisia default
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors',
      maxZoom: 19
    }).addTo(map)
    
    // Add click handler
    map.on('click', (e) => {
      setMarker(e.latlng)
      reverseGeocode(e.latlng)
    })

    // Try to get user's location
    detectLocation()
  }
  document.head.appendChild(script)
}

// Set marker on map
const setMarker = (latlng) => {
  if (marker) {
    map.removeLayer(marker)
  }
  
  marker = L.marker(latlng).addTo(map)
  marker.bindPopup('📍 Pickup Location').openPopup()
  
  // Update form coordinates
  form.latitude = latlng.lat
  form.longitude = latlng.lng
}

// Reverse geocoding to get address from coordinates
const reverseGeocode = async (latlng) => {
  try {
    const response = await fetch(
      `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latlng.lat}&lon=${latlng.lng}`
    )
    const data = await response.json()
    
    // Build address string
    const parts = []
    if (data.address.road) parts.push(data.address.road)
    if (data.address.city || data.address.town || data.address.village) {
      parts.push(data.address.city || data.address.town || data.address.village)
    }
    if (data.address.postcode) parts.push(data.address.postcode)
    
    const address = parts.length > 0 ? parts.join(', ') : data.display_name
    
    form.location = address
    detectedAddress.value = address
  } catch (error) {
    console.error('Geocoding Error:', error)
    form.location = `${latlng.lat.toFixed(6)}, ${latlng.lng.toFixed(6)}`
  }
}

// Detect user location
const detectLocation = () => {
  if (!navigator.geolocation) {
    console.log('Geolocation not supported')
    return
  }
  
  navigator.geolocation.getCurrentPosition(
    (position) => {
      const latlng = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      }
      
      if (map) {
        map.setView(latlng, 15)
        setMarker(latlng)
        reverseGeocode(latlng)
      }
    },
    (error) => {
      console.log('Unable to get position:', error)
    }
  )
}

// Lifecycle hooks
onMounted(() => {
  // Set default date (3 days from now)
  const defaultDate = new Date()
  defaultDate.setDate(defaultDate.getDate() + 3)
  defaultDate.setHours(14, 0, 0, 0)
  form.scheduled_date = defaultDate.toISOString().slice(0, 16)

  // Initialize map
  initMap()
})

onUnmounted(() => {
  if (map) {
    map.remove()
  }
})
</script>

<style scoped>
button {
  transition: all 0.2s ease;
}

button:hover:not(:disabled) {
  transform: translateY(-1px);
}

button:active:not(:disabled) {
  transform: translateY(0);
}
</style>