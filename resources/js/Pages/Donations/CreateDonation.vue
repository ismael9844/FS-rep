<template>
  <Header/>
<div>
  <img
  src="/bckg4.jpg"
  alt="Impact Background"
  class="fixed inset-0 w-full h-full object-cover opacity-100 pointer-events-none select-none"
  style="z-index: -1;"
/>

    <div class="max-w-6xl mx-auto">
      

      <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 mb-8 text-center">
        <h1 class="text-4xl font-bold text-white mb-2"> New donation</h1>
      </div>

      <!-- Main Container -->
      <div class="bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl overflow-hidden">
        <div class="grid lg:grid-cols-2 gap-0">
          <!-- Form Section -->
          <div class="p-8 lg:p-12">
            <form @submit.prevent="submitForm" class="space-y-6">
              <!-- Title -->
              <div class="form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                  Donation name
                </label>
                <input
                  v-model="form.title"
                  type="text"
                  required
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  placeholder="Ex: Fruits and vegtables"
                />
              </div>

              <!-- Category -->
<div class="form-group">
  <label class="block text-sm font-semibold text-gray-700 mb-2">
    Category
  </label>
  <select
    v-model="form.category"
    required
    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
  >
    <option disabled value="">Select a Category</option>
    <option value="Desserts">Desserts</option>
    <option value="Meals">Meals</option>
    <option value="Vegetables">Vegetables</option>
    <option value="Fruits">Fruits</option>
    <option value="Others">Others</option>

  </select>
</div>


              <!-- Description -->
              <div class="form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                 Description
                </label>
                <textarea
                  v-model="form.description"
                  rows="4"
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  placeholder="Describe your donation in details..."
                ></textarea>
              </div>

              <!-- Quantity & Unit -->
              <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                  <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Quantity
                  </label>
                  <input
                    v-model="form.quantity"
                    type="number"
                    min="1"
                    required
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  />
                </div>
<div class="form-group">
  <label class="block text-sm font-semibold text-gray-700 mb-2">
    Unit
  </label>
  <select
    v-model="form.unit"
    required
    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
  >
    <option disabled value="">Select a unit</option>
    <option value="kg">kg</option>
    <option value="litres">litres</option>
    <option value="slices">slices</option>
    <option value="pieces">pieces</option>
    <option value="packs">packs</option>
    <option value="boxes">boxes</option>
  </select>
</div>

              </div>

              <!-- Availability -->
              <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                  <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Available from
                  </label>
                  <input
                    v-model="form.available_from"
                    type="datetime-local"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  />
                </div>
                <div class="form-group">
                  <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Available until
                  </label>
                  <input
                    v-model="form.available_until"
                    type="datetime-local"
                    required
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  />
                </div>
              </div>

              <!-- Expiration Date -->
              <div class="form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                  Expiration Date
                </label>
                <input
                  v-model="form.expiration_date"
                  type="date"
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                />
              </div>

              <!-- Location -->
              <div class="grid grid-cols-2 gap-4">
  <div class="form-group">
    <label class="block text-sm font-semibold text-gray-700 mb-2">
      City
    </label>
    <input
      v-model="form.city"
      type="text"
      readonly
      required
      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-100 cursor-not-allowed focus:outline-none"
      placeholder="Auto-filled by map"
    />
  </div>
  <div class="form-group">
    <label class="block text-sm font-semibold text-gray-700 mb-2">
      Postal code
    </label>
    <input
      v-model="form.postal_code"
      type="text"
      readonly
      required
      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-100 cursor-not-allowed focus:outline-none"
      placeholder="Auto-filled by map"
    />
  </div>
</div>


              <!-- Submit Button -->
              <button
                type="submit"
                :disabled="processing"
                class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 active:scale-95 disabled:opacity-50"
              >
                <span v-if="processing">⏳ Sending</span>
                <span v-else>Add my donation</span>
              </button>
            </form>
          </div>

          <!-- Map Section -->
          <div class="bg-gradient-to-br from-blue-50 to-indigo-100 p-8 lg:p-12">
            <div class="mb-6">
              <h3 class="text-xl font-bold text-gray-800 mb-2">📍 Location</h3>
              <p class="text-gray-600 mb-4">
                Define the location of your donation on to the map below.
              </p>
              
              <button
                type="button"
                @click="detectLocation"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-all duration-200 mb-4"
              >
                Use my position
              </button>

              <div v-if="detectedCity" class="bg-white/80 backdrop-blur-sm rounded-lg p-4 flex items-center space-x-3">
                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                  <span class="text-white text-sm">📍</span>
                </div>
                <div>
                  <p class="font-semibold text-gray-800">Position detected at:</p>
                  <p class="text-gray-600">{{ detectedCity }}, {{ detectedPostal }}</p>
                </div>
              </div>
            </div>

            <!-- Map Container -->
            <div id="map" class="h-96 rounded-2xl shadow-lg"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { router } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'


// Form data
const form = ref({
  title: '',
  category: '',
  description: '',
  quantity: 1,
  unit: '',
  available_from: '',
  available_until: '',
  expiration_date: '',
  donor_type: 'individual',
  city: '',
  postal_code: '',
  latitude: null,
  longitude: null
})

// State
const processing = ref(false)
const detectedCity = ref('')
const detectedPostal = ref('')

// Map variables
let map = null
let marker = null

// Initialize map
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
    // Initialize map centered on Silifke, Mersin
    map = L.map('map').setView([36.3783, 33.9383], 13)
    
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
  }
  document.head.appendChild(script)
}

// Set marker on map
const setMarker = (latlng) => {
  if (marker) {
    map.removeLayer(marker)
  }
  
  marker = L.marker(latlng).addTo(map)
  marker.bindPopup('📍 Position').openPopup()
  
  // Update form coordinates
  form.value.latitude = latlng.lat
  form.value.longitude = latlng.lng
 
  //debug
  console.log('Coordonnées sélectionnées:', {
    lat: latlng.lat,
    lng: latlng.lng,
    formData: form.value
  })
}

// Reverse geocoding
const reverseGeocode = async (latlng) => {
  try {
    const response = await fetch(
      `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latlng.lat}&lon=${latlng.lng}`
    )
    const data = await response.json()
    
    const city = data.address.city || data.address.town || data.address.village || ''
    const postcode = data.address.postcode || ''
    
    if (city || postcode) {
      form.value.city = city
      form.value.postal_code = postcode
      detectedCity.value = city
      detectedPostal.value = postcode
    }
  } catch (error) {
    console.error('Geocodage Error:', error)
  }
}

// Detect user location
const detectLocation = () => {
  if (!navigator.geolocation) {
    alert('La géolocalisation n\'est pas supportée par votre navigateur')
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
    () => {
      alert('Impossible to get your position')
    }
  )
}

// Submit form
const submitForm = () => {
  processing.value = true
  
  router.post('/donations', form.value, {
    onSuccess: () => {
      router.visit('/dashboard')
    },
    onError: (errors) => {
      console.error('Erreurs:', errors)
      processing.value = false
    },
    onFinish: () => {
      processing.value = false
    }
  })
}

// Lifecycle hooks
onMounted(() => {
  initMap()
})

onUnmounted(() => {
  if (map) {
    map.remove()
  }
})
</script>

<style scoped>
.form-group {
  @apply relative;
}

.form-group input:focus,
.form-group textarea:focus {
  @apply outline-none;
}

/* Animation pour les boutons */
button {
  transition: all 0.2s ease;
}

button:hover {
  transform: translateY(-1px);
}

button:active {
  transform: translateY(0);
}

/* Responsive adjustments */
@media (max-width: 1024px) {
  .grid.lg\\:grid-cols-2 {
    grid-template-columns: 1fr;
  }
}
</style>