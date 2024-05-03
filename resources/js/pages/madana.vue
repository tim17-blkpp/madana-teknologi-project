<style>
    .nav-item{
        margin-right: 30px;
    }

    .navbar{
        padding: 0;
    }

    .container-fluid{
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

    @media (max-width: 600px) {
        .nav-item{
            margin: 10px ;
        }
        .get-quote{
            display: none;
        }
        .container-fluid{
            padding-left: 0;
            padding-right: 0;
        }
        .jumbotron-text{
            text-align: center;
        }
    }

    @media (min-width: 600px) {
        .quote-resp{
            display: none;
        }
    }
</style>

<template>
    <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #335C94;">
            <div class="container-fluid">
                <img src="img/madana-icon.png">
                <button class="navbar-toggler me-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">About</a>
                        </li>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Portofolio
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
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
                            <button type="button" class="btn btn-light w-100">Get Quote</button>
                        </li>
                    </ul>
                </div>
                <div class="get-quote">
                    <button type="button" class="btn btn-light">Get Quote</button>
                </div>
            </div>
        </nav>
    <!-- Navbar -->

    <!-- Jumbotron -->
        <section>
            <div class="jumbotron-section bg-dark">
                <div class="container">
                    <div class="row h-100">
                        <div class="col-md-4 d-flex align-items-center jumbotron-text">
                            <div>
                                <div class="h1">
                                    Grow Big With Out Tech Business
                                </div>
                                <div>
                                    Nulla sodales massa at feugiat suscipit. 
                                    Ut mattis neque nec ante mollis, vitae tempor felis gravida.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5"></div>
                    </div>
                </div>
                <img src="img/jumbotron.png">
            </div>
        </section>
    <!-- Jumbotron -->

    <!-- About -->
        <section style="background-color: white; padding: 150px 0">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md">
                        <img src="img/about-content.png" width="100%">
                    </div>
                    <div class="col-md d-flex align-items-center">
                        <div>
                            <div class="h2 text-dark">About</div>
                            <div class="text-dark fs-5">
                                Donec in auctor est, in vulputate nisi. Vestibulum tristique eros enim, sed feugiat enim ornare sit amet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse et metus sit amet velit pulvinar fringilla. In quis mi eget eros hendrerit sodales. Integer rutrum mollis sapien. Praesent ipsum velit, bibendum tempor nisi id, tempor vestibulum felis. Maecenas suscipit enim quis sapien ultricies, in lacinia sapien vestibulum. Cras feugiat, enim quis rhoncus pulvinar, nulla nunc pretium libero, lobortis posuere libero dui.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!-- About -->

    <!-- Portofolio -->
        <section style="background-color: #E7F1FF;">
            <div class="container">
                Portofolio
            </div>
        </section>
    <!-- Portofolio -->
</template>

<route lang="yaml">
    meta:
      layout: blank
</route>

<script>

</script>
