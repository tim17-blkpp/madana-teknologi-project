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
              <ul class="navbar-nav ms-auto me-auto" id="navbar-links">
              </ul>
            </div>
            <div class="get-quote">
                <button type="button" id="downloadButton" class="btn btn-light" style="color: #335C94 !important;">Get Quote</button>
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
                    <p class="me-4 my-auto text-white">Filter</p>
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
                    <div class="card shadow-content rounded-4" style="height: 350px;" @click="selectProject(project)">
                        <img :src="project.thumbnail_path" class="card-img-top rounded-top-4 w-100" alt="..." style="height: 200px">
                        <div class="card-body d-flex justify-content-center text-center">
                            <div class="p-3">
                                <h5 class="card-title blue-font">{{ project.name }}</h5>
                                <p class="card-text blue-font">({{ new Date(project.end_date).getFullYear() }})</p>
                            </div>
                        </div>
                        <div class="rounded-4 hover-overlay">
                        <div class="hover-text p-4">
                            <a class="fs-4 text-white hover-link" data-bs-toggle="modal" data-bs-target="#projectModal">See More</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <div class="row">
                    <div v-for="project in currentProjects" :key="project.id" class="col-12">
                        <div class="card mb-4 rounded-3 shadow-content" @click="selectProject(project)">
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
                                <div class="hover-text p-4 d-flex align-items-center">
                                    <a class="fs-4 text-white hover-link" data-bs-toggle="modal" data-bs-target="#projectModal">See More</a>
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
        <!-- Modal -->
        <div class="modal fade" id="projectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h1 class="modal-title fs-5" id="projectModalLabel">{{ selectedProject.name }}</h1>
                    <p>({{ new Date(selectedProject.end_date).getFullYear() }})</p>
                    <div class="d-flex justify-content-center">
                    <img :src="selectedProject.thumbnail_path" alt="..." class="rounded-4 w-50">
                    </div>
                    <p class="mt-5" style="max-height: 7.5em; overflow-y: auto;">{{ selectedProject.description }}</p>
                </div>
                <div class="modal-footer">
                    <a :href="selectedProject.url" class="btn btn-primary dark-blue-color">Link Project</a>
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
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
            <img src="" alt="..." class="h-50">
            <div class="ms-4">
            <h4 style="margin: 0;" class="text-white">Loading...</h4>
            <p class="fw-light text-white">Loading...</p>
            <div>
                <a href="#" target="_blank">
                <img src="img/assets/footer/whatsapp-icon.png" alt="whatsapp">
                </a>
                <a href="#" target="_blank">
                <img src="img/assets/footer/twt-icon.png" alt="twitter">
                </a>
                <a href="#" target="_blank">
                <img src="img/assets/footer/linkedin-icon.png" alt="linkedin">
                </a>
            </div>
            </div>
        </div>
        <div class="col-lg-2 py-4">
            <p class="fs-4 mb-3 text-white">Feature</p>
            <div id="footer-feature-links"></div>
        </div>
        <div class="col-lg-2 py-4">
            <p class="fs-4 mb-3 text-white">Services</p>
            <div id="footer-service-links"></div>
        </div>
        <div class="col-lg py-4">
            <p class="fs-4 mb-3 text-white">Our Contacts</p>
            <div>
            <p id="footer-email" class="feature-footer mb-3 fw-light text-white">Email: Loading...</p>
            <p id="footer-phone" class="feature-footer fw-light text-white">Phone: Loading...</p>
            </div>
        </div>
        </div>
    </div>
    <div class="text-center p-3 dark-blue-color text-white">
        © Copyright 2023 All Rights Reserved by Madana Innotech
    </div>
    </footer>
    <!-- Footer End -->
</template>

<script>
import axios from 'axios';
import L from 'leaflet';

export default {
  data() {
    return {
      projects: [],
      projectChunks: [],
      tools: [],
      roles: [],
      clients: [],
      faqs: [],
      hasMore: false,
      selectedProject: {},
      navLinks: [
        { text: 'Home', href: '/madana' },
        { text: 'About', href: '/madana#about' },
        { text: 'Projects', href: '/projects' },
        { text: 'Tools', href: '/madana#tools' },
        { text: 'Roles', href: '/madana#roles' },
        { text: 'Company', href: '/madana#company' },
        { text: 'FAQs', href: '/madana#faq' },
        { text: 'Contact', href: '/madana#contact' }
      ],
      categories: [],
      konfigurasi: {},
      maxToolsToShow: 6,
      maxRolesToShow: 4,
      maxClientsToShow: 5,
      maxFaqsToShow: 5,
      isSmallScreen: window.innerWidth <= 600,
      contactForm: {
        name: '',
        email: '',
        phone: '',
        message: ''
      },
      currentPage: 1,
      projectsPerPage: 6,
      isListView: true,
      selectedCategory: null,
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
    this.fetchTools();
    this.fetchRoles();
    this.fetchClients();
    this.fetchFaqs();
    this.fetchCategories();
    this.fetchKonfigurasi();
  },
  mounted() {
    window.addEventListener('resize', this.checkScreenSize);
    document.getElementById("downloadButton").addEventListener("click", this.downloadFile);
    this.populateNavbarAndFooter();
    this.checkScreenSize();
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.checkScreenSize);
  },
  methods: {
    async fetchProjects() {
      try {
        const response = await axios.get('/api/public/projects');
        this.projects = response.data.data;
        this.projectChunks = this.chunkArray(this.projects, 3);
        this.checkScreenSize();
      } catch (error) {
        console.error('Error fetching projects:', error);
      }
    },
    async fetchTools() {
      try {
        const response = await axios.get('/api/public/tools');
        this.tools = response.data.data;
        this.checkScreenSize();
      } catch (error) {
        console.error('Error fetching tools:', error);
      }
    },
    async fetchRoles() {
      try {
        const response = await axios.get('/api/public/roles');
        this.roles = response.data.data;
        this.checkScreenSize();
      } catch (error) {
        console.error('Error fetching roles:', error);
      }
    },
    async fetchClients() {
      try {
        const response = await axios.get('/api/public/clients');
        this.clients = response.data.data;
        this.checkScreenSize();
      } catch (error) {
        console.error('Error fetching clients:', error);
      }
    },
    async fetchFaqs() {
      try {
        const response = await axios.get('/api/public/faqs');
        this.faqs = response.data.data;
        this.hasMore = response.data.meta.current_page < response.data.meta.last_page;
        this.checkScreenSize();
      } catch (error) {
        console.error('Error fetching faqs:', error);
      }
    },
    async fetchCategories() {
      try {
        const response = await axios.get('/api/projects/categories');
        this.categories = response.data.data;
        this.services = this.categories.map(category => `${category.name} App`);
        this.populateFooterServices();
      } catch (error) {
        console.error('Error fetching categories:', error);
      }
    },
    async fetchKonfigurasi() {
      try {
        const response = await axios.get('/api/konfigurasi');
        this.konfigurasi = response.data;

        // Update the footer content after fetching the configuration data
        this.updateFooterContent();

        // Initialize the map after fetching the configuration data
        this.initMap();
      } catch (error) {
        console.error('Error fetching konfigurasi:', error);
      }
    },
    chunkArray(array, chunkSize) {
      const result = [];
      for (let i = 0; i < array.length; i += chunkSize) {
        result.push(array.slice(i, i + chunkSize));
      }
      return result;
    },
    downloadFile() {
      var link = document.createElement("a");
      link.href = "/files/madana-porto.txt";
      link.download = "madana-porto.txt";
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    },
    selectProject(project) {
      this.selectedProject = project;
    },
    populateNavbarAndFooter() {
      const navbar = document.getElementById('navbar-links');
      const footerFeatureLinks = document.getElementById('footer-feature-links');

      this.navLinks.forEach(link => {
        const li = document.createElement('li');
        li.classList.add('nav-item');
        const a = document.createElement('a');
        a.classList.add('nav-link');
        a.classList.add('text-white');
        a.href = link.href;
        a.textContent = link.text;
        li.appendChild(a);
        navbar.appendChild(li);
      });

      if (this.isSmallScreen) {
        const li = document.createElement('li');
        li.classList.add('nav-item');
        li.innerHTML = `
          <div class="quote-resp">
            <button type="button" id="responsiveDownloadButton" class="btn btn-light w-100" style="color: #335C94 !important;">Get Quote</button>
          </div>
        `;
        navbar.appendChild(li);

        document.getElementById('responsiveDownloadButton').addEventListener('click', this.downloadFile);
      }

      this.navLinks.slice(0, -1).forEach(link => {
        const a = document.createElement('a');
        a.href = link.href;
        a.classList.add('text-decoration-none');

        const p = document.createElement('p');
        p.classList.add('feature-footer', 'mb-3', 'fw-light', 'text-white');
        p.textContent = link.text;

        a.appendChild(p);
        footerFeatureLinks.appendChild(a);
      });
    },
    populateFooterServices() {
      const footerServiceLinks = document.getElementById('footer-service-links');
      footerServiceLinks.innerHTML = '';
      this.services.forEach(service => {
        const p = document.createElement('p');
        p.classList.add('feature-footer', 'mb-3', 'fw-light', 'text-white');
        p.textContent = service;
        footerServiceLinks.appendChild(p);
      });
    },
    toggleShowMore(section) {
      if (section === 'tools') {
        this.maxToolsToShow = this.maxToolsToShow === 6 ? this.tools.length : 6;
      } else if (section === 'roles') {
        this.maxRolesToShow = this.maxRolesToShow === 4 ? this.roles.length : 4;
      } else if (section === 'clients') {
        this.maxClientsToShow = this.maxClientsToShow === 5 ? this.clients.length : 5;
      } else if (section === 'faqs') {
        this.maxFaqsToShow = this.maxFaqsToShow === 5 ? this.faqs.length : 5;
      }
    },
    checkScreenSize() {
      this.isSmallScreen = window.innerWidth <= 600;
      if (!this.isSmallScreen) {
        this.maxToolsToShow = this.tools.length;
        this.maxRolesToShow = this.roles.length;
        this.maxClientsToShow = this.clients.length;
        this.maxFaqsToShow = 5;
      } else {
        this.maxToolsToShow = 6;
        this.maxRolesToShow = 4;
        this.maxClientsToShow = 5;
        this.maxFaqsToShow = 5;
      }
    },
    initMap() {
      const googleMapsCoords = this.konfigurasi.google_maps.split(', ');
      const lat = parseFloat(googleMapsCoords[0]);
      const lng = parseFloat(googleMapsCoords[1]);

      const map = L.map('map').setView([lat, lng], 18);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 21,
        attribution: '© OpenStreetMap'
      }).addTo(map);

      L.marker([lat, lng]).addTo(map).bindPopup('<b>Madana Technology</b>').openPopup();
    },
    updateFooterContent() {
      document.querySelector('.footer-icon img').src = this.konfigurasi.logo;
      document.querySelector('.footer-icon h4').textContent = this.konfigurasi.nama;
      document.querySelector('.footer-icon p').textContent = this.konfigurasi.alamat;
      
      const whatsappIcon = document.querySelector('.footer-icon img[alt="whatsapp"]');
      whatsappIcon.parentElement.href = this.konfigurasi.whatsapp;
      
      const twitterIcon = document.querySelector('.footer-icon img[alt="twitter"]');
      twitterIcon.parentElement.href = this.konfigurasi.twitter;
      
      const linkedinIcon = document.querySelector('.footer-icon img[alt="linkedin"]');
      linkedinIcon.parentElement.href = this.konfigurasi.instagram;
      
      document.getElementById('footer-email').textContent = `Email: ${this.konfigurasi.email}`;
      document.getElementById('footer-phone').textContent = `Phone: ${this.konfigurasi.no_telp}`;
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
        this.projectsPerPage = 6;
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
      this.currentPage = 1;
    },
  }
};
</script>

<route lang="yaml">
    meta:
      layout: blank
</route>


