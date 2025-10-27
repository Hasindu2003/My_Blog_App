# API Documentation

## Authentication Endpoints

### Register User
**Endpoint**: `POST /register.php`

**Request Body**:
```json
{
  "username": "string",
  "email": "string",
  "password": "string",
  "confirm_password": "string"
}
```

**Response**:
```json
{
  "success": true,
  "message": "Registration successful"
}
```

**Validation Rules**:
- All fields are required
- Email must be valid format
- Password minimum 6 characters
- Passwords must match
- Username must be unique
- Email must be unique

---

### Login User
**Endpoint**: `POST /login.php`

**Request Body**:
```json
{
  "username": "string",
  "password": "string"
}
```

**Response**:
```json
{
  "success": true,
  "message": "Login successful",
  "user": {
    "id": 1,
    "username": "johndoe",
    "email": "john@example.com"
  }
}
```

---

### Logout User
**Endpoint**: `GET /logout.php`

**Response**:
```json
{
  "success": true,
  "message": "Logged out successfully"
}
```

---

### Check Authentication
**Endpoint**: `GET /check_auth.php`

**Response (Authenticated)**:
```json
{
  "authenticated": true,
  "user": {
    "id": 1,
    "username": "johndoe",
    "email": "john@example.com"
  }
}
```

**Response (Not Authenticated)**:
```json
{
  "authenticated": false
}
```

---

## Blog Endpoints

### Get All Blogs
**Endpoint**: `GET /api_blogs.php`

**Query Parameters**:
- `user_only=true` (optional) - Get only current user's blogs

**Response**:
```json
{
  "success": true,
  "blogs": [
    {
      "id": 1,
      "user_id": 1,
      "title": "My First Blog",
      "content": "Blog content here...",
      "username": "johndoe",
      "created_at": "2025-01-01 12:00:00",
      "updated_at": "2025-01-01 12:00:00"
    }
  ]
}
```

---

### Get Single Blog
**Endpoint**: `GET /api_blogs.php?id={blog_id}`

**Response**:
```json
{
  "success": true,
  "blog": {
    "id": 1,
    "user_id": 1,
    "title": "My First Blog",
    "content": "Blog content here...",
    "username": "johndoe",
    "created_at": "2025-01-01 12:00:00",
    "updated_at": "2025-01-01 12:00:00"
  }
}
```

---

### Create Blog
**Endpoint**: `POST /api_blogs.php`

**Authentication**: Required

**Request Body**:
```json
{
  "title": "string",
  "content": "string"
}
```

**Response**:
```json
{
  "success": true,
  "message": "Blog created successfully",
  "blog_id": 1
}
```

**Validation Rules**:
- User must be authenticated
- Title and content are required
- Title and content cannot be empty

---

### Update Blog
**Endpoint**: `PUT /api_blogs.php`

**Authentication**: Required

**Request Body**:
```json
{
  "id": 1,
  "title": "string",
  "content": "string"
}
```

**Response**:
```json
{
  "success": true,
  "message": "Blog updated successfully"
}
```

**Authorization Rules**:
- User must be authenticated
- User must own the blog
- Returns 403 if user doesn't own the blog
- Returns 404 if blog doesn't exist

---

### Delete Blog
**Endpoint**: `DELETE /api_blogs.php`

**Authentication**: Required

**Request Body**:
```json
{
  "id": 1
}
```

**Response**:
```json
{
  "success": true,
  "message": "Blog deleted successfully"
}
```

**Authorization Rules**:
- User must be authenticated
- User must own the blog
- Returns 403 if user doesn't own the blog
- Returns 404 if blog doesn't exist

---

## Error Responses

All endpoints may return the following error responses:

**401 Unauthorized** (Authentication required):
```json
{
  "success": false,
  "message": "Unauthorized"
}
```

**403 Forbidden** (Insufficient permissions):
```json
{
  "success": false,
  "message": "You can only edit your own blogs"
}
```

**404 Not Found**:
```json
{
  "success": false,
  "message": "Blog not found"
}
```

**405 Method Not Allowed**:
```json
{
  "success": false,
  "message": "Method not allowed"
}
```

**500 Internal Server Error**:
```json
{
  "success": false,
  "message": "Database error occurred"
}
```

---

## Database Schema

### Users Table
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Blogs Table
```sql
CREATE TABLE blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

---

## Security Features

1. **Password Security**
   - Passwords are hashed using PHP's `password_hash()` function
   - Uses bcrypt algorithm by default

2. **SQL Injection Protection**
   - All queries use PDO prepared statements
   - No raw SQL with user input

3. **Session Security**
   - Session-based authentication
   - Sessions destroyed on logout

4. **Authorization**
   - Ownership checks on edit/delete operations
   - Protected routes redirect to login

5. **Input Validation**
   - All user inputs are validated
   - Email format validation
   - Password strength requirements
   - Required field checks

6. **XSS Protection**
   - HTML content is escaped in frontend
   - Uses textContent for user-generated content
