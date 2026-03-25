<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
    users: Array,
    volunteers: Object  
})

function updateStatus(userId, status) {
    console.log('Updating status for user:', userId, 'to:', status);
    console.log('Volunteers object:', props.volunteers);
    console.log('Volunteer for this user:', props.volunteers[userId]);
    
    router.post(route('admin.verifications.update', userId), { 
        verification_status: status 
    })
}

function goBack() {
    router.get('/admin')
}

function getStatusEmoji(status) {
    switch(status) {
        case 'approved': return ''
        case 'declined': return ''
        case 'pending': return ''
        default: return ''
    }
}
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-green-50 to-white">
        <div class="container mx-auto px-6 py-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-4">
                    <button 
                        @click="goBack"
                        class="flex items-center space-x-2 px-4 py-2 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200"
                    >
                        <span class="text-lg">←</span>
                        <span>Back to Admin</span>
                    </button>
                </div>
                <h1 class="text-3xl font-light text-gray-800">Verification Management</h1>
                <div></div>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-green-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-green-50 border-b border-green-100">
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-700">Name</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-700">Email</th>
                                <th class="px-6 py-4 text-center text-sm font-medium text-gray-700">Status</th>
                                <th class="px-6 py-4 text-center text-sm font-medium text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-for="user in users" :key="user.id" class="hover:bg-green-25 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ user.name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-600">{{ user.email }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex items-center space-x-2">
                                        <span class="text-lg">
                                            {{ getStatusEmoji(props.volunteers[user.id]?.verification_status) }}
                                        </span>
                                        <span :class="{
                                            'text-green-600 bg-green-50': props.volunteers[user.id]?.verification_status === 'approved',
                                            'text-red-600 bg-red-50': props.volunteers[user.id]?.verification_status === 'declined',
                                            'text-amber-600 bg-amber-50': props.volunteers[user.id]?.verification_status === 'pending'
                                        }" class="px-2 py-1 rounded-full text-xs font-medium capitalize">
                                            {{ props.volunteers[user.id]?.verification_status || 'undefined' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button 
                                            @click="updateStatus(user.id, 'pending')"
                                            class="px-3 py-1.5 text-xs font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg transition-all duration-200"
                                        >
                                            Pending
                                        </button>
                                        <button 
                                            @click="updateStatus(user.id, 'approved')"
                                            class="px-3 py-1.5 text-xs font-medium text-green-700 bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg transition-all duration-200"
                                        >
                                            Approve
                                        </button>
                                        <button 
                                            @click="updateStatus(user.id, 'declined')"
                                            class="px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg transition-all duration-200"
                                        >
                                            Decline
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.bg-green-25 {
    background-color: #f8fdf8;
}
</style>