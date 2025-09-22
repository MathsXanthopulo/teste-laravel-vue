<script setup>
import { Link } from '@inertiajs/vue3'
import { LayoutDashboard, Users } from 'lucide-vue-next'
import { computed, ref } from 'vue'

const props = defineProps({
  user: {
    type: Object,
    required: true
  }
})

// Estado do sidebar
const isExpanded = ref(false)

// Funções para controlar o sidebar
const expandSidebar = () => {
  isExpanded.value = true
}

const collapseSidebar = () => {
  isExpanded.value = false
}

// Computed properties
const userName = computed(() => props.user?.name || 'Usuário')
const userEmail = computed(() => props.user?.email || 'usuario@email.com')
const userInitials = computed(() => {
  const name = userName.value
  return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
})
</script>

<template>
  <div 
    class="space-sidebar min-h-screen flex flex-col transition-all duration-300 ease-in-out"
    :class="isExpanded ? 'w-64' : 'w-16'"
    @mouseenter="expandSidebar"
    @mouseleave="collapseSidebar"
  >
    <!-- Logo/Header -->
    <div class="p-6 border-b border-gray-700">
      <div class="flex items-center" :class="isExpanded ? 'space-x-3' : 'justify-center'">
        <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl flex items-center justify-center shadow-lg">
          <span class="text-white font-bold text-lg">CRM</span>
        </div>
        <div v-show="isExpanded" class="transition-opacity duration-300">
          <h1 class="text-white font-semibold text-lg">{{ user.company_name || 'Sistema CRM' }}</h1>
          <p class="text-gray-400 text-sm">Gestão Empresarial</p>
        </div>
      </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-6">
      <ul class="space-y-2">
        <li>
          <Link 
            :href="route('dashboard.index')" 
            :class="[
              'flex items-center rounded-xl transition-all duration-200 ease-in-out transform',
              isExpanded ? 'space-x-3 px-4 py-3' : 'justify-center p-3',
              $page.url === '/dashboard' || $page.url === '/' 
                ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg shadow-purple-600/25' 
                : 'text-gray-300 hover:bg-gradient-to-r hover:from-purple-600/20 hover:to-purple-700/20 hover:text-white hover:shadow-md hover:scale-105'
            ]"
          >
            <LayoutDashboard class="w-5 h-5 flex-shrink-0" />
            <span v-show="isExpanded" class="font-medium transition-opacity duration-300">Dashboard</span>
          </Link>
        </li>

        <li>
          <Link 
            :href="route('colaboradores.index')" 
            :class="[
              'flex items-center rounded-xl transition-all duration-200 ease-in-out transform',
              isExpanded ? 'space-x-3 px-4 py-3' : 'justify-center p-3',
              $page.url.startsWith('/colaboradores') 
                ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg shadow-purple-600/25' 
                : 'text-gray-300 hover:bg-gradient-to-r hover:from-purple-600/20 hover:to-purple-700/20 hover:text-white hover:shadow-md hover:scale-105'
            ]"
          >
            <Users class="w-5 h-5 flex-shrink-0" />
            <span v-show="isExpanded" class="font-medium transition-opacity duration-300">Colaboradores</span>
          </Link>
        </li>

      </ul>
    </nav>

    <!-- User Profile Section -->
    <div class="p-4 border-t border-gray-700">
      <div class="flex items-center" :class="isExpanded ? 'space-x-3' : 'justify-center'">
        <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full flex items-center justify-center shadow-lg">
          <span class="text-white font-medium text-sm">{{ userInitials }}</span>
        </div>
        <div v-show="isExpanded" class="flex-1 min-w-0 transition-opacity duration-300">
          <p class="text-white font-medium text-sm truncate">{{ userName }}</p>
          <p class="text-gray-400 text-xs truncate">{{ userEmail }}</p>
        </div>
        <Link 
          v-show="isExpanded"
          :href="route('logout')" 
          method="post"
          class="text-gray-400 hover:text-white transition-all duration-200 hover:bg-gray-800 rounded-lg p-2 hover:scale-105"
          title="Sair"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
          </svg>
        </Link>
      </div>
    </div>
  </div>
</template>
