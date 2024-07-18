<template>
  <div class="row justify-content-center">
    <VCard class="mb-6 col-12">
      <div class="row">
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
    <VCard class="mb-6 row w-100 col-12" title="Data Kategori Proyek">
      <div class="chart-container col-lg-12">
        <canvas id="line-chart"></canvas>
      </div>
    </VCard>
    <VCard class="mb-6 row col-12" title="Data Jumlah Klien">
      <div class="chart-container col-lg-12">
        <canvas id="bar-chart"></canvas>
      </div>
    </VCard>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { Chart, registerables } from 'chart.js';
import axios from '@axios';

Chart.register(...registerables);

export default {
  setup() {
    const projects = ref([]);
    const clients = ref([]);
    const categories = ref([]);

    const getLastSixMonths = () => {
      const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      const today = new Date();
      let result = [];
      for (let i = 5; i >= 0; i--) {
        const d = new Date(today.getFullYear(), today.getMonth() - i, 1);
        result.push(months[d.getMonth()]);
      }
      return result;
    };

    const chartData = {
      labels: getLastSixMonths(),
      datasets: [],
    };

    const chartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
        },
      },
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Project Categories Statistics',
        },
      },
    };

    const fetchProjects = async () => {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/projects');
        projects.value = response.data.data;
      } catch (error) {
        console.error('Error fetching projects:', error);
      }
    };

    const fetchClients = async () => {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/projects/clients');
        clients.value = response.data.data;
      } catch (error) {
        console.error('Error fetching clients:', error);
      }
    };

    const fetchCategories = async () => {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/projects/categories');
        categories.value = response.data.data;

        // Prepare datasets for chart based on categories fetched
        categories.value.forEach(category => {
          const categoryData = {
            label: category.name,
            backgroundColor: getRandomColor(),
            borderColor: getRandomColor(),
            data: getLastSixMonths().map(month => {
              return projects.value.filter(project => {
                const endDate = new Date(project.end_date);
                return project.category.name === category.name && endDate.toLocaleString('en-us', { month: 'long' }) === month;
              }).length;
            }),
            fill: false,
          };
          chartData.datasets.push(categoryData);
        });

        // Render chart after fetching data
        renderChart();
      } catch (error) {
        console.error('Error fetching categories:', error);
      }
    };

    const fetchUniqueClientsByMonth = (month) => {
      const uniqueClients = [];
      projects.value.forEach(project => {
        const endDate = new Date(project.end_date);
        if (endDate.toLocaleString('en-us', { month: 'long' }) === month) {
          const clientName = project.client.name;
          if (!uniqueClients.includes(clientName)) {
            uniqueClients.push(clientName);
          }
        }
      });
      return uniqueClients.length;
    };

    const renderChart = () => {
      const lineCtx = document.getElementById('line-chart').getContext('2d');
      new Chart(lineCtx, {
        type: 'line',
        data: chartData,
        options: chartOptions,
      });

      const barData = {
        labels: getLastSixMonths(),
        datasets: [
          {
            label: 'Total Clients',
            backgroundColor: '#36a2eb',
            borderColor: '#36a2eb',
            data: getLastSixMonths().map(month => fetchUniqueClientsByMonth(month)),
            fill: false,
          },
        ],
      };

      const barCtx = document.getElementById('bar-chart').getContext('2d');
      new Chart(barCtx, {
        type: 'bar',
        data: barData,
        options: chartOptions,
      });
    };

    const getRandomColor = () => {
      // Function to generate random color for each dataset
      const letters = '0123456789ABCDEF';
      let color = '#';
      for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
    };

    onMounted(() => {
      fetchProjects();
      fetchClients();
      fetchCategories();
    });

    return {
      projects,
      clients,
    };
  },
};
</script>

<style lang="scss">
.chart-container {
  height: 400px;
  width: 100%;
  position: relative;
}
</style>
