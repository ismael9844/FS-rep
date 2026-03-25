<template>
  
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-green-50 py-8 px-4">
    <Header/>
    <div class="max-w-4xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Edit Place</h1>
        <p class="text-slate-600">Update location details and photos</p>
      </div>

      <!-- Form Card -->
      <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
        <form @submit.prevent="submitForm" class="p-8">
          <!-- Form Grid -->
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column - Basic Info -->
            <div class="space-y-6">
              <h3 class="text-lg font-semibold text-slate-800 border-b border-slate-100 pb-2">Basic Information</h3>
              
              <!-- Title -->
              <div class="form-group">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                  Title <span class="text-red-500">*</span>
                </label>
                <input 
                  v-model="form.title" 
                  class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 placeholder:text-slate-400" 
                  placeholder="Enter place title"
                  required 
                />
              </div>

              <!-- Address -->
              <div class="form-group">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                  Address <span class="text-red-500">*</span>
                </label>
                <input 
                  v-model="form.address" 
                  class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 placeholder:text-slate-400" 
                  placeholder="Enter full address"
                  required 
                />
              </div>

              <!-- Contact Info -->
              <div class="form-group">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                  Contact Info <span class="text-red-500">*</span>
                </label>
                <input 
                  v-model="form.contact_info" 
                  class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 placeholder:text-slate-400" 
                  placeholder="Phone, email, etc."
                  required 
                />
              </div>

              <!-- Availability -->
              <div class="form-group">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                  Available From <span class="text-red-500">*</span>
                </label>
                <input 
                  type="date" 
                  v-model="form.availability" 
                  class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" 
                  required 
                />
              </div>

              <!-- Google Maps -->
              <div class="form-group">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                  Google Maps Link
                  <span class="text-slate-500 font-normal">(optional)</span>
                </label>
                <input 
                  v-model="form.google_maps_link" 
                  class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 placeholder:text-slate-400" 
                  placeholder="https://maps.google.com/..."
                />
              </div>
            </div>

            <!-- Right Column - Description & Photos -->
            <div class="space-y-6">
              <!-- Description -->
              <div class="form-group">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                  Description <span class="text-red-500">*</span>
                </label>
                <textarea 
                  v-model="form.description" 
                  rows="6"
                  class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 placeholder:text-slate-400 resize-none" 
                  placeholder="Describe this beautiful place..."
                  required
                ></textarea>
              </div>

              <!-- Current Photos -->
              <div class="form-group">
                <div class="flex items-center justify-between mb-3">
                  <label class="block text-sm font-semibold text-slate-700">
                    Current Photos 
                    <span v-if="currentPhotos.length" class="text-slate-500 font-normal">({{ currentPhotos.length }} images)</span>
                  </label>
                </div>
                
                <div v-if="currentPhotos.length > 0" class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                  <div 
                    v-for="photo in currentPhotos" 
                    :key="photo.id"
                    class="relative group"
                  >
                    <img 
                      :src="getPhotoUrl(photo)" 
                      class="w-full h-28 object-cover rounded-lg border-2 border-slate-200 group-hover:border-red-300 transition-all duration-200" 
                      :alt="place.title"
                      @error="handleImageError($event, photo)"
                    />
                    
                    <!-- Delete overlay -->
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                      <button
                        type="button"
                        @click="confirmDeletePhoto(photo)"
                        class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full transition-colors duration-200 transform scale-90 group-hover:scale-100"
                      >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                      </button>
                    </div>
                    
                    <!-- Image index -->
                    <div class="absolute top-2 left-2 bg-slate-900/70 text-white text-xs px-2 py-1 rounded-full">
                      {{ currentPhotos.indexOf(photo) + 1 }}
                    </div>
                  </div>
                </div>
                
                <div v-else class="border-2 border-dashed border-slate-200 rounded-xl p-8 text-center">
                  <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                  </div>
                  <p class="text-slate-500 text-sm">No photos uploaded yet</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Add New Photos Section -->
          <div class="mt-8 pt-6 border-t border-slate-100">
            <label class="block text-sm font-semibold text-slate-700 mb-4">
              Add New Photos
              <span class="text-slate-500 font-normal">(optional)</span>
            </label>
            
            <!-- Upload Area -->
            <div 
              class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:border-green-300 transition-colors duration-200 cursor-pointer"
              @click="$refs.fileInput.click()"
              @dragover.prevent="dragover = true"
              @dragleave.prevent="dragover = false"
              @drop.prevent="handleDrop"
              :class="{ 'border-green-300 bg-green-50': dragover }"
            >
              <input
                ref="fileInput"
                type="file"
                multiple
                accept="image/*"
                @change="handleFiles"
                class="hidden"
              />
              
              <div class="space-y-2">
                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto">
                  <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                  </svg>
                </div>
                <p class="text-slate-600 text-sm">Click or drop images here</p>
              </div>
            </div>

            <!-- New Images Preview -->
            <div v-if="newImagePreviews.length" class="mt-4">
              <h4 class="text-sm font-semibold text-slate-700 mb-3">New Images ({{ newImagePreviews.length }})</h4>
              <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                <div 
                  v-for="(preview, index) in newImagePreviews" 
                  :key="index"
                  class="relative group"
                >
                  <img 
                    :src="preview" 
                    class="w-full h-20 object-cover rounded-lg border border-slate-200" 
                    :alt="`New image ${index + 1}`"
                  />
                  <button
                    type="button"
                    @click="removeNewImage(index)"
                    class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors opacity-0 group-hover:opacity-100"
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
              <span class="text-sm font-medium text-slate-700">Updating...</span>
              <span class="text-sm text-slate-600">{{ progress }}%</span>
            </div>
            <div class="w-full bg-slate-200 rounded-full h-2">
              <div 
                class="h-2 rounded-full bg-gradient-to-r from-green-500 to-green-600 transition-all duration-300" 
                :style="{ width: progress + '%' }"
              ></div>
            </div>
          </div>

          <!-- Actions -->
          <div class="flex gap-4 mt-8 pt-6 border-t border-slate-100">
            <button 
              type="button"
              @click="router.visit('/places')"
              class="px-6 py-3 border-2 border-slate-200 text-slate-600 rounded-xl font-semibold hover:border-slate-300 hover:bg-slate-50 transition-all duration-200"
            >
              Cancel
            </button>
            
            <button 
              type="submit" 
              :disabled="loading"
              class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 disabled:from-slate-400 disabled:to-slate-500 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 disabled:transform-none disabled:shadow-none flex items-center justify-center gap-2"
            >
              <svg v-if="loading" class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
              </svg>
              <span>{{ loading ? 'Updating...' : 'Update Place' }}</span>
            </button>

            <button 
              type="button" 
              @click="confirmDelete"
              class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5"
            >
              Delete
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Photo Delete Confirmation Modal -->
    <div 
      v-if="showDeletePhotoModal" 
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
      @click.self="showDeletePhotoModal = false"
    >
      <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 transform transition-all duration-300">
        <div class="text-center">
          <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-slate-800 mb-2">Delete Photo</h3>
          <p class="text-slate-600 mb-6">Are you sure you want to delete this photo? This action cannot be undone.</p>
          
          <div class="flex gap-3">
            <button 
              type="button"
              @click="showDeletePhotoModal = false"
              class="flex-1 px-4 py-2 border-2 border-slate-200 text-slate-600 rounded-xl font-semibold hover:bg-slate-50 transition-colors"
            >
              Cancel
            </button>
            <button 
              type="button"
              @click="executeDeletePhoto"
              class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-colors"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div 
      v-if="showDeleteModal" 
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
      @click.self="showDeleteModal = false"
    >
      <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 transform transition-all duration-300">
        <div class="text-center">
          <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-slate-800 mb-2">Delete Place</h3>
          <p class="text-slate-600 mb-6">Are you sure you want to delete "{{ place.title }}"? This action cannot be undone.</p>
          
          <div class="flex gap-3">
            <button 
              type="button"
              @click="showDeleteModal = false"
              class="flex-1 px-4 py-2 border-2 border-slate-200 text-slate-600 rounded-xl font-semibold hover:bg-slate-50 transition-colors"
            >
              Cancel
            </button>
            <button 
              type="button"
              @click="deletePlace"
              class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-colors"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'


const props = defineProps({
  place: Object
})

const form = ref({
  title: props.place.title,
  description: props.place.description,
  address: props.place.address,
  google_maps_link: props.place.google_maps_link,
  contact_info: props.place.contact_info,
  availability: props.place.availability,
  photos: []
})

const currentPhotos = ref([...props.place.photos || []])
const photoToDelete = ref(null)
const showDeletePhotoModal = ref(false)

const loading = ref(false)
const progress = ref(0)
const dragover = ref(false)
const newImagePreviews = ref([])
const showDeleteModal = ref(false)

// Plus simple maintenant grâce à l'accesseur dans le modèle
function getPhotoUrl(photo) {
  return photo.url || `/storage/${photo.path}` || ''
}

function handleImageError(event, photo) {
  console.error('Image failed to load:', photo)
  // Optionnel: remplacer par une image placeholder
  event.target.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjI0IiBoZWlnaHQ9IjI0IiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0xMiA4VjEyTTE2IDEySDhNMTIgMTZWMTIiIHN0cm9rZT0iIzlDQTNBRiIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiLz4KPC9zdmc+'
}

function confirmDeletePhoto(photo) {
  photoToDelete.value = photo
  showDeletePhotoModal.value = true
}

function executeDeletePhoto() {
  if (!photoToDelete.value) return
  
  const photoId = photoToDelete.value.id
  showDeletePhotoModal.value = false
  
  router.delete(`/places/${props.place.id}/photos/${photoId}`, {
    onSuccess: () => {
      // Retirer la photo de la liste locale
      currentPhotos.value = currentPhotos.value.filter(p => p.id !== photoId)
      showToast('Photo deleted successfully')
    },
    onError: () => showToast('Failed to delete photo', 'error'),
    onFinish: () => {
      photoToDelete.value = null
    }
  })
}

function handleFiles(e) {
  const files = Array.from(e.target.files || [])
  processFiles(files)
}

function handleDrop(e) {
  dragover.value = false
  const files = Array.from(e.dataTransfer.files || [])
  processFiles(files)
}

function processFiles(files) {
  const maxSize = 10 * 1024 * 1024 // 10MB max per file
  const validFiles = []
  
  for (const file of files) {
    if (!file.type.startsWith('image/')) {
      showToast('Please select only image files', 'error')
      continue
    }
    if (file.size > maxSize) {
      showToast(`File ${file.name} exceeds 10MB limit`, 'error')
      continue
    }
    validFiles.push(file)
  }

  if (validFiles.length === 0) return

  form.value.photos = [...form.value.photos, ...validFiles]

  // Generate previews for new images
  validFiles.forEach(file => {
    const reader = new FileReader()
    reader.onload = (ev) => newImagePreviews.value.push(ev.target.result)
    reader.readAsDataURL(file)
  })
}

function removeNewImage(index) {
  newImagePreviews.value.splice(index, 1)
  const newFiles = Array.from(form.value.photos)
  newFiles.splice(index, 1)
  form.value.photos = newFiles
}



function confirmDelete() {
  showDeleteModal.value = true
}

function deletePlace() {
  showDeleteModal.value = false
  loading.value = true
  
  router.delete(`/places/${props.place.id}`, {
    onSuccess: () => {
      showToast('Place deleted successfully')
      setTimeout(() => router.visit('/places'), 1000)
    },
    onError: () => {
      showToast('Failed to delete place', 'error')
      loading.value = false
    }
  })
}

function showToast(message, type = 'success') {
  const toast = document.createElement('div')
  const bgColor = type === 'error' ? 'bg-red-600' : 'bg-green-600'
  const icon = type === 'error' ? 
    '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>' :
    '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>'
  
  toast.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-4 rounded-xl shadow-lg z-50 transform transition-all duration-300 flex items-center gap-3`
  toast.innerHTML = `
    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">${icon}</svg>
    <span class="font-medium">${message}</span>
  `
  
  document.body.appendChild(toast)
  
  setTimeout(() => toast.style.transform = 'translateX(0)', 100)
  setTimeout(() => {
    toast.style.transform = 'translateX(100%)'
    setTimeout(() => toast.remove(), 300)
  }, 3000)
}

function submitForm() {
  // Client-side validation
  if (!form.value.title?.trim() || !form.value.description?.trim() || !form.value.address?.trim() || !form.value.contact_info?.trim()) {
    showToast('Please fill all required fields', 'error')
    return
  }

  loading.value = true
  const data = new FormData()
  
  // Add all form fields
  for (let key in form.value) {
    if (key === 'photos') {
      form.value.photos.forEach(file => data.append('photos[]', file))
    } else {
      data.append(key, form.value[key] || '')
    }
  }
  
  // Add method spoofing for PUT request
  data.append('_method', 'PUT')

  router.post(`/places/${props.place.id}`, data, {
    forceFormData: true,
    onProgress: (event) => {
      if (event.lengthComputable) {
        progress.value = Math.round((event.loaded / event.total) * 100)
      }
    },
    onSuccess: () => {
      showToast('Place updated successfully!')
      setTimeout(() => router.visit('/places'), 1500)
    },
    onError: (errors) => {
      console.error('Update errors', errors)
      showToast('Please check the form for errors', 'error')
    },
    onFinish: () => {
      loading.value = false
      progress.value = 0
    }
  })
}
</script>

<style scoped>
.form-group input:focus,
.form-group textarea:focus {
  box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
}

/* Animation pour les previews */
.grid > div {
  animation: fadeInUp 0.3s ease-out forwards;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Modal animation */
.fixed.inset-0 {
  animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
</style>