# 🏥 City Care Clinic - Hospital Management System

A comprehensive, modular Hospital Management System built with **PHP 8+**, **JSON**, and **Bootstrap**. This project was developed as part of the Web Engineering Lab Assignment to demonstrate server-side logic, data persistence without SQL, and advanced session management.

---

## 📺 Project Video Demonstration
Check out the full walkthrough and feature demo of this system on YouTube:
👉 **[Watch the Project Demo Here](https://youtu.be/CqmoBCxEY3c?si=W6-xQSfk0TwoAPbd)**

---

## 👤 Developer Information
* **Name:** M Umair
* **Registration No:** 232201007
* **Class:** BSCS 6A
* **Institution:** Khan Institute of Computer Science and IT
* **Submitted To:** Sir Husain Gilani

---

## 🚀 Key Features

### 1. Dynamic Dashboard & UI
* A centralized hub (`index.php`) providing access to all 6 clinic modules.
* Modern UI featuring **blurred backgrounds** and professional medical-themed aesthetics.
* Fully responsive navigation bar available on every page.

### 2. Patient Registry (Full CRUD)
* **Create:** Register new patients with automatic ID generation (starting at 1001).
* **Read:** Real-time display of patient records from local storage.
* **Update:** Inline editing of patient details.
* **Delete:** Remove records with a secure JavaScript confirmation.
* **Persistence:** All data is stored locally in `patients_data.json` (No Database Required).

### 3. Smart Appointment System
* Server-side validation to prevent past-date bookings.
* "Sticky" form logic that retains user input during validation errors.
* Character limits and data sanitization for patient safety.

### 4. Doctor Scheduling Logic
* Uses multidimensional associative arrays to manage staff rosters.
* Dynamic filtering using a custom `getDoctorsByDay()` function.
* Automated calculation of average consultation fees using `array_column()`.

### 5. Medical Report Generator
* Advanced string processing: converts names to `strtoupper()`.
* Sanitizes messy diagnosis notes using `preg_replace()`.
* **Discharge Status:** Visual badges (Green/Red/Orange) to track patient movement.

### 6. Multi-Step Intake (Session Based)
* A 3-step wizard using `$_SESSION` to maintain state.
* **Step 1:** Personal/Identity details.
* **Step 2:** Health metrics (BP, Diabetes, Weight, Height).
* **Step 3:** BMI Calculation and classification (Normal, Overweight, etc.).
* Generates a unique 5-digit reference number upon completion.

---

## 🛠️ Installation & Setup

1.  **Download/Clone:** Place the project folder inside your XAMPP `htdocs` directory.
2.  **Permissions (Mac Users):**
    Open your terminal in the project folder and run:
    ```bash
    chmod 777 patients_data.json history_log.json
    ```
3.  **Run:** Open your browser and navigate to:
    `http://localhost/Your_Folder_Name/index.php`

---

## 📁 File Structure
* `index.php` - Main Dashboard
* `header.php` - Global Navbar & CSS
* `register.php` - CRUD Operations
* `schedule.php` - Doctor Roster
* `report.php` - Report Generator
* `step1.php` / `step2.php` / `step3.php` - Session-based Intake
* `patients_data.json` - Local Data Storage

---

## 📜 License
This project was developed for academic purposes at the Khan Institute of Computer Science and IT.
