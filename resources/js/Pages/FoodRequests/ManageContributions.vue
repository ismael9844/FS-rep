<template>
  <Header/>
  <div class="min-h-screen bg-gray-50 py-4 sm:py-8">
    <div class="max-w-7xl mx-auto px-4">
      
      <!-- Header -->
      <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Manage Contributions</h1>
        <p class="text-sm sm:text-base text-gray-600">Review and confirm food contributions and PayPal payments</p>
      </div>

      <!-- Success Message -->
      <div v-if="$page.props.flash?.success" class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <p class="text-green-700 font-medium text-sm sm:text-base">{{ $page.props.flash.success }}</p>
        </div>
      </div>

      <!-- Error Message -->
      <div v-if="errorMessage" class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <p class="text-red-700 font-medium text-sm sm:text-base">{{ errorMessage }}</p>
        </div>
      </div>

      <!-- Tabs -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-x-auto">
        <div class="flex border-b border-gray-200 min-w-max">
          <button 
            @click="activeTab = 'pending'"
            :class="activeTab === 'pending' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
            class="px-4 sm:px-6 py-3 sm:py-4 border-b-2 font-medium text-xs sm:text-sm transition-colors whitespace-nowrap"
          >
            Pending ({{ pendingOffers.length }})
          </button>
          <button 
            @click="activeTab = 'accepted'"
            :class="activeTab === 'accepted' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
            class="px-4 sm:px-6 py-3 sm:py-4 border-b-2 font-medium text-xs sm:text-sm transition-colors whitespace-nowrap"
          >
            Accepted ({{ acceptedOffers.length }})
          </button>
          <button 
            @click="activeTab = 'confirmed'"
            :class="activeTab === 'confirmed' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
            class="px-4 sm:px-6 py-3 sm:py-4 border-b-2 font-medium text-xs sm:text-sm transition-colors whitespace-nowrap"
          >
            Confirmed ({{ confirmedOffers.length }})
          </button>
          <button 
            @click="activeTab = 'paypal'"
            :class="activeTab === 'paypal' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
            class="px-4 sm:px-6 py-3 sm:py-4 border-b-2 font-medium text-xs sm:text-sm transition-colors whitespace-nowrap"
          >
            PayPal ({{ confirmedPaypal.length }})
          </button>
        </div>
      </div>

      <!-- Pending Offers -->
      <div v-show="activeTab === 'pending'" class="space-y-4">
        <div v-if="pendingOffers.length" v-for="offer in pendingOffers" :key="offer.id"
             class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
          <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3 mb-4">
            <div class="flex-1">
              <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-1">{{ offer.user?.name || 'Unknown' }}</h3>
              <p class="text-xs sm:text-sm text-gray-600">Wants to contribute {{ offer.quantity }} portions</p>
              <p class="text-xs text-gray-500 mt-1">Available until {{ formatDate(offer.available_until) }}</p>
            </div>
            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1 rounded-full self-start">
              Pending
            </span>
          </div>
          
          <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
            <a 
              v-if="offer.confirmation_token"
              :href="`/food-offers/accept/${offer.confirmation_token}`"
              class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center py-2.5 sm:py-2 rounded-lg font-medium transition-colors text-sm"
            >
              Accept
            </a>
            <button 
              v-if="offer.confirmation_token"
              @click="openDeclineModal(offer.confirmation_token)"
              class="flex-1 bg-red-100 hover:bg-red-200 text-red-700 py-2.5 sm:py-2 rounded-lg font-medium transition-colors text-sm"
            >
              Decline
            </button>
            <p v-if="!offer.confirmation_token" class="text-red-500 text-sm">Error: No token</p>
          </div>
        </div>
        <div v-else class="text-center py-12 text-gray-500 text-sm sm:text-base">
          No pending offers
        </div>
      </div>

      <!-- Accepted Offers -->
      <div v-show="activeTab === 'accepted'" class="space-y-4">
        <div v-if="acceptedOffers.length" v-for="offer in acceptedOffers" :key="offer.id"
             class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
          <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3 mb-4">
            <div class="flex-1">
              <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-1">{{ offer.user?.name || 'Unknown' }}</h3>
              <p class="text-xs sm:text-sm text-gray-600">{{ offer.quantity }} portions</p>
              <p class="text-xs text-gray-500 mt-1 break-words">
                <strong>Pickup:</strong> {{ formatDate(offer.scheduled_date) }}<br class="sm:hidden">
                <span class="sm:inline"> at </span>{{ offer.location }}
              </p>
            </div>
            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full self-start">
              Accepted
            </span>
          </div>
          
          <button 
            @click="openConfirmReceivedModal(offer.id)"
            class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white py-3 rounded-lg font-medium transition-all shadow-lg hover:shadow-xl text-sm sm:text-base"
          >
            ✓ Mark as Received
          </button>
        </div>
        <div v-else class="text-center py-12 text-gray-500 text-sm sm:text-base">
          No accepted offers waiting for pickup
        </div>
      </div>

      <!-- Confirmed Offers -->
      <div v-show="activeTab === 'confirmed'" class="space-y-4">
        <div v-if="confirmedOffers.length" v-for="offer in confirmedOffers" :key="offer.id"
             class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
          <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3">
            <div class="flex-1">
              <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-1">{{ offer.user?.name || 'Unknown' }}</h3>
              <p class="text-xs sm:text-sm text-gray-600">{{ offer.quantity }} portions received</p>
              <p class="text-xs text-gray-500 mt-1">{{ formatDate(offer.scheduled_date) }}</p>
            </div>
            <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full self-start">
              ✓ Confirmed
            </span>
          </div>
        </div>
        <div v-else class="text-center py-12 text-gray-500 text-sm sm:text-base">
          No confirmed contributions yet
        </div>
      </div>

      <!-- PayPal Contributions -->
      <div v-show="activeTab === 'paypal'" class="space-y-6">
        
        <!-- Formulaire pour ajouter une contribution manuelle -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">➕ Add Received Payment</h3>
          <p class="text-sm text-gray-600 mb-4">
            When you receive money via PayPal, enter the amount here to update the progress bar.
          </p>
          
          <form @submit.prevent="addPaypalContribution" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Amount (€)</label>
                <input 
                  v-model.number="paypalForm.amount"
                  type="number"
                  step="0.01"
                  min="0.01"
                  required
                  placeholder="10.00"
                  class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Contributor Name (Optional)</label>
                <input 
                  v-model="paypalForm.contributor_name"
                  type="text"
                  placeholder="John Doe"
                  class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                />
              </div>
            </div>
            
            <button 
              type="submit"
              :disabled="paypalForm.processing"
              class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white py-3 rounded-lg font-medium transition-all shadow-lg hover:shadow-xl disabled:opacity-50 text-sm sm:text-base"
            >
              {{ paypalForm.processing ? 'Adding...' : '✓ Add Contribution' }}
            </button>
          </form>
        </div>

        <!-- Liste des contributions confirmées -->
        <div v-if="confirmedPaypal.length">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Recorded Contributions</h3>
          <div class="space-y-3">
            <div v-for="contribution in confirmedPaypal" :key="contribution.id"
                 class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
              <div class="flex justify-between items-start gap-3">
                <div class="flex-1 min-w-0">
                  <p class="font-semibold text-gray-900 text-sm sm:text-base">
                    {{ contribution.contributor_name || 'Anonymous' }}
                  </p>
                  <p class="text-xs sm:text-sm text-gray-600">
                    €{{ parseFloat(contribution.amount).toFixed(2) }}
                  </p>
                  <p class="text-xs text-gray-500 mt-1">
                    {{ formatDate(contribution.created_at) }}
                  </p>
                </div>
                <button 
                  @click="openDeleteModal(contribution.id)"
                  class="text-red-500 hover:text-red-700 p-2"
                  title="Delete"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
        
        <div v-else class="text-center py-12 text-gray-500 text-sm sm:text-base">
          No contributions recorded yet
        </div>
      </div>
    </div>

    <!-- Confirmation Modals -->
    <!-- Decline Offer Modal -->
    <div v-if="showDeclineModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl shadow-xl p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">Decline Offer</h3>
        <p class="text-gray-600 mb-6">Are you sure you want to decline this food offer?</p>
        <div class="flex gap-3">
          <button 
            @click="showDeclineModal = false"
            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 rounded-lg font-medium transition-colors"
          >
            Cancel
          </button>
          <button 
            @click="confirmDecline"
            class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg font-medium transition-colors"
          >
            Decline
          </button>
        </div>
      </div>
    </div>

    <!-- Confirm Received Modal -->
    <div v-if="showConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl shadow-xl p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">Confirm Receipt</h3>
        <p class="text-gray-600 mb-6">Confirm that you have physically received this contribution?</p>
        <div class="flex gap-3">
          <button 
            @click="showConfirmModal = false"
            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 rounded-lg font-medium transition-colors"
          >
            Cancel
          </button>
          <button 
            @click="confirmReceivedAction"
            class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-medium transition-colors"
          >
            Confirm
          </button>
        </div>
      </div>
    </div>

    <!-- Delete Contribution Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl shadow-xl p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">Delete Contribution</h3>
        <p class="text-gray-600 mb-6">Are you sure you want to delete this contribution?</p>
        <div class="flex gap-3">
          <button 
            @click="showDeleteModal = false"
            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 rounded-lg font-medium transition-colors"
          >
            Cancel
          </button>
          <button 
            @click="confirmDelete"
            class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg font-medium transition-colors"
          >
            Delete
          </button>
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
  pendingOffers: Array,
  acceptedOffers: Array,
  confirmedOffers: Array,
  pendingPaypal: Array,
  confirmedPaypal: Array,
})

const activeTab = ref('pending')
const errorMessage = ref('')

// Modal states
const showDeclineModal = ref(false)
const showConfirmModal = ref(false)
const showDeleteModal = ref(false)
const pendingToken = ref(null)
const pendingId = ref(null)

// Decline offer
const openDeclineModal = (token) => {
  pendingToken.value = token
  showDeclineModal.value = true
}

const confirmDecline = () => {
  router.visit(`/food-offers/decline/${pendingToken.value}`)
  showDeclineModal.value = false
}

// Confirm received
const openConfirmReceivedModal = (id) => {
  pendingId.value = id
  showConfirmModal.value = true
}

const confirmReceivedAction = () => {
  router.post(`/food-offers/${pendingId.value}/confirm-received`, {}, {
    preserveScroll: true,
    onSuccess: () => {
      showConfirmModal.value = false
    }
  })
}

// PayPal form
const paypalForm = ref({
  amount: null,
  contributor_name: '',
  processing: false
})

const addPaypalContribution = () => {
  if (!paypalForm.value.amount || paypalForm.value.amount <= 0) {
    errorMessage.value = 'Please enter a valid amount'
    setTimeout(() => errorMessage.value = '', 3000)
    return
  }
  
  paypalForm.value.processing = true
  
  router.post('/paypal-contributions/add', {
    amount: paypalForm.value.amount,
    contributor_name: paypalForm.value.contributor_name || 'Anonymous'
  }, {
    preserveScroll: true,
    onSuccess: () => {
      paypalForm.value.amount = null
      paypalForm.value.contributor_name = ''
    },
    onFinish: () => {
      paypalForm.value.processing = false
    }
  })
}

// Delete contribution
const openDeleteModal = (id) => {
  pendingId.value = id
  showDeleteModal.value = true
}

const confirmDelete = () => {
  router.delete(`/paypal-contributions/${pendingId.value}`, {
    preserveScroll: true,
    onSuccess: () => {
      showDeleteModal.value = false
    }
  })
}

const formatDate = (dateStr) => {
  if (!dateStr) return 'N/A'
  return new Date(dateStr).toLocaleString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}
</script>