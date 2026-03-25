<template>
  <div class="min-h-screen bg-green-50">

    <!-- Header pleine largeur -->
    <Header/>

    <!-- Background image -->
    <img
      src="/bckg5.jpg"
      alt="Impact Background"
      class="fixed inset-0 w-full h-full object-cover opacity-20 pointer-events-none select-none"
      style="z-index: -1;"
    />

    <!-- Profile Header Card -->
    <div class="bg-white/80 backdrop-blur-sm shadow-lg border border-green-100 p-8 mb-8">
      <div class="flex items-center justify-center mb-6">
        <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-green-400">
          <img v-if="user.profile_image" :src="user.profile_image" alt="Profile Image" class="w-full h-full object-cover"/>
          <div v-else class="bg-gradient-to-r from-green-400 to-emerald-500 w-full h-full flex items-center justify-center">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path v-if="user.role === 'organization'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
          </div>
        </div>
      </div>
      <h1 class="text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-2 text-center">
        {{ user.role === 'organization' || user.role === 'partner' ? 'Organization Profile' : 'My Donor Profile' }}
      </h1>
      <p class="text-green-600 text-center text-lg mb-4">
        {{ user.role === 'organization' ? 'Managing donations and partnerships' : 'Making a difference, one donation at a time' }}
      </p>

      <!-- ✅ Bouton Edit Profile -->
      <div class="flex justify-center">
        <button
          @click="openEditModal"
          class="flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-emerald-700 transition-all shadow-md hover:shadow-lg"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
          </svg>
          Edit Profile
        </button>
      </div>
    </div>

    <!-- ✅ MODAL Edit Profile -->
    <div v-if="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center px-4">
      <!-- Backdrop -->
      <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="closeEditModal"></div>

      <!-- Modal -->
      <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 z-10">
        <!-- Header Modal -->
        <div class="flex items-center justify-between mb-6">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-r from-green-400 to-emerald-500 rounded-xl flex items-center justify-center">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Edit Profile</h3>
          </div>
          <button @click="closeEditModal" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <!-- Form -->
        <form @submit.prevent="submitEditProfile" class="space-y-4">
          <!-- Name -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
            <input
              v-model="editForm.name"
              type="text"
              required
              class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
              placeholder="Your full name"
            />
            <p v-if="editErrors.name" class="text-red-500 text-xs mt-1">{{ editErrors.name }}</p>
          </div>

          <!-- Email -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
            <input
              v-model="editForm.email"
              type="email"
              required
              class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
              placeholder="your@email.com"
            />
            <p v-if="editErrors.email" class="text-red-500 text-xs mt-1">{{ editErrors.email }}</p>
          </div>

          <!-- Current Password -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
              Current Password
              <span class="text-gray-400 font-normal">(required to save changes)</span>
            </label>
            <input
              v-model="editForm.current_password"
              type="password"
              required
              class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
              placeholder="Enter your current password"
            />
            <p v-if="editErrors.current_password" class="text-red-500 text-xs mt-1">{{ editErrors.current_password }}</p>
          </div>

          <!-- New Password (optional) -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
              New Password
              <span class="text-gray-400 font-normal">(optional)</span>
            </label>
            <input
              v-model="editForm.password"
              type="password"
              class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
              placeholder="Leave empty to keep current"
            />
          </div>

          <!-- Confirm New Password -->
          <div v-if="editForm.password">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm New Password</label>
            <input
              v-model="editForm.password_confirmation"
              type="password"
              class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
              placeholder="Confirm new password"
            />
          </div>

          <!-- Success message -->
          <div v-if="editSuccess" class="p-3 bg-green-50 border border-green-200 rounded-xl flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-green-700 text-sm font-medium">Profile updated successfully!</p>
          </div>

          <!-- Error message -->
          <div v-if="editErrors.general" class="p-3 bg-red-50 border border-red-200 rounded-xl">
            <p class="text-red-700 text-sm">{{ editErrors.general }}</p>
          </div>

          <!-- Buttons -->
          <div class="flex gap-3 pt-2">
            <button
              type="button"
              @click="closeEditModal"
              class="flex-1 py-3 border-2 border-gray-200 text-gray-600 rounded-xl font-semibold hover:bg-gray-50 transition-all"
            >
              Cancel
            </button>
            <button
              type="submit"
              :disabled="editProcessing"
              class="flex-1 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-emerald-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
            >
              <svg v-if="editProcessing" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
              </svg>
              {{ editProcessing ? 'Saving...' : 'Save Changes' }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-6">

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-green-100 p-6 hover:shadow-xl transition-all duration-300">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-green-600 text-sm font-medium">Total Donations</p>
              <p class="text-3xl font-bold text-gray-800">{{ totalDonations }}</p>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14a2 2 0 110 4H5a2 2 0 110-4zm0 0v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-green-100 p-6 hover:shadow-xl transition-all duration-300">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-green-600 text-sm font-medium">Total Items</p>
              <p class="text-3xl font-bold text-gray-800">{{ totalItems }}</p>
            </div>
            <div class="bg-emerald-100 p-3 rounded-full">
              <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-green-100 p-6 hover:shadow-xl transition-all duration-300">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-green-600 text-sm font-medium">Member Since</p>
              <p class="text-xl font-bold text-gray-800">{{ formatDate(user.created_at) }}</p>
            </div>
            <div class="bg-teal-100 p-3 rounded-full">
              <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Charts Section -->
      <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-green-100 p-6">
          <div class="flex items-center mb-6">
            <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-800">Donations Over Time</h3>
          </div>
          <div class="h-80"><canvas ref="lineChart" class="w-full h-full"></canvas></div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-green-100 p-6">
          <div class="flex items-center mb-6">
            <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-800">Donation Items Distribution</h3>
          </div>
          <div class="h-80"><canvas ref="barChart" class="w-full h-full"></canvas></div>
        </div>
      </div>

      <!-- Main Content Grid -->
      <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Account Information -->
        <div class="xl:col-span-1">
          <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-green-100 p-6">
            <div class="flex items-center mb-6">
              <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              <h2 class="text-xl font-semibold text-gray-800">Account Information</h2>
            </div>
            <div class="space-y-4">
              <div class="bg-green-50 rounded-xl p-4">
                <p class="text-sm text-green-600 font-medium mb-1">Name</p>
                <p class="text-lg text-gray-800 font-semibold">{{ user.name }}</p>
              </div>
              <div class="bg-emerald-50 rounded-xl p-4">
                <p class="text-sm text-emerald-600 font-medium mb-1">Email</p>
                <p class="text-lg text-gray-800 font-semibold">{{ user.email }}</p>
              </div>
              <div class="bg-green-50 rounded-xl p-4">
                <p class="text-sm text-green-600 font-medium mb-1">Joined on</p>
                <p class="text-lg text-gray-800 font-semibold">{{ formatDate(user.created_at) }}</p>
              </div>
              <template v-if="user.role !== 'receiver' && partnerInfo">
                <div class="bg-blue-50 rounded-xl p-4">
                  <p class="text-sm text-blue-600 font-medium mb-1">Organization Name</p>
                  <p class="text-lg text-gray-800 font-semibold">{{ partnerInfo.name || 'Not specified' }}</p>
                </div>
                <div class="bg-purple-50 rounded-xl p-4">
                  <p class="text-sm text-purple-600 font-medium mb-1">Organization Type</p>
                  <p class="text-lg text-gray-800 font-semibold">{{ partnerInfo.type || 'Not specified' }}</p>
                </div>
                <div class="bg-indigo-50 rounded-xl p-4">
                  <p class="text-sm text-indigo-600 font-medium mb-1">Address</p>
                  <p class="text-lg text-gray-800 font-semibold">{{ partnerInfo.address || 'Not specified' }}</p>
                </div>
                <div class="bg-orange-50 rounded-xl p-4">
                  <p class="text-sm text-orange-600 font-medium mb-1">Contact Email</p>
                  <p class="text-lg text-gray-800 font-semibold">{{ partnerInfo.contact_email || 'Not specified' }}</p>
                </div>
                <div class="bg-pink-50 rounded-xl p-4">
                  <p class="text-sm text-pink-600 font-medium mb-1">Contact Phone</p>
                  <p class="text-lg text-gray-800 font-semibold">{{ partnerInfo.contact_phone || 'Not specified' }}</p>
                </div>
                <div class="bg-yellow-50 rounded-xl p-4">
                  <p class="text-sm text-yellow-600 font-medium mb-1">Status</p>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                        :class="{
                          'bg-green-100 text-green-800': partnerInfo.status === 'active',
                          'bg-red-100 text-red-800': partnerInfo.status === 'inactive',
                          'bg-yellow-100 text-yellow-800': partnerInfo.status === 'pending',
                          'bg-gray-100 text-gray-800': !partnerInfo.status
                        }">
                    {{ partnerInfo.status || 'Unknown' }}
                  </span>
                </div>
              </template>
              <template v-if="user.role !== 'organization' && volunteerInfo">
                <div class="bg-sky-50 rounded-xl p-4">
                  <p class="text-sm text-sky-600 font-medium mb-1">Phone</p>
                  <p class="text-lg text-gray-800 font-semibold">{{ volunteerInfo.phone || 'Not specified' }}</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-4">
                  <p class="text-sm text-blue-600 font-medium mb-1">Skills</p>
                  <p class="text-lg text-gray-800 font-semibold">{{ volunteerInfo.skills || 'Not specified' }}</p>
                </div>
                <div class="bg-indigo-50 rounded-xl p-4">
                  <p class="text-sm text-indigo-600 font-medium mb-1">Availability</p>
                  <p class="text-lg text-gray-800 font-semibold">{{ volunteerInfo.availability || 'Not specified' }}</p>
                </div>
                <div class="bg-yellow-50 rounded-xl p-4">
                  <p class="text-sm text-yellow-600 font-medium mb-1">Volunteer Since</p>
                  <p class="text-lg text-gray-800 font-semibold">{{ formatDate(volunteerInfo.created_at) || 'Not specified' }}</p>
                </div>
              </template>
            </div>
          </div>
        </div>

        <!-- Donations History -->
        <div class="xl:col-span-2">
          <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-green-100 p-6">
            <div class="flex items-center mb-6">
              <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
              </svg>
              <h2 class="text-xl font-semibold text-gray-800">
                {{ user.role !== 'receiver' ? 'Our Donations History' : 'My Donations History' }}
              </h2>
            </div>
            <div class="space-y-4 max-h-96 overflow-y-auto">
              <div v-if="donations.length">
                <div v-for="(donation, index) in donations" :key="donation.id"
                     class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 hover:shadow-md transition-all duration-300">
                  <div class="flex items-start justify-between">
                    <div class="flex-1">
                      <div class="flex items-center mb-2">
                        <h3 class="text-lg font-semibold text-gray-800 mr-2">{{ donation.title }}</h3>
                        <span class="px-2 py-1 rounded-full text-xs font-medium text-white" :style="{ backgroundColor: getDonationColor(index) }">Food</span>
                      </div>
                      <p class="text-sm text-gray-600 mb-3">{{ donation.description }}</p>
                      <div class="flex items-center text-sm text-gray-500 space-x-4">
                        <div class="flex items-center">
                          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                          </svg>
                          <span>{{ donation.quantity }} {{ donation.unit }}</span>
                        </div>
                        <div class="flex items-center">
                          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                          <span>Expires: {{ formatDate(donation.expiration_date) }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div v-else class="text-center py-8">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                </svg>
                <p class="text-gray-500">{{ user.role === 'organization' ? 'No donations received yet.' : "You haven't made any donations yet." }}</p>
                <p class="text-sm text-gray-400">{{ user.role === 'organization' ? 'Partner with donors to help your community!' : 'Start making a difference today!' }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Affiliated Partners -->
      <div v-if="user.role === 'organization' && affiliatedPartners && affiliatedPartners.length > 0" class="mt-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-green-100 p-6">
          <div class="flex items-center mb-6">
            <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h2 class="text-xl font-semibold text-gray-800">Partners</h2>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div v-for="partner in affiliatedPartners" :key="partner.id"
                 class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300 hover:scale-105">
              <div class="flex items-start space-x-3">
                <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-blue-300 flex-shrink-0">
                  <img v-if="partner.profile_image" :src="`/storage/${partner.profile_image}`" alt="Partner" class="w-full h-full object-cover"/>
                  <div v-else class="bg-gradient-to-r from-blue-400 to-indigo-500 w-full h-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                  </div>
                </div>
                <div class="flex-1 min-w-0">
                  <h3 class="text-lg font-semibold text-gray-900 truncate">{{ partner.name }}</h3>
                  <p class="text-sm text-blue-600 font-medium">{{ partner.type || 'Organisation' }}</p>
                  <p class="text-xs text-gray-500 mt-1" v-if="partner.address">{{ partner.address }}</p>
                  <div class="flex items-center mt-2 space-x-2">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Approved</span>
                    <span class="text-xs text-gray-400">Since {{ formatDate(partner.approved_at) }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Received Donations (Organizations) -->
      <div v-if="user.role === 'organization'" class="mt-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-green-100 p-6">
          <div class="flex items-center mb-6">
            <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            <h2 class="text-xl font-semibold text-gray-800">Received Donations and Funding</h2>
          </div>
          <div class="space-y-4 max-h-96 overflow-y-auto">
            <div v-if="hasReceivedDonations">
              <div v-for="f in receivedFoodDonations" :key="'fd' + f.id"
                   class="flex items-center justify-between p-4 rounded-lg border border-blue-100 hover:border-blue-200 transition-colors bg-blue-50/50">
                <div class="flex items-center space-x-4">
                  <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                  </div>
                  <div>
                    <p class="font-semibold text-gray-900">{{ f.donor_name || 'Anonymous Donor' }}</p>
                    <p class="text-sm text-gray-600">{{ f.title }} - {{ f.quantity }} {{ f.unit }}</p>
                    <p class="text-xs text-gray-500">{{ formatDate(f.created_at) }}</p>
                  </div>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Food Donation</span>
              </div>
            </div>
            <div v-else class="text-center py-8">
              <p class="text-gray-500">No donations or funding received yet.</p>
              <p class="text-sm text-gray-400">Community support will appear here when received.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Contributions (non-organizations) -->
      <div v-if="user.role !== 'organization'" class="mt-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-green-100 p-6">
          <div class="flex items-center mb-6">
            <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
            </svg>
            <h2 class="text-xl font-semibold text-gray-800">Contributions</h2>
          </div>
          <div class="space-y-4 max-h-96 overflow-y-auto">
            <div v-if="myContributions && myContributions.length > 0">
              <div v-for="c in myContributions" :key="'mc' + c.id"
                   class="flex items-center justify-between p-4 rounded-lg border border-emerald-100 hover:border-emerald-200 transition-colors bg-emerald-50/50">
                <div class="flex items-center space-x-4">
                  <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                  </div>
                  <div>
                    <p class="font-semibold text-gray-900">{{ c.organization_name || 'Organization' }}</p>
                    <p class="text-sm text-gray-600">€{{ parseFloat(c.amount).toFixed(2) }} contribution</p>
                    <p class="text-xs text-gray-500">{{ formatDate(c.created_at) }}</p>
                  </div>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Financial Support</span>
              </div>
            </div>
            <div v-if="foodRequestDonations && foodRequestDonations.length > 0">
              <div v-for="fd in foodRequestDonations" :key="'fd' + fd.id"
                   class="flex items-center justify-between p-4 rounded-lg border border-emerald-100 hover:border-emerald-200 transition-colors bg-emerald-50/50">
                <div class="flex items-center space-x-4">
                  <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                  </div>
                  <div>
                    <p class="font-semibold text-gray-900">{{ fd.food_request?.organization?.partner_profile?.name || 'Organization' }}</p>
                    <p class="text-sm text-gray-600">Donated {{ fd.quantity }} item(s) to: {{ fd.food_request?.title }}</p>
                    <p class="text-xs text-gray-500">{{ formatDate(fd.created_at) }}</p>
                  </div>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Food Support</span>
              </div>
            </div>
            <div v-if="(!myContributions || myContributions.length === 0) && (!foodRequestDonations || foodRequestDonations.length === 0)" class="text-center py-8">
              <p class="text-gray-500">No contributions made yet.</p>
              <p class="text-sm text-gray-400">Your financial support to organizations will appear here.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Profile Image Update -->
      <div class="max-w-3xl mx-auto py-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-green-100 p-6">
          <div class="flex items-center mb-6">
            <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h2 class="text-xl font-semibold text-gray-800">Update your profile picture</h2>
          </div>
          <div class="max-w-md mx-auto">
            <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-6">
              <div class="flex flex-col items-center space-y-4">
                <div v-if="previewImage" class="w-32 h-32 rounded-full overflow-hidden border-4 border-green-200 shadow-lg relative group">
                  <img :src="previewImage" alt="Preview" class="w-full h-full object-cover"/>
                  <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition">
                    <button type="button" @click="removeImage" class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">Remove</button>
                  </div>
                </div>
                <div v-else class="w-full relative border-2 border-dashed rounded-xl cursor-pointer bg-green-50 hover:bg-green-100 transition-colors p-6 text-center" @dragover.prevent @drop.prevent="handleDrop">
                  <input type="file" accept="image/*" @change="onFileChange" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"/>
                  <div class="flex flex-col items-center">
                    <svg class="w-8 h-8 mb-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <p class="text-sm font-medium text-green-600">Drop your image here or click to upload</p>
                    <p class="text-xs text-green-500">PNG, JPG, JPEG (MAX. 2MB)</p>
                  </div>
                </div>
                <p v-if="errorMessage" class="text-red-600 text-sm font-medium">{{ errorMessage }}</p>
              </div>
              <button type="submit" :disabled="processing" class="w-full px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-emerald-700 transform hover:scale-105 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none shadow-lg">
                <span v-if="processing" class="flex items-center justify-center">
                  <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Uploading...
                </span>
                <span v-else>Save the picture</span>
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Privacy Section -->
      <div class="max-w-3xl mx-auto pb-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-green-100 p-6">
          <div class="flex items-center mb-4">
            <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zM12 11v10M12 1v4M4 21h16"/>
            </svg>
            <h2 class="text-xl font-semibold text-gray-800">Donation Name Privacy</h2>
          </div>
          <div class="flex items-center space-x-3">
            <label class="flex items-center cursor-pointer">
              <input type="checkbox" v-model="isAnonymous" class="sr-only" />
              <div class="w-11 h-6 bg-gray-200 rounded-full relative transition-colors duration-200" :class="{'bg-green-500': isAnonymous}">
                <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow-md transform transition-transform duration-200" :class="{'translate-x-5': isAnonymous}"></span>
              </div>
              <span class="ml-3 text-sm text-gray-700">Hide my name on donations</span>
            </label>
          </div>
          <p class="mt-2 text-sm text-gray-500">When enabled, your name will appear as <strong>Anonymous</strong> on all your donations.</p>
          <button @click="updatePrivacy" :disabled="processingPrivacy" class="mt-4 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-emerald-700 transform hover:scale-105 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg">
            <span v-if="processingPrivacy">Updating...</span>
            <span v-else>Save Privacy</span>
          </button>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, nextTick } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'
import axios from 'axios'

const props = defineProps({
  user: Object,
  donations: Array,
  partnerInfo: Object,
  volunteerInfo: Object,
  myContributions: Array,
  foodRequestDonations: Array,
  affiliatedPartners: Array,
  receivedFoodDonations: Array,
})

const { receivedFoodDonations } = props
const isAnonymous = ref(false)
const originalName = ref(props.user.name)
const processingPrivacy = ref(false)
const hasReceivedDonations = computed(() => receivedFoodDonations?.length > 0)

// ✅ Edit Profile Modal
const showEditModal = ref(false)
const editProcessing = ref(false)
const editSuccess = ref(false)
const editErrors = ref({})
const editForm = ref({
  name: '',
  email: '',
  current_password: '',
  password: '',
  password_confirmation: '',
})

function openEditModal() {
  editForm.value.name = props.user.name
  editForm.value.email = props.user.email
  editForm.value.current_password = ''
  editForm.value.password = ''
  editForm.value.password_confirmation = ''
  editErrors.value = {}
  editSuccess.value = false
  showEditModal.value = true
}

function closeEditModal() {
  showEditModal.value = false
  editSuccess.value = false
  editErrors.value = {}
}

async function submitEditProfile() {
  editProcessing.value = true
  editErrors.value = {}
  editSuccess.value = false

  try {
    await axios.post('/profile/update-info', editForm.value)
    
    // Mettre à jour les données locales
    props.user.name = editForm.value.name
    props.user.email = editForm.value.email
    originalName.value = editForm.value.name
    
    editSuccess.value = true
    
    setTimeout(() => {
      closeEditModal()
      router.reload()
    }, 1500)

  } catch (error) {
    if (error.response?.data?.errors) {
      editErrors.value = error.response.data.errors
    } else if (error.response?.data?.message) {
      editErrors.value = { general: error.response.data.message }
    } else {
      editErrors.value = { general: 'Failed to update profile. Please try again.' }
    }
  } finally {
    editProcessing.value = false
  }
}

// Profile image
const form = useForm({ profile_image: null })
const previewImage = ref(null)
const errorMessage = ref(null)
const processing = ref(false)

function onFileChange(e) {
  const file = e.target.files[0]
  validateFile(file)
  form.profile_image = (file && file.size <= 2 * 1024 * 1024) ? file : null
}

function handleDrop(e) {
  const file = e.dataTransfer.files[0]
  validateFile(file)
  form.profile_image = (file && file.size <= 2 * 1024 * 1024) ? file : null
}

function validateFile(file) {
  if (!file) return
  if (file.size > 2 * 1024 * 1024) {
    errorMessage.value = "The image must not exceed 2MB."
    previewImage.value = null
    return
  }
  errorMessage.value = null
  const reader = new FileReader()
  reader.onload = (event) => { previewImage.value = event.target.result }
  reader.readAsDataURL(file)
}

function removeImage() {
  previewImage.value = null
  errorMessage.value = null
}

function submit() {
  if (!form.profile_image) {
    errorMessage.value = "Please select an image."
    return
  }
  processing.value = true
  errorMessage.value = null
  form.post('/profile/update-image', {
    onFinish: () => (processing.value = false),
    onSuccess: (page) => {
      if (page.props.user.profile_image) {
        previewImage.value = page.props.user.profile_image
        props.user.profile_image = page.props.user.profile_image
      }
    },
    onError: (errors) => { errorMessage.value = errors.profile_image || 'Upload failed' },
  })
}

// Charts
const lineChart = ref(null)
const barChart = ref(null)

const formatDate = date => {
  if (!date) return 'Not specified'
  return new Date(date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' })
}

const donationColors = ['#10B981','#3B82F6','#F59E0B','#EF4444','#8B5CF6','#06B6D4','#84CC16','#F97316','#EC4899','#6B7280']
const getDonationColor = (index) => donationColors[index % donationColors.length]
const totalDonations = computed(() => props.donations?.reduce((sum, d) => sum + d.quantity, 0) || 0)
const totalItems = computed(() => props.donations?.length || 0)

const generateFullYearMonths = () => {
  const months = []
  const currentYear = new Date().getFullYear()
  for (let month = 0; month < 12; month++) {
    const date = new Date(currentYear, month, 1)
    months.push({
      key: `${currentYear}-${String(month + 1).padStart(2, '0')}`,
      label: date.toLocaleDateString('en-GB', { month: 'short', year: 'numeric' }),
      donations: []
    })
  }
  return months
}

const chartData = computed(() => {
  const monthlyData = generateFullYearMonths()
  if (!props.donations?.length) return monthlyData
  const monthlyMap = {}
  monthlyData.forEach(month => { monthlyMap[month.key] = month })
  props.donations.forEach((donation, index) => {
    const date = new Date(donation.created_at || new Date())
    const monthKey = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`
    if (monthlyMap[monthKey]) {
      monthlyMap[monthKey].donations.push({ title: donation.title, quantity: donation.quantity, color: getDonationColor(index) })
    }
  })
  return monthlyData
})

const donationItemsData = computed(() => {
  if (!props.donations?.length) return []
  return props.donations.map((donation, index) => ({ title: donation.title, quantity: donation.quantity, color: getDonationColor(index) }))
})

const initCharts = async () => {
  await nextTick()
  if (!lineChart.value || !barChart.value) return
  if (typeof Chart === 'undefined') {
    const script = document.createElement('script')
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js'
    script.onload = () => createCharts()
    document.head.appendChild(script)
  } else {
    createCharts()
  }
}

const createCharts = () => {
  const lineCtx = lineChart.value.getContext('2d')
  const allDonations = new Map()
  if (props.donations?.length) {
    props.donations.forEach((donation, index) => {
      if (!allDonations.has(donation.title)) {
        allDonations.set(donation.title, { label: donation.title, data: new Array(12).fill(0), borderColor: getDonationColor(index), backgroundColor: getDonationColor(index) + '20', borderWidth: 3, tension: 0.4, fill: false })
      }
    })
    chartData.value.forEach((monthData, monthIndex) => {
      monthData.donations.forEach(donation => {
        const dataset = allDonations.get(donation.title)
        if (dataset) dataset.data[monthIndex] += donation.quantity
      })
    })
  }
  if (allDonations.size === 0) {
    allDonations.set('No Data', { label: 'No donations yet', data: new Array(12).fill(0), borderColor: '#D1D5DB', backgroundColor: '#D1D5DB20', borderWidth: 2, tension: 0.4, fill: false })
  }
  new Chart(lineCtx, {
    type: 'line',
    data: { labels: chartData.value.map(d => d.label), datasets: Array.from(allDonations.values()) },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'top', labels: { usePointStyle: true, padding: 20 } } }, scales: { y: { beginAtZero: true, grid: { color: '#E5E7EB' }, ticks: { stepSize: 1 } }, x: { grid: { color: '#E5E7EB' } } } }
  })

  const barCtx = barChart.value.getContext('2d')
  if (donationItemsData.value.length > 0) {
    new Chart(barCtx, {
      type: 'doughnut',
      data: { labels: donationItemsData.value.map(d => d.title), datasets: [{ data: donationItemsData.value.map(d => d.quantity), backgroundColor: donationItemsData.value.map(d => d.color), borderWidth: 0 }] },
      options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } } } }
    })
  } else {
    new Chart(barCtx, {
      type: 'doughnut',
      data: { labels: ['No Data'], datasets: [{ data: [1], backgroundColor: ['#E5E7EB'], borderWidth: 0 }] },
      options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
    })
  }
}

function updatePrivacy() {
  processingPrivacy.value = true
  const newName = isAnonymous.value ? 'Anonymous' : originalName.value
  axios.post('/profile/update-name-privacy', { name: newName })
    .then(() => {
      props.user.name = newName
      processingPrivacy.value = false
      alert('Privacy updated successfully!')
    })
    .catch(() => {
      processingPrivacy.value = false
      alert('Failed to update privacy')
    })
}

onMounted(() => {
  initCharts()
  if (props.user.profile_image) previewImage.value = props.user.profile_image
  isAnonymous.value = props.user.name === 'Anonymous'
})
</script>