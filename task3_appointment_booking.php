<?php
/* Name: M Umair | Reg No: 232201007 | Class: BSCS 6A 
   Institution: Khan Institute of Computer Science and IT */

$currentPage = 'appointment';
$pageTitle = 'Appointment Booking';

$errors = [];
$patientName = '';
$appointmentDate = '';
$appointmentTime = '';
$department = '';
$notes = '';
$submitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientName     = trim($_POST['patient_name'] ?? '');
    $appointmentDate = trim($_POST['appointment_date'] ?? '');
    $appointmentTime = trim($_POST['appointment_time'] ?? '');
    $department      = trim($_POST['department'] ?? '');
    $notes           = trim($_POST['notes'] ?? '');

    if (strlen($patientName) < 3) $errors[] = 'Patient name must be at least 3 characters long.';
    if ($appointmentDate === '') { $errors[] = 'Please select an appointment date.'; }
    else { $today = new DateTime('today'); $selected = new DateTime($appointmentDate); if ($selected < $today) $errors[] = 'Appointment date cannot be in the past.'; }
    if ($appointmentTime === '') $errors[] = 'Please select an appointment time.';
    if ($department === '') $errors[] = 'Please select a department.';
    if (strlen($notes) > 200) $errors[] = 'Notes cannot exceed 200 characters (currently ' . strlen($notes) . ').';

    if (empty($errors)) $submitted = true;
}

include 'header.php';
?>
  <body style="background-image:url('https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=1920&q=80')">
    <nav class="navbar">
      <a class="navbar-logo" href="index.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg><div><span>City Care Clinic</span><small>Hospital Management System</small></div></a>
      <button class="nav-toggle" onclick="document.querySelector('.navbar-links').classList.toggle('open')" aria-label="Menu"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button>
      <ul class="navbar-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="task2_patient_registration.php">Register</a></li>
        <li><a href="task3_appointment_booking.php" class="active">Appointment</a></li>
        <li><a href="schedule.php">Schedule</a></li>
        <li><a href="report.php">Report</a></li>
        <li><a href="step1.php">Intake</a></li>
      </ul>
    </nav>

    <style>
      .errors{ margin-top:12px; padding:12px 14px; border-radius:10px; background:#fee2e2; border:1px solid rgba(220,38,38,.2); }
      .errors p{ margin:4px 0; color:#dc2626; font-size:14px; font-weight:500; }
      label{ display:block; margin-top:14px; font-weight:600; font-size:14px; }
      input[type="text"], input[type="date"], input[type="time"], select, textarea{ width:100%; margin-top:4px; padding:10px 12px; border:1px solid var(--border); border-radius:10px; font-size:14px; font-family:inherit; color:var(--text); background:#f8fafc; }
      textarea{ resize:vertical; min-height:70px; }
      input:focus, select:focus, textarea:focus{ outline:none; border-color:var(--accent); box-shadow:0 0 0 3px rgba(37,99,235,.12); }
      .char-count{ margin-top:4px; font-size:12px; color:var(--muted); text-align:right; }
      .char-count.over{ color:#dc2626; font-weight:600; }
      button{ margin-top:18px; padding:10px 20px; border:1px solid var(--accent); border-radius:12px; background:var(--accent); color:#fff; font-size:14px; font-weight:600; cursor:pointer; }
      button:hover{ background:#1d4ed8; }
      .row{ display:flex; justify-content:space-between; gap:14px; padding:10px 14px; border-bottom:1px solid var(--border); font-size:14px; }
      .row:last-child{ border-bottom:none; }
      .label{ color:var(--muted); font-weight:600; }
      .value{ font-weight:500; text-align:right; max-width:60%; }
      .success-badge{ display:inline-block; padding:6px 16px; border-radius:999px; background:#dcfce7; color:#16a34a; font-weight:650; font-size:14px; }
    </style>

    <div class="page-content">
      <div class="wrap">
        <?php if (!$submitted): ?>
        <section class="card">
          <h1>Appointment Booking</h1>
          <p>Schedule a new appointment. All fields are required.</p>
          <?php if (!empty($errors)): ?>
          <div class="errors"><?php foreach ($errors as $err): ?><p><?= htmlspecialchars($err) ?></p><?php endforeach; ?></div>
          <?php endif; ?>
          <form method="POST" action="">
            <label for="patient_name">Patient Name</label>
            <input type="text" id="patient_name" name="patient_name" value="<?= htmlspecialchars($patientName) ?>" required />
            <label for="appointment_date">Appointment Date</label>
            <input type="date" id="appointment_date" name="appointment_date" value="<?= htmlspecialchars($appointmentDate) ?>" required />
            <label for="appointment_time">Appointment Time</label>
            <input type="time" id="appointment_time" name="appointment_time" value="<?= htmlspecialchars($appointmentTime) ?>" required />
            <label for="department">Department</label>
            <select id="department" name="department" required>
              <option value="">-- Select Department --</option>
              <option value="General Medicine" <?= $department === 'General Medicine' ? 'selected' : '' ?>>General Medicine</option>
              <option value="Cardiology" <?= $department === 'Cardiology' ? 'selected' : '' ?>>Cardiology</option>
              <option value="Dermatology" <?= $department === 'Dermatology' ? 'selected' : '' ?>>Dermatology</option>
              <option value="Orthopedics" <?= $department === 'Orthopedics' ? 'selected' : '' ?>>Orthopedics</option>
              <option value="Pediatrics" <?= $department === 'Pediatrics' ? 'selected' : '' ?>>Pediatrics</option>
              <option value="ENT" <?= $department === 'ENT' ? 'selected' : '' ?>>ENT</option>
              <option value="Gynecology" <?= $department === 'Gynecology' ? 'selected' : '' ?>>Gynecology</option>
            </select>
            <label for="notes">Notes / Symptoms (max 200 characters)</label>
            <textarea id="notes" name="notes" maxlength="200"><?= htmlspecialchars($notes) ?></textarea>
            <div class="char-count <?= strlen($notes) > 200 ? 'over' : '' ?>"><?= strlen($notes) ?> / 200</div>
            <button type="submit">Book Appointment</button>
          </form>
        </section>
        <?php else: ?>
        <section class="card">
          <h1>Appointment Confirmed</h1>
          <p>Your appointment has been booked successfully.</p>
          <div class="row"><span class="label">Patient Name</span><span class="value"><?= htmlspecialchars(strtoupper($patientName)) ?></span></div>
          <div class="row"><span class="label">Date</span><span class="value"><?= htmlspecialchars($appointmentDate) ?></span></div>
          <div class="row"><span class="label">Time</span><span class="value"><?= htmlspecialchars($appointmentTime) ?></span></div>
          <div class="row"><span class="label">Department</span><span class="value"><?= htmlspecialchars($department) ?></span></div>
          <?php if ($notes !== ''): ?><div class="row"><span class="label">Notes</span><span class="value"><?= htmlspecialchars($notes) ?></span></div><?php endif; ?>
          <div class="row"><span class="label">Status</span><span class="value"><span class="success-badge">Booked</span></span></div>
          <div style="margin-top:16px;"><a href="task3_appointment_booking.php" style="display:inline-flex; padding:10px 14px; border-radius:10px; border:1px solid var(--border); text-decoration:none; color:var(--text); background:#f8fafc; font-size:13px; font-weight:500;">Book Another</a></div>
        </section>
        <?php endif; ?>
      </div>
    </div>
  </body>
</html>
