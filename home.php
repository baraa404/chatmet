<?php
require_once 'db_connect.php';

// Check if user is logged in
$isLoggedIn = isLoggedIn();
$username = '';

if ($isLoggedIn) {
    // Get user information
    try {
        $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        $username = $user['username'];
    } catch(PDOException $e) {
        // Silently handle error
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatMet - Advanced AI Assistant</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="home.php">
                <i class="fas fa-comments text-purple me-2"></i>
                <span class="fw-bold">Chat<span class="text-purple">Met</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="mobile-menu-button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">How It Works</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <?php if ($isLoggedIn): ?>
                        <span class="me-3 d-flex align-items-center">Welcome, <?php echo htmlspecialchars($username); ?></span>
                        <a href="chatbot.php" class="btn btn-primary me-2">Chatbot</a>
                        <a href="logout.php" class="btn btn-outline-danger">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-link text-dark me-2">Sign In</a>
                        <a href="register.php" class="btn btn-primary glow">Get Started</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg text-white py-5 py-md-6">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="display-4 fw-bold mb-4">The Future of <span class="text-warning">AI</span> Conversations
                        - 100% Free</h1>
                    <p class="lead mb-4 opacity-90">ChatMet understands and responds like a human, helping you with
                        everything from creative writing to complex problem solving. No subscriptions, no limits,
                        completely free.</p>
                    <div class="d-grid gap-3 d-sm-flex">
                        <?php if ($isLoggedIn): ?>
                            <a href="chatbot.php" class="btn btn-light text-purple px-4 py-3 fw-bold glow">Go to Chatbot</a>
                        <?php else: ?>
                            <a href="register.php" class="btn btn-light text-purple px-4 py-3 fw-bold glow">Get Started Now</a>
                        <?php endif; ?>
                        <a href="#features" class="btn btn-outline-light px-4 py-3 fw-bold">Explore Features</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="./img/aipic.png" alt="AI Assistant" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 py-md-6 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Powerful Features</h2>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">ChatMet is packed with innovative features
                    designed
                    to enhance your productivity and creativity.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4 p-lg-5">
                            <div class="feature-icon bg-purple-light mb-4">
                                <i class="fas fa-brain text-purple"></i>
                            </div>
                            <h3 class="h4 fw-bold mb-3">Advanced Natural Language</h3>
                            <p class="text-muted mb-0">Our AI understands context, nuance, and complex queries with
                                human-like
                                comprehension.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4 p-lg-5">
                            <div class="feature-icon bg-primary bg-opacity-10 mb-4">
                                <i class="fas fa-lightbulb text-primary"></i>
                            </div>
                            <h3 class="h4 fw-bold mb-3">Creative Assistance</h3>
                            <p class="text-muted mb-0">Generate ideas, stories, poems, and more with our creative
                                writing
                                capabilities.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4 p-lg-5">
                            <div class="feature-icon bg-success bg-opacity-10 mb-4">
                                <i class="fas fa-code text-success"></i>
                            </div>
                            <h3 class="h4 fw-bold mb-3">Code Generation</h3>
                            <p class="text-muted mb-0">Write, debug, and explain code in multiple programming languages
                                with ease.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-5 py-md-6 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">How ChatMet Works</h2>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">Getting started with ChatMet is simple and
                    intuitive.</p>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="position-relative">
                        <div class="position-absolute top-0 start-0 translate-middle-y bg-purple-light rounded-circle opacity-50"
                            style="width: 120px; height: 120px; z-index: 0;"></div>
                        <div class="position-absolute bottom-0 end-0 translate-middle bg-primary bg-opacity-10 rounded-circle opacity-50"
                            style="width: 120px; height: 120px; z-index: 0;"></div>
                        <div class="position-relative">
                            <img src="./img/4630062.jpg" alt="ChatMet Dashboard" class="img-fluid rounded-3 shadow">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-4 pb-2">
                        <div class="d-flex">
                            <div class="bg-purple text-white rounded-circle d-flex align-items-center justify-content-center me-3 mt-1"
                                style="width: 40px; height: 40px;">
                                <span class="fw-bold">1</span>
                            </div>
                            <div>
                                <h3 class="h4 fw-bold mb-2">Sign Up for Free</h3>
                                <p class="text-muted">Create your account in seconds. No credit card required.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 pb-2">
                        <div class="d-flex">
                            <div class="bg-purple text-white rounded-circle d-flex align-items-center justify-content-center me-3 mt-1"
                                style="width: 40px; height: 40px;">
                                <span class="fw-bold">2</span>
                            </div>
                            <div>
                                <h3 class="h4 fw-bold mb-2">Explore Features</h3>
                                <p class="text-muted">Discover all the powerful capabilities ChatMet has to offer.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 pb-2">
                        <div class="d-flex">
                            <div class="bg-purple text-white rounded-circle d-flex align-items-center justify-content-center me-3 mt-1"
                                style="width: 40px; height: 40px;">
                                <span class="fw-bold">3</span>
                            </div>
                            <div>
                                <h3 class="h4 fw-bold mb-2">Start Chatting</h3>
                                <p class="text-muted">Begin your conversation with ChatMet and experience the future of
                                    AI assistance.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <?php if ($isLoggedIn): ?>
                            <a href="chatbot.php" class="btn btn-primary btn-lg px-4 py-2 glow">Go to Chatbot</a>
                        <?php else: ?>
                            <a href="register.php" class="btn btn-primary btn-lg px-4 py-2 glow">Get Started Now</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="gradient-bg text-white py-5 py-md-6">
        <div class="container py-5 text-center">
            <h2 class="display-5 fw-bold mb-4">Ready to Experience the Power of ChatMet? It's 100% Free!</h2>
            <p class="lead mb-5 mx-auto opacity-90" style="max-width: 800px;">Join thousands of users who are already
                transforming
                their work with our completely free AI assistant. No credit cards, no subscriptions, no limits.</p>
            <div class="d-grid gap-3 d-sm-flex justify-content-center">
                <?php if ($isLoggedIn): ?>
                    <a href="chatbot.php" class="btn btn-light text-purple px-5 py-3 fw-bold glow">Go to Chatbot</a>
                <?php else: ?>
                    <a href="register.php" class="btn btn-light text-purple px-5 py-3 fw-bold glow">Get Started Now</a>
                    <a href="login.php" class="btn btn-outline-light px-5 py-3 fw-bold">Sign In</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark py-4">
        <div class="container text-center">
            <div class="d-flex align-items-center justify-content-center mb-3">
                <i class="fas fa-comments text-light me-2"></i>
                <span class="fw-bold text-white">Chat<span class="text-purple">Met</span></span>
            </div>
            <p class="text-light small mb-3">The advanced AI assistant for your personal and professional needs.</p>
            <div class="d-flex justify-content-center gap-3 mb-3">

                <a href="#" class="text-light"><i class="fab fa-github"></i></a>
            </div>
            <p class="text-light small mb-0">© 2025 ChatMet. All rights reserved.</p>
        </div>
    </footer>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
