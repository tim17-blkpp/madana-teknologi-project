import axios from "@axios"
import { defineStore } from "pinia"

// This is a store for managing faq data API calls
export const useFaqStore = defineStore('FaqStore', {
  actions: {
    fetchFaqs(params) {
      return axios.get('/api/faqs', { params })
    },
    fetchFaq(id) {
      return axios.get(`/api/faqs/${id}`)
    },
    createFaq(data) {
      return axios.post('/api/faqs', data)
    },
    updateFaq(id, data) {
      return axios.put(`/api/faqs/${id}`, data)
    },
    deleteFaq(id) {
      return axios.delete(`/api/faqs/${id}`)
    },
  },
})
