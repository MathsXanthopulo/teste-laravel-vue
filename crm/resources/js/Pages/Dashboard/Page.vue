<template>
  <Head title="Dashboard" />
  
  <AppLayout title="Dashboard" subtitle="Visão geral do sistema">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <SpaceCard 
        v-for="stat in stats" 
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

    <!-- Charts and Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Overview Chart -->
      <Card>
        <template #header>
          <div class="p-6 pb-0">
            <h3 class="text-lg font-semibold text-gray-900">Overview</h3>
            <p class="text-sm text-gray-600">Vendas dos últimos meses</p>
          </div>
        </template>
        <template #content>
          <div class="p-6 pt-0">
            <!-- Simple Bar Chart -->
            <div class="h-64 flex items-end justify-between space-x-4">
              <div v-for="data in chartData" :key="data.month" class="flex flex-col items-center flex-1">
                <div 
                  class="bg-gradient-to-t from-purple-600 to-purple-400 rounded-t w-full mb-2 transition-all duration-300 hover:from-purple-700 hover:to-purple-500"
                  :style="{ height: `${(data.value / 5000) * 200}px` }"
                ></div>
                <span class="text-xs text-gray-600 font-medium">{{ data.month }}</span>
                <span class="text-xs text-gray-500">${{ data.value.toLocaleString() }}</span>
              </div>
            </div>
            
            <!-- Chart Legend -->
            <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
              <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                <span class="text-sm text-gray-600">Total de Vendas</span>
              </div>
              <div class="text-sm text-gray-500">
                Últimos 3 meses
              </div>
            </div>
          </div>
        </template>
      </Card>

      <!-- Recent Sales Table -->
      <Card>
        <template #header>
          <div class="p-6 pb-0">
            <h3 class="text-lg font-semibold text-gray-900">Vendas Recentes</h3>
            <p class="text-sm text-gray-600">Você fez 265 vendas este mês</p>
          </div>
        </template>
        <template #content>
          <div class="p-6 pt-0">
            <DataTable :value="recentSales" class="p-datatable-sm" :paginator="false">
              <Column field="name" header="Cliente">
                <template #body="slotProps">
                  <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-blue-500 rounded-full flex items-center justify-center text-white text-xs font-medium">
                      {{ slotProps.data.avatar }}
                    </div>
                    <div>
                      <div class="font-medium text-gray-900">{{ slotProps.data.name }}</div>
                      <div class="text-sm text-gray-500">{{ slotProps.data.email }}</div>
                    </div>
                  </div>
                </template>
              </Column>
              
              <Column field="amount" header="Valor" class="text-right">
                <template #body="slotProps">
                  <span class="font-semibold text-green-600">{{ slotProps.data.amount }}</span>
                </template>
              </Column>
            </DataTable>
          </div>
        </template>
      </Card>
    </div>

    <!-- Additional Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
      <!-- Quick Actions -->
      <Card>
        <template #header>
          <div class="p-6 pb-0">
            <h3 class="text-lg font-semibold text-gray-900">Ações Rápidas</h3>
          </div>
        </template>
        <template #content>
          <div class="p-6 pt-0">
            <div class="space-y-3">
              <Button label="Novo Cliente" icon="pi pi-user-plus" class="w-full justify-start" severity="secondary" />
              <Button label="Nova Venda" icon="pi pi-plus" class="w-full justify-start" severity="secondary" />
              <Button label="Relatório" icon="pi pi-chart-bar" class="w-full justify-start" severity="secondary" />
            </div>
          </div>
        </template>
      </Card>

      <!-- Recent Activity -->
      <Card>
        <template #header>
          <div class="p-6 pb-0">
            <h3 class="text-lg font-semibold text-gray-900">Atividade Recente</h3>
          </div>
        </template>
        <template #content>
          <div class="p-6 pt-0">
            <div class="space-y-4">
              <div class="flex items-center space-x-3">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <div class="flex-1">
                  <p class="text-sm text-gray-900">Nova venda realizada</p>
                  <p class="text-xs text-gray-500">Há 2 minutos</p>
                </div>
              </div>
              <div class="flex items-center space-x-3">
                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                <div class="flex-1">
                  <p class="text-sm text-gray-900">Cliente adicionado</p>
                  <p class="text-xs text-gray-500">Há 15 minutos</p>
                </div>
              </div>
              <div class="flex items-center space-x-3">
                <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                <div class="flex-1">
                  <p class="text-sm text-gray-900">Relatório gerado</p>
                  <p class="text-xs text-gray-500">Há 1 hora</p>
                </div>
              </div>
            </div>
          </div>
        </template>
      </Card>

      <!-- System Status -->
      <Card>
        <template #header>
          <div class="p-6 pb-0">
            <h3 class="text-lg font-semibold text-gray-900">Status do Sistema</h3>
          </div>
        </template>
        <template #content>
          <div class="p-6 pt-0">
            <div class="space-y-4">
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Servidor</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                  Online
                </span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Banco de Dados</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                  Conectado
                </span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">API</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                  Funcionando
                </span>
              </div>
            </div>
          </div>
        </template>
      </Card>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import SpaceCard from '@/Components/SpaceCard.vue'

// Dados mockados para o dashboard
const stats = [
  {
    title: 'Total Revenue',
    value: '$45,231.89',
    change: '+20.1% from last month',
    icon: '🚀',
    variant: 'primary'
  },
  {
    title: 'Subscriptions',
    value: '+2,350',
    change: '+180.1% from last month',
    icon: '👥',
    variant: 'success'
  },
  {
    title: 'Sales',
    value: '+12,234',
    change: '+19% from last month',
    icon: '📊',
    variant: 'info'
  },
  {
    title: 'Active Now',
    value: '+573',
    change: '+201 since last hour',
    icon: '⭐',
    variant: 'warning'
  }
]

const recentSales = [
  {
    name: 'Olivia Martin',
    email: 'olivia.martin@email.com',
    amount: '+$1,999.00',
    avatar: 'OM'
  },
  {
    name: 'Jackson Lee',
    email: 'jackson.lee@email.com',
    amount: '+$39.00',
    avatar: 'JL'
  },
  {
    name: 'Isabella Nguyen',
    email: 'isabella.nguyen@email.com',
    amount: '+$299.00',
    avatar: 'IN'
  },
  {
    name: 'William Kim',
    email: 'will@email.com',
    amount: '+$99.00',
    avatar: 'WK'
  },
  {
    name: 'Sofia Davis',
    email: 'sofia.davis@email.com',
    amount: '+$39.00',
    avatar: 'SD'
  }
]

const chartData = [
  { month: 'Jan', value: 2000 },
  { month: 'Jun', value: 4500 },
  { month: 'Nov', value: 3000 }
]
</script>