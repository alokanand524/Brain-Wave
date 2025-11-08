// Simple WebRTC Study Room Implementation
let localStream = null;
let isLive = false;

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing WebRTC...');
    
    // Check if required elements exist
    const requiredElements = {
        joinBtn: document.getElementById('joinLiveBtn'),
        endBtn: document.getElementById('endLiveBtn'),
        liveVideo: document.getElementById('liveVideo'),
        liveCard: document.getElementById('liveCard'),
        closeCard: document.getElementById('closeCard'),
        studyGrid: document.getElementById('studyGrid')
    };
    
    console.log('Required elements check:', requiredElements);
    
    // Check for missing elements
    Object.keys(requiredElements).forEach(key => {
        if (!requiredElements[key]) {
            console.error(`Missing element: ${key}`);
        }
    });
    
    setupEventListeners();
    loadLiveSessions();
    setInterval(loadLiveSessions, 5000); // Refresh every 5 seconds
});

function setupEventListeners() {
    console.log('Setting up event listeners...');
    
    // Check if WebRTC is supported
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        console.error('WebRTC not supported in this browser');
        alert('WebRTC not supported in this browser. Please use Chrome, Firefox, or Safari.');
        return;
    }
    
    // Check secure context (HTTPS or localhost)
    if (!window.isSecureContext && location.hostname !== 'localhost') {
        console.error('WebRTC requires HTTPS or localhost');
        alert('Camera access requires HTTPS. Please use https:// or localhost');
    }
    
    const joinBtn = document.getElementById('joinLiveBtn');
    const endBtn = document.getElementById('endLiveBtn');
    const closeBtn = document.getElementById('closeCard');
    
    console.log('Event listener elements:', {joinBtn, endBtn, closeBtn});
    
    if (joinBtn) {
        joinBtn.addEventListener('click', startLiveSession);
        console.log('Join button listener added');
    }
    
    if (endBtn) {
        endBtn.addEventListener('click', endLiveSession);
        console.log('End button listener added');
    }
    
    if (closeBtn) {
        closeBtn.addEventListener('click', endLiveSession);
        console.log('Close button listener added');
    }
}

async function startLiveSession() {
    console.log('Starting live session...');
    
    try {
        // Always show floating card first
        showFloatingCard();
        
        console.log('Trying to access camera...');
        
        try {
            // Try to get camera
            localStream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: false
            });
            
            console.log('Camera access granted, showing video');
            
            // Show video in card
            const liveVideo = document.getElementById('liveVideo');
            liveVideo.srcObject = localStream;
            liveVideo.style.display = 'block';
            
            // Hide placeholder
            const placeholder = document.getElementById('videoPlaceholder');
            if (placeholder) placeholder.style.display = 'none';
            
        } catch (cameraError) {
            console.log('Camera not available, showing name only');
            
            // Keep video hidden, show placeholder with name
            const liveVideo = document.getElementById('liveVideo');
            const placeholder = document.getElementById('videoPlaceholder');
            
            liveVideo.style.display = 'none';
            if (placeholder) placeholder.style.display = 'flex';
        }
        
        // Update buttons
        const joinBtn = document.getElementById('joinLiveBtn');
        const endBtn = document.getElementById('endLiveBtn');
        
        if (joinBtn) joinBtn.style.display = 'none';
        if (endBtn) endBtn.style.display = 'inline-block';
        
        isLive = true;
        
        // Update server
        await fetch('/live-session/start', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        });
        
        console.log('Live session started successfully!');
        
    } catch (error) {
        console.error('Error starting live session:', error);
        alert('Error: ' + error.message);
    }
}

function showFloatingCard() {
    const liveCard = document.getElementById('liveCard');
    const userName = document.querySelector('#user-name-display').textContent.trim();
    
    // Add user name to card header
    const cardHeader = document.getElementById('cardHeader');
    let nameSpan = cardHeader.querySelector('.user-name');
    
    if (!nameSpan) {
        nameSpan = document.createElement('span');
        nameSpan.className = 'user-name';
        nameSpan.style.cssText = 'color: white; font-weight: bold; margin-right: auto;';
        cardHeader.insertBefore(nameSpan, cardHeader.firstChild);
    }
    
    nameSpan.textContent = userName;
    
    // Add placeholder if not exists
    if (!document.getElementById('videoPlaceholder')) {
        const placeholder = document.createElement('div');
        placeholder.id = 'videoPlaceholder';
        placeholder.style.cssText = `
            position: absolute;
            top: 30px;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #222;
            color: white;
            text-align: center;
        `;
        placeholder.innerHTML = `
            <i class="fas fa-user" style="font-size: 2rem; margin-bottom: 10px;"></i>
            <div>${userName}</div>
            <small>Studying Live</small>
        `;
        liveCard.appendChild(placeholder);
    }
    
    liveCard.style.display = 'block';
}

async function endLiveSession() {
    console.log('Ending live session...');
    
    try {
        // Stop camera
        if (localStream) {
            console.log('Stopping camera tracks...');
            localStream.getTracks().forEach(track => {
                track.stop();
                console.log('Stopped track:', track.kind);
            });
            localStream = null;
        }

        // Hide floating card and clean up
        const liveCard = document.getElementById('liveCard');
        const placeholder = document.getElementById('videoPlaceholder');
        const liveVideo = document.getElementById('liveVideo');
        
        if (liveCard) {
            liveCard.style.display = 'none';
            console.log('Video card hidden');
        }
        
        if (placeholder) {
            placeholder.style.display = 'none';
        }
        
        if (liveVideo) {
            liveVideo.style.display = 'block';
        }
        
        // Show join button, hide end button
        const joinBtn = document.getElementById('joinLiveBtn');
        const endBtn = document.getElementById('endLiveBtn');
        
        if (joinBtn) joinBtn.style.display = 'inline-block';
        if (endBtn) endBtn.style.display = 'none';
        
        isLive = false;
        
        console.log('Updating server...');

        // Update server
        const response = await fetch('/live-session/end', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        });
        
        const result = await response.json();
        console.log('Server response:', result);
        
        console.log('Live session ended successfully!');
        
    } catch (error) {
        console.error('Error ending live session:', error);
        alert('Error ending session: ' + error.message);
    }
}

async function loadLiveSessions() {
    try {
        const response = await fetch('/live-sessions');
        const sessions = await response.json();
        updateStudyGrid(sessions);
        updateUserCount(sessions.length);
    } catch (error) {
        console.error('Error loading live sessions:', error);
    }
}

function updateStudyGrid(sessions) {
    const studyGrid = document.getElementById('studyGrid');
    if (!studyGrid) return;

    studyGrid.innerHTML = '';
    
    sessions.forEach(session => {
        if (session.user) {
            const card = createStudyCard(session.user);
            studyGrid.appendChild(card);
        }
    });
}

function createStudyCard(user) {
    const card = document.createElement('div');
    card.className = 'study-card';
    card.innerHTML = `
        <div class="card-header">
            <img src="${user.profile_image || '/image/profileImage.png'}" alt="${user.name}" class="profile-img">
            <span class="user-name">${user.name}</span>
            <div class="status-dot active"></div>
        </div>
        <div class="card-body">
            <div class="video-placeholder">
                <i class="fas fa-video"></i>
                <span>Studying Live</span>
            </div>
        </div>
    `;
    return card;
}

function updateUserCount(count) {
    const userCountElement = document.getElementById('userCount');
    if (userCountElement) {
        userCountElement.textContent = count;
    }
}

