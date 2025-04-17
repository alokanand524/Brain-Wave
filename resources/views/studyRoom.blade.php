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
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#authModal" style="margin-left: 10px;">Login</button>
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
                <span id="page-info">1 / 1</span>
                <span class="pagination-control" onclick="changePage(1)">&raquo;</span>
            </div>

            <!-- Right -->
            <div class="d-flex align-items-center gap-2">
                <button class="nav-icon-btn"><i class="fas fa-bolt"></i></button>

                <!-- <button class="nav-icon-btn"><i class="far fa-clock"></i></button> -->
                <button class="nav-icon-btn" style="position: relative; padding: 0; border: none; background: transparent;">
                    <div class="clock-container" style="width: 40px; height: 40px;">
                        <canvas id="canvas" width="35" height="35"></canvas>
                        <div class="digital-popup" id="digitalTime">00:00:00</div>
                    </div>
                </button>



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
                            <button id="loginBtn" class="active" onclick="switchForm('login')">Login direct with --</button>
                            <button id="signupBtn" onclick="switchForm('register')">Register</button>
                        </div>


                        <a href="{{ route('google.login') }}" class="btn btn-danger w-100 mt-3">
                            <i class="fab fa-google me-2"></i> Continue with Google
                        </a>

                        <div class="divider"><span>or</span></div>


                        <div id="loginForm" style="display: block;">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-2">
                                    <label for="loginEmail" class="form-label lbl-decor3">Email</label>
                                    <input type="email" name="email" id="loginEmail" class="form-control" placeholder="Enter your email" required>
                                </div>

                                <div class="mb-2">
                                    <label for="loginPassword" class="form-label lbl-decor">Password</label>
                                    <input type="password" name="password" id="loginPassword" class="form-control" placeholder="Enter your password" required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Login</button>

                                <p class="mt-2 text-center">
                                    Don't have an account?
                                    <a href="#" onclick="switchForm('register')" style="color: orange;">Register</a>
                                </p>

                                @if (session('status'))
                                <div class="alert alert-success mt-2">{{ session('status') }}</div>
                                @endif

                                @if ($errors->any())
                                <div class="alert alert-danger mt-2">{{ $errors->first() }}</div>
                                @endif
                            </form>



                        </div>


                        <div id="registerForm" style="display: none;">
                            <!-- <form method="POST" action="{{ route('register') }}">
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
                            </form> -->

                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="mb-1">
                                    <label for="registerName" class="form-label lbl-decor">Name</label>
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

                                <button type="submit" class="btn btn-success w-100">Send Magic Link</button>

                                <p class="mt-1 text-center">
                                    Already have an account?
                                    <a href="#" onclick="switchForm('login')" style="color: orange;">Login</a>
                                </p>

                                @if (session('status'))
                                <div class="alert alert-success mt-2">{{ session('status') }}</div>
                                @endif

                                @if ($errors->any())
                                <div class="alert alert-danger mt-2">{{ $errors->first() }}</div>
                                @endif
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
    <!-- |                 J A V A     S C R I P T                           | -->
    <!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>

    <script>
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

        function toggleActions(dot) {
            dot.classList.toggle('active');
        }

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

    <!-- login and registration form toggle -->
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

    <!-- side nav bar for Profile -->

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

    <!-- clock JS -->
    <script>
        const canvas = document.getElementById("canvas");
        const ctx = canvas.getContext("2d");
        let radius = canvas.height / 2;
        ctx.translate(radius, radius);
        radius *= 0.90;

        function drawClock() {
            ctx.clearRect(-canvas.width, -canvas.height, canvas.width * 2, canvas.height * 2);
            drawFace(ctx, radius);
            drawTime(ctx, radius);
        }

        function drawFace(ctx, radius) {
            ctx.beginPath();
            ctx.arc(0, 0, radius, 0, 2 * Math.PI);
            ctx.fillStyle = '#ffffff';
            ctx.fill();

            ctx.lineWidth = 2.5;
            ctx.strokeStyle = '#000000';
            ctx.stroke();

            ctx.beginPath();
            ctx.arc(0, 0, radius * 0.05, 0, 2 * Math.PI);
            ctx.fillStyle = '#000';
            ctx.fill();
        }

        function drawTime(ctx, radius) {
            const now = new Date();
            let hour = now.getHours();
            let minute = now.getMinutes();
            let second = now.getSeconds();

            hour %= 12;
            hour = (hour * Math.PI / 6) +
                (minute * Math.PI / (6 * 60)) +
                (second * Math.PI / (360 * 60));
            drawHand(ctx, hour, radius * 0.45, 2.7);

            minute = (minute * Math.PI / 30) + (second * Math.PI / (30 * 60));
            drawHand(ctx, minute, radius * 0.7, 2);

            second = (second * Math.PI / 30);
            drawHand(ctx, second, radius * 0.85, 1.5);
        }

        function drawHand(ctx, pos, length, width) {
            ctx.beginPath();
            ctx.lineWidth = width;
            ctx.lineCap = "round";
            ctx.moveTo(0, 0);
            ctx.rotate(pos);
            ctx.lineTo(0, -length);
            ctx.strokeStyle = "#000";
            ctx.stroke();
            ctx.rotate(-pos);
        }

        function updateDigitalClock() {
            const now = new Date();
            const digitalTime = document.getElementById("digitalTime");
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            digitalTime.innerText = `${h}:${m}:${s}`;
        }

        setInterval(() => {
            drawClock();
            updateDigitalClock();
        }, 1000);
    </script>


</body>

</html>