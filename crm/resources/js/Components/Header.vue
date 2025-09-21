<template>
  <header class="space-header px-6 py-4">
    <div class="flex items-center justify-between">
      <!-- Left: Page Title -->
      <div>
        <h1 class="text-2xl font-bold text-white">{{ pageTitle }}</h1>
        <p class="text-sm text-gray-300 mt-1">{{ pageSubtitle }}</p>
      </div>

      <!-- Right: Actions and User -->
      <div class="flex items-center space-x-4">
        <!-- Search -->
        <div class="relative">
          <InputText 
            placeholder="Pesquisar..." 
            class="w-64 pl-10 space-input"
          />
          <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" 
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </div>

        <!-- Notifications -->
        <button class="relative p-2 text-gray-400 hover:text-gray-200 transition-colors">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5a2.5 2.5 0 01-2.5-2.5V6a2.5 2.5 0 012.5-2.5h15A2.5 2.5 0 0122 6v11a2.5 2.5 0 01-2.5 2.5h-15z"></path>
          </svg>
          <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
        </button>

        <!-- User Menu -->
        <div class="flex items-center space-x-3">
          <div class="text-right">
            <p class="text-sm font-medium text-white">{{ user.name }}</p>
            <p class="text-xs text-gray-300">{{ user.email }}</p>
          </div>
          <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
            <span class="text-white font-medium text-sm">{{ userInitials }}</span>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  pageTitle: {
    type: String,
    default: 'Dashboard'
  },
  pageSubtitle: {
    type: String,
    default: 'Visão geral do sistema'
  },
  user: {
    type: Object,
    required: true
  }
})

const userInitials = computed(() => {
  const name = props.user?.name || 'Usuário'
  return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
})
</script>
