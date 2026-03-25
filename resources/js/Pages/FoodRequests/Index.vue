<template>
<Header />
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto py-8 px-4">
      
      <!-- Access Denied Message for non-partners/admins -->
      <div v-if="!canAccessRequests" class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
          <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-8 text-center">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Partner Access Required</h1>
            <p class="text-blue-100">You need to be a partner to create food requests</p>
          </div>

          <div class="p-8">
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg mb-6">
              <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                  <h3 class="text-lg font-semibold text-blue-900 mb-2">Why do I need partner access?</h3>
                  <p class="text-blue-800 leading-relaxed mb-3">
                    Food requests are reserved for verified partners and organizations to ensure accountability and proper food distribution to those in need.
                  </p>
                  <ul class="text-blue-800 space-y-2">
                    <li class="flex items-start">
                      <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                      </svg>
                      <span>Partners can request food assistance for their communities</span>
                    </li>
                    <li class="flex items-start">
                      <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                      </svg>
                      <span>Track donations and contributions in real-time</span>
                    </li>
                    <li class="flex items-start">
                      <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                      </svg>
                      <span>Access exclusive partner features and support</span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="bg-gradient-to-r from-emerald-50 to-green-50 border border-emerald-200 p-6 rounded-lg mb-6">
              <h3 class="text-lg font-semibold text-emerald-900 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                How to become a partner
              </h3>
              <ol class="text-emerald-800 space-y-3">
                <li class="flex items-start">
                  <span class="bg-emerald-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 flex-shrink-0">1</span>
                  <span>Contact our admin team using the email below</span>
                </li>
                <li class="flex items-start">
                  <span class="bg-emerald-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 flex-shrink-0">2</span>
                  <span>Provide information about your organization</span>
                </li>
                <li class="flex items-start">
                  <span class="bg-emerald-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 flex-shrink-0">3</span>
                  <span>Wait for admin approval (usually within 24-48 hours)</span>
                </li>
                <li class="flex items-start">
                  <span class="bg-emerald-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 flex-shrink-0">4</span>
                  <span>Start creating food requests and helping your community!</span>
                </li>
              </ol>
            </div>

            <div class="text-center">
              <a 
                href="mailto:isadiak98@gmail.com?subject=Partnership Request - FoodShare&body=Hello,%0D%0A%0D%0AI would like to become a partner with FoodShare.%0D%0A%0D%0AOrganization Name:%0D%0AContact Person:%0D%0APhone:%0D%0ADescription:%0D%0A%0D%0AThank you!"
                class="inline-flex items-center bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-8 py-4 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105"
              >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Contact Admin Team
              </a>
              <p class="text-sm text-gray-500 mt-3">
                Email: <a href="mailto:isadiak98@gmail.com" class="text-blue-600 hover:underline font-medium">isadiak98@gmail.com</a>
              </p>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200">
              <Link 
                href="/dashboard" 
                class="inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors"
              >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Dashboard
              </Link>
            </div>
          </div>
        </div>
      </div>

      <!-- Original Content (only shown if user has access) -->
      <template v-else>
        <!-- Header Section -->
        <div class="mb-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-2">My Food Requests</h1>
          <p class="text-gray-600">Manage your community food assistance requests</p>
        </div>

        <!-- Action Bar -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
          <Link href="/food-requests/create" 
                class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2 rounded-lg transition-colors duration-200 shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Request
          </Link>

          <!-- Stats -->
          <div class="flex items-center space-x-4 text-sm text-gray-600">
            <span>Total: {{ requests.total || requests.length }}</span>
            <span v-if="requests.data">Active: {{ requests.data.length }}</span>
          </div>
        </div>

        <!-- Requests List -->
        <div v-if="requestsData.length" class="space-y-4 mb-8">
          <div v-for="r in requestsData" :key="r.id"
               class="bg-white shadow-sm rounded-xl border border-gray-200 hover:shadow-md transition-shadow duration-200">
            
            <div class="p-6">
              <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                  <h2 class="text-xl font-bold text-gray-900 mb-2">{{ r.title }}</h2>
                  <p class="text-gray-600 leading-relaxed">{{ r.description }}</p>
                </div>
                
                <!-- Actions -->
                <div class="flex items-center space-x-2 ml-4">
                  <Link :href="`/food-requests/${r.id}/edit`"
                        class="inline-flex items-center text-gray-500 hover:text-blue-600 transition-colors p-2 rounded-lg hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                  </Link>
                  <button @click="confirmDelete(r.id)"
                          class="inline-flex items-center text-gray-500 hover:text-red-600 transition-colors p-2 rounded-lg hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                </div>
              </div>

              <!-- Progress Indicators -->
              <div class="grid md:grid-cols-2 gap-4 mb-4">
                <!-- Food Progress -->
                <div v-if="r.quantity" class="space-y-2">
                  <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-700">Food Progress</span>
                    <span class="text-sm text-gray-500">{{ getFoodDonated(r) }} / {{ r.quantity }}</span>
                  </div>
                  <div class="w-full bg-gray-200 rounded-full h-2">
                    <div 
                      :style="{ width: getFoodProgressPercent(r) + '%' }" 
                      class="h-2 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full transition-all duration-300"
                    ></div>
                  </div>
                </div>

                <!-- Money Progress -->
                <div v-if="r.target_amount" class="space-y-2">
                  <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-700">Funding Progress</span>
                    <span class="text-sm text-gray-500">€{{ getMoneyCollected(r).toFixed(2) }} / €{{ Number(r.target_amount).toFixed(2) }}</span>
                  </div>
                  <div class="w-full bg-gray-200 rounded-full h-2">
                    <div 
                      :style="{ width: getMoneyProgressPercent(r) + '%' }" 
                      class="h-2 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-full transition-all duration-300"
                    ></div>
                  </div>
                </div>
              </div>

              <!-- Status and Actions -->
              <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div class="flex items-center space-x-4">
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                    {{ getStatusText(r) }}
                  </span>
                  <span class="text-sm text-gray-500">
                    Created {{ formatDate(r.created_at) }}
                  </span>
                </div>
                
                <Link :href="`/food-requests/${r.id}`"
                      class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors">
                  View Details
                  <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                  </svg>
                </Link>
              </div>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-16">
          <svg class="mx-auto w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
          <h3 class="text-lg font-medium text-gray-900 mb-2">No food requests yet</h3>
          <p class="text-gray-600 mb-6">Start by creating your first food assistance request</p>
          <Link href="/food-requests/create" 
                class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2 rounded-lg transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create First Request
          </Link>
        </div>

        <!-- Pagination -->
        <div v-if="requests.links && requests.links.length > 3" class="mt-8">
          <nav class="flex items-center justify-between">
            <div class="flex items-center text-sm text-gray-700">
              <span>
                Showing {{ requests.from }} to {{ requests.to }} of {{ requests.total }} results
              </span>
            </div>
            
            <div class="flex items-center space-x-2">
              <!-- Previous Button -->
              <Link 
                v-if="requests.prev_page_url"
                :href="requests.prev_page_url"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
              >
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Previous
              </Link>
              
              <!-- Page Numbers -->
              <div class="flex items-center space-x-1">
                <template v-for="(link, index) in requests.links" :key="index">
                  <Link
                    v-if="link.url && !link.label.includes('Previous') && !link.label.includes('Next')"
                    :href="link.url"
                    :class="[
                      'px-3 py-2 text-sm font-medium rounded-lg transition-colors',
                      link.active 
                        ? 'bg-emerald-600 text-white' 
                        : 'text-gray-700 bg-white border border-gray-300 hover:bg-gray-50'
                    ]"
                  >
                    {{ link.label }}
                  </Link>
                  <span
                    v-else-if="!link.url && !link.label.includes('Previous') && !link.label.includes('Next')"
                    class="px-3 py-2 text-sm font-medium text-gray-400"
                  >
                    {{ link.label }}
                  </span>
                </template>
              </div>
              
              <!-- Next Button -->
              <Link 
                v-if="requests.next_page_url"
                :href="requests.next_page_url"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
              >
                Next
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
              </Link>
            </div>
          </nav>
        </div>
      </template>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-xl shadow-xl p-6 max-w-md w-full mx-4">
        <div class="flex items-center mb-4">
          <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-900">Delete Request</h3>
        </div>
        <p class="text-gray-600 mb-6">Are you sure you want to delete this food request? This action cannot be undone.</p>
        <div class="flex justify-end space-x-3">
          <button @click="showDeleteModal = false"
                  class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
            Cancel
          </button>
          <button @click="deleteRequest"
                  class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
            Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'

const page = usePage()
const props = defineProps({ requests: [Array, Object] })

const showDeleteModal = ref(false)
const deleteId = ref(null)

// Check if user has access (admin or partner)
const canAccessRequests = computed(() => {
  const user = page.props.auth?.user
  return user && (user.role === 'admin' || user.role === 'partner')
})

// Handle both array and paginated object formats
const requestsData = computed(() => {
  if (Array.isArray(props.requests)) {
    return props.requests
  }
  return props.requests.data || []
})

function confirmDelete(id) {
  deleteId.value = id
  showDeleteModal.value = true
}

function deleteRequest() {
  if (deleteId.value) {
    router.delete(`/food-requests/${deleteId.value}`, {
      preserveScroll: true,
      onSuccess: () => {
        showDeleteModal.value = false
        deleteId.value = null
      }
    })
  }
}

// Helper functions
function getFoodDonated(request) {
  if (!request.food_request_donations) return 0
  return request.food_request_donations
  .filter(d => d.status === 'confirmed') 
  .reduce((sum, d) => sum + Number(d.quantity), 0)
}

function getFoodProgressPercent(request) {
  const neededFood = request.quantity || 0
  const totalFoodDonated = getFoodDonated(request)
  return neededFood > 0 ? Math.min(100, (totalFoodDonated / neededFood) * 100) : 0
}

function getMoneyCollected(request) {
  if (!request.contributions) return 0
  return request.contributions
  .filter(c => c.status === 'confirmed')
  .reduce((sum, c) => sum + Number(c.amount), 0)
}

function getMoneyProgressPercent(request) {
  const goalAmount = Number(request.target_amount) || 0
  const totalMoneyCollected = getMoneyCollected(request)
  return goalAmount > 0 ? Math.min(100, (totalMoneyCollected / goalAmount) * 100) : 0
}

function getStatusText(request) {
  const foodProgress = getFoodProgressPercent(request)
  const moneyProgress = getMoneyProgressPercent(request)
  
  if (foodProgress >= 100 && moneyProgress >= 100) return 'Completed'
  if (foodProgress >= 100 || moneyProgress >= 100) return 'Partially Fulfilled'
  if (foodProgress > 0 || moneyProgress > 0) return 'In Progress'
  return 'Open'
}

function formatDate(dateString) {
  return new Date(dateString).toLocaleDateString('en-GB', {
    day: 'numeric',
    month: 'short',
    year: 'numeric'
  })
}
</script>