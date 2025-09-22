<template>
  <div class="space-datatable-container">
    <!-- Header da Tabela -->
    <div class="space-datatable-header">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h3 class="text-xl font-bold text-white mb-2">{{ title }}</h3>
          <p v-if="subtitle" class="text-sm text-gray-400">{{ subtitle }}</p>
        </div>
        
        <!-- Ações da Tabela -->
        <div class="flex items-center space-x-3">
          <!-- Busca -->
          <div class="relative">
            <InputText 
              v-model="globalFilter"
              placeholder="Pesquisar..." 
              class="w-64 pl-10 space-input"
            />
            <Search :size="16" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
          </div>
          
          <!-- Botão de Ação Principal -->
          <Button 
            v-if="primaryAction"
            :label="primaryAction.label"
            @click="primaryAction.handler"
            class="space-button"
          >
            <template #icon>
              <Plus :size="16" />
            </template>
          </Button>
        </div>
      </div>
    </div>

    <!-- Tabela -->
    <div class="space-card">
      <DataTable 
        :value="data" 
        :paginator="paginator"
        :rows="rows"
        :rowsPerPageOptions="[10, 25, 50]"
        :globalFilterFields="globalFilterFields"
        :loading="loading"
        :sortField="sortField"
        :sortOrder="sortOrder"
        :showGridlines="false"
        responsiveLayout="scroll"
        class="space-datatable no-pagination-border"
        :class="{ 'space-datatable--loading': loading }"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} registros"
      >
        <!-- Colunas Dinâmicas -->
        <Column 
          v-for="column in columns" 
          :key="column.field"
          :field="column.field"
          :header="column.header"
          :sortable="column.sortable !== false"
          :style="column.style"
          :class="column.class"
        >
          <template #body="slotProps" v-if="column.template">
            <component 
              :is="column.template" 
              :data="slotProps.data" 
              :field="column.field"
              :value="slotProps.data[column.field]"
            />
          </template>
          
          <!-- Template para Status -->
          <template #body="slotProps" v-else-if="column.type === 'status'">
            <Tag 
              :value="slotProps.data[column.field]"
              :severity="getStatusSeverity(slotProps.data[column.field])"
              class="space-tag"
            />
          </template>
          
          <!-- Template para Data -->
          <template #body="slotProps" v-else-if="column.type === 'date'">
            <span class="text-gray-300">
              {{ formatDate(slotProps.data[column.field]) }}
            </span>
          </template>
          
          <!-- Template para Moeda -->
          <template #body="slotProps" v-else-if="column.type === 'currency'">
            <span class="font-medium text-space-success">
              {{ formatCurrency(slotProps.data[column.field]) }}
            </span>
          </template>
          
          <!-- Template para Ações -->
          <template #body="slotProps" v-else-if="column.type === 'actions'">
            <div class="flex items-center space-x-2">
              <Button 
                v-for="action in column.actions"
                :key="action.key"
                :severity="action.severity || 'secondary'"
                size="small"
                text
                rounded
                @click="action.handler(slotProps.data)"
                class="space-action-button"
                :title="action.label"
              >
                <template #icon>
                  <Edit v-if="action.key === 'edit'" :size="14" />
                  <Trash2 v-else-if="action.key === 'delete'" :size="14" />
                </template>
              </Button>
            </div>
          </template>
        </Column>
        
        <!-- Coluna de Ações Globais (se definida) -->
        <Column 
          v-if="globalActions"
          header="Ações" 
          :exportable="false"
          style="min-width: 8rem"
          class="text-left"
        >
          <template #body="slotProps">
            <div class="flex items-center justify-start space-x-2">
              <Button 
                v-for="action in globalActions"
                :key="action.key"
                :severity="action.severity || 'secondary'"
                size="small"
                text
                rounded
                @click="action.handler(slotProps.data)"
                class="space-action-button"
                :title="action.label"
              >
                <template #icon>
                  <Edit v-if="action.key === 'edit'" :size="14" />
                  <Trash2 v-else-if="action.key === 'delete'" :size="14" />
                </template>
              </Button>
            </div>
          </template>
        </Column>
      </DataTable>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import Tag from 'primevue/tag'
import { Edit, Trash2, Plus, Search } from 'lucide-vue-next'

const props = defineProps({
  // Dados da tabela
  data: {
    type: Array,
    default: () => []
  },
  
  // Configuração das colunas
  columns: {
    type: Array,
    required: true
  },
  
  // Configurações da tabela
  title: {
    type: String,
    default: 'Tabela de Dados'
  },
  
  subtitle: {
    type: String,
    default: ''
  },
  
  // Paginação
  paginator: {
    type: Boolean,
    default: true
  },
  
  rows: {
    type: Number,
    default: 10
  },
  
  // Busca global
  globalFilterFields: {
    type: Array,
    default: () => []
  },
  
  // Loading
  loading: {
    type: Boolean,
    default: false
  },
  
  // Ordenação
  sortField: {
    type: String,
    default: ''
  },
  
  sortOrder: {
    type: Number,
    default: 1
  },
  
  // Ação principal (botão no header)
  primaryAction: {
    type: Object,
    default: null
  },
  
  // Ações globais (coluna de ações)
  globalActions: {
    type: Array,
    default: null
  }
})

// Estado da busca global
const globalFilter = ref('')

// Funções utilitárias
const getStatusSeverity = (status) => {
  const statusMap = {
    'ativo': 'success',
    'inativo': 'danger',
    'pendente': 'warning',
    'processando': 'info',
    'concluído': 'success',
    'cancelado': 'danger'
  }
  return statusMap[status?.toLowerCase()] || 'secondary'
}

const formatDate = (date) => {
  if (!date) return '-'
  return new Date(date).toLocaleDateString('pt-BR')
}

const formatCurrency = (value) => {
  if (!value) return 'R$ 0,00'
  return new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL'
  }).format(value)
}
</script>
