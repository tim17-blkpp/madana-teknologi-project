<style>
    * {
        font-family: 'Poppins', sans-serif !important;
        color: #000000;
    }

    .light-blue-color{
        background-color: #E7F1FF;
    }
    .dark-blue-color{
        background-color: #335C94 !important;
    }
    .blue-font{
        color: #335C94 !important;
    }
    .shadow-content{
        box-shadow: 0px 5px 15px 3px rgba(0,0,0,0.10);
    }
    .nav-item {
        margin-right: 30px;
    }

    .navbar {
        padding: 0;
    }

    .container-fluid {
        padding-left: 0;
        padding-right: 75px;
    }

    .jumbotron-section{
        width: 100%;
        position: relative;
    }

    .jumbotron-section img {
        width: 100%;
    }

    .jumbotron-section .row {
        position: absolute;
        width: 100%; /* agar row memenuhi lebar jumbotron-section */
    }

    #projects, #tools, #roles, #company, #faq, #contact{
        padding: 7rem 1rem;
    }

    .feature-footer{
        margin: 0;
    }

    .page-item{
        border: solid #335C94; 
        border-radius: 10px;
    }

    .pagination a{
        text-decoration: none;
        color: #335C94;
    }

    .row-list{
        display: none;
    }

    .button-row{
        display: none;
    }

    .btn-show-more{
        display: none;
    }

    .fixed-whatsapp-icon {
        position: fixed;
        bottom: 60px;
        right: 60px;
        width: 80px;  /* Set the width as per the desired size */
        height: 80px; /* Set the height as per the desired size */
        padding: 0;
        border: none;
        background-color: transparent;
        cursor: pointer;
        z-index: 1000;
    }

    .porto-section-mobile{
        display: none;
    }

    .page-item{
        width: 35px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-outline-primary {
        border-color: #335C94;
        color: #335C94 !important;
        background-color: transparent !important;
    }

    .btn-outline-primary:hover,
    .btn-outline-primary:focus,
    .btn-outline-primary:active {
        background-color: #335C94 !important;
        color: white !important;
        border-color: #335C94;
    }

    .hover-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(51, 92, 148, 0.95); /* Warna biru dengan opacity */
      opacity: 0;
      transition: opacity 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 0.8em;
      text-align: center;
  }

  .overlay-grid{
      text-align: left;
  }
  .card:hover .hover-overlay {
      opacity: 1;
  }

  .hover-text {
      display: flex;
  }

  .card:hover .hover-text {
      display: block;
  }
    @media (max-width: 600px) {
        .nav-item {
            margin: 0 20px 10px;
        }
        .navbar-collapse {
            margin: 10px 0 20px;
        }
        .get-quote {
            display: none;
        }
        .container-fluid {
            padding-left: 0;
            padding-right: 0;
        }
        .jumbotron-text {
            text-align: center;
        }
        .jumbotron-section img {
            height: 70vh;
            object-fit: cover;
        }

        #about img{
            margin-bottom: 40px;
        }

        .contact-maps{
            margin-bottom: 20px;
        }

        .contact-submit{
            width: 100%;
        }

        .footer-icon{
            justify-content: center;
        }

        .carousel-control-prev,
        .carousel-control-next {
            display: none !important;
        }

        #carouselExampleControls {
            touch-action: pan-y;
        }
        .btn-show-more{
            display: block;
        }
        .show-more-roles{
            display: none;
        }

        .fixed-whatsapp-icon {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 80px;  /* Set the width as per the desired size */
            height: 80px; /* Set the height as per the desired size */
            padding: 0;
            border: none;
            background-color: transparent;
            cursor: pointer;
            z-index: 1000;
        }

        .porto-section-pc{
            display: none;
        }
        
        .porto-section-mobile{
            display: block;
        }
        #tools, #faq{
            padding: 2rem 1rem;
        }
        .roles-responsif{
            display: none;
        }
        .faq-content{
          text-align: center;
        }
        .role-icon{
          width: 100% !important;
        }
    }

    @media (min-width: 600px) {
        .quote-resp {
            display: none;
        }
    }
</style>

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
                        <a class="nav-link active" href="/projects">Projects</a>
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
                <button type="button" id="downloadButton" class="btn btn-light" style="color: #335C94 !important;">Get Quote</button>
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
                          <div class="fs-1 text-white">
                              Grow Big With Out Tech Business
                          </div>
                          <div class="text-white">
                              Nulla sodales massa at feugiat suscipit. 
                              Ut mattis neque nec ante mollis, vitae tempor felis gravida.
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <img src="img/assets/jumbotron.png">
      </div>
    </section>
    <!-- Jumbotron End -->

    <a href="https://api.whatsapp.com/send/?phone=6289668510562&text&type=phone_number&app_absent=0">
      <button type="button" class="dark-blue-color fixed-whatsapp-icon rounded-circle">
        <svg xmlns="http://www.w3.org/2000/svg" width="50%" height="50%" fill="#ffffff" class="bi bi-whatsapp" viewBox="0 0 16 16">
          <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
        </svg>
      </button>
    </a>

    <!-- About Start -->
    <section id="about" class="vh-100 d-flex align-items-center">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <img src="img/assets/about-content.png" alt="..." class="w-100">
          </div>
          <div class="col-sm-6 d-flex align-items-center">
            <div>
              <p class="h2 mb-3">About</p>
              <p >Donec in auctor est, in vulputate nisi. Vestibulum tristique eros enim, sed feugiat enim ornare sit amet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse et metus sit amet velit pulvinar fringilla. In quis mi eget eros hendrerit sodales. Integer rutrum mollis sapien. Praesent ipsum velit, bibendum tempor nisi id, tempor vestibulum felis. Maecenas suscipit enim quis sapien ultricies, in lacinia sapien vestibulum. Cras feugiat, enim quis rhoncus pulvinar, nulla nunc pretium libero, lobortis posuere libero dui.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- About End -->

<!-- Portfolio Start -->
  <section id="projects" class="light-blue-color">
    <div class="row text-center mb-4 mt-3">
      <div class="col">
        <h2>Projects</h2>
      </div>
    </div>
    <div id="carouselExampleControls" class="carousel slide container" data-bs-ride="carousel">
      <div class="carousel-inner porto-section-pc">
        <div class="carousel-item" v-for="(chunk, index) in projectChunks" :class="{ active: index === 0 }" :key="index">
          <div class="row container mx-auto justify-content-center">
            <div class="col-sm-3 col-6 mb-3 px-3" v-for="project in chunk" :key="project.id" >
              <div class="card shadow-content rounded-4" style="height: 300px;">
                <img :src="project.thumbnail_path" class="card-img-top rounded-top-4 w-100" alt="..." style="height: 150px">
                <div class="card-body blue-font d-flex justify-content-center text-center">
                  <div class="p-3">
                    <h5 class="card-title">{{ project.name }}</h5>
                    <p class="card-text">({{ new Date(project.end_date).getFullYear() }})</p>
                  </div>
                </div>
                <div class="hover-overlay rounded-4">
                  <div class="hover-text p-4">
                    <p class="fw-normal text-white">{{ project.description }}</p>
                    <a class="fw-normal text-white" :href="project.url" style="background: none;">Link</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev d-flex justify-content-start" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <img src="/img/assets/arrow-left.png" alt="..." width="24px">
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next d-flex justify-content-end" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <img src="/img/assets/arrow-right.png" alt="..." width="24px">
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <div class="porto-section-mobile container">
      <div class="col-12" v-for="project in projects" :key="project.id">
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
        </div>
      </div>
      <div class="col-12 mb-3">
        <a href="projects">
          <button type="button" class="btn w-100 p-2 text-white btn-show-more dark-blue-color">See More</button>
        </a>
      </div>
    </div>
  </section>
  <!-- Portfolio End -->

  <!-- Tools Start -->
  <section id="tools" class="light-blue-color">
    <div class="row text-center mb-4">
      <div class="col">
        <h2>Tools</h2>
      </div>
    </div>
    <div class="container mb-5">
      <div class="row text-center justify-content-center">
        <div v-for="tool in tools" :key="tool.id" class="col-lg-2 col-6 mb-3">
          <div class="d-flex justify-content-center align-items-center bg-light rounded-3 shadow-content py-3 mb-3">
            <img :src="tool.icon" alt="..." class="me-3" style="width: 25%; aspect-ratio: 1;">
            <h5 class="my-auto">{{ tool.name }}</h5>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 mb-3 container">
      <button type="button" class="btn w-100 p-2 text-white btn-show-more dark-blue-color">See More</button>
    </div>
  </section>
  <!-- Tools End -->

  <!-- Roles Start -->
  <section id="roles" class="dark-blue-color">
    <div class="row text-center mb-4">
      <div class="col text-white">
        <h2>Roles</h2>
      </div>
    </div>
    <div class="container">
      <div class="row text-center justify-content-center">
        <div v-for="role in roles" :key="role.id" class="col-lg-3 col-6 mb-4">
          <div class="justify-content-center align-items-center text-white mb-3">
            <img :src="role.icon" alt="..." class="mb-3 w-50 role-icon" style="aspect-ratio: 1;">
            <h4 class="my-auto">{{ role.name }}</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <button type="button" class="btn w-100 p-2 blue-font btn-show-more bg-light">See More</button>
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
        <div v-for="client in clients" :key="client.id" class="col-sm-2 rounded-4">
          <div class="py-3 shadow-content d-flex justify-content-center mb-4">
            <img :src="client.logo" alt="..." style="width: 30%; aspect-ratio: 1;">
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 mb-3 container">
      <button type="button" class="btn w-100 p-2 text-white btn-show-more dark-blue-color">See More</button>
    </div>
  </section>
  <!-- Company End -->

  <!-- FAQ Start -->
  <section id="faq" style="margin-bottom: 50px;">
    <div class="row text-center mb-4">
      <div class="col">
        <h2>FAQs</h2>
      </div>
    </div>
    <div class="container">
      <div v-for="faq in faqs" :key="faq.id" class="card mb-4 rounded-3 shadow-content">
        <div class="row g-0">
          <div class="col-md-1">
            <div class="dark-blue-color h-100" style="width: 15%; border-radius: 5px 0 0 5px;"></div>
          </div>
          <div class="col-md py-3">
            <div class="card-body w-100 blue-font faq-content">
              <h5 class="card-title">{{ faq.question }}</h5>
              <p class="card-text">{{ faq.answer }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-2 col-12 justify-content-center d-flex">
          <button v-if="hasMore" @click="loadMore" type="button" class="btn btn-outline-primary w-100 p-2">See More</button>
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
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.1721583335443!2d110.37512507419902!3d-7.771561592247833!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a59b2d4729729%3A0xac4d7b5fcf34f8e4!2sGadjah%20Mada%20University!5e0!3m2!1sen!2sid!4v1717123842004!5m2!1sen!2sid" class="w-100" style="aspect-ratio: 1.25;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>          
        </div>
        <div class="col-lg-6">
          <form>
            <div class="mb-3">
              <input type="name" class="form-control py-2 px-3" id="name" aria-describedby="emailHelp" placeholder="Name">
            </div>
            <div class="mb-3">
              <input type="email" class="form-control py-2 px-3" id="email" aria-describedby="emailHelp" placeholder="Email">
            </div>
            <div class="mb-3">
              <input type="phone" class="form-control py-2 px-3" id="phone" aria-describedby="emailHelp" placeholder="Phone Number">
            </div>
            <div class="mb-3">
              <textarea class="form-control" id="description" rows="11"></textarea>
            </div>
            <button type="submit" class="float-end btn dark-blue-color text-white contact-submit px-5">Submit</button>
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
            <p class="feature-footer mb-3 fw-light text-white">Projects</p>
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
  </footer>
  <!-- Footer End -->
</template>

<script>
import axios from 'axios';

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
    };
  },
  created() {
    this.fetchProjects();
    this.fetchTools();
    this.fetchRoles();
    this.fetchClients();
    this.fetchFaqs();
  },
  methods: {
    async fetchProjects() {
      try {
        const response = await axios.get('/api/public/projects');
        this.projects = response.data.data;
        this.projectChunks = this.chunkArray(this.projects, 3);
      } catch (error) {
        console.error('Error fetching projects:', error);
      }
    },
    async fetchTools() {
      try {
        const response = await axios.get('/api/public/tools');
        this.tools = response.data.data;
      } catch (error) {
        console.error('Error fetching tools:', error);
      }
    },
    async fetchRoles() {
      try {
        const response = await axios.get('/api/public/roles');
        this.roles = response.data.data;
      } catch (error) {
        console.error('Error fetching roles:', error);
      }
    },
    async fetchClients() {
      try {
        const response = await axios.get('/api/public/clients');
        this.clients = response.data.data;
      } catch (error) {
        console.error('Error fetching clients:', error);
      }
    },
    async fetchFaqs() {
      try {
        const response = await axios.get('/api/public/faqs');
        this.faqs = response.data.data;
        this.hasMore = response.data.meta.current_page < response.data.meta.last_page;
      } catch (error) {
        console.error('Error fetching faqs:', error);
      }
    },
    chunkArray(array, chunkSize) {
      const result = [];
      for (let i = 0; i < array.length; i += chunkSize) {
        result.push(array.slice(i, i + chunkSize));
      }
      return result;
    },
    async loadMore() {
      try {
        const response = await axios.get(`/api/public/faqs?page=${this.faqs.meta.current_page + 1}`);
        this.faqs = [...this.faqs, ...response.data.data];
        this.hasMore = response.data.meta.current_page < response.data.meta.last_page;
      } catch (error) {
        console.error('Error loading more faqs:', error);
      }
    },
    downloadFile() {
      var link = document.createElement("a");
      link.href = "/files/madana-porto.txt";
      link.download = "madana-porto.txt";
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    },
  },
  mounted() {
    document.getElementById("downloadButton").addEventListener("click", this.downloadFile);
  },
};
</script>

<route lang="yaml">
    meta:
      layout: blank
</route>
