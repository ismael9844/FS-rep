<template>
  <div class="min-h-screen bg-gray-50">
<!-- Header -->
<header class="bg-white border-b border-gray-200 sticky top-0 z-10">
  <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
    <h1 class="text-2xl font-semibold text-gray-900">Admin Dashboard</h1>
    <div class="flex space-x-4"> <!-- Added space-x-4 for spacing between buttons -->
      <a
        href="/dashboard"
        class="px-5 py-2 bg-emerald-500 text-white rounded-xl font-medium shadow hover:bg-emerald-600 transition-all duration-200"
      >
        Home
      </a>
      <a
        href="/admin/sponsorships"
        class="px-5 py-2 bg-emerald-500 text-white rounded-xl font-medium shadow hover:bg-emerald-600 transition-all duration-200"
      >
        Sponsor
      </a>
      <a
        href="/verifications"
        class="px-5 py-2 bg-emerald-500 text-white rounded-xl font-medium shadow hover:bg-emerald-600 transition-all duration-200"
      >
        Volunteers
      </a>
    </div>
  </div>
</header>

    <div class="max-w-7xl mx-auto px-6 py-8">
      <!-- Key Metrics -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg border border-gray-200 p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Total Users</p>
              <p class="text-2xl font-semibold text-gray-900 mt-1">{{ users.length }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Total Donations</p>
              <p class="text-2xl font-semibold text-gray-900 mt-1">{{ donations.length }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Total Partners</p>
              <p class="text-2xl font-semibold text-gray-900 mt-1">{{ partners.length }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Data Tables -->
      <div class="space-y-8">
        <!-- Users Table -->
        <section class="bg-white rounded-lg border border-gray-200">
          <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
              <h2 class="text-lg font-medium text-gray-900">Users</h2>
              <div class="flex items-center space-x-4">
                <select
                  v-model="userFilters.role"
                  @change="filterUsers"
                  class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option value="">All roles</option>
                  <option value="admin">Admin</option>
                  <option value="receiver">Receiver</option>
                  <option value="organization">Organization</option>
                </select>
                <select
                  v-model="userFilters.perPage"
                  @change="filterUsers"
                  class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option value="10">10 per page</option>
                  <option value="25">25 per page</option>
                  <option value="50">50 per page</option>
                  <option value="100">100 per page</option>
                </select>
              </div>
            </div>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requests</th>

                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="user in paginatedUsers" :key="user.id" class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ user.id }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ user.name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ user.email }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                      {{ user.role }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <button
                      @click="confirmDelete('user', user.id)"
                      class="text-red-600 hover:text-red-900 font-medium"
                    >
                      Delete
                    </button>

                  </td>
                  
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <button
                    @click="openRequestModal('user', user.id)"
                    class="text-indigo-600 hover:text-indigo-900 font-medium"
                  >
                  Request Docs
                  </button>
                  </td>




                </tr>
              </tbody>
            </table>
          </div>
          <!-- Users Pagination -->
          <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
              <div class="text-sm text-gray-700">
                Showing {{ ((userPagination.currentPage - 1) * userFilters.perPage) + 1 }} to 
                {{ Math.min(userPagination.currentPage * userFilters.perPage, filteredUsers.length) }} 
                of {{ filteredUsers.length }} results
              </div>
              <div class="flex items-center space-x-2">
                <button
                  @click="changeUserPage(userPagination.currentPage - 1)"
                  :disabled="userPagination.currentPage === 1"
                  class="px-3 py-1 text-sm border border-gray-300 rounded disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50"
                >
                  Previous
                </button>
                <span v-for="page in userPagination.pages" :key="page" class="flex items-center">
                  <button
                    @click="changeUserPage(page)"
                    :class="[
                      'px-3 py-1 text-sm border rounded',
                      page === userPagination.currentPage
                        ? 'bg-blue-500 text-white border-blue-500'
                        : 'border-gray-300 hover:bg-gray-50'
                    ]"
                  >
                    {{ page }}
                  </button>
                </span>
                <button
                  @click="changeUserPage(userPagination.currentPage + 1)"
                  :disabled="userPagination.currentPage === userPagination.totalPages"
                  class="px-3 py-1 text-sm border border-gray-300 rounded disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50"
                >
                  Next
                </button>
              </div>
            </div>
          </div>
        </section>
          <!-- Modal -->
<!-- Modal: affiche note et envoie la demande au serveur -->
<div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
  <div class="bg-white rounded-lg p-6 w-full max-w-md">
    <h3 class="text-lg font-medium mb-2">Request documents for {{ modalEntityType }} #{{ modalEntityId }}</h3>
    <textarea v-model="note" rows="4" class="w-full border p-2 mb-3" placeholder="Write a note (optional)"></textarea>

    <div class="flex justify-end space-x-2">
      <button @click="closeModal" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
      <button @click="sendRequest" :disabled="sending" class="px-4 py-2 bg-emerald-600 text-white rounded">
        <span v-if="sending">Sending...</span>
        <span v-else>Send request</span>
      </button>
    </div>

    <div v-if="errors.general" class="text-red-600 mt-3">{{ errors.general }}</div>
    <div v-if="errors.note" class="text-red-600 mt-1">{{ errors.note }}</div>
  </div>
</div>



        <!-- Donations Table -->
        <section class="bg-white rounded-lg border border-gray-200">
          <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
              <h2 class="text-lg font-medium text-gray-900">Donations</h2>
              <select
                v-model="donationFilters.perPage"
                @change="updateDonationPagination"
                class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
              </select>
            </div>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donor</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="don in paginatedDonations" :key="don.id" class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ don.id }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ don.title }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ don.user.name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ don.quantity }} {{ don.unit }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <button
                      @click="confirmDelete('donation', don.id)"
                      class="text-red-600 hover:text-red-900 font-medium"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- Donations Pagination -->
          <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
              <div class="text-sm text-gray-700">
                Showing {{ ((donationPagination.currentPage - 1) * donationFilters.perPage) + 1 }} to 
                {{ Math.min(donationPagination.currentPage * donationFilters.perPage, donations.length) }} 
                of {{ donations.length }} results
              </div>
              <div class="flex items-center space-x-2">
                <button
                  @click="changeDonationPage(donationPagination.currentPage - 1)"
                  :disabled="donationPagination.currentPage === 1"
                  class="px-3 py-1 text-sm border border-gray-300 rounded disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50"
                >
                  Previous
                </button>
                <span v-for="page in donationPagination.pages" :key="page" class="flex items-center">
                  <button
                    @click="changeDonationPage(page)"
                    :class="[
                      'px-3 py-1 text-sm border rounded',
                      page === donationPagination.currentPage
                        ? 'bg-blue-500 text-white border-blue-500'
                        : 'border-gray-300 hover:bg-gray-50'
                    ]"
                  >
                    {{ page }}
                  </button>
                </span>
                <button
                  @click="changeDonationPage(donationPagination.currentPage + 1)"
                  :disabled="donationPagination.currentPage === donationPagination.totalPages"
                  class="px-3 py-1 text-sm border border-gray-300 rounded disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50"
                >
                  Next
                </button>
              </div>
            </div>
          </div>
        </section>

        <!-- Partners Table -->
        <section class="bg-white rounded-lg border border-gray-200">
          <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
              <h2 class="text-lg font-medium text-gray-900">Partners & Organizations</h2>
              <select
                v-model="partnerFilters.perPage"
                @change="updatePartnerPagination"
                class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
              </select>
            </div>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
  <thead class="bg-gray-50">
    <tr>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donations</th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document</th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requests</th>
    </tr>
  </thead>
  <tbody class="bg-white divide-y divide-gray-200">
    <tr v-for="p in paginatedPartners" :key="p.id" class="hover:bg-gray-50">
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ p.id }}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ p.name }}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ p.role }}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ p.donations_count }}</td>

      <!-- Nouvelle colonne Document -->
      <td class="px-6 py-4 whitespace-nowrap text-sm">
        <a
          v-if="p.document_path"
          :href="`/storage/${p.document_path}`"
          target="_blank"
          class="text-indigo-600 hover:text-indigo-900 underline"
        >
          See Documents
        </a>
        <span v-else class="text-gray-400">—</span>
      </td>

      <!-- Actions (status update) -->
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        <select
          v-model="p.status"
          @change="updateStatus(p)"
          class="text-sm border-gray-300 rounded"
        >
          <option value="pending">Pending</option>
          <option value="approved">Approved</option>
          <option value="suspended">Suspended</option>
        </select>
      </td>
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
<!-- bouton Request Docs (dans la ligne partner) -->
<button
  @click="openRequestModal('partner', p.id)"
  class="text-indigo-600 hover:text-indigo-900 font-medium"
>
  Request Docs
</button>

</td>
    </tr>
  </tbody>
            <!-- Modal -->
<!-- Modal - Version corrigée -->
<div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
  <div class="bg-white rounded-lg p-6 w-full max-w-md">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Request Additional Documents</h3>
    <textarea
      v-model="note"
      class="w-full border border-gray-300 rounded p-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
      rows="4"
      placeholder="Write your note for the user/partner..."
    ></textarea>
    <div class="flex justify-end space-x-2 mt-4">
      <button 
        @click="closeModal" 
        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded transition-colors duration-200"
      >
        Cancel
      </button>
      <button 
        @click="sendRequest" 
        class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded transition-colors duration-200"
        :disabled="!note.trim()"
        :class="{ 'opacity-50 cursor-not-allowed': !note.trim() }"
      >
        Send
      </button>
    </div>
  </div>
</div>

</table>

          </div>
          <!-- Partners Pagination -->
          <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
              <div class="text-sm text-gray-700">
                Showing {{ ((partnerPagination.currentPage - 1) * partnerFilters.perPage) + 1 }} to 
                {{ Math.min(partnerPagination.currentPage * partnerFilters.perPage, partners.length) }} 
                of {{ partners.length }} results
              </div>
              <div class="flex items-center space-x-2">
                <button
                  @click="changePartnerPage(partnerPagination.currentPage - 1)"
                  :disabled="partnerPagination.currentPage === 1"
                  class="px-3 py-1 text-sm border border-gray-300 rounded disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50"
                >
                  Previous
                </button>
                <span v-for="page in partnerPagination.pages" :key="page" class="flex items-center">
                  <button
                    @click="changePartnerPage(page)"
                    :class="[
                      'px-3 py-1 text-sm border rounded',
                      page === partnerPagination.currentPage
                        ? 'bg-blue-500 text-white border-blue-500'
                        : 'border-gray-300 hover:bg-gray-50'
                    ]"
                  >
                    {{ page }}
                  </button>
                </span>
                <button
                  @click="changePartnerPage(partnerPagination.currentPage + 1)"
                  :disabled="partnerPagination.currentPage === partnerPagination.totalPages"
                  class="px-3 py-1 text-sm border border-gray-300 rounded disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50"
                >
                  Next
                </button>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
    <!-- parent template -->
<UploadDocument
  v-if="showModal"
  :entity-type="modalEntityType"
  :entity-id="modalEntityId"
  @close="showModal = false"
/>

  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import { ref, computed, onMounted } from 'vue'

const props = defineProps({
  users: Array,
  donations: Array,
  partners: Array
})

// Variables pour le modal
const showModal = ref(false)
const note = ref("")
const modalType = ref(null)
const modalId = ref(null)
const sending = ref(false)
const errors = ref({})

// Filtres et pagination pour les utilisateurs
const userFilters = ref({
  role: '',
  perPage: 10
})

const userPagination = ref({
  currentPage: 1,
  totalPages: 1,
  pages: []
})

// Filtres et pagination pour les donations
const donationFilters = ref({
  perPage: 10
})

const donationPagination = ref({
  currentPage: 1,
  totalPages: 1,
  pages: []
})

// Filtres et pagination pour les partenaires
const partnerFilters = ref({
  perPage: 10
})

const partnerPagination = ref({
  currentPage: 1,
  totalPages: 1,
  pages: []
})

// Computed pour les utilisateurs filtrés
const filteredUsers = computed(() => {
  let filtered = [...props.users]
  
  if (userFilters.value.role) {
    filtered = filtered.filter(user => user.role === userFilters.value.role)
  }
  
  return filtered
})

// Computed pour les utilisateurs paginés
const paginatedUsers = computed(() => {
  const start = (userPagination.value.currentPage - 1) * userFilters.value.perPage
  const end = start + parseInt(userFilters.value.perPage)
  return filteredUsers.value.slice(start, end)
})

// Computed pour les donations paginées
const paginatedDonations = computed(() => {
  const start = (donationPagination.value.currentPage - 1) * donationFilters.value.perPage
  const end = start + parseInt(donationFilters.value.perPage)
  return props.donations.slice(start, end)
})

// Computed pour les partenaires paginés
const paginatedPartners = computed(() => {
  const start = (partnerPagination.value.currentPage - 1) * partnerFilters.value.perPage
  const end = start + parseInt(partnerFilters.value.perPage)
  return props.partners.slice(start, end)
})

// Fonction pour ouvrir le modal

function openRequestModal(type, id) {
  modalType.value = type
  modalId.value = id
  note.value = ''
  showModal.value = true
}

// Fonction pour fermer le modal
function closeModal() {
  showModal.value = false

}

function sendRequest() {
  if (!modalType.value || !modalId.value) { alert('Missing'); return }
  sending.value = true
  router.post('/admin/request-document', {
    type: modalType.value,
    id: modalId.value,
    note: note.value
  }, {
    onSuccess: () => {
      sending.value = false
      showModal.value = false
      alert('Request sent')
    },
    onError: (err) => {
      sending.value = false
      console.error(err)
      alert('Failed to send request')
    }
  })
}

// Fonctions pour la pagination des utilisateurs
function updateUserPagination() {
  const totalItems = filteredUsers.value.length
  const totalPages = Math.ceil(totalItems / userFilters.value.perPage)
  
  userPagination.value.totalPages = totalPages
  userPagination.value.currentPage = Math.min(userPagination.value.currentPage, totalPages)
  
  // Générer les numéros de page
  const pages = []
  const maxPages = 5
  let startPage = Math.max(1, userPagination.value.currentPage - Math.floor(maxPages / 2))
  let endPage = Math.min(totalPages, startPage + maxPages - 1)
  
  if (endPage - startPage + 1 < maxPages) {
    startPage = Math.max(1, endPage - maxPages + 1)
  }
  
  for (let i = startPage; i <= endPage; i++) {
    pages.push(i)
  }
  
  userPagination.value.pages = pages
}

function changeUserPage(page) {
  if (page >= 1 && page <= userPagination.value.totalPages) {
    userPagination.value.currentPage = page
  }
}

function filterUsers() {
  userPagination.value.currentPage = 1
  updateUserPagination()
}

// Fonctions pour la pagination des donations
function updateDonationPagination() {
  const totalItems = props.donations.length
  const totalPages = Math.ceil(totalItems / donationFilters.value.perPage)
  
  donationPagination.value.totalPages = totalPages
  donationPagination.value.currentPage = Math.min(donationPagination.value.currentPage, totalPages)
  
  const pages = []
  const maxPages = 5
  let startPage = Math.max(1, donationPagination.value.currentPage - Math.floor(maxPages / 2))
  let endPage = Math.min(totalPages, startPage + maxPages - 1)
  
  if (endPage - startPage + 1 < maxPages) {
    startPage = Math.max(1, endPage - maxPages + 1)
  }
  
  for (let i = startPage; i <= endPage; i++) {
    pages.push(i)
  }
  
  donationPagination.value.pages = pages
}

function changeDonationPage(page) {
  if (page >= 1 && page <= donationPagination.value.totalPages) {
    donationPagination.value.currentPage = page
  }
}

// Fonctions pour la pagination des partenaires
function updatePartnerPagination() {
  const totalItems = props.partners.length
  const totalPages = Math.ceil(totalItems / partnerFilters.value.perPage)
  
  partnerPagination.value.totalPages = totalPages
  partnerPagination.value.currentPage = Math.min(partnerPagination.value.currentPage, totalPages)
  
  const pages = []
  const maxPages = 5
  let startPage = Math.max(1, partnerPagination.value.currentPage - Math.floor(maxPages / 2))
  let endPage = Math.min(totalPages, startPage + maxPages - 1)
  
  if (endPage - startPage + 1 < maxPages) {
    startPage = Math.max(1, endPage - maxPages + 1)
  }
  
  for (let i = startPage; i <= endPage; i++) {
    pages.push(i)
  }
  
  partnerPagination.value.pages = pages
}

function changePartnerPage(page) {
  if (page >= 1 && page <= partnerPagination.value.totalPages) {
    partnerPagination.value.currentPage = page
  }
}

// Fonctions existantes
function updateStatus(partner) {
  router.patch(`/partners/${partner.id}/status`, { status: partner.status }, {
    onSuccess: () => alert('Status updated'),
    onError: err => console.error(err),
  });
}

function confirmDelete(type, id) {
  if (confirm(`Are you sure you want to delete this ${type}?`)) {
    let route = ''
    if (type === 'user') route = `/admin/users/${id}`
    if (type === 'donation') route = `/donations/${id}`
    if (type === 'partner') route = `/partners/${id}`

    router.delete(route, {
      onSuccess: () => {
        alert(`${type} deleted.`)
      },
      onError: err => {
        console.error(err)
      }
    })
  }
}

// Initialisation
onMounted(() => {
  updateUserPagination()
  updateDonationPagination()
  updatePartnerPagination()
})
</script>