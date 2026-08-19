import { defineStore } from 'pinia'
import { fetchConnections } from '../api/mock-interceptor'

/**
 * Services the merchant granted a data sharing consent to. Read-only: managing
 * the sharing happens on each module's own configuration page.
 *
 * The list arrives already sorted from the server (active services first,
 * revoked ones last), so the store does not reorder it.
 */
export const useConnectionsStore = defineStore('connections', {
  state: () => ({
    services: [],
    loading: false,
    error: null,
  }),

  actions: {
    async loadConnections() {
      this.loading = true
      this.error = null

      try {
        this.services = await fetchConnections()
      } catch (error) {
        this.error = error.message
      } finally {
        this.loading = false
      }
    },
  },
})
