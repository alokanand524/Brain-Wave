
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
