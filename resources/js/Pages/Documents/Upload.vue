<template>
  <Header />
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-emerald-50 py-12 px-4">
    <div class="max-w-2xl mx-auto">
      <!-- Main Card -->
      <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-emerald-100 p-8 md:p-12 transition-all duration-300 hover:shadow-emerald-100/50">
        
        <!-- Header Section -->
        <div class="text-center mb-8">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-emerald-400 to-emerald-500 rounded-2xl mb-4 shadow-lg">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
          </div>
          <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-slate-800 to-emerald-600 bg-clip-text text-transparent mb-2">
            Upload Document
          </h1>
          <p class="text-slate-600 text-lg">
            Securely upload your requested document
          </p>
        </div>

        <!-- Error State for Missing Token -->
        <div v-if="!token" class="text-center py-8">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-2xl mb-4">
            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-slate-800 mb-2">Invalid Upload Link</h3>
          <p class="text-red-600 bg-red-50 px-4 py-3 rounded-xl border border-red-200">
            The upload link is missing or invalid. Please check your link and try again.
          </p>
        </div>

        <!-- Upload Form -->
        <form @submit.prevent="submit" class="space-y-6" v-else>
          
          <!-- File Upload Area -->
          <div class="relative">
            <div 
              @drop="handleDrop"
              @dragover="handleDragOver"
              @dragleave="handleDragLeave"
              :class="[
                'border-2 border-dashed rounded-2xl p-8 text-center transition-all duration-300 cursor-pointer group',
                isDragging ? 'border-emerald-400 bg-emerald-50' : 'border-slate-300 hover:border-emerald-400 hover:bg-emerald-50/50',
                selectedFile ? 'border-emerald-400 bg-emerald-50' : ''
              ]"
              @click="$refs.fileInput.click()"
            >
              <input 
                ref="fileInput"
                type="file" 
                @change="handleFile" 
                required 
                class="hidden"
                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
              />
              
              <!-- Upload Icon and Text -->
              <div v-if="!selectedFile" class="space-y-4">
                <div class="mx-auto w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                  <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                </div>
                <div>
                  <p class="text-lg font-semibold text-slate-700 mb-1">
                    Drop your file here or click to browse
                  </p>
                  <p class="text-sm text-slate-500">
                    Supports PDF, DOC, DOCX, JPG, PNG (Max 10MB)
                  </p>
                </div>
              </div>

              <!-- Selected File Display -->
              <div v-else class="flex items-center justify-center space-x-3">
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                  <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                </div>
                <div class="text-left">
                  <p class="font-semibold text-slate-700">{{ selectedFile.name }}</p>
                  <p class="text-sm text-slate-500">{{ formatFileSize(selectedFile.size) }}</p>
                </div>
                <button 
                  @click.stop="removeFile"
                  type="button"
                  class="ml-4 w-8 h-8 bg-red-100 rounded-full flex items-center justify-center hover:bg-red-200 transition-colors"
                >
                  <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <button 
            type="submit" 
            :disabled="processing || !selectedFile"
            :class="[
              'w-full py-4 px-6 rounded-2xl font-semibold text-lg transition-all duration-300 transform',
              processing || !selectedFile 
                ? 'bg-slate-100 text-slate-400 cursor-not-allowed' 
                : 'bg-gradient-to-r from-emerald-500 to-emerald-600 text-white hover:from-emerald-600 hover:to-emerald-700 hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-emerald-200'
            ]"
          >
            <span v-if="processing" class="inline-flex items-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Uploading...
            </span>
            <span v-else>
              {{ selectedFile ? 'Upload Document' : 'Select a file first' }}
            </span>
          </button>
        </form>

        <!-- Success Message -->
        <div 
          v-if="message" 
          class="mt-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center space-x-3 animate-fade-in"
        >
          <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <p class="text-emerald-700 font-medium">{{ message }}</p>
        </div>

        <!-- Error Message -->
        <div 
          v-if="error" 
          class="mt-6 p-4 bg-red-50 border border-red-200 rounded-2xl flex items-center space-x-3 animate-fade-in"
        >
          <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <p class="text-red-700 font-medium">{{ error }}</p>
        </div>
      </div>

      <!-- Footer Info -->
      <div class="text-center mt-8 text-slate-500 text-sm">
        <p>Your document will be processed securely and confidentially.</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'

const props = defineProps({
  token: {
    type: String,
    default: null
  }
})

const token = ref(props.token)
const processing = ref(false)
const message = ref(null)
const error = ref(null)
const selectedFile = ref(null)
const isDragging = ref(false)
const form = useForm({ document: null, token: null })

// Si token n'est pas fourni en props, on le prend depuis l'URL
onMounted(() => {
  if (!token.value) {
    const params = new URLSearchParams(window.location.search)
    token.value = params.get('token')
  }
})

function handleFile(e) {
  const file = e.target.files[0]
  if (file) {
    selectedFile.value = file
    form.document = file
    // Clear any previous messages
    message.value = null
    error.value = null
  }
}

function handleDrop(e) {
  e.preventDefault()
  isDragging.value = false
  
  const files = e.dataTransfer.files
  if (files.length > 0) {
    const file = files[0]
    selectedFile.value = file
    form.document = file
    message.value = null
    error.value = null
  }
}

function handleDragOver(e) {
  e.preventDefault()
  isDragging.value = true
}

function handleDragLeave(e) {
  e.preventDefault()
  isDragging.value = false
}

function removeFile() {
  selectedFile.value = null
  form.document = null
  message.value = null
  error.value = null
}

function formatFileSize(bytes) {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

function submit() {
  if (!token.value) {
    error.value = 'Missing token'
    return
  }
  
  if (!selectedFile.value) {
    error.value = 'Please select a file to upload'
    return
  }

  form.token = token.value
  processing.value = true
  message.value = null
  error.value = null

  form.post('/documents/upload', {
    forceFormData: true,
    onSuccess: () => {
      message.value = 'Document uploaded successfully! Thank you.'
      selectedFile.value = null
      form.document = null
      processing.value = false
    },
    onError: (errs) => {
      error.value = errs?.document || 'Upload failed. Please try again.'
      processing.value = false
    },
    onFinish: () => {
      processing.value = false
    }
  })
}
</script>

<style scoped>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 0.3s ease-out;
}
</style>