

<template>
  <!-- Navbar Start -->
  <nav
    class="navbar navbar-expand-lg navbar-dark"
    style="background-color: #335C94;"
  >
    <div class="container-fluid">
      <img src="img/assets/madana-icon.png">
      <button
        class="navbar-toggler me-4"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon" />
      </button>
      <div
        id="navbarNav"
        class="collapse navbar-collapse"
      >
        <ul
          id="navbar-links"
          class="navbar-nav ms-auto me-auto"
        />
      </div>
      <div class="get-quote">
        <button
          id="downloadButton"
          type="button"
          class="btn btn-light"
          style="color: #335C94 !important;"
        >
          Get Quote
        </button>
      </div>
    </div>
  </nav>
  <!-- Navbar End -->

  <!-- Jumbotron Start -->
  <section id="home">
    <div class="jumbotron-section">
      <div class="container">
        <div class="row h-100 container">
          <div class="col-md-5 d-flex align-items-center jumbotron-text">
            <div>
<<<<<<< HEAD
              <p class="h2 mb-3">About</p>
              <p class="description-content">{{ konfigurasi.deskripsi }}</p>
=======
              <div class="fs-1 text-white">
                Grow Big With Out Tech Business
              </div>
              <div class="text-white">
                Nulla sodales massa at feugiat suscipit. 
                Ut mattis neque nec ante mollis, vitae tempor felis gravida.
              </div>
>>>>>>> 4ac35898c704d94f993493a04eeba4c56f22a90f
            </div>
          </div>
        </div>
      </div>
      <img src="img/assets/jumbotron.png">
    </div>
  </section>
  <!-- Jumbotron End -->

  <a href="https://api.whatsapp.com/send/?phone=6289668510562&text&type=phone_number&app_absent=0">
    <button
      type="button"
      class="dark-blue-color fixed-whatsapp-icon rounded-circle"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="50%"
        height="50%"
        fill="#ffffff"
        class="bi bi-whatsapp"
        viewBox="0 0 16 16"
      >
        <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
      </svg>
    </button>
  </a>

  <!-- About Start -->
  <section
    id="about"
    class="d-flex align-items-center"
  >
    <div class="container">
      <div class="row">
        <div class="col-sm-6 d-flex align-items-center">
          <img
            src="img/assets/about-content.png"
            alt="..."
            class="w-100"
          >
        </div>
        <div class="col-sm-6 d-flex align-items-center">
          <div>
            <p class="h2 mb-3">
              About
            </p>
            <p>{{ konfigurasi.deskripsi }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- About End -->

  <!-- Portfolio Start -->
  <section
    id="projects"
    class="light-blue-color"
  >
    <div class="row text-center mb-4 mt-3">
      <div class="col">
        <h2>Projects</h2>
      </div>
    </div>
    <div
      id="carouselExampleControls"
      class="carousel slide container"
      data-bs-ride="carousel"
    >
      <div class="carousel-inner porto-section-pc">
        <div
          v-for="(chunk, index) in projectChunks"
          :key="index"
          class="carousel-item"
          :class="{ active: index === 0 }"
        >
          <div class="row container mx-auto justify-content-center">
            <div
              v-for="project in chunk"
              :key="project.id"
              class="col-sm-3 col-6 mb-3 px-3"
            >
              <div
                class="card shadow-content rounded-4"
                style="height: 300px;"
                @click="selectProject(project)"
              >
                <img
                  :src="project.thumbnail_path"
                  class="card-img-top rounded-top-4 w-100"
                  alt="..."
                  style="height: 170px"
                >
                <div class="card-body d-flex justify-content-center text-center">
                  <div class="p-3">
                    <h5 class="card-title blue-font">
                      {{ project.name }}
                    </h5>
                    <p class="card-text blue-font">
                      ({{ new Date(project.end_date).getFullYear() }})
                    </p>
                  </div>
                </div>
                <div class="rounded-4 hover-overlay">
                  <div class="hover-text p-4">
                    <a
                      class="fs-4 text-white hover-link"
                      data-bs-toggle="modal"
                      data-bs-target="#projectModal"
                    >See More</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button
        class="carousel-control-prev d-flex justify-content-start"
        type="button"
        data-bs-target="#carouselExampleControls"
        data-bs-slide="prev"
      >
        <img
          src="/img/assets/arrow-left.png"
          alt="..."
          width="24px"
        >
        <span class="visually-hidden">Previous</span>
      </button>
      <button
        class="carousel-control-next d-flex justify-content-end"
        type="button"
        data-bs-target="#carouselExampleControls"
        data-bs-slide="next"
      >
        <img
          src="/img/assets/arrow-right.png"
          alt="..."
          width="24px"
        >
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <div class="porto-section-mobile container">
      <div
        v-for="(project, index) in projects.slice(0, 5)"
        :key="project.id"
        class="col-12"
      >
        <div
          class="card mb-4 rounded-3 shadow-content"
          @click="selectProject(project)"
        >
          <div class="row g-0">
            <div class="col-lg-2 col-5">
              <img
                :src="project.thumbnail_path"
                class="card-img-top w-100"
                alt="..."
                style="height: 100%"
              >
            </div>
            <div class="col-lg-10 col-7 d-flex align-items-center px-3">
              <div
                class="card-body w-100"
                data-bs-toggle="modal"
                data-bs-target="#projectModal"
              >
                <h5 class="card-title mt-auto fs-6 blue-font">
                  {{ project.name }}
                </h5>
                <p class="card-title mb-auto blue-font">
                  ({{ new Date(project.end_date).getFullYear() }})
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="text-center">
        <a
          href="/projects"
          class="btn btn-primary dark-blue-color w-100"
        >Show More</a>
      </div>
    </div>

    <!-- Modal -->
    <div
      id="projectModal"
      class="modal fade"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="projectModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            />
          </div>
          <div class="modal-body">
            <h1
              id="projectModalLabel"
              class="modal-title fs-5"
            >
              {{ selectedProject.name }}
            </h1>
            <p>({{ new Date(selectedProject.end_date).getFullYear() }})</p>
            <div class="d-flex justify-content-center">
              <img
                :src="selectedProject.thumbnail_path"
                alt="..."
                class="rounded-4 w-50"
              >
            </div>
            <p
              class="mt-5"
              style="max-height: 7.5em; overflow-y: auto;"
            >
              {{ selectedProject.description }}
            </p>
          </div>
          <div class="modal-footer">
            <a
              :href="selectedProject.url"
              class="btn btn-primary dark-blue-color"
            >Link Project</a>
            <button
              type="button"
              class="btn btn-outline-primary"
              data-bs-dismiss="modal"
            >
              Tutup
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Portfolio End -->

  <!-- Tools Start -->
  <section
    id="tools"
    class="light-blue-color"
  >
    <div class="row text-center mb-4">
      <div class="col">
        <h2>Tools</h2>
      </div>
    </div>
    <div class="container">
      <div class="row text-center justify-content-center">
<<<<<<< HEAD
        <div v-for="(tool, index) in tools.slice(0, maxToolsToShow)" :key="tool.id" class="col-lg-3 col-6 mb-3">
          <div class="d-flex ps-3 align-items-center bg-light rounded-3 shadow-content py-3 mb-3">
            <img :src="tool.icon" alt="..." class="me-3" style="width: 25%; aspect-ratio: 1;">
            <h5 class="my-auto tool-name">{{ tool.name }}</h5>
=======
        <div
          v-for="(tool, index) in tools.slice(0, maxToolsToShow)"
          :key="tool.id"
          class="col-lg-2 col-6 mb-3"
        >
          <div class="d-flex ps-3 align-items-center bg-light rounded-3 shadow-content py-3 mb-3">
            <img
              :src="tool.icon"
              alt="..."
              class="me-3"
              style="width: 25%; aspect-ratio: 1;"
            >
            <h6 class="my-auto">
              {{ tool.name }}
            </h6>
>>>>>>> 4ac35898c704d94f993493a04eeba4c56f22a90f
          </div>
        </div>
      </div>
    </div>
    <div
      v-if="tools.length > 6"
      class="col-12 mb-5 container"
    >
      <button
        type="button"
        class="btn w-100 p-2 text-white btn-show-more dark-blue-color"
        @click="toggleShowMore('tools')"
      >
        {{ maxToolsToShow === tools.length ? 'See Less' : 'See More' }}
      </button>
    </div>
  </section>
  <!-- Tools End -->

  <!-- Roles Start -->
  <section
    id="roles"
    class="dark-blue-color"
  >
    <div class="row text-center mb-4">
      <div class="col text-white">
        <h2>Roles</h2>
      </div>
    </div>
    <div class="container">
      <div class="row text-center justify-content-center">
        <div
          v-for="(role, index) in roles.slice(0, maxRolesToShow)"
          :key="role.id"
          class="col-lg-3 col-6 mb-4"
        >
          <div class="justify-content-center align-items-center text-white mb-3">
            <img
              :src="role.icon"
              alt="..."
              class="mb-3 w-50 role-icon"
              style="aspect-ratio: 1;"
            >
            <h4 class="my-auto">
              {{ role.name }}
            </h4>
          </div>
        </div>
      </div>
    </div>
    <div
      v-if="roles.length > 4"
      class="col-12 container"
    >
      <button
        type="button"
        class="btn w-100 p-2 blue-font btn-show-more bg-light"
        @click="toggleShowMore('roles')"
      >
        {{ maxRolesToShow === roles.length ? 'See Less' : 'See More' }}
      </button>
    </div>
  </section>
  <!-- Roles End -->

  <!-- Company Start -->
  <section id="company">
    <div class="row text-center mb-4">
      <div class="col">
        <h2>Companies We Have Worked With</h2>
      </div>
    </div>
    <div class="container">
      <div class="row justify-content-center">
<<<<<<< HEAD
        <div v-for="(client, index) in clients.slice(0, maxClientsToShow)" :key="client.id" class="col-sm-3 rounded-4">
          <div class="py-3 shadow-content d-flex justify-content-center mb-4">
            <img :src="client.logo" alt="..." style="width: 25%; aspect-ratio: 1;">
=======
        <div
          v-for="(client, index) in clients.slice(0, maxClientsToShow)"
          :key="client.id"
          class="col-sm-2 rounded-4"
        >
          <div class="py-3 shadow-content d-flex justify-content-center mb-4">
            <img
              :src="client.logo"
              alt="..."
              style="width: 30%; aspect-ratio: 1;"
            >
>>>>>>> 4ac35898c704d94f993493a04eeba4c56f22a90f
          </div>
        </div>
      </div>
    </div>
    <div
      v-if="clients.length > 5"
      class="col-12 mb-3 container"
    >
      <button
        type="button"
        class="btn w-100 p-2 text-white btn-show-more dark-blue-color"
        @click="toggleShowMore('clients')"
      >
        {{ maxClientsToShow === clients.length ? 'See Less' : 'See More' }}
      </button>
    </div>
  </section>
  <!-- Company End -->

  <!-- FAQ Start -->
  <section
    id="faq"
    style="margin-bottom: 50px;"
  >
    <div class="row text-center mb-4">
      <div class="col">
        <h2>FAQs</h2>
      </div>
    </div>
    <div class="container">
      <div
        v-for="faq in faqs.slice(0, maxFaqsToShow)"
        :key="faq.id"
        class="card mb-4 rounded-3 shadow-content"
      >
        <div class="row g-0">
          <div class="col-md-1">
            <div
              class="dark-blue-color h-100"
              style="width: 15%; border-radius: 5px 0 0 5px;"
            />
          </div>
          <div class="col-md py-3">
            <div class="card-body w-100 blue-font">
<<<<<<< HEAD
              <h5 class="card-title ">{{ faq.question }}</h5>
              <p class="card-text">{{ faq.answer }}</p>
=======
              <h5 class="card-title">
                {{ faq.question }}
              </h5>
              <p class="card-text">
                {{ faq.answer }}
              </p>
>>>>>>> 4ac35898c704d94f993493a04eeba4c56f22a90f
            </div>
          </div>
        </div>
      </div>
      <div
        v-if="faqs.length > 5"
        class="row justify-content-center"
      >
        <div class="col-lg-2 col-12 justify-content-center d-flex">
          <button
            type="button"
            class="btn btn-outline-primary w-100 p-2"
            @click="toggleShowMore('faqs')"
          >
            {{ maxFaqsToShow === faqs.length ? 'See Less' : 'See More' }}
          </button>
        </div>
      </div>
    </div>
  </section>
  <!-- FAQ End -->


  <!-- Contact Start -->
  <section id="contact">
    <div class="row text-center mb-4">
      <div class="col">
        <h2>Contact Us</h2>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-6 contact-maps">
          <div
            id="map"
            class="w-100 h-100"
          />
        </div>
        <div class="col-lg-6">
          <form @submit.prevent="submitContactForm">
            <div class="mb-3">
              <input
                v-model="contactForm.name"
                type="text"
                class="form-control py-2 px-3"
                placeholder="Name"
              >
            </div>
            <div class="mb-3">
              <input
                v-model="contactForm.email"
                type="email"
                class="form-control py-2 px-3"
                placeholder="Email"
              >
            </div>
            <div class="mb-3">
              <input
                v-model="contactForm.phone"
                type="tel"
                class="form-control py-2 px-3"
                placeholder="Phone Number"
              >
            </div>
            <div class="mb-3">
              <textarea
                v-model="contactForm.message"
                class="form-control"
                rows="11"
                placeholder="Masukkan Pesan"
              />
            </div>
            <button
              type="submit"
              class="float-end btn dark-blue-color text-white contact-submit px-5"
            >
              Submit
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- Contact End -->

  <!-- Footer Start -->
  <footer class="dark-blue-color text-white text-center text-lg-start">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 d-flex align-items-center py-4 footer-icon">
          <img
            src=""
            alt="..."
            style="width: 100px; height: 100px;"
          >
          <div class="ms-4">
            <h4
              style="margin: 0;"
              class="text-white"
            >
              Loading...
            </h4>
            <p class="fw-light text-white">
              Loading...
            </p>
            <div>
              <a
                href="#"
                target="_blank"
              >
                <img
                  src="img/assets/footer/whatsapp-icon.png"
                  alt="whatsapp"
                >
              </a>
              <a
                href="#"
                target="_blank"
              >
                <img
                  src="img/assets/footer/twt-icon.png"
                  alt="twitter"
                >
              </a>
              <a
                href="#"
                target="_blank"
              >
                <img
                  src="img/assets/footer/linkedin-icon.png"
                  alt="linkedin"
                >
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-2 py-4">
          <p class="fs-4 mb-3 text-white">
            Feature
          </p>
          <div id="footer-feature-links" />
        </div>
        <div class="col-lg-2 py-4">
          <p class="fs-4 mb-3 text-white">
            Services
          </p>
          <div id="footer-service-links" />
        </div>
        <div class="col-lg py-4">
          <p class="fs-4 mb-3 text-white">
            Our Contacts
          </p>
          <div>
            <p
              id="footer-email"
              class="feature-footer mb-3 fw-light text-white"
            >
              Email: Loading...
            </p>
            <p
              id="footer-phone"
              class="feature-footer fw-light text-white"
            >
              Phone: Loading...
            </p>
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
import axios from '@axios'
import L from 'leaflet'

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
        { text: 'Home', href: '#home' },
        { text: 'About', href: '#about' },
        { text: 'Projects', href: '/projects' },
        { text: 'Tools', href: '#tools' },
        { text: 'Roles', href: '#roles' },
        { text: 'Company', href: '#company' },
        { text: 'FAQs', href: '#faq' },
        { text: 'Contact', href: '#contact' },
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
        message: '',
      },
    }
  },
  created() {
    this.fetchProjects()
    this.fetchTools()
    this.fetchRoles()
    this.fetchClients()
    this.fetchFaqs()
    this.fetchCategories()
    this.fetchKonfigurasi()
  },
  mounted() {
    window.addEventListener('resize', this.checkScreenSize)
    document.getElementById("downloadButton").addEventListener("click", this.downloadFile)
    this.populateNavbarAndFooter()
    this.checkScreenSize()
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.checkScreenSize)
  },
  methods: {
    async fetchProjects() {
      try {
        const response = await axios.get('/api/public/projects')

        this.projects = response.data.data
        this.projectChunks = this.chunkArray(this.projects, 3)
        this.checkScreenSize()
      } catch (error) {
        console.error('Error fetching projects:', error)
      }
    },
    async fetchTools() {
      try {
        const response = await axios.get('/api/public/tools')

        this.tools = response.data.data
        this.checkScreenSize()
      } catch (error) {
        console.error('Error fetching tools:', error)
      }
    },
    async fetchRoles() {
      try {
        const response = await axios.get('/api/public/roles')

        this.roles = response.data.data
        this.checkScreenSize()
      } catch (error) {
        console.error('Error fetching roles:', error)
      }
    },
    async fetchClients() {
      try {
        const response = await axios.get('/api/public/clients')

        this.clients = response.data.data
        this.checkScreenSize()
      } catch (error) {
        console.error('Error fetching clients:', error)
      }
    },
    async fetchFaqs() {
      try {
        const response = await axios.get('/api/public/faqs')

        this.faqs = response.data.data
        this.hasMore = response.data.meta.current_page < response.data.meta.last_page
        this.checkScreenSize()
      } catch (error) {
        console.error('Error fetching faqs:', error)
      }
    },
    async fetchCategories() {
      try {
        const response = await axios.get('/api/projects/categories')

        this.categories = response.data.data
        this.services = this.categories.map(category => `${category.name} App`)
        this.populateFooterServices()
      } catch (error) {
        console.error('Error fetching categories:', error)
      }
    },
    async fetchKonfigurasi() {
      try {
        const response = await axios.get('/api/konfigurasi')

        this.konfigurasi = response.data

        // Update the footer content after fetching the configuration data
        this.updateFooterContent()

        // Initialize the map after fetching the configuration data
        this.initMap()
      } catch (error) {
        console.error('Error fetching konfigurasi:', error)
      }
    },
    chunkArray(array, chunkSize) {
      const result = []
      for (let i = 0; i < array.length; i += chunkSize) {
        result.push(array.slice(i, i + chunkSize))
      }
      
      return result
    },
    downloadFile() {
      var link = document.createElement("a")
      link.href = "/files/madana-porto.txt"
      link.download = "madana-porto.txt"
      document.body.appendChild(link)
      link.click()
      document.body.removeChild(link)
    },
    selectProject(project) {
      this.selectedProject = project
    },
    populateNavbarAndFooter() {
      const navbar = document.getElementById('navbar-links')
      const footerFeatureLinks = document.getElementById('footer-feature-links')

      this.navLinks.forEach(link => {
        const li = document.createElement('li')

        li.classList.add('nav-item')

        const a = document.createElement('a')

        a.classList.add('nav-link')
        a.classList.add('text-white')
        a.href = link.href
        a.textContent = link.text
        li.appendChild(a)
        navbar.appendChild(li)
      })

      if (this.isSmallScreen) {
        const li = document.createElement('li')

        li.classList.add('nav-item')
        li.innerHTML = `
          <div class="quote-resp">
            <button type="button" id="responsiveDownloadButton" class="btn btn-light w-100" style="color: #335C94 !important;">Get Quote</button>
          </div>
        `
        navbar.appendChild(li)

        document.getElementById('responsiveDownloadButton').addEventListener('click', this.downloadFile)
      }

      this.navLinks.slice(0, -1).forEach(link => {
        const a = document.createElement('a')

        a.href = link.href
        a.classList.add('text-decoration-none')

        const p = document.createElement('p')

        p.classList.add('feature-footer', 'mb-3', 'fw-light', 'text-white')
        p.textContent = link.text

        a.appendChild(p)
        footerFeatureLinks.appendChild(a)
      })
    },
    populateFooterServices() {
      const footerServiceLinks = document.getElementById('footer-service-links')

      footerServiceLinks.innerHTML = ''
      this.services.forEach(service => {
        const p = document.createElement('p')

        p.classList.add('feature-footer', 'mb-3', 'fw-light', 'text-white')
        p.textContent = service
        footerServiceLinks.appendChild(p)
      })
    },
    toggleShowMore(section) {
      if (section === 'tools') {
        this.maxToolsToShow = this.maxToolsToShow === 6 ? this.tools.length : 6
      } else if (section === 'roles') {
        this.maxRolesToShow = this.maxRolesToShow === 4 ? this.roles.length : 4
      } else if (section === 'clients') {
        this.maxClientsToShow = this.maxClientsToShow === 5 ? this.clients.length : 5
      } else if (section === 'faqs') {
        this.maxFaqsToShow = this.maxFaqsToShow === 5 ? this.faqs.length : 5
      }
    },
    checkScreenSize() {
      this.isSmallScreen = window.innerWidth <= 600
      if (!this.isSmallScreen) {
        this.maxToolsToShow = this.tools.length
        this.maxRolesToShow = this.roles.length
        this.maxClientsToShow = this.clients.length
        this.maxFaqsToShow = 5
      } else {
        this.maxToolsToShow = 6
        this.maxRolesToShow = 4
        this.maxClientsToShow = 5
        this.maxFaqsToShow = 5
      }
    },
    initMap() {
      const googleMapsCoords = this.konfigurasi.google_maps.split(', ')
      const lat = parseFloat(googleMapsCoords[0])
      const lng = parseFloat(googleMapsCoords[1])

      const map = L.map('map').setView([lat, lng], 18)

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 21,
        attribution: '© OpenStreetMap',
      }).addTo(map)

      L.marker([lat, lng]).addTo(map).bindPopup('<b>Madana Technology</b>').openPopup()
    },
    updateFooterContent() {
      document.querySelector('.footer-icon img').src = this.konfigurasi.logo
      document.querySelector('.footer-icon h4').textContent = this.konfigurasi.nama
      document.querySelector('.footer-icon p').textContent = this.konfigurasi.alamat
      
      const whatsappIcon = document.querySelector('.footer-icon img[alt="whatsapp"]')

      whatsappIcon.parentElement.href = this.konfigurasi.whatsapp
      
      const twitterIcon = document.querySelector('.footer-icon img[alt="twitter"]')

      twitterIcon.parentElement.href = this.konfigurasi.twitter
      
      const linkedinIcon = document.querySelector('.footer-icon img[alt="linkedin"]')

      linkedinIcon.parentElement.href = this.konfigurasi.instagram
      
      document.getElementById('footer-email').textContent = `Email: ${this.konfigurasi.email}`
      document.getElementById('footer-phone').textContent = `Phone: ${this.konfigurasi.no_telp}`
    },
  },
}
</script>

<style src="/public/assets/css/style.css"></style>


<route lang="yaml">
    meta:
      layout: blank
</route>
