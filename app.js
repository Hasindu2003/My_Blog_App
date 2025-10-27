// Global state
let currentUser = null;

// Initialize app
document.addEventListener('DOMContentLoaded', () => {
    checkAuthentication();
});

// Check if user is authenticated
async function checkAuthentication() {
    try {
        const response = await fetch('check_auth.php');
        const data = await response.json();
        
        if (data.authenticated) {
            currentUser = data.user;
            updateUIForAuthenticatedUser();
        } else {
            currentUser = null;
            updateUIForUnauthenticatedUser();
        }
    } catch (error) {
        console.error('Auth check failed:', error);
    }
}

// Update UI for authenticated user
function updateUIForAuthenticatedUser() {
    const authLinks = document.getElementById('auth-links');
    if (authLinks) {
        authLinks.innerHTML = `
            <span class="username-display">Welcome, ${currentUser.username}</span>
            <button onclick="logout()" class="btn btn-small">Logout</button>
        `;
    }
}

// Update UI for unauthenticated user
function updateUIForUnauthenticatedUser() {
    const authLinks = document.getElementById('auth-links');
    if (authLinks) {
        authLinks.innerHTML = `
            <a href="auth.html">Login</a>
            <a href="auth.html?register=true">Register</a>
        `;
    }
}

// Register user
async function register(username, email, password, confirmPassword) {
    try {
        const response = await fetch('register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                username,
                email,
                password,
                confirm_password: confirmPassword
            })
        });
        
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Registration error:', error);
        return { success: false, message: 'Network error occurred' };
    }
}

// Login user
async function login(username, password) {
    try {
        const response = await fetch('login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username, password })
        });
        
        const data = await response.json();
        
        if (data.success) {
            currentUser = data.user;
        }
        
        return data;
    } catch (error) {
        console.error('Login error:', error);
        return { success: false, message: 'Network error occurred' };
    }
}

// Logout user
async function logout() {
    try {
        await fetch('logout.php');
        currentUser = null;
        window.location.href = 'index.html';
    } catch (error) {
        console.error('Logout error:', error);
    }
}

// Blog API functions
async function getBlogs(userOnly = false) {
    try {
        const url = userOnly ? 'api_blogs.php?user_only=true' : 'api_blogs.php';
        const response = await fetch(url);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching blogs:', error);
        return { success: false, message: 'Network error occurred' };
    }
}

async function getBlog(id) {
    try {
        const response = await fetch(`api_blogs.php?id=${id}`);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching blog:', error);
        return { success: false, message: 'Network error occurred' };
    }
}

async function createBlog(title, content) {
    try {
        const response = await fetch('api_blogs.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ title, content })
        });
        
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error creating blog:', error);
        return { success: false, message: 'Network error occurred' };
    }
}

async function updateBlog(id, title, content) {
    try {
        const response = await fetch('api_blogs.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id, title, content })
        });
        
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error updating blog:', error);
        return { success: false, message: 'Network error occurred' };
    }
}

async function deleteBlog(id) {
    if (!confirm('Are you sure you want to delete this blog?')) {
        return { success: false, message: 'Cancelled' };
    }
    
    try {
        const response = await fetch('api_blogs.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id })
        });
        
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error deleting blog:', error);
        return { success: false, message: 'Network error occurred' };
    }
}

// Utility functions
function showMessage(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    
    const container = document.querySelector('.container');
    if (container) {
        container.insertBefore(alertDiv, container.firstChild);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function truncateText(text, maxLength) {
    if (text.length <= maxLength) return text;
    return text.substring(0, maxLength) + '...';
}
