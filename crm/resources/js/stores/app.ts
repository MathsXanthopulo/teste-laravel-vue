import { ref, computed } from 'vue'

// Estado global da aplicação
const isLoading = ref(false)
const sidebarOpen = ref(false)

export function useAppStore() {
  const setLoading = (loading: boolean) => {
    isLoading.value = loading
  }

  const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value
  }

  const closeSidebar = () => {
    sidebarOpen.value = false
  }

  return {
    // State
    isLoading: computed(() => isLoading.value),
    sidebarOpen: computed(() => sidebarOpen.value),
    
    // Actions
    setLoading,
    toggleSidebar,
    closeSidebar
  }
}
