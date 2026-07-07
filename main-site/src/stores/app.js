import { defineStore } from 'pinia'
import api from '../api'

export const useAppStore = defineStore('app', {
  state: () => ({
    stats: {
      total_accounts: 0,
      available_accounts: 0,
      total_games: 0,
      total_visitors: 0,
      today_visitors: 0,
      most_expensive_account: null,
    },
    loading: false,
  }),
  actions: {
    async fetchStats() {
      try {
        const { data } = await api.get('/stats')
        this.stats = data
      } catch {
        // silent fail
      }
    },
    async trackVisit() {
      try {
        await api.post('/visitor', { page: window.location.pathname })
      } catch {
        // silent fail
      }
    },
  },
})
