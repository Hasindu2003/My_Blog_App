# Project Structure

```
My_Blog_App/
│
├── Frontend (HTML/CSS/JavaScript)
│   ├── index.html              # Home page - lists all blogs
│   ├── auth.html               # Login/Register page
│   ├── editor.html             # Create/Edit blog page
│   ├── view.html               # Single blog view page
│   ├── style.css               # Global styles
│   └── app.js                  # Frontend JavaScript logic
│
├── Backend (PHP)
│   ├── db.php                  # Database connection
│   ├── register.php            # User registration API
│   ├── login.php               # User login API
│   ├── logout.php              # User logout API
│   ├── check_auth.php          # Authentication check API
│   └── api_blogs.php           # Blog CRUD operations API
│
├── Database
│   └── setup.sql               # Database schema and setup
│
├── Configuration
│   ├── config.sample.php       # Sample configuration file
│   └── .gitignore              # Git ignore rules
│
└── Documentation
    ├── README.md               # Main documentation
    ├── API.md                  # API documentation
    ├── INSTALLATION.md         # Installation guide
    ├── TESTING.md              # Testing guide
    └── STRUCTURE.md            # This file
```

## Application Flow

### User Registration Flow
```
User → auth.html (Register Form)
     → register.php (Validate & Create User)
     → Database (Insert User)
     → Success Message
     → Redirect to Login
```

### User Login Flow
```
User → auth.html (Login Form)
     → login.php (Validate Credentials)
     → Database (Check User)
     → Create Session
     → Redirect to Home Page
```

### Create Blog Flow
```
User → index.html (Click "Create New Blog")
     → editor.html (Blog Form)
     → api_blogs.php POST (Create Blog)
     → Database (Insert Blog)
     → Redirect to Home Page
```

### View Blog Flow
```
User → index.html (Click "Read More")
     → view.html?id=X
     → api_blogs.php GET (Fetch Blog)
     → Database (Select Blog)
     → Display Blog Content
```

### Edit Blog Flow
```
User → view.html (Click "Edit" on own blog)
     → editor.html?id=X (Pre-filled Form)
     → api_blogs.php PUT (Update Blog)
     → Database (Update Blog)
     → Redirect to Blog View
```

### Delete Blog Flow
```
User → view.html (Click "Delete" on own blog)
     → Confirmation Dialog
     → api_blogs.php DELETE
     → Database (Delete Blog)
     → Redirect to Home Page
```

## Technology Stack

### Frontend
- **HTML5**: Semantic markup for pages
- **CSS3**: Modern styling with flexbox and responsive design
- **JavaScript (ES6+)**: Client-side logic and API communication
- **Fetch API**: AJAX requests to backend

### Backend
- **PHP 7.4+**: Server-side scripting
- **PDO**: Database abstraction layer
- **Sessions**: User authentication state

### Database
- **MySQL 5.7+**: Relational database
- **InnoDB**: Storage engine with foreign key support

### Architecture
- **RESTful API**: Clean API design
- **MVC Pattern**: Separation of concerns
- **Session-based Auth**: Secure authentication

## Data Flow

### Authentication State
```
1. User logs in → Session created
2. Session stored on server
3. Session ID sent to client as cookie
4. Client sends cookie with each request
5. Server validates session
6. Access granted/denied based on session
```

### Blog Data Flow
```
Client (Browser)
    ↕ AJAX (Fetch API)
API Endpoints (PHP)
    ↕ PDO
Database (MySQL)
```

## Security Layers

1. **Input Validation**
   - Client-side: JavaScript validation
   - Server-side: PHP validation

2. **SQL Injection Prevention**
   - Prepared statements with PDO

3. **XSS Prevention**
   - HTML escaping in JavaScript
   - textContent instead of innerHTML

4. **Authentication**
   - Session-based authentication
   - Password hashing with bcrypt

5. **Authorization**
   - Ownership verification
   - Route protection

## Component Interactions

### Authentication Components
```
auth.html ←→ app.js ←→ login.php/register.php ←→ db.php ←→ MySQL
                  ↓
            check_auth.php (Session Check)
```

### Blog Components
```
index.html ←→ app.js ←→ api_blogs.php ←→ db.php ←→ MySQL
editor.html ←→ app.js ←→ api_blogs.php ←→ db.php ←→ MySQL
view.html ←→ app.js ←→ api_blogs.php ←→ db.php ←→ MySQL
```

## File Dependencies

### index.html depends on:
- style.css (styling)
- app.js (blog loading, authentication check)
- api_blogs.php (fetch blogs)
- check_auth.php (check login status)

### auth.html depends on:
- style.css (styling)
- app.js (authentication functions)
- register.php (user registration)
- login.php (user login)

### editor.html depends on:
- style.css (styling)
- app.js (blog CRUD, authentication)
- api_blogs.php (create/update blog)
- check_auth.php (require login)

### view.html depends on:
- style.css (styling)
- app.js (blog display, delete)
- api_blogs.php (fetch blog, delete blog)
- check_auth.php (check ownership)

## Database Relationships

```
users (1) ←→ (N) blogs
  ↓
  Cascade delete: If user is deleted, their blogs are deleted
```

## Session Management

```
Login:
1. Validate credentials
2. Create session
3. Store user_id, username, email in session
4. Return success

Authentication Check:
1. Check if session exists
2. Check if user_id in session
3. Return user data or not authenticated

Logout:
1. Destroy session
2. Clear session data
3. Return success
```

## Frontend State Management

```javascript
// Global state in app.js
currentUser = {
    id: number,
    username: string,
    email: string
} | null

// Updated on:
- Page load (checkAuthentication)
- Login (login function)
- Logout (logout function)
```

## API Response Format

All API responses follow this format:
```json
{
    "success": boolean,
    "message": string,
    "data": object (optional)
}
```

## Error Handling

### Client-side (JavaScript)
```javascript
try {
    const response = await fetch(url);
    const data = await response.json();
    if (data.success) {
        // Handle success
    } else {
        // Handle error
    }
} catch (error) {
    // Handle network error
}
```

### Server-side (PHP)
```php
try {
    // Database operation
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error']);
}
```

## Responsive Breakpoints

- **Desktop**: > 768px
- **Tablet**: 768px
- **Mobile**: < 768px

CSS media queries handle responsive layout adjustments.
