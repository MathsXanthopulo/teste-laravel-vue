import axios from 'axios'

const api = axios.create({
  headers: { 'X-Requested-With': 'XMLHttpRequest' },
  withCredentials: true,
})

api.interceptors.response.use(
  (r) => r,
  (e) => {
    // logging básico (ajuste se quiser)
    console.error('[API ERROR]', e?.response?.status, e?.response?.data)
    return Promise.reject(e)
  }
)

export default api
