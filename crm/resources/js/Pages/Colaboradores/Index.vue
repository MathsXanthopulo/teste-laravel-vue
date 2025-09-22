<template>
  <Head title="Colaboradores" />
  
  <AppLayout title="Colaboradores" subtitle="Gestão de colaboradores da empresa">
    <!-- Stats Cards -->
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

    <!-- Modal de Edição/Criação -->
    <SquareModal
      :show="showEditModal"
      :title="selectedColaborador ? 'Editar Colaborador' : 'Novo Colaborador'"
      size="lg"
      @close="closeEditModal"
    >
      <form @submit.prevent="saveColaborador" class="space-y-4">
        <!-- Nome -->
        <div>
          <label class="block text-sm font-medium text-gray-300 mb-2">
            Nome Completo *
          </label>
          <input
            v-model="form.name"
            type="text"
            class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Digite o nome completo"
            required
          />
          <div v-if="form.errors.name" class="mt-1 text-sm text-red-400">
            {{ form.errors.name }}
          </div>
        </div>

        <!-- Email e Telefone -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">
              E-mail
            </label>
            <input
              v-model="form.email"
              type="email"
              class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="email@exemplo.com"
            />
            <div v-if="form.errors.email" class="mt-1 text-sm text-red-400">
              {{ form.errors.email }}
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">
              Telefone
            </label>
            <input
              v-model="form.phone"
              type="text"
              class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="(11) 99999-9999"
              @input="handlePhoneInput"
            />
            <div v-if="form.errors.phone" class="mt-1 text-sm text-red-400">
              {{ form.errors.phone }}
            </div>
          </div>
        </div>

        <!-- Cargo e Departamento -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">
              Cargo
            </label>
            <input
              v-model="form.cargo"
              type="text"
              class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Ex: Desenvolvedor, Analista, etc."
            />
            <div v-if="form.errors.cargo" class="mt-1 text-sm text-red-400">
              {{ form.errors.cargo }}
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">
              Departamento
            </label>
            <input
              v-model="form.departamento"
              type="text"
              class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Ex: TI, Marketing, RH, etc."
            />
            <div v-if="form.errors.departamento" class="mt-1 text-sm text-red-400">
              {{ form.errors.departamento }}
            </div>
          </div>
        </div>

        <!-- Salário e Data Admissão -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">
              Salário (R$)
            </label>
            <input
              v-model="form.salario"
              type="text"
              class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="R$ 5.000,00"
              @input="handleCurrencyInput"
            />
            <div v-if="form.errors.salario" class="mt-1 text-sm text-red-400">
              {{ form.errors.salario }}
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">
              Data de Admissão
            </label>
            <input
              v-model="form.data_admissao"
              type="date"
              class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <div v-if="form.errors.data_admissao" class="mt-1 text-sm text-red-400">
              {{ form.errors.data_admissao }}
            </div>
          </div>
        </div>

        <!-- Status -->
        <div>
          <label class="block text-sm font-medium text-gray-300 mb-2">
            Status
          </label>
          <select
            v-model="form.status"
            class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option value="ativo">Ativo</option>
            <option value="inativo">Inativo</option>
          </select>
          <div v-if="form.errors.status" class="mt-1 text-sm text-red-400">
            {{ form.errors.status }}
          </div>
        </div>
      </form>
      
      <template #footer>
        <button
          @click="closeEditModal"
          type="button"
          class="px-4 py-2 text-sm text-gray-400 hover:text-white transition-colors"
        >
          Cancelar
        </button>
        <button
          @click="saveColaborador"
          :disabled="form.processing"
          type="submit"
          class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50"
        >
          {{ form.processing ? 'Salvando...' : (selectedColaborador ? 'Salvar Alterações' : 'Criar Colaborador') }}
        </button>
      </template>
    </SquareModal>

    <!-- Modal de Confirmação de Exclusão -->
    <SquareModal
      :show="showDeleteModal"
      title="Confirmar Exclusão"
      size="md"
      @close="closeDeleteModal"
    >
      <div class="space-y-4">
        <p class="text-gray-300">
          Tem certeza que deseja excluir o colaborador?
        </p>
        <div v-if="selectedColaborador" class="bg-red-900/20 border border-red-500/30 p-4 rounded-lg">
          <p class="text-red-300 font-medium">{{ selectedColaborador.name }}</p>
          <p class="text-red-400 text-sm">{{ selectedColaborador.cargo }} - {{ selectedColaborador.departamento }}</p>
        </div>
        <p class="text-sm text-red-400">
          ⚠️ Esta ação não pode ser desfeita.
        </p>
      </div>
      
      <template #footer>
        <button
          @click="closeDeleteModal"
          class="px-4 py-2 text-sm text-gray-400 hover:text-white transition-colors"
        >
          Cancelar
        </button>
        <button
          @click="confirmDelete"
          class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition-colors"
        >
          Excluir
        </button>
      </template>
    </SquareModal>
  </AppLayout>
</template>

<script setup>
import { Head, useForm, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import SpaceCard from '@/Components/SpaceCard.vue'
import SpaceDataTable from '@/Components/SpaceDataTable.vue'
import SquareModal from '@/Components/SquareModal.vue'

// Props recebidas do controller
const props = defineProps({
  colaboradores: {
    type: Array,
    required: true
  }
})

// Estado
const loading = ref(false)
const showEditModal = ref(false)
const showDeleteModal = ref(false)
const selectedColaborador = ref(null)

// Formulário
const form = useForm({
  name: '',
  email: '',
  phone: '',
  cargo: '',
  departamento: '',
  salario: '',
  data_admissao: '',
  status: 'ativo'
})

// Funções de máscara
const formatPhone = (value) => {
  const numbers = value.replace(/\D/g, '');
  if (numbers.length <= 11) {
    return numbers.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
  }
  return value;
}

const formatCurrency = (value) => {
  const numbers = value.replace(/\D/g, '');
  if (numbers.length > 0) {
    const numericValue = parseFloat(numbers) / 100;
    return 'R$ ' + numericValue.toLocaleString('pt-BR', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  }
  return '';
}

const handlePhoneInput = (event) => {
  const value = event.target.value;
  const formatted = formatPhone(value);
  form.phone = formatted;
  event.target.value = formatted;
}

const handleCurrencyInput = (event) => {
  const value = event.target.value;
  const formatted = formatCurrency(value);
  // Salvar o valor numérico no form (sem formatação)
  const numbers = value.replace(/\D/g, '');
  if (numbers.length > 0) {
    form.salario = (parseFloat(numbers) / 100).toString();
  } else {
    form.salario = '';
  }
  event.target.value = formatted;
}

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
    field: 'name',
    header: 'Nome',
    sortable: true
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
    sortable: true
  },
  {
    field: 'salarioFormatado',
    header: 'Salário',
    sortable: true
  }
]

// Ações globais (coluna de ações)
const globalActions = [
  {
    key: 'edit',
    label: 'Editar',
    severity: 'secondary',
    handler: (data) => handleEdit(data)
  },
  {
    key: 'delete',
    label: 'Excluir',
    severity: 'danger',
    handler: (data) => handleDelete(data)
  }
]

// Ação principal (botão no header)
const primaryAction = {
  label: 'Novo Colaborador',
  handler: () => handleCreate()
}

// Handlers
const handleEdit = (colaborador) => {
  selectedColaborador.value = colaborador
  // Preencher formulário com dados existentes
  form.name = colaborador.name
  form.email = colaborador.email || ''
  form.phone = colaborador.phone || ''
  form.cargo = colaborador.cargo || ''
  form.departamento = colaborador.departamento || ''
  form.salario = colaborador.salario || ''
  form.data_admissao = colaborador.dataAdmissao || ''
  form.status = colaborador.status.toLowerCase()
  showEditModal.value = true
}

const handleDelete = (colaborador) => {
  selectedColaborador.value = colaborador
  showDeleteModal.value = true
}

const handleCreate = () => {
  selectedColaborador.value = null
  // Limpar formulário
  form.reset()
  form.status = 'ativo'
  showEditModal.value = true
}

const closeEditModal = () => {
  showEditModal.value = false
  selectedColaborador.value = null
  form.reset()
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
  selectedColaborador.value = null
}

const confirmDelete = () => {
  if (selectedColaborador.value) {
    router.delete(route('colaboradores.destroy', selectedColaborador.value.id), {
      onSuccess: () => {
        closeDeleteModal()
        // O Inertia fará o redirect automático
      },
      onError: (errors) => {
        console.error('Erro ao excluir:', errors)
      }
    })
  }
}

const saveColaborador = () => {
  if (selectedColaborador.value) {
    // Atualizar colaborador existente
    router.put(route('colaboradores.update', selectedColaborador.value.id), form.data(), {
      onSuccess: () => {
        closeEditModal()
        // O Inertia fará o redirect automático
      },
      onError: (errors) => {
        console.error('Erro ao atualizar:', errors)
      }
    })
  } else {
    // Criar novo colaborador
    router.post(route('colaboradores.store'), form.data(), {
      onSuccess: () => {
        closeEditModal()
        // O Inertia fará o redirect automático
      },
      onError: (errors) => {
        console.error('Erro ao criar:', errors)
      }
    })
  }
}
</script>