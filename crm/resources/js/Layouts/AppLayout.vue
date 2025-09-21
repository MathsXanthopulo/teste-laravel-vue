<template>
  <div class="min-h-screen">
    <div class="flex">
      <!-- Sidebar -->
      <Sidebar :user="$page.props.auth.user" />
      
      <!-- Main Content -->
      <div class="flex-1 flex flex-col">
        <!-- Header -->
        <Header 
          :page-title="pageTitle"
          :page-subtitle="pageSubtitle"
          :user="$page.props.auth.user"
        />
        
        <!-- Page Content -->
        <main class="flex-1 p-6">
          <slot />
        </main>
      </div>
    </div>
    
    <!-- Toast Notifications -->
    <Toaster />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import { Toaster } from 'sonner'

const props = defineProps({
  title: {
    type: String,
    default: 'Dashboard'
  },
  subtitle: {
    type: String,
    default: 'Visão geral do sistema'
  }
})

const pageTitle = computed(() => props.title)
const pageSubtitle = computed(() => props.subtitle)
</script>
