<template>
  <Head title="Colaboradores" />
  
  <AppLayout title="Colaboradores" subtitle="Gestão de colaboradores da empresa">
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

    <!-- Tabela de Colaboradores usando SpaceDataTable -->
    <SpaceDataTable
      :data="colaboradores"
      :columns="tableColumns"
      :global-actions="globalActions"
      :primary-action="primaryAction"
      title="Lista de Colaboradores"
      subtitle="Gerencie todos os colaboradores da empresa"
      :global-filter-fields="['name', 'email', 'cargo', 'departamento']"
      :loading="loading"
    />
  </AppLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import SpaceCard from '@/Components/SpaceCard.vue'
import SpaceDataTable from '@/Components/SpaceDataTable.vue'

// Props recebidas do controller
const props = defineProps({
  colaboradores: {
    type: Array,
    required: true
  }
})

// Estado
const loading = ref(false)

// Stats para os cards
const stats = computed(() => [
  {
    title: 'Total Colaboradores',
    value: props.colaboradores.length.toString(),
    change: '+2 desde o mês passado',
    icon: '👥',
    variant: 'primary'
  },
  {
    title: 'Colaboradores Ativos',
    value: colaboradoresAtivos.value.toString(),
    change: 'Colaboradores ativos',
    icon: '✅',
    variant: 'success'
  },
  {
    title: 'Departamentos',
    value: departamentosUnicos.value.toString(),
    change: 'Departamentos únicos',
    icon: '🏢',
    variant: 'info'
  },
  {
    title: 'Salário Médio',
    value: 'R$ 7.800,00',
    change: 'Remuneração média',
    icon: '💰',
    variant: 'warning'
  }
])

// Computed properties
const colaboradoresAtivos = computed(() => 
  props.colaboradores.filter(c => c.status === 'Ativo').length
)

const departamentosUnicos = computed(() => 
  [...new Set(props.colaboradores.map(c => c.departamento))].length
)

// Configuração das colunas da tabela
const tableColumns = [
  {
    field: 'avatar',
    header: 'Avatar',
    sortable: false,
    style: 'width: 80px',
    template: {
      name: 'AvatarTemplate',
      props: ['data', 'value']
    }
  },
  {
    field: 'name',
    header: 'Nome',
    sortable: true,
    template: {
      name: 'NameTemplate',
      props: ['data', 'value']
    }
  },
  {
    field: 'cargo',
    header: 'Cargo',
    sortable: true
  },
  {
    field: 'departamento',
    header: 'Departamento',
    sortable: true
  },
  {
    field: 'status',
    header: 'Status',
    sortable: true,
    type: 'status'
  },
  {
    field: 'dataAdmissao',
    header: 'Data Admissão',
    sortable: true,
    type: 'date'
  },
  {
    field: 'salario',
    header: 'Salário',
    sortable: true,
    type: 'currency'
  }
]

// Ações globais (coluna de ações)
const globalActions = [
  {
    key: 'edit',
    icon: 'pi pi-pencil',
    label: 'Editar',
    severity: 'secondary',
    handler: (data) => handleEdit(data)
  },
  {
    key: 'delete',
    icon: 'pi pi-trash',
    label: 'Excluir',
    severity: 'danger',
    handler: (data) => handleDelete(data)
  }
]

// Ação principal (botão no header)
const primaryAction = {
  label: 'Novo Colaborador',
  icon: 'pi pi-plus',
  handler: () => handleCreate()
}

// Handlers
const handleEdit = (colaborador) => {
  console.log('Edit:', colaborador)
  // Implementar edição
}

const handleDelete = (colaborador) => {
  console.log('Delete:', colaborador)
  // Implementar exclusão
}

const handleCreate = () => {
  console.log('Create new colaborador')
  // Implementar criação
}
</script>