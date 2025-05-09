# ChatMet - Chat Application with Gemini Integration

ChatMet is a free chat application built with PHP and MySQL, featuring integration with Google's Gemini API.

## Setup Instructions

### Prerequisites
- XAMPP (or any PHP/MySQL server)
- Web browser

### Installation Steps

1. **Start XAMPP**
   - Start Apache and MySQL services from the XAMPP Control Panel

2. **Create Database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Import the `chatmet_db.sql` file to create the database and tables

3. **Copy Files**
   - Copy all project files to your XAMPP htdocs folder (e.g., `C:\xampp\htdocs\chatmet`)

4. **Access the Application**
   - Open your web browser and navigate to: http://localhost/chatmet
   - You'll be redirected to the home page where you can explore features or sign in

### Default Test Account
- Username: `testuser`
- Password: `password123`

## Features

- User registration and login system
- Secure password hashing
- Chat interface with Gemini integration
- Markdown rendering in chat responses
- Code syntax highlighting
- Chat history tracking
- Dark/light theme support
- Responsive landing page

## File Structure

- `index.php` - Main entry point, redirects to home page
- `home.php` - Landing page with features and information
- `login.php` - User login page
- `register.php` - New user registration
- `chatbot.php` - Main chat interface with Gemini integration
- `save_chat.php` - AJAX endpoint for saving chat messages
- `logout.php` - Logout functionality
- `db_connect.php` - Database connection and helper functions
- `chatmet_db.sql` - Database structure and initial data

## User Flow

1. **New Users**:
   - Visit the home page
   - Click "Get Started" to register
   - Fill out the registration form
   - Log in with new credentials
   - Start chatting with Gemini

2. **Returning Users**:
   - Visit the home page
   - Click "Sign In"
   - Enter credentials
   - Start chatting

## Gemini API Integration

ChatMet uses Google's Gemini API for generating responses. The application makes direct calls to the Gemini API from the browser using JavaScript fetch API.

## Technologies Used

- PHP 7.4+
- MySQL 5.7+
- Bootstrap 5
- Font Awesome 6
- JavaScript (ES6+)
- Marked.js for Markdown rendering
- Highlight.js for code syntax highlighting
- Google Gemini API
