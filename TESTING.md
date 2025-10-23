# Testing Guide for My Blog App

## Manual Testing Checklist

### Prerequisites
1. Set up MySQL database using `setup.sql`
2. Configure `config.php` with your database credentials
3. Start PHP server: `php -S localhost:8000`

### Test Cases

#### User Authentication

**Test 1: User Registration**
1. Navigate to `http://localhost:8000/auth.html?register=true`
2. Enter username, email, password, and confirm password
3. Click "Register"
4. Expected: Success message and redirect to login form

**Test 2: Registration Validation**
- Test empty fields → Should show error
- Test mismatched passwords → Should show error
- Test password < 6 characters → Should show error
- Test invalid email format → Should show error
- Test duplicate username → Should show error
- Test duplicate email → Should show error

**Test 3: User Login**
1. Navigate to `http://localhost:8000/auth.html`
2. Enter valid username and password
3. Click "Login"
4. Expected: Success message and redirect to home page with username displayed

**Test 4: Login Validation**
- Test empty fields → Should show error
- Test invalid credentials → Should show error

**Test 5: User Logout**
1. While logged in, click "Logout" button
2. Expected: Redirect to home page, login/register links visible

#### Blog Management

**Test 6: View All Blogs (Unauthenticated)**
1. Navigate to `http://localhost:8000/index.html` without logging in
2. Expected: Can view all blogs, no "Create New Blog" button

**Test 7: Create Blog (Unauthenticated)**
1. Without logging in, try to access `http://localhost:8000/editor.html`
2. Expected: Redirect to login page

**Test 8: Create New Blog**
1. Login as a user
2. Click "Create New Blog" button on home page
3. Enter title and content
4. Click "Publish"
5. Expected: Success message and redirect to home page with new blog visible

**Test 9: Create Blog Validation**
- Test empty title → Should show error
- Test empty content → Should show error

**Test 10: View Single Blog**
1. From home page, click "Read More" on any blog
2. Expected: Full blog content displayed with author and date

**Test 11: Edit Own Blog**
1. View a blog you created
2. Click "Edit" button
3. Modify title and/or content
4. Click "Update"
5. Expected: Success message and updated blog displayed

**Test 12: Edit Other User's Blog**
1. Try to access `http://localhost:8000/editor.html?id=X` where X is another user's blog
2. Expected: Error message and redirect to home page

**Test 13: Delete Own Blog**
1. View a blog you created
2. Click "Delete" button
3. Confirm deletion
4. Expected: Success message and redirect to home page, blog removed

**Test 14: Delete Other User's Blog**
1. Try to delete another user's blog via API
2. Expected: 403 Forbidden error

#### UI/UX Testing

**Test 15: Responsive Design**
1. Test on desktop (1920x1080)
2. Test on tablet (768x1024)
3. Test on mobile (375x667)
4. Expected: Layout adjusts properly for all screen sizes

**Test 16: Navigation**
1. Test all navigation links
2. Expected: All links work correctly

**Test 17: Error Messages**
1. Test various error scenarios
2. Expected: Clear, helpful error messages displayed

**Test 18: Success Messages**
1. Test successful operations
2. Expected: Success messages displayed and auto-dismiss after 5 seconds

## Security Testing

### Authentication Security
- ✓ Passwords are hashed using `password_hash()`
- ✓ Sessions are used for authentication
- ✓ Protected routes redirect to login

### Authorization Security
- ✓ Users can only edit/delete their own blogs
- ✓ API endpoints check user ownership

### Input Validation
- ✓ All user inputs are validated
- ✓ SQL injection protection via prepared statements
- ✓ XSS protection via proper HTML escaping

### Session Security
- ✓ Session-based authentication
- ✓ Logout destroys session

## Performance Testing

1. Test with multiple users and blogs
2. Verify page load times
3. Check database query performance

## Browser Compatibility

Test on:
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)

## Known Limitations

1. No email verification on registration
2. No password reset functionality
3. No rich text editor (plain text only)
4. No image upload support
5. No pagination for blog list
6. No search functionality
7. No comments system

## Future Enhancements

1. Add email verification
2. Implement password reset
3. Add rich text editor (e.g., TinyMCE, Quill)
4. Add image upload and management
5. Implement pagination
6. Add search and filtering
7. Add comments and likes
8. Add user profiles
9. Add categories/tags
10. Add admin panel
