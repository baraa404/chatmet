// Custom JavaScript for ChatMet
console.log('Script loaded successfully');

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM fully loaded');
    // Mobile menu toggle (using Bootstrap's collapse)
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', function () {
            const target = document.getElementById('mobile-menu');
            if (target) {
                const bsCollapse = new bootstrap.Collapse(target);
                bsCollapse.toggle();
            }
        });
    }

    // Simulate typing animation in the demo chat
    setTimeout(() => {
        const typingIndicator = document.querySelector('.typing-indicator');
        const aiResponse = document.querySelector('.ai-response:last-child .response-text');

        if (typingIndicator && aiResponse) {
            typingIndicator.remove();
            aiResponse.innerHTML += `
                <p class="mt-1 text-secondary">ChatMet stands out with its advanced natural language processing, larger knowledge base, and more human-like responses. Unlike basic chatbots, I can understand context, remember previous parts of our conversation, and provide more nuanced, detailed answers to complex questions.</p>
            `;
        }
    }, 2000);

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});
