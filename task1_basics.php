<?php
/* Name: M Umair | Reg No: 232201007 | Class: BSCS 6A 
   Institution: Khan Institute of Computer Science and IT */

$currentPage = 'home';
$pageTitle = 'PHP Basics';

$clinicName = 'City Care Clinic';
$establishedYear = 2005;
$consultationFee = 500.00;
$isOpenToday = true;

$currentYear = (int) date('Y');
$yearsInService = max(0, $currentYear - $establishedYear);

$statusText = $isOpenToday
  ? 'Clinic is OPEN today — Walk-ins Welcome'
  : 'Clinic is CLOSED today — Please call ahead';
$statusClass = $isOpenToday ? 'ok' : 'bad';

include 'header.php';
?>
  <body style="background-image:url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=1920&q=80')">
    <nav class="navbar">
      <a class="navbar-logo" href="index.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg><div><span>City Care Clinic</span><small>Hospital Management System</small></div></a>
      <button class="nav-toggle" onclick="document.querySelector('.navbar-links').classList.toggle('open')" aria-label="Menu"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button>
      <ul class="navbar-links">
        <li><a href="index.php" class="active">Home</a></li>
        <li><a href="task2_patient_registration.php">Register</a></li>
        <li><a href="task3_appointment_booking.php">Appointment</a></li>
        <li><a href="schedule.php">Schedule</a></li>
        <li><a href="report.php">Report</a></li>
        <li><a href="step1.php">Intake</a></li>
      </ul>
    </nav>

    <style>
      .row{ display:flex; justify-content:space-between; gap:14px; padding:12px 14px; border-radius:10px; border:1px solid var(--border); background:#f8fafc; }
      .row + .row{ margin-top:8px; }
      .label{ color:var(--muted); }
      .value{ font-weight:650; }
      .status-box{ margin-top:14px; padding:14px; border-radius:12px; border:1px solid var(--border); background:#f8fafc; font-weight:600; font-size:14px; }
      .status-box.ok{ border-color:rgba(22,163,74,.3); }
      .status-box.bad{ border-color:rgba(220,38,38,.3); }
      .badge{ display:inline-block; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:600; margin-right:8px; }
      .badge-ok{ background:#dcfce7; color:#16a34a; }
      .badge-bad{ background:#fee2e2; color:#dc2626; }
      .top-row{ display:flex; align-items:flex-start; justify-content:space-between; gap:14px; flex-wrap:wrap; }
      .meta{ display:inline-flex; gap:8px; align-items:center; padding:8px 14px; border-radius:999px; border:1px solid var(--border); background:#f0f9ff; color:var(--accent); font-size:13px; font-weight:600; white-space:nowrap; }
    </style>

    <div class="page-content">
      <div class="wrap">
        <section class="card">
          <div class="top-row">
            <div>
              <h1>PHP Basics</h1>
              <p>Welcome to <strong><?= htmlspecialchars($clinicName) ?></strong></p>
            </div>
            <div class="meta">Years in service: <strong><?= $yearsInService ?></strong></div>
          </div>
          <div style="margin-top:18px;">
            <div class="row"><div class="label">Established</div><div class="value"><?= $establishedYear ?></div></div>
            <div class="row"><div class="label">Consultation Fee</div><div class="value">Rs. <?= number_format($consultationFee, 2) ?></div></div>
            <div class="row"><div class="label">Current Year</div><div class="value"><?= $currentYear ?></div></div>
          </div>
          <div class="status-box <?= $statusClass ?>">
            <span class="badge <?= $statusClass === 'ok' ? 'badge-ok' : 'badge-bad' ?>"><?= $isOpenToday ? 'OPEN' : 'CLOSED' ?></span>
            <?= htmlspecialchars($statusText) ?>
          </div>
        </section>
      </div>
    </div>
  </body>
</html>
