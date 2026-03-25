<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50 overflow-hidden">
        <!-- Decorative background shapes - plus visibles -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Top right circle -->
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-indigo-200 rounded-full opacity-40 blur-3xl"></div>
            
            <!-- Bottom left circle -->
            <div class="absolute -bottom-32 -left-32 w-[500px] h-[500px] bg-green-200 rounded-full opacity-40 blur-3xl"></div>
            
            <!-- Middle circle -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-purple-200 rounded-full opacity-30 blur-3xl"></div>
            
            <!-- Small accent circles -->
            <div class="absolute top-1/4 right-1/4 w-32 h-32 bg-blue-200 rounded-full opacity-35 blur-2xl"></div>
            <div class="absolute bottom-1/4 left-1/3 w-40 h-40 bg-pink-200 rounded-full opacity-35 blur-2xl"></div>
            
            <!-- Additional decorative elements -->
            <div class="absolute top-10 left-1/4 w-24 h-24 bg-yellow-100 rounded-full opacity-30 blur-2xl"></div>
            <div class="absolute bottom-10 right-1/3 w-28 h-28 bg-teal-100 rounded-full opacity-30 blur-2xl"></div>
        </div>

        <!-- Logo container with circular frame - VOTRE LOGO -->
        <div class="relative mb-6">
            <div class="w-32 h-32 rounded-full bg-white shadow-lg flex items-center justify-center border-4 border-indigo-100 overflow-hidden">
                <!-- Votre logo ici -->
                <img 
                    src="/logo2.webp" 
                    alt="Logo" 
                    class="w-full h-full object-cover"
                />
            </div>
        </div>

        <!-- Form container -->
        <div class="relative w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>