<template>
  <Header/>
  <div class="min-h-screen bg-gradient-to-br from-green-100 via-green-50 to-white py-8 px-4">
    <div class="max-w-4xl mx-auto">
      <!-- Header Card -->
      <div class="bg-white shadow-sm border border-green-100 rounded-2xl p-6 mb-6">
        <div class="flex justify-between items-center">
          <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zm-10-7h10l-5-5v5zm5 2v10"/>
              </svg>
            </div>
            <div>
              <h1 class="text-2xl font-bold text-gray-800">Your Notifications</h1>
              <p class="text-sm text-gray-500">{{ filteredNotifications.length }} notification{{ filteredNotifications.length !== 1 ? 's' : '' }}</p>
            </div>
          </div>
          <button
            v-if="filteredNotifications.length > 0"
            @click="clearNotifications"
            class="px-4 py-2 text-sm font-medium text-red-600 hover:text-white hover:bg-red-500 border border-red-200 hover:border-red-500 rounded-lg transition-all duration-200 ease-in-out"
          >
            Clear All
          </button>
        </div>
      </div>

      <!-- Notifications List -->
      <div v-if="filteredNotifications.length" class="space-y-4">
        <div
          v-for="notification in filteredNotifications"
          :key="notification.id"
          class="bg-white border border-green-100 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 ease-in-out group"
        >
          <div class="p-6">
            <div class="flex items-start space-x-4">
              <!-- Notification Icon -->
              <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 transition-colors">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>

              <!-- Notification Content -->
              <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between">
                  <p class="text-gray-800 text-sm font-medium leading-6">
                    {{ notification.data.message }}
                  </p>
                  <time class="text-xs text-gray-400 whitespace-nowrap ml-4">
                    {{ formatDate(notification.created_at) }}
                  </time>
                </div>

                <!-- Actions : View donation -->
                <div class="mt-4" v-if="notification.data.donation_id">
                  <Link
                    :href="`/donations/${notification.data.donation_id}`"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 border border-green-200 hover:border-green-300 rounded-lg transition-all duration-200 ease-in-out group"
                  >
                    <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    View Donation Details
                  </Link>
                </div>

                <!-- Actions : Respond to request -->
                <div class="mt-4 flex gap-2" v-if="notification.data.request_id">
                  <button
                    @click="respond(notification.data.request_id, 'accepted', notification.id)"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm transition"
                  >
                    Accept
                  </button>
                  <button
                    @click="respond(notification.data.request_id, 'rejected', notification.id)"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm transition"
                  >
                    Reject
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="bg-white border border-green-100 rounded-xl shadow-sm p-12 text-center">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zm-10 0H0l5-5v5zm5-5v10"/>
          </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-800 mb-2">No notifications yet</h3>
        <p class="text-gray-500 text-sm max-w-md mx-auto">
          You'll receive notifications about donation updates, new opportunities, and important announcements here.
        </p>
        <div class="mt-6">
          <Link
            href="/donations"
            class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors duration-200 ease-in-out"
          >
            Explore Donations
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import Header from '@/Components/Header.vue'


const props = defineProps({
  notifications: Array,
  partnerRequests: Array
})

// État local pour gérer les notifications supprimées
const removedNotificationIds = ref(new Set())

const pendingIds = computed(() =>
  new Set(
    props.partnerRequests
      .filter(r => r.status === 'pending')
      .map(r => r.id)
  )
)

const filteredNotifications = computed(() =>
  props.notifications.filter(n => {
    // Exclure les notifications supprimées localement
    if (removedNotificationIds.value.has(n.id)) {
      return false
    }
    
    const d = n.data || {}
    if (d.type === 'partner_request') {
      return pendingIds.value.has(d.request_id)
    }
    return true
  })
)

function clearNotifications() {
  if (confirm('Are you sure you want to clear all notifications?')) {
    router.post('/notifications/clear', {}, {
      onSuccess: () => router.reload()
    })
  }
}

function respond(requestId, status, notificationId) {
  if (confirm(`Are you sure you want to ${status} this request?`)) {
    // Masquer immédiatement la notification
    removedNotificationIds.value.add(notificationId)
    
    // Envoyer la réponse au serveur en arrière-plan
    router.post('/food-requests/respond', { 
      request_id: requestId, 
      status: status
    }, {
      onError: () => {
        // Si erreur, remettre la notification
        removedNotificationIds.value.delete(notificationId)
        alert('Failed to send the response.')
      }
    })
  }
}

function formatDate(value) {
  const date = new Date(value)
  const now = new Date()
  const diffTime = Math.abs(now - date)
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))

  if (diffDays === 1) return 'Today'
  else if (diffDays === 2) return 'Yesterday'
  else if (diffDays <= 7) return `${diffDays - 1} days ago`
  else return date.toLocaleDateString('en-US', {
    year: 'numeric', month: 'short', day: 'numeric'
  })
}
</script>