<?php
/* Name: M Umair | Reg No: 232201007 | Class: BSCS 6A 
   Institution: Khan Institute of Computer Science and IT */

session_start();
$currentPage = 'intake';
$pageTitle = 'Step 1 — Personal Info';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['name']  = trim($_POST['name'] ?? '');
    $_SESSION['dob']   = trim($_POST['dob'] ?? '');
    $_SESSION['cnic']  = trim($_POST['cnic'] ?? '');
    $_SESSION['city']  = trim($_POST['city'] ?? '');
    header('Location: step2.php');
    exit;
}

include 'header.php';
?>
  <body style="background-image:url('https://images.unsplash.com/photo-1538108149393-fbbd81895907?w=1920&q=80')">
    <nav class="navbar">
      <a class="navbar-logo" href="index.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg><div><span>City Care Clinic</span><small>Hospital Management System</small></div></a>
      <button class="nav-toggle" onclick="document.querySelector('.navbar-links').classList.toggle('open')" aria-label="Menu"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button>
      <ul class="navbar-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="task2_patient_registration.php">Register</a></li>
        <li><a href="task3_appointment_booking.php">Appointment</a></li>
        <li><a href="schedule.php">Schedule</a></li>
        <li><a href="report.php">Report</a></li>
        <li><a href="step1.php" class="active">Intake</a></li>
      </ul>
    </nav>

    <style>
      .steps{ display:flex; gap:8px; margin:16px 0; }
      .step-dot{ flex:1; height:6px; border-radius:999px; background:var(--border); }
      .step-dot.active{ background:var(--accent); }
      label{ display:block; margin-top:14px; font-weight:600; font-size:14px; }
      input[type="text"], input[type="date"]{ width:100%; margin-top:4px; padding:10px 12px; border:1px solid var(--border); border-radius:10px; font-size:14px; font-family:inherit; color:var(--text); background:#f8fafc; }
      input:focus{ outline:none; border-color:var(--accent); box-shadow:0 0 0 3px rgba(37,99,235,.12); }
      button{ margin-top:18px; padding:10px 20px; border:1px solid var(--accent); border-radius:12px; background:var(--accent); color:#fff; font-size:14px; font-weight:600; cursor:pointer; }
      button:hover{ background:#1d4ed8; }
    </style>

    <div class="page-content">
      <div class="wrap">
        <section class="card">
          <h1>Multi-Step Patient Intake</h1>
          <p>Step 1 of 3 — Personal Information</p>
          <div class="steps"><div class="step-dot active"></div><div class="step-dot"></div><div class="step-dot"></div></div>
          <form method="POST" action="">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($_SESSION['name'] ?? '') ?>" required />
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" value="<?= htmlspecialchars($_SESSION['dob'] ?? '') ?>" required />
            <label for="cnic">CNIC</label>
            <input type="text" id="cnic" name="cnic" placeholder="XXXXX-XXXXXXX-X" value="<?= htmlspecialchars($_SESSION['cnic'] ?? '') ?>" required />
            <label for="city">City</label>
            <input type="text" id="city" name="city" value="<?= htmlspecialchars($_SESSION['city'] ?? '') ?>" required />
            <button type="submit">Next Step &rarr;</button>
          </form>
        </section>
      </div>
    </div>
  </body>
</html>
