<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-green-50">
    <Header/>
    <div class="max-w-6xl mx-auto px-6 py-8">
      <!-- État vide avec design moderne -->
      <div v-if="places.length === 0" class="text-center py-16">
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
          <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">No places added</h3>
        <p class="text-gray-500 max-w-md mx-auto">
          Start by adding your first place to create your personal collection.
        </p>
      </div>

      <!-- Grille des cartes modernisée -->
      <div v-else class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        <div 
          v-for="place in places" 
          :key="place.id" 
          class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-green-200"
        >
          <!-- Section photos avec overlay moderne -->
          <div class="relative h-48 bg-gradient-to-br from-green-100 to-emerald-100">
            <div v-if="place.photos && place.photos.length > 0" class="flex gap-1 h-full">
              <img 
                v-for="(photo, index) in place.photos.slice(0, 3)" 
                :key="photo.id"
                :src="photo.url" 
                :class="[
                  'object-cover transition-transform duration-300 group-hover:scale-105',
                  place.photos.length === 1 ? 'w-full h-full rounded-t-2xl' : 'flex-1',
                  index === 0 ? 'rounded-tl-2xl' : '',
                  index === place.photos.length - 1 ? 'rounded-tr-2xl' : ''
                ]"
                :alt="`Photo of ${place.title}`"
              />
            </div>
            <div v-else class="flex items-center justify-center h-full">
              <svg class="w-16 h-16 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            </div>
            
            <!-- Badge de disponibilité -->

          </div>

          <!-- Contenu de la carte -->
          <div class="p-6">
            <div class="mb-4">
              <h3 class="font-bold text-xl text-gray-800 mb-2 group-hover:text-green-700 transition-colors">
                {{ place.title }}
              </h3>
              <p class="text-gray-600 text-sm leading-relaxed line-clamp-2">
                {{ place.description }}
              </p>
            </div>

            <!-- Informations de contact avec icônes -->
            <div class="space-y-2 mb-6">
              <div v-if="place.contact_info" class="flex items-center gap-2 text-sm text-gray-500">
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span>{{ place.contact_info }}</span>
              </div>

              <a 
                v-if="place.google_maps_link" 
                :href="place.google_maps_link" 
                target="_blank" 
                class="inline-flex items-center gap-2 text-sm text-green-600 hover:text-green-700 transition-colors"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>View on Google Maps</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
              </a>
            </div>

            <!-- Actions avec design moderne -->
            <div class="flex gap-3">
              <button 
                @click="editPlace(place.id)" 
                class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-xl text-sm font-medium hover:from-green-600 hover:to-emerald-600 transition-all duration-200 shadow-sm hover:shadow-md"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
              </button>
              <button 
                @click="deletePlace(place.id)" 
                class="px-4 py-3 bg-gray-100 text-gray-600 rounded-xl text-sm font-medium hover:bg-red-50 hover:text-red-600 transition-all duration-200 border border-gray-200 hover:border-red-200"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'


const props = defineProps({
  places: Array
})

function editPlace(id) {
  router.visit(`/places/${id}/edit`)
}

function deletePlace(id) {
  if (confirm('Are you sure you want to delete this place?')) {
    router.delete(`/places/${id}`, {
      onSuccess: () => router.reload()
    })
  }
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>