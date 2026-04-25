# Contributing to Casa de Vida App

Thank you for your interest in contributing to the Casa de Vida management system! This document provides guidelines and information for contributors.

## Getting Started

### Prerequisites
- Modern web browser (Chrome, Firefox, Safari, Edge)
- Python 3.6 or higher (for local development server)
- Basic knowledge of HTML, CSS, and JavaScript

### Setup
1. Clone the repository
2. Navigate to the project directory
3. Start the development server: `python -m http.server 8080`
4. Open your browser and go to `http://localhost:8080`

## Development Guidelines

### Code Style
- Use 2 spaces for indentation
- Follow JavaScript ES6+ standards
- Use semantic HTML5 elements
- Follow Bootstrap 5 conventions for CSS
- Add comments for complex functionality

### File Organization
```
AppCasadeVida/
|-- css/           # Stylesheets
|-- js/            # JavaScript modules
|-- sounds/        # Audio files
|-- index.html     # Main application file
|-- README.md      # Documentation
```

### JavaScript Modules
- **database.js** - Data persistence and CRUD operations
- **auth.js** - User authentication and authorization
- **app.js** - Main application controller
- **crud.js** - Form handling and modal management
- **notifications.js** - Notification system
- **views.js** - Screen rendering and navigation
- **utils.js** - Utility functions
- **attendance.js** - Attendance management
- **fileManager.js** - File upload/download handling
- **charts.js** - Data visualization

## Feature Development

### Adding New Features
1. Create a new branch: `git checkout -b feature/new-feature`
2. Implement your changes
3. Test thoroughly
4. Update documentation if needed
5. Submit a pull request

### Database Changes
- All data is stored in localStorage as JSON
- Database structure is defined in `database.js`
- When adding new entities, update the `getEmptyDatabase()` method
- Ensure proper data validation

### UI Components
- Use Bootstrap 5 classes for consistency
- Follow the existing color scheme and design patterns
- Ensure responsive design for mobile devices
- Add proper ARIA labels for accessibility

## Testing

### Manual Testing Checklist
- [ ] Login/logout functionality
- [ ] Role-based access control
- [ ] CRUD operations for all entities
- [ ] File upload/download
- [ ] Attendance recording
- [ ] Notification system
- [ ] Charts and statistics
- [ ] Mobile responsiveness

### Browser Compatibility
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Bug Reports

When reporting bugs, please include:
1. Description of the issue
2. Steps to reproduce
3. Expected vs actual behavior
4. Browser and version
5. Screenshots if applicable

## Security Considerations

- Input validation for all user inputs
- XSS prevention in dynamic content
- Secure handling of file uploads
- Proper authentication checks
- No sensitive data in client-side storage

## Performance

- Minimize DOM manipulation
- Use event delegation where appropriate
- Optimize image loading
- Implement lazy loading for large datasets
- Cache frequently accessed data

## Documentation

### Code Comments
- Add JSDoc comments for functions
- Explain complex algorithms
- Document API endpoints (if any)
- Include examples for usage

### README Updates
- Update installation instructions
- Add new features to feature list
- Update screenshots if UI changes
- Maintain version history

## Release Process

1. Update version number in `package.json`
2. Update `README.md` with new features
3. Test thoroughly on multiple browsers
4. Create a git tag: `git tag v1.0.0`
5. Push to repository

## Community Guidelines

### Code of Conduct
- Be respectful and inclusive
- Provide constructive feedback
- Help others learn and grow
- Follow professional communication standards

### Communication
- Use clear and descriptive commit messages
- Explain the "why" behind changes
- Ask questions if something is unclear
- Share knowledge with the community

## Contributing Types

### Bug Fixes
- Small, targeted fixes
- Include test cases if possible
- Document the fix

### Features
- New functionality
- UI improvements
- Performance enhancements

### Documentation
- README improvements
- Code comments
- User guides
- API documentation

### Infrastructure
- Build tools
- Deployment scripts
- CI/CD improvements

## Getting Help

- Check existing issues for similar problems
- Read the documentation thoroughly
- Ask questions in discussions
- Join our community channels

## Recognition

Contributors will be recognized in:
- README.md contributors section
- Release notes
- Commit history
- Community highlights

Thank you for contributing to Casa de Vida! Your contributions help make this system better for everyone.
