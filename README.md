

````markdown
# Task Manager — PHP & MySQL Task Management Application

A web-based **Task Management Application** developed with **PHP and MySQL**.

Task Manager allows users to create, organize, update, and manage their personal tasks while providing authentication, email verification, password reset, categories, priorities, and due dates.

---

## 📋 Overview

**Task Manager** is a PHP-based Task Management Application designed to help users manage their daily tasks through a simple and responsive web interface.

The project focuses on practicing **Full Stack Web Development** using PHP, MySQL, PDO, HTML5, CSS3, JavaScript, Bootstrap, and PHP Sessions.

The application includes user authentication, email verification, password management, task CRUD operations, categories, priorities, due dates, and pagination.

This project was developed as an academic / educational project to strengthen practical Web Development skills.

---

## ✨ Features

### 👤 User Authentication

- User registration
- User login
- User logout
- Session-based authentication
- Password hashing
- Password verification
- Email verification
- Password reset
- Change password

### 📝 Task Management

- Create tasks
- Display tasks
- Edit tasks
- Delete tasks
- Assign task priorities
- Assign task categories
- Set due dates
- Detect overdue tasks
- User-specific task management
- Pagination

### 🎨 User Interface

- Responsive design
- Bootstrap integration
- Custom CSS styling
- Font Awesome icons
- Interactive forms
- Client-side validation
- Responsive layouts

---

## 🛠️ Technologies

| Technology | Usage |
|---|---|
| `PHP` | Backend / Server-side logic |
| `MySQL` | Database management |
| `PDO` | Database access |
| `HTML5` | Page structure |
| `CSS3` | Styling and layouts |
| `JavaScript` | Client-side validation and interactions |
| `Bootstrap` | Responsive User Interface |
| `Font Awesome` | Icons |
| `PHP Sessions` | Authentication and session management |
| `mail()` | Email verification and password reset |

---

## 👨‍💻 My Contribution

My work on this project included:

- Designing and developing the PHP application.
- Implementing user registration and login.
- Implementing session-based authentication.
- Implementing email verification.
- Implementing password reset and password change functionality.
- Developing task creation, editing, listing, and deletion.
- Implementing task priorities and categories.
- Implementing pagination for task lists.
- Connecting the application to MySQL using PDO.
- Developing the Front-End using HTML5, CSS3, Bootstrap, and JavaScript.
- Organizing the project structure.
- Using Git and GitHub for version control.

---

## 📸 Screenshots

Screenshots of the application are available in the `screenShots/` directory.

### Home Page

![Home](screenShots/home.png)

### Registration

![sign up](screenShots/sign up.png)

### Dashboard

![Dashboard](screenShots/dashboard.png)

### Add Task

![Task List](screenShots/add task.png)



---

## 📁 Project Structure

```text
Task-Manager/
│
├── codeSource/
│   ├── about.php
│   ├── add_task.php
│   ├── change_password.php
│   ├── connexion.php
│   ├── dash.php
│   ├── delete.php
│   ├── design.php
│   ├── edit.php
│   ├── home.php
│   ├── list.php
│   ├── login.php
│   ├── logout.php
│   ├── reset_password.php
│   ├── sign up.php
│   ├── style.css
│   └── verification.php
│
├── assets/
│   ├── videos/
│   ├── images/
│   ├── mailHog/
│   └── dataBase.txt
│
├── screenShots/
│
└── README.md
```

---

## 🔄 Application Flow

### Authentication Flow

```text
sign up.php
      │
      ├── Validate user information
      ├── Hash password
      ├── Generate verification code
      └── Send verification email
               │
               ▼
        verification.php
               │
               ├── Verify account
               └── Activate user account
                        │
                        ▼
                    login.php
                        │
                        ├── Find user by email
                        ├── Verify password
                        └── Store user information in PHP session
                                 │
                                 ▼
                              dash.php
```

### Task Management Flow

```text
dash.php
   │
   ├── add_task.php
   │       └── Create a new task
   │
   ├── list.php
   │       ├── Display user's tasks
   │       ├── Apply pagination
   │       └── Display task information
   │
   ├── edit.php
   │       └── Update an existing task
   │
   └── delete.php
           └── Delete an existing task
```

### Password Reset Flow

```text
reset_password.php
        │
        ├── Request password reset
        └── Send reset information
                 │
                 ▼
        change_password.php
                 │
                 └── Update user password
```

---

## 🗄️ Database Structure

The application uses **MySQL** as its database management system.

The project uses a database named:

```text
todolist
```

The source code references the following tables:

```text
users
tasks
categorie
```

### `users`

Stores user account information such as:

- User ID
- User name
- Email
- Password

### `tasks`

Stores task information such as:

- Task ID
- User ID
- Title
- Description
- Due date
- Priority
- Category

### `categorie`

Stores task category information.

> The exact database schema should remain synchronized with the database definition provided in `assets/dataBase.txt`.

---

## ⚙️ Requirements

Before running the project, make sure you have:

- PHP 8.x or a compatible PHP version
- MySQL
- Apache, XAMPP, WAMP, Laragon, or PHP built-in server
- A modern web browser

The project also contains a `mailHog/` directory under `assets/` for the development email workflow.

---

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/soufiane-chbicheb/Task-Manager.git
```

Navigate to the project:

```bash
cd Task-Manager
```

### 2. Create the database

Create the MySQL database:

```sql
CREATE DATABASE todolist
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

### 3. Configure the database

Use the database information provided in:

```text
assets/dataBase.txt
```

to create or import the required tables.

### 4. Configure the PHP connection

Open:

```text
codeSource/connexion.php
```

and configure the database connection according to your local environment.

### 5. Run the project

You can use the PHP built-in development server:

```bash
php -S localhost:8000 -t codeSource
```

Then open:

```text
http://localhost:8000
```

You can also run the project using XAMPP, WAMP, or Laragon.

---

## 🔧 Configuration

The application contains configuration related to:

- MySQL connection
- PHP Sessions
- Email verification
- Password reset

For local development, configure the values according to your environment.

For production, sensitive information should **not** be committed to GitHub.

Use environment variables or a server-side configuration file for values such as:

```text
DB_HOST
DB_PORT
DB_NAME
DB_USER
DB_PASSWORD
```

---

## 📖 Usage

### Create an Account

1. Open the registration page.
2. Enter the required information.
3. Submit the registration form.
4. Complete email verification.
5. Login to the application.

### Manage Tasks

After logging in:

1. Open the dashboard.
2. Create a new task.
3. Add a title and description.
4. Select a category.
5. Select a priority.
6. Set a due date.
7. Save the task.
8. Edit or delete the task when required.

---

## 🔐 Authentication

The application provides:

- Registration
- Login
- Logout
- Email verification
- Password hashing
- Password verification
- Password reset
- Password change
- Session-based authentication

Passwords should be stored using:

```php
password_hash()
```

and verified using:

```php
password_verify()
```

---

## 📝 Task Management

The application implements the main **CRUD** operations:

```text
Create
   ↓
Read
   ↓
Update
   ↓
Delete
```

Users can manage their own tasks and assign:

- Title
- Description
- Category
- Priority
- Due date

The application also supports task pagination and overdue task detection.

---

## 🛡️ Security

The project uses several security mechanisms, including:

- `password_hash()` for password hashing
- `password_verify()` for password verification
- PDO prepared statements
- Session-based authentication
- User ownership checks
- Server-side validation
- `htmlspecialchars()` when displaying user-controlled values

### Security Improvements

Before using the application in a production environment, the following improvements are recommended:

- Add CSRF protection.
- Use secure, random, expiring password-reset tokens.
- Use secure email-verification tokens or codes.
- Add rate limiting for authentication and verification.
- Regenerate the session ID after successful login.
- Configure secure session cookies.
- Move database credentials outside the source code.
- Use HTTPS in production.
- Avoid displaying raw database errors to users.

---

## ⚠️ Known Issues

The current project version still requires some improvements before production use:

- Password reset should use secure, expiring, one-time tokens.
- Email verification should include expiration and attempt limits.
- CSRF protection should be added to state-changing forms.
- Database credentials should not be hard-coded in production.
- Authentication checks should be consistently applied to protected pages.
- User-name fields should remain consistent throughout the application.
- Task deletion should verify task ownership.
- All referenced images, videos, and other assets should be present in the repository.

---

## 🔮 Future Improvements

Possible future improvements include:

- CSRF protection
- Secure password-reset tokens
- Secure email-verification tokens
- Task completion status
- Search functionality
- Task filtering
- Task sorting
- Task statistics
- Category management
- Improved UI/UX
- Automated testing
- GitHub Actions CI
- PHPStan / static analysis
- Docker support
- Environment-based configuration
- MVC architecture
- Improved database organization
- Internationalization (`i18n`)

---

## 🌿 Git Workflow

The `main` branch should be protected and direct pushes should be avoided.

Recommended workflow:

```text
Feature Branch
      │
      ▼
Pull Request
      │
      ▼
Code Review
      │
      ▼
Status Checks
      │
      ▼
Merge
      │
      ▼
main
```

Example:

```bash
git checkout -b feature/add-task
```

After making changes:

```bash
git add .
git commit -m "feat: add task creation"
git push origin feature/add-task
```

Then create a **Pull Request** from the feature branch to `main`.

Recommended protection for `main`:

- Require Pull Requests before merging.
- Require approvals when working with collaborators.
- Require Status Checks to pass.
- Require conversation resolution.
- Disable force pushes.
- Disable branch deletion.
- Prevent bypassing protection rules when appropriate.

---

## 🤝 Contributing

Contributions are welcome.

1. Fork the repository.
2. Create a new branch.
3. Make your changes.
4. Test the application.
5. Commit your changes.
6. Push your branch.
7. Open a Pull Request.

Example:

```bash
git checkout -b feature/my-feature
git add .
git commit -m "feat: add my feature"
git push origin feature/my-feature
```

---

## 🎓 Project Type

**Academic / Educational Project — PHP & MySQL Web Application**

This project was developed to practice:

- Backend Web Development
- PHP
- MySQL
- Database management
- CRUD operations
- Authentication
- Session management
- Email verification
- Password management
- Front-End integration
- Git and GitHub

---

## 📚 Learning Objectives

This project provided practical experience with:

- Building a web application using PHP.
- Connecting PHP to MySQL using PDO.
- Designing CRUD functionality.
- Implementing authentication and sessions.
- Working with password hashing.
- Implementing email verification.
- Implementing password reset functionality.
- Organizing a multi-page PHP application.
- Building responsive interfaces.
- Using Git and GitHub for version control.
- Understanding basic Web Application Security.

---

## 👤 Author

**Soufiane Chbicheb**

Junior Full Stack Web Developer

- GitHub: [@soufiane-chbicheb](https://github.com/soufiane-chbicheb)
- LinkedIn: [Soufiane Chbicheb](https://www.linkedin.com/in/soufiane-chbicheb-344815429/)

---

## 📄 License

This project was created for academic and educational purposes.

If you want to allow other developers to reuse, modify, and distribute the project, add an appropriate open-source license such as the **MIT License** in a `LICENSE` file.

---

