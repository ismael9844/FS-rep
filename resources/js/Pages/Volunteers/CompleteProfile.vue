<template>
  <div class="min-h-screen bg-gradient-to-br from-green-100 via-green-50 to-white py-8 px-4">
    <div class="max-w-2xl mx-auto">
      <!-- Back Button -->
        <div class="mb-6">
          <button
            @click="goBack"
            class="group inline-flex items-center px-6 py-3 bg-white/80 backdrop-blur-sm hover:bg-white/90 text-gray-700 hover:text-emerald-600 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 border border-emerald-100/50"
          >
            <svg 
              class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-200" 
              fill="none" 
              stroke="currentColor" 
              viewBox="0 0 24 24"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="font-medium">Back</span>
          </button>
        </div>

      <!-- Header Card -->
      <div class="bg-white shadow-sm border border-green-100 rounded-2xl p-6 mb-6">
        <div class="flex items-center space-x-3">
          <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
          </div>
          <div>
            <h1 class="text-2xl font-bold text-gray-800">Your Volunteer Profile</h1>
            <p class="text-sm text-gray-500">Complete your profile to help more people</p>
          </div>
        </div>
      </div>

      <!-- Profile Form -->
      <div class="bg-white shadow-sm border border-green-100 rounded-2xl p-8">
        <form @submit.prevent="submit" class="space-y-6">
          
          <!-- Phone Field -->
          <div class="space-y-2">
            <label class="flex items-center text-sm font-medium text-gray-700">
              <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
              </svg>
              Phone Number
            </label>
            <input
              v-model="form.phone"
              type="tel"
              placeholder="Enter your phone number"
              class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 ease-in-out"
              :class="{ 'border-red-300 focus:ring-red-500 focus:border-red-500': form.errors.phone }"
            />
            <p v-if="form.errors.phone" class="text-red-600 text-sm flex items-center">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              {{ form.errors.phone }}
            </p>
          </div>

          <!-- Skills Field -->
          <div class="space-y-2">
            <label class="flex items-center text-sm font-medium text-gray-700">
              <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
              </svg>
              Skills & Expertise
            </label>
            <textarea
              v-model="form.skills"
              rows="3"
              placeholder="Describe your skills (e.g., cooking, driving, organizing events, languages spoken...)"
              class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 ease-in-out resize-none"
              :class="{ 'border-red-300 focus:ring-red-500 focus:border-red-500': form.errors.skills }"
            ></textarea>
            <p v-if="form.errors.skills" class="text-red-600 text-sm flex items-center">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              {{ form.errors.skills }}
            </p>
          </div>

          <!-- Availability Field -->
          <div class="space-y-2">
            <label class="flex items-center text-sm font-medium text-gray-700">
              <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              Availability
            </label>
            <textarea
              v-model="form.availability"
              rows="3"
              placeholder="When are you available? (e.g., Weekends, Evenings, Mornings, Flexible...)"
              class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 ease-in-out resize-none"
              :class="{ 'border-red-300 focus:ring-red-500 focus:border-red-500': form.errors.availability }"
            ></textarea>
            <p v-if="form.errors.availability" class="text-red-600 text-sm flex items-center">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              {{ form.errors.availability }}
            </p>
          </div>

          <!-- Submit Button -->
          <div class="pt-4">
            <button
              type="submit"
              class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 ease-in-out transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"
              :disabled="form.processing"
            >
              <span v-if="form.processing" class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Saving...
              </span>
              <span v-else class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Profile
              </span>
            </button>
          </div>
        </form>
      </div>

      <!-- Helper Card -->
      <div class="bg-green-50 border border-green-200 rounded-2xl p-6 mt-6">
        <div class="flex items-start space-x-3">
          <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div>
            <h3 class="font-medium text-green-800 mb-1">Why complete your profile?</h3>
            <p class="text-sm text-green-700">
              A complete profile gives donors insight into your skills and availability, making your contribution more meaningful and effective.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="mt-16 pt-8 pb-6 border-t border-green-100 bg-white">
      <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <!-- Company Info -->
          <div class="col-span-1 md:col-span-2">
            <div class="flex items-center space-x-2 mb-4">
              <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
              </div>
              <h3 class="text-lg font-bold text-gray-800">FoodDonation</h3>
            </div>
            <p class="text-gray-600 text-sm mb-4 max-w-md">
              Connecting passionate volunteers with meaningful opportunities to make a positive impact in their communities.
            </p>
            <div class="flex space-x-4">
              <a href="#" class="text-gray-400 hover:text-green-600 transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                </svg>
              </a>

              <a href="#" class="text-gray-400 hover:text-green-600 transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
              </a>
            </div>
          </div>

          <!-- Quick Links -->
          <div>
            <h4 class="font-semibold text-gray-800 mb-4">Quick Links</h4>
            <ul class="space-y-2">
              <li>
                <Link href="/dashboard2" class="text-sm text-gray-600 hover:text-green-600 transition-colors">
                  Dashboard
                </Link>
              </li>
              <li>
                <Link href="/opportunities" class="text-sm text-gray-600 hover:text-green-600 transition-colors">
                  Opportunities
                </Link>
              </li>
              <li>
                <Link href="/donor-profile" class="text-sm text-gray-600 hover:text-green-600 transition-colors">
                  My Profile
                </Link>
              </li>
              <li>
                <Link href="/about" class="text-sm text-gray-600 hover:text-green-600 transition-colors">
                  About Us
                </Link>
              </li>
            </ul>
          </div>

          <!-- Support -->
          <div>
            <h4 class="font-semibold text-gray-800 mb-4">Support</h4>
            <ul class="space-y-2">
              <li>
                <Link href="/help" class="text-sm text-gray-600 hover:text-green-600 transition-colors">
                  Help Center
                </Link>
              </li>
              <li>
                <Link href="/contact" class="text-sm text-gray-600 hover:text-green-600 transition-colors">
                  Contact Us
                </Link>
              </li>
              <li>
                <Link href="/privacy" class="text-sm text-gray-600 hover:text-green-600 transition-colors">
                  Privacy Policy
                </Link>
              </li>
              <li>
                <Link href="/terms" class="text-sm text-gray-600 hover:text-green-600 transition-colors">
                  Terms of Service
                </Link>
              </li>
            </ul>
          </div>
        </div>

        <!-- Bottom Bar -->
        <div class="mt-8 pt-6 border-t border-gray-200">
          <div class="flex flex-col md:flex-row justify-between items-center">
            <p class="text-sm text-gray-500">
              © {{ new Date().getFullYear() }} FoodDonation. All rights reserved.
            </p>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'

const docFile = ref(null)
const preview = ref(null)
const isImage = ref(false)
const fileName = ref('')
const fileSize = ref('')
const uploadError = ref(null)
const uploading = ref(false)
let objectUrl = null // pour revoke

const uploadForm = useForm({
  document: null
})

const props = defineProps({
  volunteer: Object
})

const goBack = () => {
  if (window.history.length > 1) {
    window.history.back()
  } else {
    router.visit('/dashboard')
  }
}

// Initialise le form avec les valeurs existantes
const form = useForm({
  phone: props.volunteer.phone || '',
  skills: props.volunteer.skills || '',
  availability: props.volunteer.availability || ''
})

const submit = () => {
  // Envoie en PATCH vers /volunteer/{id}
  form.patch(route('volunteer.update', props.volunteer.id), {
    onSuccess: () => {
      // tu peux afficher une notification ici
    }
  })
}
function onFileChange(e) {
  const f = e.target.files?.[0]
  if (!f) return

  // taille max 5MB (5120 KB)
  if (f.size > 5 * 1024 * 1024) {
    uploadError.value = 'File must be <= 5MB'
    return
  }

  uploadError.value = null
  fileName.value = f.name
  fileSize.value = (f.size / 1024).toFixed(1) + ' KB'
  isImage.value = f.type.startsWith('image/')

  // si on avait créé un objectURL précédent, le libérer
  if (objectUrl) {
    URL.revokeObjectURL(objectUrl)
    objectUrl = null
  }

  if (isImage.value) {
    // preview dataURL pour images
    const reader = new FileReader()
    reader.onload = evt => preview.value = evt.target.result
    reader.readAsDataURL(f)
  } else {
    // pour PDF autres types -> createObjectURL (utile pour <object> preview / ouverture)
    objectUrl = URL.createObjectURL(f)
    preview.value = objectUrl
  }

  // IMPORTANT: attacher le fichier au form Inertia (FormData)
  uploadForm.document = f
}

function removeFile() {
   if (objectUrl) {
    URL.revokeObjectURL(objectUrl)
    objectUrl = null
  }
  docFile.value = null
  preview.value = null
  uploadForm.document = null
  fileName.value = ''
  fileSize.value = ''
  uploadError.value = null
}

function uploadDocument() {
  if (!uploadForm.document) {
    uploadError.value = 'Please select a file'
    return
  }

  uploading.value = true
  uploadError.value = null

  // Utilise le chemin direct si 'route()' JS n'existe pas dans ton projet (Ziggy)
  const url = typeof route === 'function' ? route('volunteer.upload-document') : '/volunteer/upload-document'

  uploadForm.post(url, {
    forceFormData: true, // CRUCIAL pour envoyer FormData
    onSuccess: (page) => {
      uploading.value = false
      // clear and optionally refresh
      removeFile()
      // tu peux rediriger ou reload si tu veux assurer l'état
      location.reload()
    },
    onError: (errors) => {
      uploading.value = false
      console.error('Upload errors', errors)
      // show first useful error
      if (errors?.document) uploadError.value = errors.document
      else if (errors?.message) uploadError.value = errors.message
      else uploadError.value = 'Upload failed'
    },
    onFinish: () => {
      uploading.value = false
    }
  })

}
</script>