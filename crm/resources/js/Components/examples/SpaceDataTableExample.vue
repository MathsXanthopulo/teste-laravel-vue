<template>
  <div class="p-6">
    <h2 class="text-2xl font-bold text-white mb-6">Exemplo de Uso - SpaceDataTable</h2>
    
    <!-- Exemplo 1: Tabela Simples -->
    <div class="mb-8">
      <h3 class="text-lg font-semibold text-white mb-4">Exemplo 1: Tabela Simples</h3>
      <SpaceDataTable
        :data="simpleData"
        :columns="simpleColumns"
        title="Produtos"
        subtitle="Lista de produtos em estoque"
        :global-filter-fields="['name', 'category', 'status']"
      />
    </div>

    <!-- Exemplo 2: Tabela com Ações -->
    <div class="mb-8">
      <h3 class="text-lg font-semibold text-white mb-4">Exemplo 2: Tabela com Ações</h3>
      <SpaceDataTable
        :data="usersData"
        :columns="usersColumns"
        :global-actions="usersActions"
        :primary-action="usersPrimaryAction"
        title="Usuários"
        subtitle="Gerenciar usuários do sistema"
        :global-filter-fields="['name', 'email', 'role']"
      />
    </div>

    <!-- Exemplo 3: Tabela com Diferentes Tipos de Coluna -->
    <div class="mb-8">
      <h3 class="text-lg font-semibold text-white mb-4">Exemplo 3: Tabela com Tipos Especiais</h3>
      <SpaceDataTable
        :data="ordersData"
        :columns="ordersColumns"
        :global-actions="ordersActions"
        title="Pedidos"
        subtitle="Histórico de pedidos"
        :global-filter-fields="['id', 'customer', 'status']"
      />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import SpaceDataTable from '@/Components/SpaceDataTable.vue'

// Dados de exemplo
const simpleData = ref([
  { id: 1, name: 'Produto A', category: 'Eletrônicos', price: 299.99, status: 'ativo' },
  { id: 2, name: 'Produto B', category: 'Roupas', price: 89.99, status: 'inativo' },
  { id: 3, name: 'Produto C', category: 'Casa', price: 199.99, status: 'ativo' },
  { id: 4, name: 'Produto D', category: 'Eletrônicos', price: 599.99, status: 'pendente' }
])

const usersData = ref([
  { id: 1, name: 'João Silva', email: 'joao@email.com', role: 'admin', status: 'ativo', lastLogin: '2024-01-15' },
  { id: 2, name: 'Maria Santos', email: 'maria@email.com', role: 'user', status: 'ativo', lastLogin: '2024-01-14' },
  { id: 3, name: 'Pedro Costa', email: 'pedro@email.com', role: 'moderator', status: 'inativo', lastLogin: '2024-01-10' }
])

const ordersData = ref([
  { id: 'ORD-001', customer: 'Cliente A', amount: 1500.00, status: 'concluído', date: '2024-01-15', items: 3 },
  { id: 'ORD-002', customer: 'Cliente B', amount: 750.50, status: 'processando', date: '2024-01-14', items: 2 },
  { id: 'ORD-003', customer: 'Cliente C', amount: 2200.00, status: 'pendente', date: '2024-01-13', items: 5 }
])

// Configuração das colunas - Exemplo 1
const simpleColumns = [
  { field: 'id', header: 'ID', sortable: true },
  { field: 'name', header: 'Nome', sortable: true },
  { field: 'category', header: 'Categoria', sortable: true },
  { field: 'price', header: 'Preço', sortable: true, type: 'currency' },
  { field: 'status', header: 'Status', sortable: true, type: 'status' }
]

// Configuração das colunas - Exemplo 2
const usersColumns = [
  { field: 'id', header: 'ID', sortable: true },
  { field: 'name', header: 'Nome', sortable: true },
  { field: 'email', header: 'Email', sortable: true },
  { field: 'role', header: 'Função', sortable: true },
  { field: 'status', header: 'Status', sortable: true, type: 'status' },
  { field: 'lastLogin', header: 'Último Login', sortable: true, type: 'date' }
]

// Configuração das colunas - Exemplo 3
const ordersColumns = [
  { field: 'id', header: 'Pedido', sortable: true },
  { field: 'customer', header: 'Cliente', sortable: true },
  { field: 'amount', header: 'Valor', sortable: true, type: 'currency' },
  { field: 'status', header: 'Status', sortable: true, type: 'status' },
  { field: 'date', header: 'Data', sortable: true, type: 'date' },
  { field: 'items', header: 'Itens', sortable: true }
]

// Ações para usuários
const usersActions = [
  {
    key: 'edit',
    icon: 'pi pi-pencil',
    label: 'Editar',
    severity: 'secondary',
    handler: (data) => console.log('Edit user:', data)
  },
  {
    key: 'delete',
    icon: 'pi pi-trash',
    label: 'Excluir',
    severity: 'danger',
    handler: (data) => console.log('Delete user:', data)
  }
]

const usersPrimaryAction = {
  label: 'Novo Usuário',
  icon: 'pi pi-plus',
  handler: () => console.log('Create new user')
}

// Ações para pedidos
const ordersActions = [
  {
    key: 'view',
    icon: 'pi pi-eye',
    label: 'Visualizar',
    severity: 'info',
    handler: (data) => console.log('View order:', data)
  },
  {
    key: 'edit',
    icon: 'pi pi-pencil',
    label: 'Editar',
    severity: 'secondary',
    handler: (data) => console.log('Edit order:', data)
  }
]
</script>
