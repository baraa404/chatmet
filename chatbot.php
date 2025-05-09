<?php
require_once 'db_connect.php';

requireLogin();

try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    $stmt = $conn->prepare("SELECT * FROM user_settings WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $settings = $stmt->fetch();

    $stmt = $conn->prepare("SELECT * FROM chat_history WHERE user_id = ? ORDER BY timestamp ASC");
    $stmt->execute([$_SESSION['user_id']]);
    $chat_history = $stmt->fetchAll();
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

if (isset($_GET['clear_history'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM chat_history WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        header("Location: chatbot.php");
        exit;
    } catch(PDOException $e) {
        die("Error clearing history: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot - ChatMet</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/marked/4.3.0/marked.min.js"></script>
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="home.php">
                <i class="fas fa-comments text-purple me-2"></i>
                <span class="fw-bold">Chat<span class="text-purple">Met</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="chatbot.php">Chatbot</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="me-3">Welcome, <?php echo htmlspecialchars($user['username']); ?></span>
                    <a href="?logout=1" class="btn btn-outline-danger">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Chat Interface -->
    <div class="container py-4">

        <div class="row">
            <!-- Main Chat Area -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Chat with ChatMet</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="chat-container">
                            <div class="chat-messages p-4" id="chatMessages" style="height: 500px; overflow-y: auto;">
                                <!-- Welcome message -->
                                <div class="assistant-message chat-message">
                                    <div class="d-flex">
                                        <div class="bg-purple-light p-2 rounded-circle me-2">
                                            <i class="fas fa-robot text-purple"></i>
                                        </div>
                                        <div class="response-text">
                                            <p class="fw-medium mb-1">ChatMet</p>
                                            <p class="mb-0">Hello, <?php echo htmlspecialchars($user['username']); ?>! I'm ChatMet. How can I help you today?</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Chat history will be displayed here -->
                                <?php foreach ($chat_history as $chat): ?>
                                    <div class="user-message chat-message">
                                        <div class="d-flex">
                                            <div class="bg-light p-2 rounded-circle me-2">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <p class="fw-medium mb-1">You</p>
                                                <p class="mb-0"><?php echo htmlspecialchars($chat['message']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="assistant-message chat-message">
                                        <div class="d-flex">
                                            <div class="bg-purple-light p-2 rounded-circle me-2">
                                                <i class="fas fa-robot text-purple"></i>
                                            </div>
                                            <div class="response-text">
                                                <p class="fw-medium mb-1">ChatMet</p>
                                                <div class="markdown-content"><?php echo htmlspecialchars($chat['response']); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                                <!-- Typing indicator (hidden by default) -->
                                <div class="assistant-message chat-message typing-message" style="display: none;">
                                    <div class="d-flex">
                                        <div class="bg-purple-light p-2 rounded-circle me-2">
                                            <i class="fas fa-robot text-purple"></i>
                                        </div>
                                        <div class="response-text">
                                            <p class="fw-medium mb-1">ChatMet</p>
                                            <div class="typing-indicator">
                                                <div class="typing-dot"></div>
                                                <div class="typing-dot"></div>
                                                <div class="typing-dot"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="chat-input p-3 border-top">
                                <form id="chatForm" class="d-flex flex-column">
                                    <div class="input-group mb-2">
                                        <textarea id="messageInput" class="form-control" placeholder="Type your message..." rows="2" required></textarea>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center px-2">
                                        <small class="text-muted">Press Enter to send, Shift+Enter for new line</small>
                                        <div>
                                            <button type="button" id="clearInputBtn" class="btn btn-sm btn-link text-muted">Clear</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white py-4 border-top">
        <div class="container text-center">
            <div class="d-flex align-items-center justify-content-center mb-3">
                <i class="fas fa-comments text-purple me-2"></i>
                <span class="fw-bold">Chat<span class="text-purple">Met</span></span>
            </div>
            <p class="text-muted small mb-3">The advanced AI assistant for your personal and professional needs.</p>
            <div class="d-flex justify-content-center gap-3 mb-3">

                <a href="#" class="text-muted"><i class="fab fa-github"></i></a>
            </div>
            <p class="text-muted small mb-0">© 2025 ChatMet. All rights reserved.</p>
        </div>
    </footer>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatForm = document.getElementById('chatForm');
            const messageInput = document.getElementById('messageInput');
            const chatMessages = document.getElementById('chatMessages');
            const typingMessage = document.querySelector('.typing-message');
            const clearInputBtn = document.getElementById('clearInputBtn');

            const apiKey = 'AIzaSyBCAPOttdORJ9ziZSSmbu60Y6wrD58oB68';
            const hasApiKey = true;

            marked.setOptions({
                highlight: function(code, lang) {
                    if (lang && hljs.getLanguage(lang)) {
                        return hljs.highlight(code, { language: lang }).value;
                    }
                    return hljs.highlightAuto(code).value;
                },
                breaks: true
            });

            document.querySelectorAll('.markdown-content').forEach(element => {
                element.innerHTML = marked.parse(element.textContent);
            });

            function scrollToBottom() {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            scrollToBottom();

            messageInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    chatForm.dispatchEvent(new Event('submit'));
                }
            });

            clearInputBtn.addEventListener('click', function() {
                messageInput.value = '';
                messageInput.focus();
            });

            function addMessageToChat(sender, message) {
                const messageElement = document.createElement('div');
                messageElement.classList.add('chat-message');

                if (sender === 'user') {
                    messageElement.classList.add('user-message');
                    messageElement.innerHTML = `
                        <div class="d-flex">
                            <div class="bg-light p-2 rounded-circle me-2">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                            <div>
                                <p class="fw-medium mb-1">You</p>
                                <p class="mb-0">${message}</p>
                            </div>
                        </div>
                    `;
                } else {
                    messageElement.classList.add('assistant-message');
                    messageElement.innerHTML = `
                        <div class="d-flex">
                            <div class="bg-purple-light p-2 rounded-circle me-2">
                                <i class="fas fa-robot text-purple"></i>
                            </div>
                            <div class="response-text">
                                <p class="fw-medium mb-1">ChatMet</p>
                                <div class="markdown-content">${message}</div>
                            </div>
                        </div>
                    `;

                    const markdownContent = messageElement.querySelector('.markdown-content');
                    markdownContent.innerHTML = marked.parse(message);
                }

                chatMessages.insertBefore(messageElement, typingMessage);
            }

            async function saveMessageToDatabase(message, response) {
                try {
                    const formData = new FormData();
                    formData.append('message', message);
                    formData.append('response', response);
                    formData.append('save_chat', true);

                    const result = await fetch('save_chat.php', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await result.json();
                    return data.success;
                } catch (error) {
                    console.error('Error saving message:', error);
                    return false;
                }
            }

            async function callGeminiAPI(message) {
                try {
                    typingMessage.style.display = 'block';
                    scrollToBottom();

                    const endpoint = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${apiKey}`;

                    const requestBody = {
                        contents: [{
                            parts: [{
                                text: message
                            }]
                        }]
                    };

                    const response = await fetch(endpoint, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(requestBody)
                    });

                    const data = await response.json();

                    typingMessage.style.display = 'none';

                    if (data.error) {
                        throw new Error(data.error.message || 'Error calling Gemini API');
                    }

                    const responseText = data.candidates[0].content.parts[0].text;

                    addMessageToChat('assistant', responseText);

                    await saveMessageToDatabase(message, responseText);

                    scrollToBottom();

                    return responseText;
                } catch (error) {
                    console.error('Error calling Gemini API:', error);

                    typingMessage.style.display = 'none';

                    const errorMessage = `Sorry, I encountered an error: ${error.message}. Please try again later.`;
                    addMessageToChat('assistant', errorMessage);

                    scrollToBottom();

                    return null;
                }
            }

            chatForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const message = messageInput.value.trim();

                if (!message) return;

                messageInput.value = '';

                addMessageToChat('user', message);

                await callGeminiAPI(message);
            });
        });
    </script>
</body>
</html>
