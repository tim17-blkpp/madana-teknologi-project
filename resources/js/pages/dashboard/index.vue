<template>
  <div>
    <VCard class="mb-6" title="Statistik Proyek">
    </VCard>
    <VCard class="mb-6">
      <div class="row p-5">
        <div class="col d-flex justify-content-center bg-primary m-3">
          <div>
            <p>Project</p>
            <p>{{ projects.length }}</p>
          </div>
        </div>
        <div class="col d-flex justify-content-center bg-success m-3">
          <div>
            <p>Klien</p>
            <p>{{ clients.length }}</p>
          </div>
        </div>
      </div>
    </VCard>
  </div>
</template>

<script>
import axios from '@axios';
import { Line } from 'vue-chartjs';

export default {
  data() {
    return {
      projects: [],
      clients: [],
    };
  },
  created() {
    this.fetchProjects();
    this.fetchClients();
  },
  methods: {
    async fetchProjects() {
      try {
        const response = await axios.get('/api/projects');
        this.projects = response.data.data;
        this.updateChartData(); // Setelah data proyek diterima, perbarui chartData
      } catch (error) {
        console.error('Error fetching projects:', error);
      }
    },
    async fetchClients() {
      try {
        const response = await axios.get('/api/projects/clients');
        this.clients = response.data.data;
      } catch (error) {
        console.error('Error fetching clients:', error);
      }
    }
  }
};
</script>

