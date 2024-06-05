import axios from "@axios"
import { defineStore } from "pinia"

// This is a store for managing Project data API calls
function logFormData(formData) {
  for (let pair of formData.entries()) {
    console.log(`${pair[0]}: ${pair[1]}`)
  }
}
export const useProjectStore = defineStore('ProjectStore', {
  actions: {
    fetchProjects(params) {
      return axios.get('/api/projects', { params })
    },
    fetchProject(id) {
      return axios.get(`/api/projects/${id}`)
    },
    createProject(data) {
      // return axios.post('/api/projects', data)
      const formData = new FormData()

      // Object.keys(data).forEach(key => {
      //   if (data[key] !== null) {
      //     formData.append(key, data[key])
      //   }
      // })

      // formData.append('thumbnail', data.thumbnail)
      // if (data.thumbnail instanceof File) {
      //   formData.append('thumbnail', data.thumbnail)
      // }
      
      for (const key in data) {
        if (key !== 'category' && key !== 'client')
          formData.append(key, data[key])
      }

      if (data.thumbnail instanceof File) {
        console.warn("pppppppppp")
        formData.append('thumbnail', data.thumbnail)
      } 
      
      // logFormData(data)
      
      
      return axios.post('/api/projects', data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
    },
    updateProject(id, data) {
      // return axios.put(`/api/projects/${id}`, data)
      const formData = new FormData()

      for (const key in data) {
        if (key !== 'category' && key !== 'client')
          formData.append(key, data[key])
      }

      if (data.thumbnail instanceof File) {
        console.warn("pppppppppp")
        formData.append('thumbnail', data.thumbnail)
      } 
      
      logFormData(formData)
      console.warn(data)
      
      return axios.post(`/api/projects/${id}`, data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
        body: {
          ...data,
          _method: 'PUT',
        },
      })
    },
    deleteProject(id) {
      return axios.delete(`/api/projects/${id}`)
    },
  },
})
