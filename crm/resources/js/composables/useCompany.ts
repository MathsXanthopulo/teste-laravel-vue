import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

export interface Company {
  id: number
  name: string
  cnpj: string
  email: string
  phone: string
  created_at: string
  updated_at: string
}

export function useCompany() {
  const page = usePage()
  
  const company = computed(() => {
    return page.props.auth?.user?.company as Company | null
  })

  const isCompanyOwner = computed(() => {
    return !!company.value
  })

  const companyId = computed(() => {
    return company.value?.id
  })

  return {
    company,
    isCompanyOwner,
    companyId
  }
}
