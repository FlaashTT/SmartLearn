# SmartLearn

Welcome to the Online Courses Platform, a web system designed to connect instructors and students, enabling the creation, management, and participation in interactive courses on various topics such as technology, design, marketing, business, personal development, and more.

## 🚀 Main Features
- 👤 User registration and authentication (students and instructors)
- 📚 Course, module, and lesson management
- 📝 Student enrollment in courses
- 💳 Payment system for paid courses
- 🎓 Certificate issuance upon course completion
- ✅ Evaluation and quiz system
- 🏷️ Courses in multiple categories and topics

## 🛠️ Technologies Used
- **Backend**: PHP with MySQL
- **Frontend**: HTML, CSS, pure JavaScript
- **Security**: Password hashing with SHA-256, protection against SQL Injection
- **External Tools**: Google Forms for quizzes and feedback collection

## 🔧 Installation

### 1️⃣ Requirements
Before starting, make sure you have the following requirements installed:
- 🖥️ Web server (Apache or Nginx)
- 🐘 PHP 8.2.12 or higher
- 🗄️ MySQL 5.7 or higher

### 2️⃣ Clone the Repository
```sh
    git clone https://github.com/FlaashTT/SmartLearn
    cd SmartLearn
```

### 3️⃣ Configure the Database
1. Create a database in MySQL:
   ```sql
   CREATE DATABASE smartlearndb;
   ```
2. Import the `database.sql` file available in the project.


### 4️⃣ Set Up the Server
If using PHP's built-in server for testing:
```sh
    php -S localhost:8000 -t public
```
If using Apache, ensure the `.htaccess` file is correctly configured.

### 5️⃣ Access the Platform
Open your browser and visit:
```
    http://localhost:8000
```

## 🤝 Contribution
If you want to contribute to the project, fork it, create a new branch, and submit a pull request.

## 📜 License
This project is licensed under the MIT License.

