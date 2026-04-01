<?php
/* Name: M Umair | Reg No: 232201007 | Class: BSCS 6A 
   Institution: Khan Institute of Computer Science and IT */

session_start();
$currentPage = 'intake';
$pageTitle = 'Step 2 — Health Info';

if (!isset($_SESSION['name'])) {
    header('Location: step1.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['back'])) {
        header('Location: step1.php');
        exit;
    }
    $_SESSION['bp']       = trim($_POST['bp'] ?? '');
    $_SESSION['diabetes'] = trim($_POST['diabetes'] ?? '');
    $_SESSION['weight']   = (float)($_POST['weight'] ?? 0);
    $_SESSION['height']   = (float)($_POST['height'] ?? 0);
    header('Location: step3.php');
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
      input[type="text"], input[type="number"], select{ width:100%; margin-top:4px; padding:10px 12px; border:1px solid var(--border); border-radius:10px; font-size:14px; font-family:inherit; color:var(--text); background:#f8fafc; }
      input:focus, select:focus{ outline:none; border-color:var(--accent); box-shadow:0 0 0 3px rgba(37,99,235,.12); }
      .btn-row{ display:flex; gap:10px; margin-top:18px; }
      button{ padding:10px 20px; border-radius:12px; font-size:14px; font-weight:600; cursor:pointer; }
      button[type="submit"]{ background:var(--accent); color:#fff; border:1px solid var(--accent); }
      button[type="submit"]:hover{ background:#1d4ed8; }
      button[name="back"]{ background:#f8fafc; color:var(--text); border:1px solid var(--border); }
      button[name="back"]:hover{ border-color:var(--accent); color:var(--accent); }
    </style>

    <div class="page-content">
      <div class="wrap">
        <section class="card">
          <h1>Multi-Step Patient Intake</h1>
          <p>Step 2 of 3 — Health Information</p>
          <div class="steps"><div class="step-dot active"></div><div class="step-dot active"></div><div class="step-dot"></div></div>
          <form method="POST" action="">
            <label for="bp">Blood Pressure</label>
            <input type="text" id="bp" name="bp" placeholder="e.g. 120/80" value="<?= htmlspecialchars($_SESSION['bp'] ?? '') ?>" required />
            <label for="diabetes">Diabetes</label>
            <select id="diabetes" name="diabetes" required>
              <option value="">-- Select --</option>
              <option value="No" <?= ($_SESSION['diabetes'] ?? '') === 'No' ? 'selected' : '' ?>>No</option>
              <option value="Type 1" <?= ($_SESSION['diabetes'] ?? '') === 'Type 1' ? 'selected' : '' ?>>Type 1</option>
              <option value="Type 2" <?= ($_SESSION['diabetes'] ?? '') === 'Type 2' ? 'selected' : '' ?>>Type 2</option>
              <option value="Gestational" <?= ($_SESSION['diabetes'] ?? '') === 'Gestational' ? 'selected' : '' ?>>Gestational</option>
            </select>
            <label for="weight">Weight (kg)</label>
            <input type="number" id="weight" name="weight" step="0.1" min="1" value="<?= htmlspecialchars($_SESSION['weight'] ?? '') ?>" required />
            <label for="height">Height (cm)</label>
            <input type="number" id="height" name="height" step="0.1" min="1" value="<?= htmlspecialchars($_SESSION['height'] ?? '') ?>" required />
            <div class="btn-row">
              <button type="submit" name="back" value="1">&larr; Back</button>
              <button type="submit">Next Step &rarr;</button>
            </div>
          </form>
        </section>
      </div>
    </div>
  </body>
</html>
