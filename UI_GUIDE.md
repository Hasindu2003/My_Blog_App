# User Interface Guide

## Pages Overview

### 1. Home Page (index.html)
The home page displays all blog posts in a card layout.

**Features:**
- Header with logo and navigation
- Welcome message
- "Create New Blog" button (visible only when logged in)
- Blog cards showing:
  - Title
  - Author name
  - Publication date
  - Content excerpt (200 characters)
  - "Read More" button
- Responsive grid layout
- Footer

**URL:** `http://localhost:8000/index.html`

**Unauthenticated View:**
- Login and Register links in navigation
- No "Create New Blog" button
- Can view all blogs but cannot create

**Authenticated View:**
- Username and Logout button in navigation
- "Create New Blog" button visible
- Can view and create blogs

---

### 2. Authentication Page (auth.html)
Combined login and registration page with toggle functionality.

**Features:**
- Toggle between Login and Register forms
- Login form:
  - Username field
  - Password field
  - Submit button
  - Link to switch to registration
- Register form:
  - Username field
  - Email field
  - Password field
  - Confirm Password field
  - Submit button
  - Link to switch to login
- Real-time validation
- Error/success messages

**URL:** 
- Login: `http://localhost:8000/auth.html`
- Register: `http://localhost:8000/auth.html?register=true`

**Validation:**
- All fields required
- Email format validation
- Password minimum 6 characters
- Password confirmation match

---

### 3. Blog Editor (editor.html)
Page for creating new blogs or editing existing ones.

**Features:**
- Large text area for title
- Large textarea for content (minimum 300px height)
- Publish/Update button
- Cancel button
- Auto-save functionality could be added
- Character counter could be added

**URL:**
- Create: `http://localhost:8000/editor.html`
- Edit: `http://localhost:8000/editor.html?id=X`

**Authentication:**
- Requires user to be logged in
- Redirects to auth.html if not authenticated

**Authorization:**
- For editing: User must own the blog
- Shows error and redirects if user doesn't own the blog

---

### 4. Blog View (view.html)
Single blog post view with full content.

**Features:**
- Full blog title (large heading)
- Author name and publication date
- Updated date (if different from created date)
- Full blog content
- Edit button (only for blog owner)
- Delete button (only for blog owner)
- Back to Home button

**URL:** `http://localhost:8000/view.html?id=X`

**For Blog Owner:**
- Edit and Delete buttons visible
- Can modify or remove the blog

**For Other Users:**
- Only view and read the blog
- No edit/delete buttons

---

## Color Scheme

The application uses a purple gradient theme:

**Primary Colors:**
- Header Gradient: #667eea to #764ba2
- Button Primary: #667eea
- Button Hover: #5568d3

**Secondary Colors:**
- Background: #f4f4f4 (light gray)
- Card Background: #ffffff (white)
- Text: #333 (dark gray)
- Meta Text: #666 (medium gray)
- Content Text: #555 (gray)

**Accent Colors:**
- Success: #d4edda (light green)
- Error: #f8d7da (light red)
- Info: #d1ecf1 (light blue)

---

## Typography

**Font Family:** 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif

**Font Sizes:**
- Logo: 1.5rem
- Page Title: 2.5rem
- Blog Title (card): 1.8rem
- Blog Title (view): 2.5rem
- Editor Title: 2rem
- Body Text: 1rem
- Meta Text: 0.9rem
- Blog Content (view): 1.1rem

---

## Layout

### Desktop (> 768px)
- Container max-width: 1200px
- Blog cards: Full width with padding
- Navigation: Horizontal layout
- Forms: Centered with max-width 500px

### Tablet & Mobile (≤ 768px)
- Container: Full width with 20px padding
- Navigation: Vertical layout
- Blog cards: Stack vertically
- Forms: Full width responsive

---

## Interactive Elements

### Buttons
- Rounded corners (5px border-radius)
- Smooth hover transitions (0.3s)
- Different colors for different actions:
  - Primary (publish, save): #667eea
  - Secondary (cancel): #6c757d
  - Danger (delete): #dc3545

### Cards
- White background
- Subtle shadow: 0 2px 10px rgba(0,0,0,0.1)
- Hover effect: Slight lift and stronger shadow
- Rounded corners (8px border-radius)

### Forms
- Input fields with border
- Focus state: Purple border (#667eea)
- Placeholder text for guidance
- Error states in red

### Messages
- Auto-dismiss after 5 seconds
- Color-coded by type (success/error/info)
- Positioned at top of container

---

## User Flow Examples

### First-Time User
1. Lands on index.html
2. Sees blog list, Login/Register links
3. Clicks Register
4. Fills registration form
5. Sees success message
6. Automatically shown login form
7. Logs in
8. Redirected to home page
9. Sees "Create New Blog" button
10. Creates first blog post

### Returning User
1. Lands on index.html
2. Clicks Login
3. Enters credentials
4. Redirected to home page
5. Username shown in nav
6. Can create, edit, delete own blogs

### Reading Blogs
1. Lands on index.html
2. Scrolls through blog cards
3. Clicks "Read More"
4. Reads full blog
5. Clicks "Back to Home"
6. Continues browsing

---

## Accessibility Features

- Semantic HTML5 elements
- Proper heading hierarchy
- Form labels for all inputs
- Alt text support (for future image features)
- Keyboard navigation support
- Focus states visible
- Sufficient color contrast

---

## Responsive Design

The application is fully responsive across:
- Desktop computers (1920px+)
- Laptops (1366px - 1920px)
- Tablets (768px - 1366px)
- Mobile phones (320px - 768px)

**Responsive Features:**
- Flexible grid layout
- Stacking columns on small screens
- Touch-friendly buttons
- Readable text sizes
- Optimized for portrait and landscape

---

## Loading States

- Spinner animation while loading blogs
- "Loading..." text for user feedback
- Disabled buttons during form submission
- Button text changes (e.g., "Publishing...")

---

## Empty States

- "No blogs yet" message when no blogs exist
- "Be the first to create a blog post!" call-to-action
- Empty state styling matches overall design

---

## Error Handling

- Clear error messages
- Red alert boxes for errors
- Green alert boxes for success
- Auto-dismiss after 5 seconds
- Network error handling
- 404 page for missing blogs
- 403 for unauthorized actions

---

## Performance Considerations

- Minimal external dependencies
- Optimized CSS (no frameworks)
- Vanilla JavaScript (no jQuery)
- Efficient database queries
- Lazy loading potential for future

---

## Browser Compatibility

Tested and compatible with:
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

Uses modern JavaScript features:
- Async/await
- Fetch API
- ES6+ syntax
- Template literals

---

## Future UI Enhancements

Potential improvements:
1. Rich text editor (WYSIWYG)
2. Markdown support
3. Image upload and display
4. User avatars
5. Dark mode toggle
6. Blog categories/tags
7. Search functionality
8. Infinite scroll
9. Share buttons
10. Print styles
