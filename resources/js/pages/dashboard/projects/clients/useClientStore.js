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
      return axios.post('/api/projects/clients', data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
    },
    updateClient(id, data) {
      return axios.post(`/api/projects/clients/${id}`, data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
        body: {
          ...data,
          _method: 'PUT',
        },
      })
    },
    deleteClient(id) {
      return axios.delete(`/api/projects/clients/${id}`)
    },
  },
})
