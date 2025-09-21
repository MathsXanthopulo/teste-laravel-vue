import { ref } from 'vue'
import api from '@/lib/axios'

export function useApi() {
  const loading = ref(false)
  const error = ref<string | null>(null)

  async function get<T>(url: string, params?: any) {
    loading.value = true; error.value = null
    try { const { data } = await api.get<T>(url, { params }); return data }
    catch (e: any) { error.value = e?.response?.data?.message || 'Falha na requisição'; throw e }
    finally { loading.value = false }
  }
  async function post<T>(url: string, body?: any) {
    loading.value = true; error.value = null
    try { const { data } = await api.post<T>(url, body); return data }
    catch (e: any) { error.value = e?.response?.data?.message || 'Falha na requisição'; throw e }
    finally { loading.value = false }
  }
  async function put<T>(url: string, body?: any) {
    loading.value = true; error.value = null
    try { const { data } = await api.put<T>(url, body); return data }
    catch (e: any) { error.value = e?.response?.data?.message || 'Falha na requisição'; throw e }
    finally { loading.value = false }
  }
  async function del<T>(url: string) {
    loading.value = true; error.value = null
    try { const { data } = await api.delete<T>(url); return data }
    catch (e: any) { error.value = e?.response?.data?.message || 'Falha na requisição'; throw e }
    finally { loading.value = false }
  }

  return { get, post, put, del, loading, error }
}
