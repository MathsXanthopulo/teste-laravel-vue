// Tipos globais da aplicação

export interface User {
  id: number
  name: string
  email: string
  email_verified_at?: string
  company_id?: number
  created_at: string
  updated_at: string
  company?: Company
}

export interface Company {
  id: number
  name: string
  cnpj: string
  email: string
  phone: string
  created_at: string
  updated_at: string
}

export interface Employee {
  id: number
  name: string
  email: string
  phone: string
  company_id: number
  created_at: string
  updated_at: string
  company?: Company
}

export interface DashboardStats {
  monthCreated: number
  monthDeleted: number
  total: number
}

export interface PaginatedResponse<T> {
  data: T[]
  current_page: number
  last_page: number
  per_page: number
  total: number
  from: number
  to: number
}

export interface ApiError {
  message: string
  errors?: Record<string, string[]>
}
