<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Study Room Enhanced</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- CSS IMPLEMENTATION -->
    @vite(['resources/css/style.css'])
    @vite(['resources/css/live-stydy-group.css'])


    <style>

    </style>
</head>


<body>

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">BrainWave</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('index') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('features') }}">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="">Explore</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
                <button id="theme-toggle" class="btn btn-outline-light ms-3">
                    <i id="theme-icon" class="fas fa-moon"></i>
                </button>
                <!-- <a href="{{ route('studyRoom') }}" class="btn btn-join ms-3">Join Now</a> -->
                @guest
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#authModal">Login</button>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Second Nav Bar-->
    <nav class="navbar navbar-expand-lg container navbar-light navbar-custom px-3 py-2 position-relative mt-6 pt-3">
        <div class="container-fluid d-flex justify-content-between align-items-center">

            <!-- Left -->
            <div class="d-flex align-items-center gap-2">
                <div class="d-flex align-items-center gap-2">

                    <!-- Display Profile Picture of Users -->
                    <!-- <span class="dp-wrapper">
                        <img src="{{ asset('image/profileImage.png') }}" alt="Profile profileImage">
                    </span> -->


                    <!-- <span class="dp-wrapper" id="profileImageTrigger">
                        <img src="{{ asset('image/profileImage.png') }}" alt="Profile Image">
                    </span> -->
                    <span class="dp-wrapper" id="profileImageTrigger">
                        @auth
                        <img src="{{ Auth::user()->profile_image }}" alt="{{ Auth::user()->name }}" class="rounded-circle" width="50">
                        @else
                        <img src="{{ asset('image/profileImage.png') }}" alt="Guest" class="rounded-circle" width="50">
                        @endauth
                    </span>



                    @auth
                    <div id="profileSidebar" class="profile-sidebar">
                        <div class="profile-card mt-5">
                            <div class="card-body">
                                <span class="close-btn" style="margin-left: 200px;" id="closeSidebar">&times;</span>

                                <div class="d-flex img-info">
                                    <!-- <img src="{{ asset('image/bg.jpg') }}" alt="Profile" class="profile-img mb-2"> -->

                                    <span class="dp-wrapper" id="profileImageTrigger">
                                        @auth
                                        <img src="{{ Auth::user()->profile_image }}" alt="{{ Auth::user()->name }}" class="rounded-circle" width="50">
                                        @else
                                        <img src="{{ asset('image/profileImage.png') }}" alt="Guest" class="rounded-circle" width="50">
                                        @endauth
                                    </span>
                                    <h5>
                                        @auth
                                        {{ Auth::user()->name }}
                                        @else
                                        You Guest
                                        @endauth
                                    </h5>
                                    
                                </div>

                                <div class="profile-options">
                                    <a href="#"><i class="fas fa-user"></i> View Profile</a>
                                    <a href="#"><i class="fas fa-chart-line"></i> See Your Status</a>
                                </div>

                                <div class="profile-divider"></div>

                                <div class="profile-options">
                                    <a href="#"><i class="fas fa-user-shield"></i> Privacy Settings</a>
                                    <a href="#"><i class="fas fa-cogs"></i> Account Settings</a>
                                </div>

                                <div class="profile-divider"></div>

                                <!-- <div class="profile-options">
                                    <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                </div> -->

                                @auth
                                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <div class="profile-options">
                                        <!-- <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a> -->
                                        <button type="submit" class="btn btn-danger "><i class="fas fa-sign-out-alt"></i> Logout</button>
                                    </div>

                                </form>
                                @endauth

                            </div>
                        </div>
                    </div>
                    @endauth

                    <!-- Fetch User Name after Login -->
                    <span id="user-name-display" class="text-white bg-primary fw-bold px-3 py-1 rounded me-3">
                        @auth
                        {{ Auth::user()->name }}
                        @else
                        You Guest
                        @endauth
                    </span>

                    <!-- Cemera which toggle ON/OFF for Live Study -->
                    <i id="video-icon" class="fas fa-video-slash text-muted" onclick="toggleCamera(this)" style="cursor:pointer"></i>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination-center">
                <span class="pagination-control" onclick="changePage(-1)">&laquo;</span>
                <span id="page-info">1 / 2</span>
                <span class="pagination-control" onclick="changePage(1)">&raquo;</span>
            </div>

            <!-- Right -->
            <div class="d-flex align-items-center gap-2">
                <button class="nav-icon-btn"><i class="fas fa-bolt"></i></button>
                <button class="nav-icon-btn"><i class="far fa-clock"></i></button>

                <!-- <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#authModal">Register</button> -->
                <!-- @guest
                <button  data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                @endguest -->

                <!-- @auth
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger ">Logout</button>
                </form>
                @endauth -->

                <button class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#confirmFinishModal">
                    Join session
                </button>

                <div class="d-flex align-items-center icon-box-group ms-3">
                    <i class="fas fa-users"></i><span class="ms-1" id="userCount">lbl-decor0</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Study Cards Grid -->
    <div class="study-grid container" id="studyGrid"></div>

    <!-- Finish Modal -->
    <div class="modal fade" id="confirmFinishModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-primary text-white">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Finish Session?</h5>
                </div>
                <div class="modal-body">Are you sure you want to finish the session?</div>
                <div class="modal-footer border-0">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="/" class="btn btn-danger">Close</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Auth Modal -->
    <div class="modal fade" id="authModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0">
                    <div class="glass-card">

                        <h3 id="formTitle">Welcome Back 👋</h3>

                        <div class="toggle-btns">
                            <button id="loginBtn" class="active" onclick="switchForm('login')">Login</button>
                            <button id="signupBtn" onclick="switchForm('register')">Register</button>
                        </div>


                        <a href="{{ route('google.login') }}" class="btn btn-danger w-100 mt-3">
                            <i class="fab fa-google me-2"></i> Continue with Google
                        </a>

                        <div class="divider"><span>or</span></div>


                        <div id="loginForm" style="display: block;">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-1">
                                    <label for="loginEmail" class="form-label lbl-decor1">Email</label>
                                    <input type="email" name="email" id="loginEmail" class="form-control" required>
                                </div>
                                <div class="mb-1">
                                    <label for="loginPassword" class="form-label lbl-decor">Password</label>
                                    <input type="password" name="password" id="loginPassword" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                                <p class="mt-1 text-center ">
                                    Don't have an account? <a href="#" onclick="switchForm('register')">Register</a>
                                </p>
                            </form>
                        </div>


                        <div id="registerForm" style="display: none;">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="mb-1">
                                    <label for="registerName" class="form-label lbl-decor">Username</label>
                                    <input type="text" name="name" id="registerName" class="form-control" required>
                                </div>
                                <div class="mb-1">
                                    <label for="registerEmail" class="form-label lbl-decor3">Email</label>
                                    <input type="email" name="email" id="registerEmail" class="form-control" required>
                                </div>
                                <div class="mb-1">
                                    <label for="registerPassword" class="form-label lbl-decor">Password</label>
                                    <input type="password" name="password" id="registerPassword" class="form-control" required>
                                </div>
                                <div class="mb-1">
                                    <label for="password_confirmation" class="form-label lbl-decor2">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-success w-100">Register</button>
                                <p class="mt-1 text-center">
                                    Already have an account? <a href="#" onclick="switchForm('login')" style="color: orange;">Login</a>
                                </p>
                            </form>
                        </div>

                        <!-- <div class="divider"><span>or</span></div>
                        <a href="{{ route('google.login') }}" class="btn btn-danger w-100 mt-3">
                            <i class="fab fa-google me-2"></i> Continue with Google
                        </a> -->

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        let currentPage = 1;
        const cardsPerPage = 8;
        const totalUsers = 20;
        document.getElementById("userCount").textContent = totalUsers;

        function switchForm(type) {
            const title = document.getElementById("formTitle");
            const signup = document.getElementById("signupField");
            document.getElementById("loginBtn").classList.toggle("active", type === "login");
            document.getElementById("signupBtn").classList.toggle("active", type === "register");
            title.innerText = type === "register" ? "Create an Account 🚀" : "Welcome Back 👋";
            signup.style.display = type === "register" ? "block" : "none";
        }

        const statusOptions = ["Studying ⏳", "On Break ☕", "Reviewing 📚", "Focused 🔥"];

        function createCard(id) {
            const status = statusOptions[Math.floor(Math.random() * statusOptions.length)];
            return `
        <div class="study-card">
          <div class="video-section">
            <video id="video-${id}" autoplay muted playsinline></video>
            <div class="status-badge">${status}</div>
            <div class="notification-badge">25</div>
            <div class="three-dot" onclick="toggleActions(this)">⋮</div>
            <div class="hover-actions">
              <button>Rate</button><button>Follow</button><button>Report</button>
            </div>
            <div class="top-hover-icons">
              <div>🔖</div><div>💬</div><div>📒</div><div>🎖️</div>
            </div>
            <div class="emoji-reactions visible">
              <div class="emoji-btn" onclick="showReaction(this, '✨')">✨</div>
              <div class="emoji-btn" onclick="showReaction(this, '❤️')">❤️</div>
              <div class="emoji-btn" onclick="showReaction(this, '😂')">😂</div>
              <div class="emoji-btn" onclick="showReaction(this, '🔥')">🔥</div>
            </div>
            <div class="bottom-hover-info"><img src="https://i.pravatar.cc/150?img=${id}" alt="User"><span>User ${id}</span></div>
          </div>
          <div class="status-msg" onmouseover="toggleBottomHover(this,true)" onmouseout="toggleBottomHover(this,false)">
            Stay focused, stay awesome! 💪
          </div>
        </div>`;
        }

        function loadStudyCards(page) {
            const grid = document.getElementById('studyGrid');
            grid.innerHTML = '';
            const start = (page - 1) * cardsPerPage + 1;
            const end = Math.min(start + cardsPerPage - 1, totalUsers);
            for (let i = start; i <= end; i++) {
                grid.innerHTML += createCard(i);
            }
            for (let i = start; i <= end; i++) {
                startCamera(`video-${i}`);
            }
        }

        function changePage(dir) {
            const maxPage = Math.ceil(totalUsers / cardsPerPage);
            currentPage += dir;
            if (currentPage < 1) currentPage = 1;
            if (currentPage > maxPage) currentPage = maxPage;
            loadStudyCards(currentPage);
            document.getElementById("page-info").textContent = `${currentPage} / ${maxPage}`;
        }

        function startCamera(id) {
            // Skip starting camera for YOU GUEST (video-1)
            if (id === 'video-1') return;

            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => {
                    document.getElementById(id).srcObject = stream;
                }).catch(err => console.warn(err));
        }


        function toggleBottomHover(el, on) {
            const card = el.closest('.study-card');
            const emoji = card.querySelector('.emoji-reactions');
            const info = card.querySelector('.bottom-hover-info');
            emoji.classList.toggle('hidden', on);
            emoji.classList.toggle('visible', !on);
            info.style.display = on ? 'flex' : 'none';
        }

        function showReaction(el, emojiChar) {
            const emoji = document.createElement('div');
            emoji.className = 'floating-emoji';
            emoji.textContent = emojiChar;
            const parent = el.closest('.video-section');
            emoji.style.left = (el.offsetLeft + 5) + 'px';
            parent.appendChild(emoji);
            setTimeout(() => emoji.remove(), 1000);
        }

        function toggleActions(dot) {
            dot.classList.toggle('active');
        }

        // function toggleCamera(el) {
        //     el.classList.toggle("fa-video-slash");
        //     el.classList.toggle("fa-video");
        //     el.classList.toggle("text-muted");
        //     el.classList.toggle("text-success");
        // }

        document.getElementById('theme-toggle').addEventListener('click', () => {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            document.getElementById('theme-icon').className = newTheme === 'dark' ? 'fas fa-moon' : 'fas fa-sun';
        });

        window.addEventListener('DOMContentLoaded', () => {
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', theme);
            document.getElementById('theme-icon').className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-sun';
            loadStudyCards(currentPage);
        });
    </script>

    <script>
        let localStream = null;

        function toggleCamera(el) {
            const videoEl = document.getElementById("video-1");

            if (!localStream) {
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(stream => {
                        localStream = stream;
                        videoEl.srcObject = stream;

                        el.classList.remove("fa-video-slash", "text-muted");
                        el.classList.add("fa-video", "text-success");
                    })
                    .catch(err => console.warn(err));
            } else {
                localStream.getTracks().forEach(track => track.stop());
                videoEl.srcObject = null;
                localStream = null;

                el.classList.remove("fa-video", "text-success");
                el.classList.add("fa-video-slash", "text-muted");
            }
        }


        function loadStudyCards(page) {
            const grid = document.getElementById('studyGrid');
            grid.innerHTML = '';

            // Add guest card first
            grid.innerHTML += createCard(1);

            const start = (page - 1) * cardsPerPage + 2;
            const end = Math.min(start + cardsPerPage - 2, totalUsers);
            for (let i = start; i <= end; i++) {
                grid.innerHTML += createCard(i);
            }

            // Start camera only for non-guest users
            for (let i = start; i <= end; i++) {
                startCamera(`video-${i}`);
            }
        }
    </script>

    <script>
        function switchForm(type) {
            const loginForm = document.getElementById("loginForm");
            const registerForm = document.getElementById("registerForm");
            const title = document.getElementById("formTitle");

            document.getElementById("loginBtn").classList.toggle("active", type === "login");
            document.getElementById("signupBtn").classList.toggle("active", type === "register");

            title.innerText = type === "register" ? "Create an Account 🚀" : "Welcome Back 👋";
            loginForm.style.display = type === "login" ? "block" : "none";
            registerForm.style.display = type === "register" ? "block" : "none";
        }
    </script>

    <script>
        function handleLoginSuccess(user) {
            document.getElementById('user-name-display').innerText = user.name;
            document.getElementById('loginBtn').style.display = 'none';

            // If using logout button in frontend JS, show it now
            document.getElementById('logoutBtn').style.display = 'inline-block';
        }

        $.ajax({
            url: '/login',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    handleLoginSuccess(response.user);
                    $('#loginModal').modal('hide');
                } else {
                    alert(response.message);
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trigger = document.getElementById('profileImageTrigger');
            const sidebar = document.getElementById('profileSidebar');
            const closeBtn = document.getElementById('closeSidebar');

            if (trigger && sidebar && closeBtn) {
                trigger.addEventListener('click', function(e) {
                    sidebar.classList.add('active');
                });

                closeBtn.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                });

                // Click outside sidebar to close
                document.addEventListener('click', function(e) {
                    if (!sidebar.contains(e.target) && !trigger.contains(e.target)) {
                        sidebar.classList.remove('active');
                    }
                });
            }
        });
    </script>


</body>

</html>