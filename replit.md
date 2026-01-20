# LearnEase - E-Learning Platform Frontend

## Overview
LearnEase is a clean, beginner-friendly e-learning platform frontend built with pure HTML and CSS. The design features a professional educational theme with responsive layouts optimized for desktop, tablet, and mobile devices. The frontend is structured to work seamlessly with a PHP-MySQL backend.

## Project Status
**Status:** Complete ✅  
**Last Updated:** October 23, 2025  
**Version:** 1.0

## Pages Included

1. **Home (index.html)** - Hero section, featured courses, features overview, and call-to-action
2. **About (about.html)** - Mission statement, values, statistics, and contact information
3. **Courses (courses.html)** - Course catalog with search/filter functionality and course listings
4. **Course Detail (course.html)** - Individual course page with curriculum, reviews, and enrollment
5. **Login (login.html)** - User authentication form with clean design
6. **Register (register.html)** - User registration form for students and instructors
7. **Student Dashboard (student-dashboard.html)** - Course progress, assignments, and recommendations
8. **Instructor Dashboard (instructor-dashboard.html)** - Course management, student stats, and pending tasks

## Technical Stack

### Frontend
- **HTML5** - Semantic markup for accessibility and SEO
- **CSS3** - Custom styling with CSS Grid and Flexbox
- **Design Pattern** - Mobile-first responsive approach
- **No Frameworks** - Pure HTML/CSS for beginner-friendliness

### Styling Features
- CSS Variables for theming and easy customization
- Reusable component classes (cards, buttons, forms, grids)
- Responsive layouts that adapt to all screen sizes
- Clean educational color scheme (blue, green, orange accents)
- Professional typography with system fonts

## Color Scheme
- **Primary Blue:** #4A90E2 - Trust, professionalism
- **Secondary Green:** #50C878 - Growth, success
- **Accent Orange:** #F39C12 - Energy, highlights
- **Dark Text:** #2C3E50 - Readability
- **Light Text:** #7F8C8D - Supporting content
- **Background:** #F8F9FA - Clean, minimal

## Key Features

### Design
- Consistent navigation across all pages
- Beautiful gradient hero sections
- Card-based layouts for content organization
- Progress bars for course tracking
- Badge system for course levels and status
- Hover effects and transitions for interactivity

### Responsive Design
- Mobile-first approach
- Breakpoint at 768px for tablet/mobile
- Flexible grid system (2, 3, and 4 column layouts)
- Collapsible navigation for mobile (structure ready)

### PHP Integration Ready
- Form actions point to PHP processing files:
  - `process-login.php` for login
  - `process-register.php` for registration
- All forms include proper name attributes for backend processing
- Semantic structure for easy backend integration

## File Structure
```
/
├── index.html                  # Home page
├── about.html                  # About page
├── courses.html                # Course catalog
├── course.html                 # Course detail page
├── login.html                  # Login page
├── register.html               # Registration page
├── student-dashboard.html      # Student dashboard
├── instructor-dashboard.html   # Instructor dashboard
├── styles.css                  # Global stylesheet
└── replit.md                   # This documentation
```

## Navigation Structure
All pages share consistent navigation:
- **Home** → index.html
- **About** → about.html
- **Courses** → courses.html
- **Login/Register** → login.html / register.html
- **Dashboard** → student-dashboard.html or instructor-dashboard.html (when logged in)

## Development Server
The project uses Python's built-in HTTP server for local development:
- **Server:** `python -m http.server 5000`
- **Access:** http://localhost:5000
- **Port:** 5000 (Replit-compatible)

## Browser Compatibility
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## For Developers

### Customization
- **Colors:** Modify CSS variables in `:root` selector in styles.css
- **Fonts:** Change font-family in body selector
- **Spacing:** Adjust utility classes (.mt-1, .mb-2, etc.)
- **Grid Layouts:** Use .grid-2, .grid-3, or .grid-4 classes

### Adding New Pages
1. Copy the HTML structure from an existing page
2. Include `<link rel="stylesheet" href="styles.css">`
3. Use the shared navigation structure
4. Apply existing CSS classes for consistency

### Form Integration
To connect forms to a PHP backend:
1. Update form action attributes with actual PHP file paths
2. Ensure proper name attributes on all inputs
3. Add server-side validation
4. Handle POST data securely

## Backend Integration Notes

### Expected Database Tables
- **users** (id, name, email, password, user_type, created_at)
- **courses** (id, title, description, instructor_id, price, rating, students_count)
- **enrollments** (id, student_id, course_id, progress, enrolled_at)
- **lessons** (id, course_id, title, content, duration, order)
- **assignments** (id, course_id, title, due_date, status)

### Session Management
The frontend expects session-based authentication:
- Login page submits to backend for authentication
- Dashboards should check for active session
- Logout button should clear session and redirect to home

## Future Enhancements
- JavaScript for interactive features (dropdowns, search, filters)
- Video player integration for lessons
- Real-time progress tracking
- Discussion forums
- Direct messaging between students and instructors
- Payment gateway integration (Stripe)
- Certificate generation system

## Credits
**Design:** Clean, modern e-learning aesthetic  
**Target Audience:** Students and Instructors  
**Skill Level:** Beginner-friendly HTML/CSS  
**Created:** October 2025
