import axios from "@axios"
import { defineStore } from "pinia"

// This is a store for managing Category data API calls
export const useCategoryStore = defineStore('CategoryStore', {
  actions: {
    fetchCategories(params) {
      return axios.get('/api/projects/categories', { params })
    },
    fetchCategory(id) {
      return axios.get(`/api/projects/categories/${id}`)
    },
    createCategory(data) {
      return axios.post('/api/projects/categories', data)
    },
    updateCategory(id, data) {
      return axios.put(`/api/projects/categories/${id}`, data)
    },
    deleteCategory(id) {
      return axios.delete(`/api/projects/categories/${id}`)
    },
  },
})
