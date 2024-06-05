import axios from "@axios"
import { defineStore } from "pinia"

// This is a store for managing Role data API calls
export const useRoleStore = defineStore('RoleStore', {
  actions: {
    fetchRoles(params) {
      return axios.get('/api/roles', { params })
    },
    fetchRole(id) {
      return axios.get(`/api/roles/${id}`)
    },
    createRole(data) {
      return axios.post('/api/roles', data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
    },
    updateRole(id, data) {
      return axios.post(`/api/roles/${id}`, data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
        body: {
          ...data,
          _method: 'PUT',
        },
      })
    },
    deleteRole(id) {
      return axios.delete(`/api/roles/${id}`)
    },
  },
})
