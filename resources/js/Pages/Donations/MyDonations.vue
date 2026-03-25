<template>
  
  <div>
  <img
  src="/textured.png"
  alt="Impact Background"
  class="fixed inset-0 w-full h-full object-cover opacity-20 pointer-events-none select-none"
  style="z-index: -1;"
/>
<Header />
    <div class="max-w-6xl mx-auto py-10 px-4">
      <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-gray-800 mb-3">My Donations</h1>
        <p class="text-gray-600 text-lg">Manage and track your contributions</p>
      </div>
      
      <div v-if="donations.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="donation in donations"
          :key="donation.id"
          class="bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-xl hover:border-green-200 transition-all duration-300 relative overflow-hidden"
          :class="{ 'opacity-75': isExpired(donation.expiration_date) }"
        >
          <!-- Badge urgent si proche de l'expiration -->
          <div 
            v-if="isUrgent(donation.expiration_date)"
            class="absolute top-3 right-3 bg-red-100 border border-red-300 text-red-700 text-xs font-semibold px-3 py-1 rounded-full shadow-sm pulse-animation z-10"
          >
            URGENT
          </div>

          <!-- Badge expired si expiré -->
          <div 
            v-if="isExpired(donation.expiration_date)"
            class="absolute top-3 right-3 bg-gray-500 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-sm z-10"
          >
            EXPIRED
          </div>

          <!-- Barre de couleur en haut -->
          <div 
            class="h-1"
            :class="isExpired(donation.expiration_date) 
              ? 'bg-gradient-to-r from-gray-400 to-gray-500' 
              : 'bg-gradient-to-r from-green-400 to-green-500'"
          ></div>

          <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-2 leading-tight">{{ donation.title }}</h2>
            <p class="text-gray-600 text-sm mb-4 leading-relaxed">{{ donation.description }}</p>
            
            <div class="space-y-2 mb-4">
              <div class="flex items-center text-sm">
                <span class="text-gray-800 font-medium w-16 ">Qty:</span>
                <span class="text-gray-600">{{ donation.quantity }} {{ donation.unit }}</span>
              </div>
              <div class="flex items-center text-sm">
                <span class="text-gray-800 font-medium w-16">Period:</span>
                <span class="text-gray-600">{{ formatDate(donation.available_from) }} → {{ formatDate(donation.available_until) }}</span>
              </div>
              <div class="flex items-center text-sm">
                <span class="text-gray-800 font-medium w-16">Location:</span>
                <span class="text-gray-600">{{ donation.city }}, {{ donation.postal_code }}</span>
              </div>
              <div class="flex items-center text-sm">
                <span class="text-gray-800 font-medium w-16">Expires:</span>
                <span 
                  class="text-gray-600" 
                  :class="{ 
                    'text-red-600 font-medium': isUrgent(donation.expiration_date),
                    'text-gray-500 line-through': isExpired(donation.expiration_date)
                  }"
                >
                  {{ formatDate(donation.expiration_date) }}
                </span>
              </div>
              <div v-if="donation.need_volunteers > 0" class="flex items-center text-sm">
                <span class="text-gray-800 font-medium w-20">Volunteers:  </span>
                <span class="text-gray-600">
                {{ donation.need_volunteers - donation.volunteers_count }} still needed
                </span>
              </div>
            </div>

            <!-- Request Volunteers Form Toggle -->
            <div v-if="editingNeeds[donation.id]" class="mb-4 p-4 bg-green-50 rounded-lg border border-green-200">
              <div class="mb-2">
                <label class="block text-sm font-medium text-gray-700"># Volunteers</label>
                <input
                  type="number"
                  v-model.number="needs[donation.id].need_volunteers"
                  min="0"
                  class="w-24 mt-1 px-2 py-1 border rounded"
                />
              </div>
              <div class="mb-2">
                <label class="block text-sm font-medium text-gray-700">Note</label>
                <textarea
                  v-model="needs[donation.id].volunteer_note"
                  rows="2"
                  class="w-full mt-1 px-2 py-1 border rounded"
                ></textarea>
              </div>
              <div class="flex gap-2">
                <button
                  @click="submitNeeds(donation.id)"
                  class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded"
                >Save</button>
                <button
                  @click="cancelNeeds(donation.id)"
                  class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded"
                >Cancel</button>
              </div>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-gray-100">
              <div class="flex gap-2">
                <!-- Bouton Edit -->
                <Link 
                  v-if="!isExpired(donation.expiration_date)"
                  :href="`/donations/${donation.id}/edit`" 
                  class="bg-green-500 hover:bg-green-600 text-white text-xs font-medium px-4 py-2 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-sm"
                >
                  Edit
                </Link>
                
                <!-- Bouton Edit Disabled -->
                <button 
                  v-else
                  disabled
                  class="bg-gray-300 text-gray-500 text-xs font-medium px-4 py-2 rounded-lg cursor-not-allowed shadow-sm"
                  title="Cannot edit expired donation"
                >
                  Edit
                </button>
                
                <!-- Bouton Delete -->
                <button 
                  @click="confirmDelete(donation)"
                  class="bg-red-100 hover:bg-red-200 text-red-700 border border-red-300 text-xs font-medium px-4 py-2 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-sm"
                >
                  Delete
                </button>
              </div>

              <!-- Bouton Request Volunteers -->
              <button
                v-if="!editingNeeds[donation.id] && !isExpired(donation.expiration_date)"
                @click="startNeeds(donation.id)"
                class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium px-3 py-1 rounded-lg transition-all duration-200 shadow-sm"
              >
                {{ donation.need_volunteers > 0 ? 'Update Need' : 'Request Volunteers' }}
              </button>

              <!-- Bouton Request Volunteers Disabled -->
              <button
                v-if="!editingNeeds[donation.id] && isExpired(donation.expiration_date)"
                disabled
                class="bg-gray-300 text-gray-500 text-xs font-medium px-3 py-1 rounded-lg cursor-not-allowed shadow-sm"
                title="Cannot request volunteers for expired donation"
              >
                {{ donation.need_volunteers > 0 ? 'Update Need' : 'Request Volunteers' }}
              </button>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="text-center py-16">
        <div class="bg-green-50 border-2 border-dashed border-green-300 rounded-xl p-8 max-w-md mx-auto">
          <div class="text-green-500 text-6xl mb-4">🎁</div>
          <h3 class="text-xl font-semibold text-green-700 mb-2">No donations yet</h3>
          <p class="text-green-600 mb-4">You haven't published any donations yet. Start sharing to help your community!</p>
          <Link 
            href="/donations/create" 
            class="inline-block bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-sm"
          >
            ➕ Create your first donation
          </Link>
        </div>
      </div>
    </div>
  </div>
  
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'


const props = defineProps({
  donations: Array
})

// Track which donation is in "request volunteers" edit mode
const editingNeeds = ref({})

// Temp store of need_volunteers & volunteer_note per donation
const needs = ref({})

// When user clicks "Request Volunteers" or "Update Need"
function startNeeds(id) {
  editingNeeds.value[id] = true
  needs.value[id] = {
    need_volunteers: props.donations.find(d => d.id === id).need_volunteers || 0,
    volunteer_note: props.donations.find(d => d.id === id).volunteer_note || ''
  }
}

// Cancel edit mode
function cancelNeeds(id) {
  delete editingNeeds.value[id]
  delete needs.value[id]
}

// Submit the update 
function submitNeeds(id) {
  console.log('Submitting volunteer need for', id, needs.value[id]);

  router.put(`/donations/${id}`, needs.value[id], {
    onSuccess: () => {
      console.log('Updated successfully');
      editingNeeds.value[id] = false
    },
    onError: (e) => {
      console.error('Update failed', e);
    }
  })
}

// Reuse these from before
const formatDate = (value) => {
  if (!value) return ''
  return new Date(value).toLocaleString('en-US', {
    hour: '2-digit',
    minute: '2-digit',
    day: 'numeric',
    month: 'short'
  })
}

const isUrgent = (exp) => {
  if (!exp) return false
  const now = new Date()
  const expiration = new Date(exp)
  const diffDays = Math.ceil((expiration - now)/(1000*60*60*24))
  return diffDays <= 1 && diffDays >= 0
}

// New function to check if donation is expired
const isExpired = (exp) => {
  if (!exp) return false
  const now = new Date()
  const expiration = new Date(exp)
  return now > expiration
}

function confirmDelete(donation) {
  if (confirm(`Delete "${donation.title}"? This cannot be undone.`)) {
    router.delete(`/donations/${donation.id}`)
  }
}
</script>

<style scoped>
.pulse-animation {
  animation: pulse 2s infinite;
}
@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.05); }
  100% { transform: scale(1); }
}
</style>