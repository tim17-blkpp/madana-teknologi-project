<style src="/public/assets/css/style.css"></style>

<template>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #335C94;">
        <div class="container-fluid">
            <img src="img/assets/madana-icon.png">
            <button class="navbar-toggler me-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/portofolio">Portofolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Tools</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Roles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Company</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">FAQs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Contact</a>
                    </li>
                    <li class="nav-item quote-resp">
                        <button type="button" class="btn btn-light w-100" style="color: #335C94 !important;">Get Quote</button>
                    </li>
                </ul>
            </div>
            <div class="get-quote">
                <button type="button" class="btn btn-light" style="color: #335C94 !important;">Get Quote</button>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Portfolio Section -->
    <section id="portofolio">
        <div class="row text-center mb-4 mt-3">
            <div class="col">
                <h2>Portofolio</h2>
            </div>
        </div>
        <div class="container">
            <div class="d-flex justify-content-end mb-5">
                <button type="button" class="btn btn-primary me-2 dark-blue-color" @click="toggleView">
                    <img v-if="isListView" src="img/assets/porto/list-icon.png" class="py-1">
                    <img v-else src="img/assets/porto/list-icon-row.png" class="py-2">
                </button>
                <button type="button" class="btn btn-primary me-2 d-flex dark-blue-color" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <p class="me-4 my-auto">Filter</p>
                    <img src="img/assets/porto/filter-icon.png" class="my-auto">
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li class="dropdown-item" @click="selectCategory({ name: 'Tampilkan Semua' })">
                        Tampilkan Semua
                    </li>
                    <li v-for="category in categories" :key="category.id" class="dropdown-item" @click="selectCategory(category)">
                        {{ category.name }} ({{ category.projects_count }})
                    </li>
                </ul>
            </div>
            <div v-if="isListView" class="row mx-auto justify-content-center mb-3">
                <div v-for="project in currentProjects" :key="project.id" class="col-sm-4 mb-4 px-4">
                    <div class="card shadow-content">
                        <img :src="project.thumbnail_path" class="card-img-top" alt="..." style="height: 200px">
                        <div class="card-body blue-font d-flex align-items-center justify-content-center text-center" style="height: 150px">
                            <div class="p-3">
                                <h5 class="card-title">{{ project.name }}</h5>
                                <p class="card-text">({{ new Date(project.end_date).getFullYear() }})</p>
                            </div>
                        </div>
                        <div class="hover-overlay">
                            <div class="hover-text p-4">
                                <p class="fw-normal">{{ project.description }}</p>
                                <a class="fw-normal text-white" :href="project.url" style="background: none;">Link</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <div class="row">
                    <div v-for="project in currentProjects" :key="project.id" class="col-12">
                        <div class="card mb-4 rounded-3 shadow-content">
                            <div class="row g-0">
                                <div class="col-lg-2 col-5">
                                    <img :src="project.thumbnail_path" class="card-img-top w-100" alt="..." style="height: 100%">
                                </div>
                                <div class="col-lg-10 col-7 d-flex align-items-center px-3">
                                    <div class="card-body w-100 blue-font">
                                        <h5 class="card-title mt-auto fs-6">{{ project.name }}</h5>
                                        <p class="card-title mb-auto">({{ new Date(project.end_date).getFullYear() }})</p>
                                    </div>
                                </div>
                            </div>
                            <div class="hover-overlay overlay-grid">
                                <div class="hover-text p-4">
                                    <p class="fw-normal responsif-text-porto">{{ project.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col justify-content-center d-flex">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination blue-font d-flex align-items-center">
                            <li v-for="page in pages" class="page-item mx-1" :class="{active: currentPage === page}" @click="changePage(page)">
                                <a href="#">{{ page }}</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Portfolio Section End -->

    <!-- Footer Start -->
    <footer class="dark-blue-color text-white text-center text-lg-start">
      <div class="container">
        <div class="row">
          <div class="col-lg-5 d-flex align-items-center py-4 footer-icon">
            <img src="img/assets/footer/footer-madana-icon.png" alt="..." class="h-50">
            <div class="ms-4">
              <h4 style="margin: 0;" class="text-white">Madana Innotech</h4>
              <p class="fw-light text-white">Jl. Alamat Gg Gang 123</p>
              <div>
                <img src="img/assets/footer/whatsapp-icon.png" alt="...">
                <img src="img/assets/footer/twt-icon.png" alt="...">
                <img src="img/assets/footer/linkedin-icon.png" alt="...">
              </div>
            </div>
          </div>
          <div class="col-lg-2 py-4">
            <p class="fs-4 mb-3 text-white">Feature</p>
            <div>
              <p class="feature-footer mb-3 fw-light text-white">Home</p>
              <p class="feature-footer mb-3 fw-light text-white">About</p>
              <p class="feature-footer mb-3 fw-light text-white">Portofolio</p>
              <p class="feature-footer mb-3 fw-light text-white">FAQs</p>
              <p class="feature-footer fw-light text-white">Contact</p>
            </div>
          </div>
          <div class="col-lg-2 py-4">
            <p class="fs-4 mb-3 text-white">Services</p>
            <div>
              <p class="feature-footer mb-3 fw-light text-white">Desktop App</p>
              <p class="feature-footer mb-3 fw-light text-white">Web App</p>
              <p class="feature-footer fw-light text-white">Mobile App</p>
            </div>
          </div>
          <div class="col-lg py-4">
            <p class="fs-4 mb-3 text-white">Our Contacts</p>
            <div>
              <p class="feature-footer mb-3 fw-light text-white">Email: info@madanatech.com</p>
              <p class="feature-footer fw-light text-white">Phone: +62 8123123123123</p>
            </div>
          </div>
        </div>
      </div>
      <div class="text-center p-3 dark-blue-color text-white">
        © Copyright 2023 All Rights Reserved by Madana Innotech
      </div>
      <!-- Copyright -->
    </footer>
    <!-- Footer End -->
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            projects: [],
            categories: [], // Add this line to store categories
            currentPage: 1, // Current active page number
            projectsPerPage: 6, // Number of projects per page
            isListView: true, // Control to switch between list view and grid view
            selectedCategory: null, // To store the selected category
        };
    },
    computed: {
        pages() {
            let filteredProjects = this.getFilteredProjects();
            return Array.from({ length: Math.ceil(filteredProjects.length / this.projectsPerPage) }, (_, i) => i + 1);
        },
        currentProjects() {
            const start = (this.currentPage - 1) * this.projectsPerPage;
            const end = start + this.projectsPerPage;
            let filteredProjects = this.getFilteredProjects();
            return filteredProjects.slice(start, end);
        }
    },
    created() {
        this.fetchProjects();
        this.fetchCategories(); // Fetch categories on component creation
        this.updateProjectsPerPage();
    },
    mounted() {
        window.addEventListener('resize', this.updateProjectsPerPage);
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.updateProjectsPerPage);
    },
    methods: {
        async fetchProjects() {
            try {
                const response = await axios.get('/api/public/projects');
                this.projects = response.data.data; // Store fetched projects data
            } catch (error) {
                console.error('Error fetching projects:', error);
            }
        },
        async fetchCategories() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/projects/categories');
                this.categories = response.data.data; // Store fetched categories data
            } catch (error) {
                console.error('Error fetching categories:', error);
            }
        },
        toggleView() {
            this.isListView = !this.isListView;
        },
        changePage(page) {
            this.currentPage = page;
        },
        updateProjectsPerPage() {
            if (window.innerWidth <= 600) {
                this.projectsPerPage = 5;
            } else {
                this.projectsPerPage = 6; // Sesuaikan jumlah konten per halaman
            }
        },
        getFilteredProjects() {
            if (this.selectedCategory === null) {
                return this.projects;
            }
            return this.projects.filter(project => project.category === this.selectedCategory.name);
        },
        selectCategory(category) {
            this.selectedCategory = category.name === "Tampilkan Semua" ? null : category;
            this.currentPage = 1; // Reset pagination saat kategori dipilih
        }
    }
};
</script>

<route lang="yaml">
    meta:
      layout: blank
</route>


