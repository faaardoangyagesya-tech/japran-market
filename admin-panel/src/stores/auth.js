import { defineStore } from 'pinia'
import api from '../api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('admin_token') || null,
    admin: JSON.parse(localStorage.getItem('admin_data') || 'null'),
  }),
  getters: {
    isAuthenticated: (state) => !!state.token,
  },
  actions: {
    async login(email, password) {
      const { data } = await api.post('/admin/login', { email, password })
      this.token = data.token
      this.admin = data.admin
      localStorage.setItem('admin_token', data.token)
      localStorage.setItem('admin_data', JSON.stringify(data.admin))
    },
    async logout() {
      try {
        await api.post('/admin/logout')
      } catch {
        // silent
      }
      this.token = null
      this.admin = null
      localStorage.removeItem('admin_token')
      localStorage.removeItem('admin_data')
    },
  },
})
