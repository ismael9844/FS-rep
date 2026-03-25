<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Edit Your Donation</h1>

      <form @submit.prevent="submit" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

          <!-- Title -->
          <div>
            <label class="block text-sm font-medium text-gray-700">Title</label>
            <input
              v-model="form.title"
              type="text"
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
              placeholder="e.g. Leftover sandwiches"
            />
          </div>

          <!-- Unit -->
          <div>
            <label class="block text-sm font-medium text-gray-700">Unit</label>
            <input
              v-model="form.unit"
              type="text"
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
              placeholder="e.g. pieces, kg..."
            />
          </div>

          <!-- Quantity -->
          <div>
            <label class="block text-sm font-medium text-gray-700">Quantity</label>
            <input
              v-model="form.quantity"
              type="number"
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
              min="1"
            />
          </div>

          <!-- Expiration Date -->
          <div>
            <label class="block text-sm font-medium text-gray-700">Expiration Date</label>
            <input
              v-model="form.expiration_date"
              type="date"
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
            />
          </div>

          <!-- Available From -->
          <div>
            <label class="block text-sm font-medium text-gray-700">Available From (HH:mm)</label>
            <input
              v-model="form.available_from"
              type="datetime-local"
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
            />
          </div>

          <!-- Available Until -->
          <div>
            <label class="block text-sm font-medium text-gray-700">Available Until</label>
            <input
              v-model="form.available_until"
              type="datetime-local"
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
            />
          </div>

          <!-- City -->
          <div>
            <label class="block text-sm font-medium text-gray-700">City</label>
            <input
              v-model="form.city"
              type="text"
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
              placeholder="e.g. Paris"
            />
          </div>

          <!-- Postal Code -->
          <div>
            <label class="block text-sm font-medium text-gray-700">Postal Code</label>
            <input
              v-model="form.postal_code"
              type="text"
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
              placeholder="e.g. 75001"
            />
          </div>

        </div>

        <!-- Description -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Description</label>
          <textarea
            v-model="form.description"
            rows="4"
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
            placeholder="Short description about the food..."
          ></textarea>
        </div>

        <!-- Submit Button -->
        <div class="text-center pt-6">
          <button
            type="submit"
            class="inline-block w-full md:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-200 transform hover:scale-105"
          >
            Update Donation
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  donation: Object
})

const form = useForm({
  title: props.donation.title,
  description: props.donation.description,
  quantity: props.donation.quantity,
  unit: props.donation.unit,
  available_from: props.donation.available_from,
  available_until: props.donation.available_until,
  city: props.donation.city,
  postal_code: props.donation.postal_code,
  expiration_date: props.donation.expiration_date,
})

function submit() {
  form.put(`/donations/${props.donation.id}`, {
    onSuccess: () => {
      console.log('Donation updated')
    },
    onError: (errors) => {
      console.error(errors)
    }
  })
}
</script>
