<?php
/* Name: M Umair | Reg No: 232201007 | Class: BSCS 6A 
   Institution: Khan Institute of Computer Science and IT */

session_start();
$currentPage = 'intake';
$pageTitle = 'Step 3 — Summary';

if (!isset($_SESSION['name']) || !isset($_SESSION['weight'])) {
    header('Location: step1.php');
    exit;
}

$confirmed = false;
$patientId = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    $patientId = rand(10000, 99999);
    $confirmed = true;
    session_unset();
    session_destroy();
}

$name     = $_SESSION['name'] ?? '';
$dob      = $_SESSION['dob'] ?? '';
$cnic     = $_SESSION['cnic'] ?? '';
$city     = $_SESSION['city'] ?? '';
$bp       = $_SESSION['bp'] ?? '';
$diabetes = $_SESSION['diabetes'] ?? '';
$weight   = $_SESSION['weight'] ?? 0;
$height   = $_SESSION['height'] ?? 0;

$bmi = 0;
$bmiClass = '';
$bmiLabel = '';
if ($height > 0) {
    $bmi = $weight / pow($height / 100, 2);
    $bmi = round($bmi, 2);
    if ($bmi < 18.5) { $bmiClass = 'underweight'; $bmiLabel = 'Underweight'; }
    elseif ($bmi < 25) { $bmiClass = 'normal'; $bmiLabel = 'Normal'; }
    elseif ($bmi < 30) { $bmiClass = 'overweight'; $bmiLabel = 'Overweight'; }
    else { $bmiClass = 'obese'; $bmiLabel = 'Obese'; }
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
      .row{ display:flex; justify-content:space-between; gap:14px; padding:10px 14px; border-bottom:1px solid var(--border); font-size:14px; }
      .row:last-child{ border-bottom:none; }
      .label{ color:var(--muted); font-weight:600; }
      .value{ font-weight:500; text-align:right; max-width:60%; }
      .bmi-box{ margin-top:12px; padding:14px; border-radius:12px; text-align:center; font-size:15px; font-weight:600; }
      .bmi-box.underweight{ background:#fef3c7; color:#d97706; }
      .bmi-box.normal{ background:#dcfce7; color:#16a34a; }
      .bmi-box.overweight{ background:#fef3c7; color:#d97706; }
      .bmi-box.obese{ background:#fee2e2; color:#dc2626; }
      .btn-row{ display:flex; gap:10px; margin-top:18px; }
      button{ padding:10px 20px; border-radius:12px; font-size:14px; font-weight:600; cursor:pointer; }
      button[name="confirm"]{ background:#16a34a; color:#fff; border:1px solid #16a34a; }
      button[name="confirm"]:hover{ background:#15803d; }
      .success-card{ text-align:center; padding:30px; }
      .success-card h1{ color:#16a34a; }
      .id-badge{ display:inline-block; margin-top:14px; padding:12px 28px; border-radius:12px; background:#dcfce7; color:#16a34a; font-size:28px; font-weight:700; letter-spacing:2px; border:2px solid rgba(22,163,74,.3); }
      .actions{ margin-top:16px; display:flex; gap:10px; flex-wrap:wrap; justify-content:center; }
      a.btn{ display:inline-flex; padding:10px 14px; border-radius:10px; border:1px solid var(--border); text-decoration:none; color:var(--text); background:#f8fafc; font-size:13px; font-weight:500; }
      a.btn:hover{ border-color:var(--accent); color:var(--accent); }
    </style>

    <div class="page-content">
      <div class="wrap">
        <?php if ($confirmed): ?>
        <section class="card success-card">
          <h1>Patient Intake Confirmed</h1>
          <p>Your information has been recorded successfully.</p>
          <div class="id-badge">#<?= $patientId ?></div>
          <p style="margin-top:14px;">Please save this Patient ID for your records.</p>
          <div class="actions"><a class="btn" href="step1.php">New Intake</a></div>
        </section>
        <?php else: ?>
        <section class="card">
          <h1>Multi-Step Patient Intake</h1>
          <p>Step 3 of 3 — Review &amp; Confirm</p>
          <div class="steps"><div class="step-dot active"></div><div class="step-dot active"></div><div class="step-dot active"></div></div>
          <h2>Personal Information</h2>
          <div class="row"><span class="label">Full Name</span><span class="value"><?= htmlspecialchars($name) ?></span></div>
          <div class="row"><span class="label">Date of Birth</span><span class="value"><?= htmlspecialchars($dob) ?></span></div>
          <div class="row"><span class="label">CNIC</span><span class="value"><?= htmlspecialchars($cnic) ?></span></div>
          <div class="row"><span class="label">City</span><span class="value"><?= htmlspecialchars($city) ?></span></div>
          <h2>Health Information</h2>
          <div class="row"><span class="label">Blood Pressure</span><span class="value"><?= htmlspecialchars($bp) ?></span></div>
          <div class="row"><span class="label">Diabetes</span><span class="value"><?= htmlspecialchars($diabetes) ?></span></div>
          <div class="row"><span class="label">Weight</span><span class="value"><?= $weight ?> kg</span></div>
          <div class="row"><span class="label">Height</span><span class="value"><?= $height ?> cm</span></div>
          <h2>BMI Analysis</h2>
          <div class="row"><span class="label">BMI Value</span><span class="value"><?= $bmi ?></span></div>
          <div class="bmi-box <?= $bmiClass ?>">
            <?= $bmiLabel ?>
            <?php if ($bmi < 18.5): ?> — BMI below 18.5
            <?php elseif ($bmi < 25): ?> — BMI between 18.5 and 24.9
            <?php elseif ($bmi < 30): ?> — BMI between 25 and 29.9
            <?php else: ?> — BMI 30 or above <?php endif; ?>
          </div>
          <form method="POST" action="">
            <div class="btn-row">
              <a class="btn" href="step2.php">&larr; Back</a>
              <button type="submit" name="confirm" value="1">Confirm &amp; Generate ID</button>
            </div>
          </form>
        </section>
        <?php endif; ?>
      </div>
    </div>
  </body>
</html>
