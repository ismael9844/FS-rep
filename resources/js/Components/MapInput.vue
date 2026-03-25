<template>
  <div id="map" class="h-64 rounded border"></div>
</template>

<script setup>
import { onMounted } from 'vue'
import L from 'leaflet'

const emit = defineEmits(['update:location'])

onMounted(() => {
  const map = L.map('map').setView([48.8566, 2.3522], 13) // par défaut : Paris
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)

  const marker = L.marker([48.8566, 2.3522], { draggable: true }).addTo(map)

  marker.on('moveend', e => {
    const latlng = e.target.getLatLng()
    emit('update:location', latlng)
  })
})
</script>
