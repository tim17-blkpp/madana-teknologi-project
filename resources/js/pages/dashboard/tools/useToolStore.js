import axios from "@axios"
import { defineStore } from "pinia"

// This is a store for managing Tool data API calls
export const useToolStore = defineStore('ToolStore', {
  actions: {
    fetchTools(params) {
      return axios.get('/api/tools', { params })
    },
    fetchTool(id) {
      return axios.get(`/api/tools/${id}`)
    },
    createTool(data) {
      return axios.post('/api/tools', data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
    },
    updateTool(id, data) {
      return axios.post(`/api/tools/${id}`, data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
        body: {
          ...data,
          _method: 'PUT',
        },
      })
    },
    deleteTool(id) {
      return axios.delete(`/api/tools/${id}`)
    },
  },
})
