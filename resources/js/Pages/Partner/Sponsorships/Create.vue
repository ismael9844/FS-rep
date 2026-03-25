<template>
      <Header />
  <div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 py-12 px-4">
    <div class="max-w-2xl mx-auto">
      <!-- En-tête avec icône -->
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
          <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
          </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Become a Sponsor</h1>
        <p class="text-gray-600">Join our community and showcase your brand</p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Si l'utilisateur a déjà une demande pending ou active -->
        <div
          v-if="existing"
          class="p-8 bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-amber-400"
        >
          <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
              <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z"/>
              </svg>
            </div>
            <div class="flex-1">
              <p class="font-semibold text-amber-800 mb-2">
                Existing Sponsorship Found
              </p>
              <p class="text-amber-700 mb-4">
                You already have a sponsorship with status: 
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800 ml-2">
                  {{ existing.status }}
                </span>
                <span v-if="existing.tier" class="block mt-2">
                  Tier: <em class="font-medium">{{ existing.tier.name }}</em>
                </span>
              </p>
              <Link
                href="/dashboard"
                class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors duration-200 font-medium"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Return to Dashboard
              </Link>
            </div>
          </div>
        </div>

        <!-- Formulaire de demande -->
        <form v-else @submit.prevent="submit" class="p-8 space-y-8" enctype="multipart/form-data">
          <!-- Sélection du tier -->
          <div class="space-y-3">
            <label for="tier" class="block text-sm font-semibold text-gray-900">
              Choose Your Sponsorship Tier
            </label>
            <div class="relative">
              <select
                id="tier"
                v-model="form.tier_id"
                required
                class="w-full appearance-none bg-white border-2 border-gray-200 rounded-xl px-4 py-3 pr-10 focus:outline-none focus:border-green-400 focus:ring-4 focus:ring-green-100 transition-all duration-200"
              >
                <option value="" disabled class="text-gray-400">Select a tier</option>
                <option
                  v-for="tier in tiers"
                  :key="tier.id"
                  :value="tier.id"
                  class="text-gray-900"
                >
                  {{ tier.name }}  ({{ tier.duration_days }} days)
                </option>
              </select>
              <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
              </div>
            </div>
            <InputError :message="form.errors.tier_id" class="mt-2" />
          </div>

          <!-- Zone d'upload des images -->
          <div class="space-y-3">
            <label class="block text-sm font-semibold text-gray-900">
              Banner Images
            </label>
            
            <!-- Zone d'upload -->
            <div class="relative" v-show="selectedImages.length < 3">
              <input
                type="file"
                multiple
                accept="image/*"
                @change="handleImages"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
              />
              <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-green-400 hover:bg-green-50 transition-all duration-200">
                <div class="flex flex-col items-center space-y-3">
                  <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                  </div>
                  <div>
                    <p class="text-lg font-medium text-gray-900">Drop your images here</p>
                    <p class="text-sm text-gray-500">or click to browse files</p>
                  </div>
                  <div class="flex items-center space-x-1 text-xs text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ 3 - selectedImages.length }} more images • JPG, PNG • Max 2MB each</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Preview des images -->
            <div v-if="selectedImages.length > 0" class="mt-4">
              <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div
                  v-for="(image, index) in selectedImages"
                  :key="index"
                  class="relative group bg-gray-100 rounded-xl overflow-hidden aspect-video"
                >
                  <img
                    :src="image.preview"
                    :alt="`Preview ${index + 1}`"
                    class="w-full h-full object-cover"
                  />
                  
                  <!-- Overlay avec informations -->
                  <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 flex items-center justify-center">
                    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-center">
                      <button
                        type="button"
                        @click="removeImage(index)"
                        class="inline-flex items-center px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 text-sm font-medium"
                      >
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Remove
                      </button>
                    </div>
                  </div>


                </div>
              </div>
            </div>

            <InputError :message="form.errors.images" class="mt-2" />
          </div>

          <!-- Bouton de soumission -->
          <div class="pt-4">
            <button
              type="submit"
              :disabled="form.processing"
              class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 px-6 rounded-xl font-semibold text-lg hover:from-green-600 hover:to-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus:ring-4 focus:ring-green-100 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02]"
            >
              <span v-if="form.processing" class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Sending Request...
              </span>
              <span v-else class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                Send Sponsorship Request
              </span>
            </button>
          </div>
        </form>
      </div>

      <!-- Footer informatif -->
      <div class="mt-8 text-center">
        <p class="text-sm text-gray-500">
          Need help? <a href="#" class="text-green-600 hover:text-green-700 font-medium">Contact our support team</a>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import Header from '@/Components/Header.vue'


const props = defineProps({
  tiers: {
    type: Array,
    required: true
  },
  existing: {
    type: Object,
    default: null
  }
})

const form = useForm({
  tier_id: null,
  images: []
})

const selectedImages = ref([])

function handleImages(e) {
  const files = Array.from(e.target.files)
  
  files.forEach(file => {
    // Vérifier la limite de 3 images
    if (selectedImages.value.length >= 3) {
      return
    }
    
    // Vérifier la taille du fichier (2MB max)
    if (file.size > 2 * 1024 * 1024) {
      alert(`File ${file.name} is too large. Maximum size is 2MB.`)
      return
    }
    
    // Créer une preview
    const reader = new FileReader()
    reader.onload = (event) => {
      selectedImages.value.push({
        file: file,
        preview: event.target.result
      })
      
      // Mettre à jour le form
      updateFormImages()
    }
    reader.readAsDataURL(file)
  })
  
  // Réinitialiser l'input
  e.target.value = ''
}

function removeImage(index) {
  selectedImages.value.splice(index, 1)
  updateFormImages()
}

function updateFormImages() {
  form.images = selectedImages.value.map(img => img.file)
}

function formatFileSize(bytes) {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i]
}

function submit() {
  form.post(route('sponsorships.store'), {
    forceFormData: true,
    onSuccess: () => {
      form.reset('tier_id', 'images')
      selectedImages.value = []
    }
  })
}
</script>