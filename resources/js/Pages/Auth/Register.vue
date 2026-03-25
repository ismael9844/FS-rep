<template>
  <GuestLayout>
    <Head title="Register" />

    <form @submit.prevent="submit" class="space-y-6">
      <!-- Full Name -->
      <div>
        <InputLabel for="name" value="Full Name" />
        <TextInput
          id="name"
          type="text"
          v-model="form.name"
          required
          autofocus
          autocomplete="name"
          class="mt-1 block w-full"
        />
        <InputError :message="form.errors.name" class="mt-1" />
      </div>

      <!-- Email Address -->
      <div>
        <InputLabel for="email" value="Email Address" />
        <TextInput
          id="email"
          type="email"
          v-model="form.email"
          required
          autocomplete="username"
          class="mt-1 block w-full"
        />
        <InputError :message="form.errors.email" class="mt-1" />
      </div>

      <!-- Password -->
      <div>
        <InputLabel for="password" value="Password" />
        <TextInput
          id="password"
          type="password"
          v-model="form.password"
          required
          autocomplete="new-password"
          class="mt-1 block w-full"
        />
        <InputError :message="form.errors.password" class="mt-1" />
      </div>

      <!-- Confirm Password -->
      <div>
        <InputLabel for="password_confirmation" value="Confirm Password" />
        <TextInput
          id="password_confirmation"
          type="password"
          v-model="form.password_confirmation"
          required
          autocomplete="new-password"
          class="mt-1 block w-full"
        />
        <InputError :message="form.errors.password_confirmation" class="mt-1" />
      </div>

      <!-- Submit -->
      <div class="flex items-center justify-end space-x-4 mt-6">
        <Link
          href="/login"
          class="text-sm text-gray-600 underline hover:text-gray-900"
        >
          Already registered?
        </Link>

        <PrimaryButton
          :disabled="form.processing"
          class="px-6 py-2"
        >
          {{ form.processing ? 'Registering...' : 'Register' }}
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  role: 'receiver', // ✅ Fixé à 'receiver'
})

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>