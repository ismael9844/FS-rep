<template>
  <div class="max-w-2xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Add a New Place</h2>

    <form @submit.prevent="submitForm">
      <div class="mb-4">
        <label class="block font-medium">Title</label>
        <input v-model="form.title" class="w-full border rounded px-3 py-2" required />
      </div>

      <div class="mb-4">
        <label class="block font-medium">Description</label>
        <textarea v-model="form.description" class="w-full border rounded px-3 py-2" required></textarea>
      </div>

      <div class="mb-4">
        <label class="block font-medium">Address</label>
        <input v-model="form.address" class="w-full border rounded px-3 py-2" required />
      </div>

      <div class="mb-4">
        <label class="block font-medium">Google Maps Link</label>
        <input v-model="form.google_maps_link" class="w-full border rounded px-3 py-2" />
      </div>

      <div class="mb-4">
        <label class="block font-medium">Contact Info</label>
        <input v-model="form.contact_info" class="w-full border rounded px-3 py-2" required />
      </div>

      <div class="mb-4">
        <label class="block font-medium">Availability</label>
        <input type="date" v-model="form.availability" class="w-full border rounded px-3 py-2" required />
      </div>

      <div class="mb-4">
        <label class="block font-medium">Photos</label>
        <input type="file" multiple @change="handleFiles" class="w-full border rounded px-3 py-2" />
      </div>

      <button class="px-4 py-2 bg-emerald-500 text-white rounded" :disabled="loading">
        {{ loading ? 'Saving...' : 'Save Place' }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const form = ref({
  title: '',
  description: '',
  address: '',
  google_maps_link: '',
  contact_info: '',
  availability: '',
  photos: [],
})

const loading = ref(false)

function handleFiles(e) {
  form.value.photos = Array.from(e.target.files)
}

function submitForm() {
  loading.value = true
  const data = new FormData()
  for (let key in form.value) {
    if (key === 'photos') {
      form.value.photos.forEach(file => data.append('photos[]', file))
    } else {
      data.append(key, form.value[key])
    }
  }

  router.post('/places', data, {
    forceFormData: true,
    onFinish: () => loading.value = false,
    onSuccess: () => router.visit('/places')
  })
}
</script>
