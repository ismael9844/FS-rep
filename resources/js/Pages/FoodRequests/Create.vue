<template>
    
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-2xl mx-auto py-8 px-4">
      
      <!-- Back Button -->
      <button @click="goBack"
        class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors duration-200 group mb-6">
        <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-200" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to requests
      </button>

      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Create New Food Request</h1>
        <p class="text-gray-600">Help your community by creating a food assistance request</p>
      </div>

      <!-- Main Form Card -->
      <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-8">
        <form @submit.prevent="submit" class="space-y-6">
          
          <!-- Title Field -->
          <div>
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
              Request Title <span class="text-red-500">*</span>
            </label>
            <input 
              id="title"
              v-model="form.title" 
              type="text"
              placeholder="e.g., Emergency Food Support for Family of 4"
              required 
              class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
              :class="{ 'border-red-300 focus:ring-red-500 focus:border-red-500': form.errors.title }"
            />
            <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>
          </div>

          <!-- Description Field -->
          <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
              Description
            </label>
            <textarea 
              id="description"
              v-model="form.description" 
              rows="4"
              placeholder="Describe your situation and what kind of food assistance you need..."
              class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-none"
              :class="{ 'border-red-300 focus:ring-red-500 focus:border-red-500': form.errors.description }"
            ></textarea>
            <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">{{ form.errors.description }}</p>
            <p class="mt-1 text-sm text-gray-500">Optional: Provide more details about your food needs</p>
          </div>
                    <!-- Paypal link Field -->
<div>
  <label for="paypal_link" class="block text-sm font-semibold text-gray-700 mb-2">
    PayPal Link
  </label>
  <input 
    id="paypal_link"
    v-model="form.paypal_link" 
    type="url"
    placeholder="https://www.paypal.com/..."
    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
           focus:outline-none focus:ring-2 focus:ring-emerald-500 
           focus:border-emerald-500 transition-colors"
    :class="{ 'border-red-300 focus:ring-red-500 focus:border-red-500': form.errors.paypal_link }"
  />
  <p v-if="form.errors.paypal_link" class="mt-1 text-sm text-red-600">{{ form.errors.paypal_link }}</p>
  <p class="mt-1 text-sm text-gray-500">
    Provide the PayPal link where you want to receive contributions.
  </p>
</div>


          <!-- Two Column Layout for Numbers -->
          <div class="grid md:grid-cols-2 gap-6">
            
            <!-- Quantity Field -->
            <div>
              <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-2">
                <span class="flex items-center">
                  <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                  </svg>
                  Food Portions Needed
                </span>
              </label>
              <input 
                id="quantity"
                v-model.number="form.quantity" 
                type="number" 
                min="1"
                placeholder="e.g., 20"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                :class="{ 'border-red-300 focus:ring-red-500 focus:border-red-500': form.errors.quantity }"
              />
              <p v-if="form.errors.quantity" class="mt-1 text-sm text-red-600">{{ form.errors.quantity }}</p>
              <p class="mt-1 text-sm text-gray-500">Number of meals/servings you need</p>
            </div>

            <!-- Target Amount Field -->
            <div>
              <label for="target_amount" class="block text-sm font-semibold text-gray-700 mb-2">
                <span class="flex items-center">
                  <svg class="w-4 h-4 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                  </svg>
                  Financial Goal (€)
                </span>
              </label>
              <input 
                id="target_amount"
                v-model.number="form.target_amount" 
                type="number" 
                min="0"
                step="0.01"
                placeholder="e.g., 150.00"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                :class="{ 'border-red-300 focus:ring-red-500 focus:border-red-500': form.errors.target_amount }"
              />
              <p v-if="form.errors.target_amount" class="mt-1 text-sm text-red-600">{{ form.errors.target_amount }}</p>
              <p class="mt-1 text-sm text-gray-500">Optional: Money to raise for food purchases</p>
            </div>

          </div>

          <!-- Deadline Field -->
          <div>
            <label for="needed_before" class="block text-sm font-semibold text-gray-700 mb-2">
              <span class="flex items-center">
                <svg class="w-4 h-4 mr-1 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Needed By
              </span>
            </label>
            <input 
              id="needed_before"
              v-model="form.needed_before" 
              type="datetime-local"
              :min="minDateTime"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
              :class="{ 'border-red-300 focus:ring-red-500 focus:border-red-500': form.errors.needed_before }"
            />
            <p v-if="form.errors.needed_before" class="mt-1 text-sm text-red-600">{{ form.errors.needed_before }}</p>
            <p class="mt-1 text-sm text-gray-500">Optional: When you need the food assistance by</p>
          </div>

          <!-- Help Text -->
          <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
              <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <div class="text-sm text-blue-700">
                <p class="font-medium mb-1">Tips for your request:</p>
                <ul class="space-y-1 text-blue-600">
                  <li>• Be specific about your food needs and situation</li>
                  <li>• You can ask for food donations, money, or both</li>
                  <li>• Community members will be able to see and respond to your request</li>
                </ul>
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
            <button 
              type="submit" 
              :disabled="form.processing"
              class="flex-1 sm:flex-none inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold px-6 py-3 rounded-lg transition-colors duration-200 shadow-sm"
            >
              <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ form.processing ? 'Creating Request...' : 'Create Request' }}
            </button>
            
            <button 
              type="button" 
              @click="goBack"
              class="flex-1 sm:flex-none inline-flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-6 py-3 rounded-lg transition-colors duration-200"
            >
              Cancel
            </button>
          </div>

        </form>
      </div>

      <!-- Additional Info Card -->
      <div class="mt-6 bg-white shadow-sm rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">What happens next?</h3>
        <div class="space-y-3 text-sm text-gray-600">
          <div class="flex items-start">
            <span class="inline-flex items-center justify-center w-6 h-6 bg-emerald-100 text-emerald-600 rounded-full text-xs font-medium mr-3 mt-0.5">1</span>
            <p>Your request will be published to the community</p>
          </div>
          <div class="flex items-start">
            <span class="inline-flex items-center justify-center w-6 h-6 bg-emerald-100 text-emerald-600 rounded-full text-xs font-medium mr-3 mt-0.5">2</span>
            <p>Community members can offer food donations or financial contributions</p>
          </div>
          <div class="flex items-start">
            <span class="inline-flex items-center justify-center w-6 h-6 bg-emerald-100 text-emerald-600 rounded-full text-xs font-medium mr-3 mt-0.5">3</span>
            <p>You'll coordinate with donors to arrange pickup or delivery</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useForm, router } from '@inertiajs/vue3'

const form = useForm({
  title: '',
  description: '',
  quantity: null,
  target_amount: null,
  needed_before: null,
  paypal_link: '',
})

// Set minimum datetime to now
const minDateTime = computed(() => {
  const now = new Date()
  const year = now.getFullYear()
  const month = String(now.getMonth() + 1).padStart(2, '0')
  const day = String(now.getDate()).padStart(2, '0')
  const hours = String(now.getHours()).padStart(2, '0')
  const minutes = String(now.getMinutes()).padStart(2, '0')
  return `${year}-${month}-${day}T${hours}:${minutes}`
})

function submit() {
  form.post(route('food-requests.store'), {
    onSuccess: () => {
      // Redirect will be handled by the backend
    },
    onError: (errors) => {
      // Form errors will be automatically handled by Inertia
      console.log('Form errors:', errors)
    }
  })
}

function goBack() {
  if (window.history.length > 1) {
    window.history.back()
  } else {
    router.visit('/food-requests')
  }
}
</script>