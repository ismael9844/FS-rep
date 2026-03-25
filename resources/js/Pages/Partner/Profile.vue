<template>
  <div class="min-h-screen bg-gradient-to-br from-yellow-50 to-green-50 p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-4">Partner Profile</h1>
      <div class="space-y-2 mb-8">
        <p><strong>Name:</strong> {{ partner.name }}</p>
        <p><strong>Type:</strong> {{ partner.type }}</p>
        <p><strong>Contact:</strong> {{ partner.contact_email }} / {{ partner.contact_phone }}</p>
        <p><strong>Address:</strong> {{ partner.address }}</p>
        <p><strong>Status:</strong> {{ partner.status }}</p>
        <p><strong>Level:</strong> {{ partner.level }}</p>
      </div>
      <Link href="/partner/history" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
        View Donation History
      </Link>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  partner: Object
})
</script>
