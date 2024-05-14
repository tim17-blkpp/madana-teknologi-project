import axios from "@axios"
import { defineStore } from "pinia"

// This is a store for managing Client data API calls
export const useClientStore = defineStore('ClientStore', {
  actions: {
    fetchClients(params) {
      return axios.get('/api/projects/clients', { params })
    },
    fetchClient(id) {
      return axios.get(`/api/projects/clients/${id}`)
    },
    createClient(data) {
      return axios.post('/api/projects/clients', data)
    },
    updateClient(id, data) {
      return axios.put(`/api/projects/clients/${id}`, data)
    },
    deleteClient(id) {
      return axios.delete(`/api/projects/clients/${id}`)
    },
  },
})
