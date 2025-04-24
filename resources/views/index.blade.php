<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrainWave - Study Together</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>


    <!-- CSS IMPLEMENTATION -->
    <!-- @vite(['resources/css/style.css']) -->
     <link rel="stylesheet" href="{{ url('CSS/style.css') }}">

    <style>
    body {
        background-image: url('{{ asset('image/HexagonBG.svg') }}');
        background-repeat: no-repeat;
        background-size: cover;
    background-position: center;
    /* background-attachment: fixed; */
    }

    .footer {
        background-image: url('{{ asset('image/cloudy_footerbg.svg') }}');
        background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    }
    .hero-img {
            background-image: url('{{ asset(' image/blob.svg') }}');
            
        }
        #galaxy-bg {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: -1;
}

.card {
    position: relative;
    overflow: hidden;
    border: 2px solid rgba(0, 255, 255, 0.2);
    border-radius: 20px;
    padding: 2rem;
    background: rgba(0, 0, 0, 0.25);
    backdrop-filter: blur(20px);
    box-shadow:
        0 0 10px rgba(0, 255, 255, 0.4),
        0 0 20px rgba(255, 0, 255, 0.2),
        inset 0 0 10px rgba(255, 255, 255, 0.05);
    color: #fff;
    transition: transform 0.5s ease, box-shadow 0.5s ease;
    transform-style: preserve-3d;
    cursor: pointer;
    z-index: 1;
}

.card:hover {
    transform: rotateY(10deg) rotateX(5deg) scale(1.05);
    box-shadow:
        0 0 25px rgba(0, 255, 255, 0.6),
        0 0 40px rgba(255, 0, 255, 0.3),
        inset 0 0 20px rgba(255, 255, 255, 0.05);
}

.card::before,
.card::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    z-index: -1;
    opacity: 0.2;
}

.card::before {
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, #0ff, transparent 70%);
    top: -100px;
    left: -100px;
    animation: pulseGlow 6s infinite ease-in-out;
}

.card::after {
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, #f0f, transparent 70%);
    bottom: -150px;
    right: -150px;
    animation: pulseGlowAlt 7s infinite ease-in-out;
}

.card img {
    width: 80px;
    height: 80px;
    margin-bottom: 1rem;
    filter: drop-shadow(0 0 8px #0ff);
    transition: transform 0.3s ease-in-out;
}

.card:hover img {
    transform: rotate(10deg) scale(1.1);
}

.card h3 {
    font-size: 1.6rem;
    margin-bottom: 0.5rem;
    color: #0ff;
    font-weight: 700;
    text-shadow: 0 0 15px rgba(0, 255, 255, 0.6);
}

.card p {
    font-size: 1rem;
    color: #ccc;
}

/* Keyframe animations */
@keyframes pulseGlow {
    0%, 100% {
        transform: scale(1);
        opacity: 0.2;
    }
    50% {
        transform: scale(1.3);
        opacity: 0.4;
    }
}

@keyframes pulseGlowAlt {
    0%, 100% {
        transform: scale(1);
        opacity: 0.2;
    }
    50% {
        transform: scale(1.5);
        opacity: 0.4;
    }
}

    </style>

</head>
<body>
<canvas id="galaxy-bg"></canvas>

<!-- Back to Top Button -->
<button id="backToTopBtn" title="Go to top">
    <i class="fas fa-arrow-up"></i>
</button>


    <!-- Navigation Bar -->
    <!-- <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">BrainWave</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#explore">Explore</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <a href="#" class="btn btn-join ms-3">Join Now</a>
            </div>
        </div>
    </nav> -->

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">BrainWave</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{  route('features') }}">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Explore</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <!-- Theme Toggle Button -->
                <!-- <button id="theme-toggle" class="btn btn-outline-light ms-3" title="Toggle Dark/Light Theme">
                    <i class="fas fa-moon" id="theme-icon"></i>
                </button> -->
                <!-- <a href="{{ route('studyRoom') }}" class="btn btn-join ms-3">Join Now</a> -->
                 @guest
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#authModal">Login</button>
                @endguest

            </div>
        </div>
    </nav>


    <!-- ------------------------------------------------------------------------- -->

    <!-- Hero Section -->
    <header id="home" class="hero-section text-center text-white d-flex align-items-center justify-content-center custom_hero container">
        <div class="container">
            <h1>Study Together, Anytime From Anywhere</h1>
            <p>Join a public study channel and collaborate with others in real-time!</p>
            <!-- <button class="btn btn-warning">Join Channel</button> -->
            <a href="{{ route('studyRoom') }}" class="btn btn-warning">Join Channel</a>


            <button class="btn btn-outline-light">Learn More</button>
        </div>

        <div class="container hero-img">
            <div><img src="{{ asset('image/hero.svg') }}" alt=""></div>
        </div>
    </header>

    <!-- -------------------------------------------------------------------------- -->

    <!-- Study Tools Section -->
    <section id="features" class="container text-center my-5">
        <h2>Study Smarter with These Tools</h2>
        <p class="p">Find the right study group that fits your needs.</p>
        <div class="row">
            <div class="col-md-4">
                <div class="card p-4">
                    <img src="{{ asset('image/education-funding.svg') }}" alt="">
                    <h3>Live Sessions</h3>
                    <p>Participate in interactive, real-time study sessions.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4">
                    <img src="{{ asset('image/education-funding.svg') }}" alt="">
                    <h3>Shared Resources</h3>
                    <p>Access a variety of materials shared by others.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4">
                    <img src="{{ asset('image/education-funding.svg') }}" alt="">
                    <h3>Collaborative Quizzes</h3>
                    <p>Test your knowledge with group-based quizzes.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Explore Channels Section -->
    <section id="explore" class="container text-center my-5 py-5">
        <h2>Explore Channels</h2>
        <p class="p">Find the right study group that fits your needs.</p>
        <div class="row">
            <div class="col-md-4">
                <div class="card p-4">
                    <img src="{{ asset('image/education-funding.svg') }}" alt="">
                    <h3>Math</h3>
                    <p>12 channels</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4">
                    <img src="{{ asset('image/education-funding.svg') }}" alt="">
                    <h3>History</h3>
                    <p>8 channels</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4">
                    <img src="{{ asset('image/education-funding.svg') }}" alt="">
                    <h3>Science</h3>
                    <p>15 channels</p>
                </div>
            </div>
        </div>
    </section>


    <header id="home" class="hero-section text-center text-white d-flex align-items-center justify-content-center custom_hero container">   

        <div class="container hero-img">
            <div><img src="{{ asset('image/hero.svg') }}" alt=""></div>
        </div>

        <div class="container">
            <h1>Study Together, Anytime From Anywhere</h1>
            <p>Join a public study channel and collaborate with others in real-time!</p>
            <button class="btn btn-warning">Join Channel</button>
            <button class="btn btn-outline-light">Learn More</button>
        </div>
    </header>

        <!-- Explore Channels Section -->
        <section id="explore" class="container text-center my-5 py-5">
        <h2>FEATURES</h2>
        <!-- <p class="p">Find the right study group that fits your needs.</p> -->
        <div class="row">
            <div class="col-md-4">
                <div class="card p-4">
                    <img src="{{ asset('image/education-funding.svg') }}" alt="">
                    <h3>Math</h3>
                    <p>12 channels</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4">
                    <img src="{{ asset('image/education-funding.svg') }}" alt="">
                    <h3>History</h3>
                    <p>8 channels</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4">
                    <img src="{{ asset('image/education-funding.svg') }}" alt="">
                    <h3>Science</h3>
                    <p>15 channels</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Hero Section -->
    <header id="home" class="hero-section text-center text-white d-flex align-items-center justify-content-center custom_hero container">
        <div class="container">
            <h1>Study Together, Anytime From Anywhere</h1>
            <p>Join a public study channel and collaborate with others in real-time!</p>
            <button class="btn btn-warning">Join Channel</button>
            <button class="btn btn-outline-light">Learn More</button>
        </div>

        <div class="container hero-img">
            <div><img src="{{ asset('image/hero.svg') }}" alt=""></div>
        </div>
    </header>


    <!-- Footer Section -->
    <footer class="footer  text-white py-5">
        <div class="container">
            <div class="row text-center text-md-start">
                <!-- Quick Links -->
                <div class="col-md-4 mb-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#home" class="text-white">Home</a></li>
                        <li><a href="#features" class="text-white">Features</a></li>
                        <li><a href="#explore" class="text-white">Explore</a></li>
                        <li><a href="#contact" class="text-white">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-md-4 mb-3">
                    <h5>Contact Us</h5>
                    <p>Email: support@brainwave.com</p>
                    <p>Phone: +123 456 7890</p>
                    <p>Address: 123 Study Lane, Learning City</p>
                </div>

                <!-- Social Media -->
                <div class="col-md-4 mb-3">
                    <h5>Follow Us</h5>
                    <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>

            <!-- Copyright -->
            <div class="text-center mt-3 pb">
                <p>&copy; 2025 BrainWave. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
    const canvas = document.getElementById("galaxy-bg");
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.z = 5;

    const renderer = new THREE.WebGLRenderer({ canvas, alpha: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(window.devicePixelRatio);

    window.addEventListener("resize", () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });

    // Create stars
    const starGeometry = new THREE.BufferGeometry();
    const starCount = 2000;
    const starVertices = [];

    for (let i = 0; i < starCount; i++) {
        const x = THREE.MathUtils.randFloatSpread(100);
        const y = THREE.MathUtils.randFloatSpread(100);
        const z = THREE.MathUtils.randFloatSpread(100);
        starVertices.push(x, y, z);
    }

    starGeometry.setAttribute('position', new THREE.Float32BufferAttribute(starVertices, 3));
    const starMaterial = new THREE.PointsMaterial({ color: 0xffffff, size: 0.5 });
    const stars = new THREE.Points(starGeometry, starMaterial);
    scene.add(stars);

    // Mouse movement interaction
    let mouseX = 0, mouseY = 0;
    document.addEventListener("mousemove", (e) => {
        mouseX = (e.clientX / window.innerWidth - 0.5) * 2;
        mouseY = (e.clientY / window.innerHeight - 0.5) * 2;
    });

    function animate() {
        requestAnimationFrame(animate);

        // Rotate slightly based on mouse movement
        stars.rotation.x += 0.0005 + (mouseY * 0.001);
        stars.rotation.y += 0.0005 + (mouseX * 0.001);

        renderer.render(scene, camera);
    }

    animate();
</script>


    <!-- Bootstrap & JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS for Smooth Scrolling & Active Link -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navLinks = document.querySelectorAll(".nav-link");

            navLinks.forEach(link => {
                link.addEventListener("click", function (event) {
                    event.preventDefault();
                    let targetId = this.getAttribute("href").substring(1);
                    let targetSection = document.getElementById(targetId);
                    
                    if (targetSection) {
                        window.scrollTo({
                            top: targetSection.offsetTop - 70, // Adjust for fixed navbar
                            behavior: "smooth"
                        });
                    }

                    // Remove 'active' class from all links and add to the clicked link
                    navLinks.forEach(link => link.classList.remove("active"));
                    this.classList.add("active");
                });
            });
        });
    </script>

<script>
    const toggleBtn = document.getElementById("theme-toggle");
    const icon = document.getElementById("theme-icon");

    // Load saved mode
    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark-mode");
        icon.classList.replace("fa-moon", "fa-sun");
    }

    toggleBtn.addEventListener("click", () => {
        document.body.classList.toggle("dark-mode");
        const isDark = document.body.classList.contains("dark-mode");

        if (isDark) {
            icon.classList.replace("fa-moon", "fa-sun");
            localStorage.setItem("theme", "dark");
        } else {
            icon.classList.replace("fa-sun", "fa-moon");
            localStorage.setItem("theme", "light");
        }
    });
</script>

<script>
    // Show/Hide Button on Scroll
    const backToTopBtn = document.getElementById("backToTopBtn");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
            backToTopBtn.style.display = "block";
        } else {
            backToTopBtn.style.display = "none";
        }
    });

    // Smooth Scroll to Top
    backToTopBtn.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.2/vanilla-tilt.min.js"></script>
<script>
    VanillaTilt.init(document.querySelectorAll(".card"), {
        max: 15,
        speed: 400,
        glare: true,
        "max-glare": 0.3,
    });
</script>


</body>
</html>
