# 📚 Personalized Learning Platform - LearnLab

**A mini project by Abhiram A.K. (20MCA245) - Mangalam College of Engineering**

## 📖 Project Overview

**LearnLab** is a web-based AI-powered personalized learning platform designed to enhance student engagement and facilitate tailored educational experiences. This platform delivers custom study materials, supports teacher-student interactions, and leverages AI to recommend learning resources based on individual student needs and progress. It aims to make learning more effective, engaging, and accessible.

## 📑 Table of Contents
- [🌟 Features](#features)
- [🛠 Technologies Used](#technologies-used)
- [💻 Installation](#installation)
  - [🔧 Set Up Backend](#set-up-backend)
  - [📥 Install Dependencies](#install-dependencies)
  - [🚀 Run the Project](#run-the-project)
- [📌 Usage](#usage)
- [📂 Modules](#modules)
- [🏗 System Architecture](#system-architecture)
- [🤝 Contributing](#contributing)
- [🙏 Acknowledgments](#acknowledgments)

## 🌟 Features

- **Personalized Learning**: Tailored content recommendations using AI algorithms.
- **Student and Teacher Interaction**: 💬 Direct messaging and support for clearing doubts.
- **Admin Management**: 🛠 Tools for managing users, content, and system settings.
- **AI-Driven Recommendations**: 🤖 Intelligent suggestions based on user activity and preferences.
- **Voice Assistant Access**: 🎙️ Students can use an integrated AI assistant for quick help.

## 🛠 Technologies Used

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**:MySQL
- **AI Framework**: AI-based recommendation system for personalized content
- **Other Libraries/Tools**: bcrypt (for password hashing), Git (version control), GitHub (repository)

## 💻 Installation

### 🔧 Set Up Backend

1. **Install PHP and MySQL** on your machine.
2. **Import the Project Database**: Import the `database.sql` file into MySQL to set up the initial database structure.
3. **Configure Environment Variables**:
   - Set up necessary environment variables for EmailJS and database connections.

### 📥 Install Dependencies
Run the following command to install necessary dependencies:
```bash
npm install
```

### 🚀 Run the Project
Start the server using the following command:
```bash
php -S localhost:8000
```

## 📌 Usage

- **Admin Panel**: 🔑 Access and manage users, oversee content uploads, and monitor platform statistics.
- **Teacher Module**: 📘 Upload study materials, answer student queries, and manage interactions.
- **Student Module**: 🎓 Access recommended resources, ask questions, and use the AI assistant for help.

## 📂 Modules

- **Admin**: 🛠 Manages platform content, users, and configurations.
- **Teacher**: 👩‍🏫 Uploads content, interacts with students, and supports academic needs.
- **Student**: 🎓 Engages with personalized learning materials and accesses support resources.

## 🏗 System Architecture

The platform is structured to support a smooth flow of interactions between admins, teachers, and students, with an AI recommendation engine analyzing user data to improve learning outcomes.

## 🤝 Contributing

1. Fork the repository.
2. Create your feature branch:
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. Commit your changes:
   ```bash
   git commit -m 'Add some feature'
   ```
4. Push to the branch:
   ```bash
   git push origin feature/your-feature-name
   ```
5. Open a Pull Request.

## 🙏 Acknowledgments

- **Project Guide**: Banu
- **Department**: MCA Department, Mangalam College of Engineering
- Special Thanks to all the contributors and supporters of this project.
