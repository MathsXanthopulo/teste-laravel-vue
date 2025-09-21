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
        <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
          <span class="text-white font-bold text-lg">CRM</span>
        </div>
        <div v-show="isExpanded" class="transition-opacity duration-300">
          <h1 class="text-white font-semibold text-lg">Sistema CRM</h1>
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
              'flex items-center rounded-lg transition-colors',
              isExpanded ? 'space-x-3 px-4 py-3' : 'justify-center p-3',
              $page.url === '/dashboard' || $page.url === '/' 
                ? 'bg-purple-600 text-white' 
                : 'text-gray-300 hover:bg-gray-800 hover:text-white'
            ]"
          >
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
            </svg>
            <span v-show="isExpanded" class="font-medium transition-opacity duration-300">Dashboard</span>
          </Link>
        </li>

        <li>
          <Link 
            :href="route('colaboradores.index')" 
            :class="[
              'flex items-center rounded-lg transition-colors',
              isExpanded ? 'space-x-3 px-4 py-3' : 'justify-center p-3',
              $page.url.startsWith('/colaboradores') 
                ? 'bg-purple-600 text-white' 
                : 'text-gray-300 hover:bg-gray-800 hover:text-white'
            ]"
          >
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
            <span v-show="isExpanded" class="font-medium transition-opacity duration-300">Colaboradores</span>
          </Link>
        </li>

        <li>
          <a 
            href="#" 
            :class="[
              'flex items-center rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors',
              isExpanded ? 'space-x-3 px-4 py-3' : 'justify-center p-3'
            ]"
          >
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span v-show="isExpanded" class="font-medium transition-opacity duration-300">Clientes</span>
          </a>
        </li>

        <li>
          <a 
            href="#" 
            :class="[
              'flex items-center rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors',
              isExpanded ? 'space-x-3 px-4 py-3' : 'justify-center p-3'
            ]"
          >
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <span v-show="isExpanded" class="font-medium transition-opacity duration-300">Produtos</span>
          </a>
        </li>

        <li>
          <a 
            href="#" 
            :class="[
              'flex items-center rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors',
              isExpanded ? 'space-x-3 px-4 py-3' : 'justify-center p-3'
            ]"
          >
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <span v-show="isExpanded" class="font-medium transition-opacity duration-300">Relatórios</span>
          </a>
        </li>
      </ul>
    </nav>

    <!-- User Profile Section -->
    <div class="p-4 border-t border-gray-700">
      <div class="flex items-center" :class="isExpanded ? 'space-x-3' : 'justify-center'">
        <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center">
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
          class="text-gray-400 hover:text-white transition-colors"
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

<script setup>
import { Link } from '@inertiajs/vue3'
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
