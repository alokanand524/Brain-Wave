// Full WebRTC Video Conferencing for Study Room
let localStream = null;
let isLive = false;
let sessionStartTime = null;
let sessionTimer = null;

document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing WebRTC Study Room...');
    setupEventListeners();
    loadLiveSessions();
    setInterval(loadLiveSessions, 3000);
});

function setupEventListeners() {
    const joinBtn = document.getElementById('joinLiveBtn');
    const endBtn = document.getElementById('endLiveBtn');
    const closeBtn = document.getElementById('closeFloating');
    
    if (joinBtn) joinBtn.addEventListener('click', startLiveSession);
    if (endBtn) endBtn.addEventListener('click', endLiveSession);
    if (closeBtn) closeBtn.addEventListener('click', () => {
        document.getElementById('floatingVideo').classList.remove('active');
    });
}

async function startLiveSession() {
    console.log('Starting live session...');
    
    try {
        // Get camera and audio
        localStream = await navigator.mediaDevices.getUserMedia({
            video: { width: 1280, height: 720 },
            audio: true
        });
        
        // Show local video in floating card
        const localVideo = document.getElementById('localVideo');
        localVideo.srcObject = localStream;
        document.getElementById('floatingVideo').classList.add('active');
        
        // Update buttons
        document.getElementById('joinLiveBtn').style.display = 'none';
        document.getElementById('endLiveBtn').style.display = 'flex';
        
        isLive = true;
        
        // Start session timer
        sessionStartTime = Date.now();
        sessionTimer = setInterval(updateSessionTime, 1000);
        
        // Notify server
        await fetch('/live-session/start', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        });
        
        console.log('Live session started successfully!');
        
    } catch (error) {
        console.error('Error starting session:', error);
        
        if (error.name === 'NotAllowedError') {
            alert('Camera/microphone access denied. Please allow access and try again.');
        } else if (error.name === 'NotFoundError') {
            alert('No camera/microphone found. Please connect a device and try again.');
        } else {
            alert('Error accessing camera: ' + error.message);
        }
    }
}

async function endLiveSession() {
    console.log('Ending live session...');
    
    try {
        // Stop all tracks
        if (localStream) {
            localStream.getTracks().forEach(track => track.stop());
            localStream = null;
        }
        
        // Hide floating video
        document.getElementById('floatingVideo').classList.remove('active');
        
        // Update buttons
        document.getElementById('joinLiveBtn').style.display = 'flex';
        document.getElementById('endLiveBtn').style.display = 'none';
        
        isLive = false;
        
        // Stop timer
        if (sessionTimer) {
            clearInterval(sessionTimer);
            sessionTimer = null;
        }
        sessionStartTime = null;
        document.getElementById('sessionTime').textContent = '00:00';
        
        // Notify server
        await fetch('/live-session/end', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        });
        
        console.log('Live session ended successfully!');
        
    } catch (error) {
        console.error('Error ending session:', error);
    }
}

function updateSessionTime() {
    if (!sessionStartTime) return;
    const elapsed = Math.floor((Date.now() - sessionStartTime) / 1000);
    const mins = Math.floor(elapsed / 60);
    const secs = elapsed % 60;
    document.getElementById('sessionTime').textContent = 
        `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
}

async function loadLiveSessions() {
    try {
        const response = await fetch('/live-sessions');
        const sessions = await response.json();
        updateStudyGrid(sessions);
        updateUserCount(sessions.length);
    } catch (error) {
        console.error('Error loading sessions:', error);
    }
}

function updateStudyGrid(sessions) {
    const studyGrid = document.getElementById('studyGrid');
    if (!studyGrid) return;
    
    studyGrid.innerHTML = '';
    
    if (sessions.length === 0) {
        studyGrid.innerHTML = `
            <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: white;">
                <i class="fas fa-users" style="font-size: 3rem; opacity: 0.5; margin-bottom: 1rem;"></i>
                <h4>No one is studying right now</h4>
                <p>Be the first to join a live study session!</p>
            </div>
        `;
        return;
    }
    
    sessions.forEach(session => {
        if (session.user) {
            const card = createStudyCard(session.user, session);
            studyGrid.appendChild(card);
        }
    });
}

function createStudyCard(user, session) {
    const card = document.createElement('div');
    card.className = 'video-card';
    
    const studyTime = calculateStudyTime(session.joined_at);
    
    card.innerHTML = `
        <div class="video-wrapper">
            <div class="video-placeholder">
                <i class="fas fa-user-circle"></i>
                <p>Studying Silently</p>
            </div>
            <div class="video-overlay">
                <div class="participant-info">
                    <img src="${user.profile_image || '/image/profileImage.png'}" 
                         alt="${user.name}" 
                         class="participant-avatar">
                    <span class="participant-name">${user.name}</span>
                </div>
                <div class="video-controls">
                    <span class="control-icon">
                        <i class="fas fa-microphone-slash"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="study-time">
                <i class="fas fa-clock"></i>
                ${studyTime}
            </div>
            <div class="live-badge">
                <span class="live-dot"></span>
                LIVE
            </div>
        </div>
    `;
    
    return card;
}

function calculateStudyTime(joinedAt) {
    const start = new Date(joinedAt);
    const now = new Date();
    const diff = Math.floor((now - start) / 1000 / 60);
    
    if (diff < 1) return 'Just joined';
    if (diff < 60) return `${diff} min`;
    
    const hours = Math.floor(diff / 60);
    const mins = diff % 60;
    return `${hours}h ${mins}m`;
}

function updateUserCount(count) {
    const userCountElement = document.getElementById('userCount');
    if (userCountElement) {
        userCountElement.textContent = count;
    }
}
