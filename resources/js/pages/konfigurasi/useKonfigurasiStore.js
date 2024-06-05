import axios from "@axios"
import { defineStore } from "pinia"

export const useKonfigurasiStore = defineStore('KonfigurasiStore', {
  actions: {
    fetchKonfigurasi(params) {
      return axios.get('/api/konfigurasi', { params })
    },
    updateKonfigurasi(data) {
      return axios.post(`/api/konfigurasi/`, data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
        body: {
          ...data,
          _method: 'PUT',
        },
      })
    },
  },
})
