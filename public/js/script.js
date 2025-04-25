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
    const joinBtn = document.getElementById('joinLiveBtn');
    const theme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', theme);
    document.getElementById('theme-icon').className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-sun';
    loadStudyCards(currentPage);
});


// login and registration toggle
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

// ----------------------------------------------------

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
    success: function (response) {
        if (response.status === 'success') {
            handleLoginSuccess(response.user);
            $('#loginModal').modal('hide');
        } else {
            alert(response.message);
        }
    }
});

// clock functionality
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


// -------------------------------------- 
document.addEventListener("DOMContentLoaded", function () {
    const registerForm = document.querySelector('#registerForm form');

    registerForm.addEventListener('submit', function (e) {
        if (registerForm.checkValidity()) {
            alert("Check email to Verify Account by Clicking Link");
        }
    });
});

// ------------------------------------------


const joinBtn = document.getElementById('joinLiveBtn');
const endBtn = document.getElementById('endLiveBtn');
const videoContainer = document.getElementById('videoContainer');
let stream;

async function markLiveStatus(status) {
    const endpoint = status === 'start' ? '/live-session/start' : '/live-session/end';

    try {
        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        const result = await response.json();
        console.log('Server response:', result);
    } catch (err) {
        console.error('Error updating live status:', err);
    }
}

joinBtn?.addEventListener('click', async (e) => {
    e.preventDefault();
    console.log("Join button clicked");

    try {
        stream = await navigator.mediaDevices.getUserMedia({
            video: true,
            audio: false
        });

        const video = document.createElement('video');
        video.srcObject = stream;
        video.autoplay = true;
        video.muted = true;
        video.classList.add('rounded', 'shadow', 'border');
        video.style.width = "60%";

        videoContainer.innerHTML = '';
        videoContainer.appendChild(video);

        joinBtn.classList.add('d-none');
        endBtn.classList.remove('d-none');

        await markLiveStatus('start');
    } catch (error) {
        alert("Camera permission required to go live.");
        console.error(error);
    }
});

document.getElementById('confirmEndBtn')?.addEventListener('click', async () => {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        videoContainer.innerHTML = '';
    }

    joinBtn.classList.remove('d-none');
    endBtn.classList.add('d-none');

    await markLiveStatus('end');
});

// ---------------------------------------------------

let localStream = null;

document.getElementById("joinLiveBtn").addEventListener("click", async () => {
    try {
        localStream = await navigator.mediaDevices.getUserMedia({
            video: true,
            audio: false
        });

        const video = document.getElementById("liveVideo");
        video.srcObject = localStream;

        document.getElementById("liveCard").style.display = "block";

        // (Optional) Notify backend you're live
        await axios.post('/live/start');

    } catch (err) {
        console.error("Camera permission denied:", err);
    }
});

// Close icon functionality
document.getElementById("closeCard").addEventListener("click", () => {
    if (localStream) {
        localStream.getTracks().forEach(track => track.stop());
    }
    document.getElementById("liveCard").style.display = "none";
});

// Make the card draggable
(function makeDraggable() {
    const card = document.getElementById("liveCard");
    const header = document.getElementById("cardHeader");
    let isDragging = false,
        offsetX, offsetY;

    header.addEventListener("mousedown", (e) => {
        isDragging = true;
        offsetX = e.clientX - card.offsetLeft;
        offsetY = e.clientY - card.offsetTop;
        card.style.transition = "none";
    });

    document.addEventListener("mousemove", (e) => {
        if (isDragging) {
            card.style.left = `${e.clientX - offsetX}px`;
            card.style.top = `${e.clientY - offsetY}px`;
            card.style.bottom = "auto";
            card.style.right = "auto";
        }
    });

    document.addEventListener("mouseup", () => {
        isDragging = false;
        card.style.transition = "all 0.1s ease";
    });
})();


// to restrict the card to hide

(function makeDraggable() {
    const card = document.getElementById("liveCard");
    const header = document.getElementById("cardHeader");
    const nav = document.getElementById("sec-nav");

    let isDragging = false,
        offsetX, offsetY;

    header.addEventListener("mousedown", (e) => {
        isDragging = true;
        offsetX = e.clientX - card.offsetLeft;
        offsetY = e.clientY - card.offsetTop;
        card.style.transition = "none";
    });

    document.addEventListener("mousemove", (e) => {
        if (isDragging) {
            // Get nav height to restrict top
            const navBottom = nav.offsetTop + nav.offsetHeight;
            const windowWidth = window.innerWidth;
            const windowHeight = window.innerHeight;
            const cardWidth = card.offsetWidth;
            const cardHeight = card.offsetHeight;

            let newLeft = e.clientX - offsetX;
            let newTop = e.clientY - offsetY;

            // Restrict to screen bounds
            newLeft = Math.max(0, Math.min(newLeft, windowWidth - cardWidth));
            newTop = Math.max(navBottom, Math.min(newTop, windowHeight - cardHeight));

            card.style.left = `${newLeft}px`;
            card.style.top = `${newTop}px`;
            card.style.bottom = "auto";
            card.style.right = "auto";
        }
    });

    document.addEventListener("mouseup", () => {
        isDragging = false;
        card.style.transition = "all 0.1s ease";
    });
})();

