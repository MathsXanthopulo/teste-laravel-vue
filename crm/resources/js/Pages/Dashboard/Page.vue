<template>
  <Head title="Dashboard" />
  
  <AppLayout title="Dashboard" subtitle="Visão geral do sistema">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <SpaceCard 
        v-for="stat in statsCards" 
        :key="stat.title"
        :title="stat.title"
        :icon="stat.icon"
        :variant="stat.variant"
        class="space-card--interactive"
      >
        <div class="flex items-center justify-between mb-4">
          <div>
            <p class="text-3xl font-bold text-white mb-1">{{ stat.value }}</p>
            <p class="text-sm text-gray-300">{{ stat.change }}</p>
          </div>
        </div>
      </SpaceCard>
    </div>

    <!-- Chart Section -->
    <div class="space-card">
      <div class="p-6 pb-0">
        <h3 class="text-lg font-semibold text-white">Resumo de Colaboradores</h3>
        <p class="text-sm text-gray-300">Distribuição por status</p>
      </div>
      <div class="p-6 pt-0">
        <div class="h-64 flex items-end justify-between space-x-4">
          <div v-for="data in colaboradoresChartData" :key="data.status" class="flex flex-col items-center flex-1">
            <div 
              class="bg-gradient-to-t from-blue-600 to-blue-400 rounded-t w-full mb-2 transition-all duration-300 hover:from-blue-700 hover:to-blue-500"
              :style="{ height: `${(data.value / Math.max(...colaboradoresChartData.map(d => d.value))) * 200}px` }"
            ></div>
            <span class="text-xs text-gray-300 font-medium">{{ data.status }}</span>
            <span class="text-xs text-gray-400">{{ data.value }}</span>
          </div>
        </div>
        
        <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-700">
          <div class="flex items-center space-x-2">
            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
            <span class="text-sm text-gray-300">Status dos Colaboradores</span>
          </div>
          <div class="text-sm text-gray-400">
            Total: {{ colaboradoresChartData.reduce((sum, item) => sum + item.value, 0) }}
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import SpaceCard from '@/Components/SpaceCard.vue'
import { Users, UserMinus, UserCheck } from 'lucide-vue-next'

const props = defineProps({
  stats: {
    type: Object,
    default: () => ({
      monthCreated: 0,
      monthDeleted: 0,
      totalActive: 0,
      lastMonthCreated: 0,
      lastMonthDeleted: 0
    })
  }
})

const calculatePercentageChange = (current, previous) => {
  if (previous === 0) return current > 0 ? '+100%' : '0%'
  const change = ((current - previous) / previous) * 100
  return change > 0 ? `+${change.toFixed(0)}%` : `${change.toFixed(0)}%`
}

const statsCards = computed(() => [
  {
    title: 'Cadastrados no Mês',
    value: props.stats.monthCreated,
    change: calculatePercentageChange(props.stats.monthCreated, props.stats.lastMonthCreated),
    icon: Users,
    variant: 'primary'
  },
  {
    title: 'Demitidos no Mês',
    value: props.stats.monthDeleted,
    change: calculatePercentageChange(props.stats.monthDeleted, props.stats.lastMonthDeleted),
    icon: UserMinus,
    variant: 'warning'
  },
  {
    title: 'Total Ativos',
    value: props.stats.totalActive,
    change: 'Colaboradores ativos',
    icon: UserCheck,
    variant: 'success'
  }
])

const colaboradoresChartData = computed(() => [
  { status: 'Ativos', value: props.stats.totalActive },
  { status: 'Cadastrados', value: props.stats.monthCreated },
  { status: 'Demitidos', value: props.stats.monthDeleted }
])
</script>