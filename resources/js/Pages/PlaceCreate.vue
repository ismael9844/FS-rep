<template>
  <!-- ✅ Header sorti du container avec padding -->
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-green-50">
    
    <Header/>

    <!-- Contenu avec padding -->
    <div class="py-4 sm:py-8 px-4">
      <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-6 sm:mb-8">
          <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 mb-2">Add New Place</h1>
          <p class="text-sm sm:text-base text-slate-600">Share a location with the community</p>
        </div>

        <!-- Success Message -->
        <div v-if="showSuccess" class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
          <div class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-green-700 font-medium text-sm sm:text-base">Place created successfully!</p>
          </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
          <form @submit.prevent="submitForm" novalidate class="p-4 sm:p-8">
            <!-- Form Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
              <!-- Left Column -->
              <div class="space-y-4 sm:space-y-6">
                <!-- Title -->
                <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Title <span class="text-red-500">*</span>
                  </label>
                  <input 
                    v-model="form.title" 
                    class="w-full border border-slate-200 rounded-xl px-3 sm:px-4 py-2 sm:py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm sm:text-base" 
                    placeholder="Enter place title"
                    required 
                  />
                  <p v-if="form.errors.title" class="text-red-500 text-xs sm:text-sm mt-2">{{ form.errors.title }}</p>
                </div>

                <!-- Contact Info -->
                <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Contact Info <span class="text-red-500">*</span>
                  </label>
                  <input 
                    v-model="form.contact_info" 
                    class="w-full border border-slate-200 rounded-xl px-3 sm:px-4 py-2 sm:py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm sm:text-base" 
                    placeholder="Phone, email, etc."
                    required 
                  />
                </div>

                <!-- Availability -->
                <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Available From <span class="text-red-500">*</span>
                  </label>
                  <input 
                    type="date" 
                    v-model="form.availability" 
                    class="w-full border border-slate-200 rounded-xl px-3 sm:px-4 py-2 sm:py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm sm:text-base" 
                    required 
                  />
                </div>

                <!-- Description -->
                <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Description <span class="text-red-500">*</span>
                  </label>
                  <textarea 
                    v-model="form.description" 
                    rows="4"
                    class="w-full border border-slate-200 rounded-xl px-3 sm:px-4 py-2 sm:py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all resize-none text-sm sm:text-base" 
                    placeholder="Describe this place..."
                    required
                  ></textarea>
                </div>
              </div>

              <!-- Right Column - MAP -->
              <div class="space-y-4 sm:space-y-6">
                <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Location <span class="text-red-500">*</span>
                    <span class="text-xs text-slate-500 font-normal ml-2">(Click on map)</span>
                  </label>
                  
                  <input 
                    ref="searchInput"
                    type="text" 
                    placeholder="Search for a location..."
                    class="w-full mb-3 border border-slate-200 rounded-xl px-3 sm:px-4 py-2 sm:py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm sm:text-base"
                  />

                  <div ref="mapContainer" class="w-full h-64 sm:h-80 rounded-xl border-2 border-slate-200 overflow-hidden shadow-inner" style="z-index: 1;"></div>
                  
                  <div v-if="form.address" class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-xs sm:text-sm text-green-800">
                      <strong>Selected:</strong> {{ form.address }}
                    </p>
                    <p class="text-xs text-green-600 mt-1">
                      {{ form.city }}, {{ form.postal_code }}
                    </p>
                  </div>
                </div>

                <!-- Google Maps Link -->
                <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Google Maps Link <span class="text-slate-500 font-normal">(optional)</span>
                  </label>
                  <input 
                    v-model="form.google_maps_link" 
                    class="w-full border border-slate-200 rounded-xl px-3 sm:px-4 py-2 sm:py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm sm:text-base" 
                    placeholder="https://maps.google.com/..."
                  />
                </div>
              </div>
            </div>

            <!-- Photos Section -->
            <div class="mt-6 sm:mt-8 pt-6 border-t border-slate-100">
              <label class="block text-sm font-semibold text-slate-700 mb-4">
                Photos <span class="text-slate-500 font-normal">(Upload multiple images)</span>
              </label>
              
              <div 
                class="border-2 border-dashed border-slate-200 rounded-xl p-6 sm:p-8 text-center hover:border-green-300 transition-colors cursor-pointer"
                @click="$refs.fileInput.click()"
                @dragover.prevent
                @drop.prevent="handleDrop"
              >
                <input
                  ref="fileInput"
                  type="file"
                  multiple
                  accept="image/*"
                  @change="handleFiles"
                  class="hidden"
                />
                
                <div class="space-y-3">
                  <div class="w-12 h-12 sm:w-16 sm:h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                  </div>
                  <div>
                    <p class="text-sm sm:text-base text-slate-600 font-medium">Click to upload images</p>
                    <p class="text-xs sm:text-sm text-slate-500">or drag and drop</p>
                    <p class="text-xs text-slate-400 mt-1">PNG, JPG, WebP (Max 5MB each)</p>
                  </div>
                </div>
              </div>

              <div v-if="previews.length" class="mt-4 sm:mt-6">
                <h4 class="text-sm font-semibold text-slate-700 mb-3">Selected Images ({{ previews.length }})</h4>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 sm:gap-4">
                  <div 
                    v-for="(preview, index) in previews" 
                    :key="index"
                    class="relative group"
                  >
                    <img 
                      :src="preview" 
                      class="w-full h-20 sm:h-24 object-cover rounded-lg border border-slate-200" 
                    />
                    <button
                      type="button"
                      @click="removeImage(index)"
                      class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors opacity-0 group-hover:opacity-100"
                    >
                      ×
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Progress Bar -->
            <div v-if="progress > 0" class="mt-6">
              <div class="flex justify-between items-center mb-2">
                <span class="text-xs sm:text-sm font-medium text-slate-700">Uploading...</span>
                <span class="text-xs sm:text-sm text-slate-600">{{ progress }}%</span>
              </div>
              <div class="w-full bg-slate-200 rounded-full h-2">
                <div class="h-2 rounded-full bg-gradient-to-r from-green-500 to-green-600 transition-all duration-300" :style="{ width: progress + '%' }"></div>
              </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-6 sm:mt-8 pt-6 border-t border-slate-100">
              <button 
                type="button"
                @click="router.visit('/places')"
                class="px-4 sm:px-6 py-2 sm:py-3 border-2 border-slate-200 text-slate-600 rounded-xl font-semibold hover:border-slate-300 hover:bg-slate-50 transition-all text-sm sm:text-base"
              >
                Cancel
              </button>
              
              <button 
                type="submit" 
                :disabled="form.processing || !form.address"
                class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 disabled:from-slate-400 disabled:to-slate-500 text-white font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-xl transition-all shadow-sm hover:shadow-md disabled:cursor-not-allowed flex items-center justify-center gap-2 text-sm sm:text-base"
              >
                <svg v-if="form.processing" class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>{{ form.processing ? 'Creating...' : 'Create Place' }}</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'

const form = useForm({
  title: '',
  description: '',
  address: '',
  city: '',
  postal_code: '',
  latitude: null,
  longitude: null,
  google_maps_link: '',
  contact_info: '',
  availability: '',
  photos: []
})

const previews = ref([])
const progress = ref(0)
const showSuccess = ref(false)
const mapContainer = ref(null)
const searchInput = ref(null)

let map = null
let marker = null

const initMap = () => {
  const link = document.createElement('link')
  link.rel = 'stylesheet'
  link.href = 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css'
  document.head.appendChild(link)

  const script = document.createElement('script')
  script.src = 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js'
  script.onload = () => {
    map = L.map(mapContainer.value).setView([36.8065, 10.1815], 13)
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors',
      maxZoom: 19
    }).addTo(map)
    
    map.on('click', (e) => {
      setMarker(e.latlng)
      reverseGeocode(e.latlng)
    })

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition((position) => {
        const latlng = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        }
        map.setView(latlng, 15)
      })
    }
  }
  document.head.appendChild(script)
}

const setMarker = (latlng) => {
  if (marker) {
    map.removeLayer(marker)
  }
  marker = L.marker(latlng).addTo(map)
  marker.bindPopup('📍 Selected Location').openPopup()
  form.latitude = latlng.lat
  form.longitude = latlng.lng
}

const reverseGeocode = async (latlng) => {
  try {
    const response = await fetch(
      `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latlng.lat}&lon=${latlng.lng}`
    )
    const data = await response.json()
    form.address = data.display_name || `${latlng.lat}, ${latlng.lng}`
    form.city = data.address.city || data.address.town || data.address.village || ''
    form.postal_code = data.address.postcode || ''
  } catch (error) {
    console.error('Geocoding error:', error)
    form.address = `${latlng.lat}, ${latlng.lng}`
  }
}

function handleFiles(e) {
  const files = Array.from(e.target.files || [])
  processFiles(files)
}

function handleDrop(e) {
  const files = Array.from(e.dataTransfer.files || [])
  processFiles(files)
}

function processFiles(files) {
  const maxSize = 5 * 1024 * 1024
  const validFiles = []
  
  for (const file of files) {
    if (!file.type.startsWith('image/')) continue
    if (file.size > maxSize) continue
    validFiles.push(file)
  }

  if (validFiles.length === 0) return

  form.photos = [...form.photos, ...validFiles]

  validFiles.forEach(file => {
    const reader = new FileReader()
    reader.onload = (ev) => previews.value.push(ev.target.result)
    reader.readAsDataURL(file)
  })
}

function removeImage(index) {
  previews.value.splice(index, 1)
  const newFiles = Array.from(form.photos)
  newFiles.splice(index, 1)
  form.photos = newFiles
}

function submitForm() {
  if (!form.address) {
    alert('Please select a location on the map')
    return
  }

  form.post('/places', {
    forceFormData: true,
    onProgress: (event) => {
      if (event.lengthComputable) {
        progress.value = Math.round((event.loaded / event.total) * 100)
      }
    },
    onSuccess: () => {
      showSuccess.value = true
      setTimeout(() => router.visit('/places'), 1500)
    },
    onFinish: () => {
      progress.value = 0
    }
  })
}

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
/* ✅ Fix Leaflet z-index - empêche la carte de passer sur le header */
:deep(.leaflet-pane),
:deep(.leaflet-control),
:deep(.leaflet-top),
:deep(.leaflet-bottom) {
  z-index: 1 !important;
}

:deep(.leaflet-control-zoom) {
  z-index: 2 !important;
}
</style>