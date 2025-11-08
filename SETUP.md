# Brain-Wave Setup Guide

## Analysis Result ⚠️

**The project was originally MySQL-based but has been converted to PostgreSQL.**

## What's Done ✅

1. **Database Configuration**: Converted from MySQL to PostgreSQL
2. **Environment File**: Updated `.env` with PostgreSQL settings
3. **WebRTC Implementation**: Added functional WebRTC for live video sessions
4. **Dependencies**: Updated Composer packages for PHP 8.1 compatibility
5. **Application Key**: Generated Laravel app key
6. **Migrations**: Updated for PostgreSQL compatibility

## Database Changes Made 🔄

### Original (MySQL):
- `DB_CONNECTION=mysql`
- `DB_PORT=3306`
- `DB_DATABASE=u208350848_brainwaveDB`

### Updated (PostgreSQL):
- `DB_CONNECTION=pgsql`
- `DB_PORT=5432`
- `DB_DATABASE=brainwave`

## Quick Setup 🚀

### Option 1: Use Setup Script
```bash
# Run the automated setup
setup_postgresql.bat
```

### Option 2: Manual Setup
```bash
# 1. Create PostgreSQL database
createdb brainwave

# 2. Update .env password
# Edit DB_PASSWORD=your_actual_postgres_password

# 3. Run migrations
php artisan migrate

# 4. Start server
php artisan serve
```

## How It Works 🎯

### Simple Concept
- Users login → Join study room → Turn on camera → Study silently with strangers
- No chat/communication, just presence like a real library
- Camera can be toggled on/off anytime

### Key Features
- **Live Sessions**: Real-time video streaming via WebRTC
- **User Management**: Login/Register with Google OAuth
- **Study Grid**: Shows all live users studying
- **Camera Control**: Toggle camera on/off
- **Session Tracking**: Tracks join/leave times

### Files Modified/Created
- `app/Http/Controllers/WebRTCController.php` - Live session management
- `public/js/webrtc.js` - WebRTC functionality
- `routes/web.php` - Added WebRTC routes
- `.env` - PostgreSQL configuration
- `config/database.php` - Default to PostgreSQL

## Troubleshooting 🔧

1. **Camera not working**: Check browser permissions
2. **Database errors**: Ensure PostgreSQL is running and database exists
3. **Google OAuth**: Set up Google Console project and update credentials

Your virtual library is ready! 📚✨