<template>
  <nav class="bg-white/85 backdrop-blur-xl border-b border-gray-200/60 sticky top-0 z-50 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <!-- Logo à gauche -->
        <div class="flex-shrink-0">
          <Link href="/dashboard2" class="flex items-center space-x-2 group">
            <img 
              src="/logo2.webp" 
              alt="FoodShare Logo" 
              class="w-10 h-10 object-contain rounded-full shadow-md group-hover:shadow-lg transition-shadow duration-200" 
            />
            <span class="text-xl font-bold text-gray-800 hidden sm:block group-hover:text-green-600 transition-colors">
              FoodShare
            </span>
          </Link>
        </div>

        <!-- Menu principal (desktop) -->
        <div class="hidden lg:block flex-1 max-w-4xl mx-8">
          <ul class="flex items-center justify-center space-x-1">
            <li v-for="item in mainMenuItems" :key="item.href">
              <Link 
                :href="item.href" 
                :class="[
                  'px-3 py-2 rounded-md text-sm font-medium transition-all duration-200',
                  isCurrentRoute(item.href) 
                    ? 'bg-green-100 text-green-700 shadow-sm' 
                    : 'text-gray-700 hover:text-green-600 hover:bg-gray-50'
                ]"
              >
                <component 
                  :is="item.icon" 
                  v-if="item.icon" 
                  class="w-4 h-4 inline-block mr-1.5" 
                />
                {{ item.label }}
              </Link>
            </li>
          </ul>
        </div>

        <!-- Actions à droite (desktop) -->
        <div class="hidden md:flex items-center space-x-3">
          <!-- Bouton CTA principal -->
          <Link 
            href="/donations/create" 
            class="bg-gradient-to-r from-green-600 to-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium hover:from-green-700 hover:to-green-800 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg"
          >
            <component :is="PlusIcon" class="w-4 h-4 inline-block mr-1" />
            Donate Now
          </Link>
          
          <!-- Menu utilisateur -->
          <div class="relative" ref="userMenuRef">
            <button 
              @click="toggleUserMenu"
              class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
            >
              <!-- Photo de profil ou avatar par défaut -->
              <div class="w-8 h-8 rounded-full overflow-hidden ring-2 ring-green-200 flex items-center justify-center">
                <img 
                  v-if="user?.profile_image" 
                  :src="user.profile_image"
                  :alt="`${user.name} profile picture`"
                  class="w-full h-full object-cover"
                  @error="handleImageError"
                />
                <div 
                  v-else 
                  class="w-full h-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white text-sm font-medium"
                >
                  {{ userInitials }}
                </div>
              </div>
              <component :is="ChevronDownIcon" class="w-4 h-4 text-gray-500" />
            </button>
            
            <!-- Dropdown menu utilisateur -->
            <Transition
              enter-active-class="transition ease-out duration-200"
              enter-from-class="transform opacity-0 scale-95"
              enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-150"
              leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95"
            >
              <div 
                v-if="showUserMenu" 
                class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50"
              >
                <!-- En-tête du menu avec info utilisateur -->
                <div class="px-4 py-3 border-b border-gray-100">
                  <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full overflow-hidden ring-2 ring-green-200 flex-shrink-0">
                      <img 
                        v-if="user?.profile_image" 
                        :src="user.profile_image"
                        :alt="`${user.name} profile picture`"
                        class="w-full h-full object-cover"
                        @error="handleImageError"
                      />
                      <div 
                        v-else 
                        class="w-full h-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white text-sm font-medium"
                      >
                        {{ userInitials }}
                      </div>
                    </div>
                    <div class="min-w-0 flex-1">
                      <p class="text-sm font-medium text-gray-900 truncate">{{ user?.name }}</p>
                      <p class="text-xs text-gray-500 truncate">{{ user?.email }}</p>
                    </div>
                  </div>
                </div>

                <Link 
                  v-for="item in userMenuItems" 
                  :key="item.href"
                  :href="item.href" 
                  class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
                  @click="showUserMenu = false"
                >
                  <component :is="item.icon" class="w-4 h-4 mr-3 text-gray-400" />
                  {{ item.label }}
                </Link>
                
                <div class="border-t border-gray-100 mt-1">
                  <button 
                    @click="logout" 
                    class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors"
                  >
                    <component :is="LogoutIcon" class="w-4 h-4 mr-3" />
                    Logout
                  </button>
                </div>
              </div>
            </Transition>
          </div>
        </div>

        <!-- Bouton menu mobile -->
        <div class="lg:hidden">
          <button 
            @click="toggleMobileMenu"
            class="p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-200"
          >
            <component :is="showMobileMenu ? XMarkIcon : Bars3Icon" class="w-6 h-6" />
          </button>
        </div>
      </div>

      <!-- Menu mobile -->
      <Transition
        enter-active-class="transition ease-out duration-300 transform"
        enter-from-class="opacity-0 -translate-y-2"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-200 transform"
        leave-from-class="transform opacity-100 translate-y-0"
        leave-to-class="opacity-0 -translate-y-2"
      >
        <div v-if="showMobileMenu" class="lg:hidden border-t border-gray-200 bg-white/95 backdrop-blur-sm">
          <div class="px-2 pt-2 pb-3 space-y-1">
            <!-- Profil utilisateur en haut du menu mobile -->
            <div class="flex items-center px-3 py-3 mb-2 bg-gray-50 rounded-lg">
              <div class="w-10 h-10 rounded-full overflow-hidden ring-2 ring-green-200 flex-shrink-0">
                <img 
                  v-if="user?.profile_image" 
                  :src="user.profile_image"
                  :alt="`${user.name} profile picture`"
                  class="w-full h-full object-cover"
                  @error="handleImageError"
                />
                <div 
                  v-else 
                  class="w-full h-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white text-sm font-medium"
                >
                  {{ userInitials }}
                </div>
              </div>
              <div class="ml-3 min-w-0 flex-1">
                <p class="text-sm font-medium text-gray-900 truncate">{{ user?.name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ user?.email }}</p>
              </div>
            </div>

            <!-- Menu principal mobile -->
            <Link 
              v-for="item in allMenuItems" 
              :key="item.href"
              :href="item.href" 
              :class="[
                'flex items-center px-3 py-2 rounded-md text-base font-medium transition-colors',
                isCurrentRoute(item.href) 
                  ? 'bg-green-100 text-green-700' 
                  : 'text-gray-700 hover:text-green-600 hover:bg-gray-50'
              ]"
              @click="showMobileMenu = false"
            >
              <component :is="item.icon" v-if="item.icon" class="w-5 h-5 mr-3" />
              {{ item.label }}
            </Link>
            
            <!-- CTA mobile -->
            <Link 
              href="/donations/create" 
              class="flex items-center px-3 py-2 rounded-md text-base font-medium bg-green-600 text-white hover:bg-green-700 transition-colors mt-4"
              @click="showMobileMenu = false"
            >
              <component :is="PlusIcon" class="w-5 h-5 mr-3" />
              Donate Now
            </Link>

            <!-- Logout mobile -->
            <button 
              @click="logout"
              class="flex items-center w-full px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50 transition-colors mt-2"
            >
              <component :is="LogoutIcon" class="w-5 h-5 mr-3" />
              Logout
            </button>
          </div>
        </div>
      </Transition>
    </div>
  </nav>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3' // ✅ Ajout de router
import { 
  HomeIcon, 
  UserIcon, 
  GlobeAltIcon, 
  HeartIcon, 
  DocumentTextIcon,
  BuildingOfficeIcon,
  Cog6ToothIcon,
  CurrencyDollarIcon,
  MapPinIcon,
  UserGroupIcon,
  PlusIcon,
  ChevronDownIcon,
  Bars3Icon,
  XMarkIcon,
  ArrowRightOnRectangleIcon as LogoutIcon,
  BuildingStorefrontIcon,
  PlusCircleIcon,
  RectangleStackIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
  user: {
    type: Object,
    default: null
  }
})

const showMobileMenu = ref(false)
const showUserMenu = ref(false)
const userMenuRef = ref(null)
const page = usePage()
const user = computed(() => props.user || page.props.auth?.user)

const userInitials = computed(() => {
  if (!user.value?.name) return 'U'
  return user.value.name
    .split(' ')
    .map(word => word.charAt(0))
    .join('')
    .substring(0, 2)
    .toUpperCase()
})

const { url } = usePage()

const mainMenuItems = [
  { href: '/dashboard2', label: 'Home', icon: HomeIcon },
  { href: '/dashboard', label: 'Explore', icon: GlobeAltIcon },
  { href: '/my-donations', label: 'My Donations', icon: HeartIcon },
  { href: '/requests', label: 'Requests', icon: DocumentTextIcon },
  { href: '/places', label: 'Places', icon: BuildingStorefrontIcon },
  //{ href: '/partners', label: 'Partners', icon: BuildingOfficeIcon },
  { href: '/donations-map', label: 'Map', icon: MapPinIcon }
]

const userMenuItems = [
  { href: '/profile/donor', label: 'Profile', icon: UserIcon },
  //{ href: '/preferences', label: 'Preferences', icon: Cog6ToothIcon },
  //{ href: '/sponsorships/create', label: 'Sponsor', icon: CurrencyDollarIcon },
  { href: '/volunteer/needs', label: 'Volunteer', icon: UserGroupIcon },
  { href: '/places/create', label: 'Add a Place', icon: PlusCircleIcon },
  { href: '/my-places', label: 'My Places', icon: RectangleStackIcon },
]

const allMenuItems = [...mainMenuItems, ...userMenuItems]

const isCurrentRoute = (href) => {
  if (!url.value) return false
  return url.value === href || (href !== '/' && url.value.startsWith(href))
}

const toggleMobileMenu = () => {
  showMobileMenu.value = !showMobileMenu.value
  if (showMobileMenu.value) {
    showUserMenu.value = false
  }
}

const toggleUserMenu = () => {
  showUserMenu.value = !showUserMenu.value
  if (showUserMenu.value) {
    showMobileMenu.value = false
  }
}

// ✅ FONCTION LOGOUT CORRIGÉE
const logout = () => {
  router.post('/logout')
}

const handleImageError = (event) => {
  event.target.style.display = 'none'
}

const closeMenus = (event) => {
  if (userMenuRef.value && !userMenuRef.value.contains(event.target)) {
    showUserMenu.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', closeMenus)
})

onUnmounted(() => {
  document.removeEventListener('click', closeMenus)
})
</script>

<style scoped>
.backdrop-blur-xl {
  backdrop-filter: blur(20px);
}

html {
  scroll-behavior: smooth;
}

.focus\:ring-2:focus {
  outline: 2px solid transparent;
  outline-offset: 2px;
  box-shadow: 0 0 0 2px rgb(34 197 94 / 0.5);
}
</style>