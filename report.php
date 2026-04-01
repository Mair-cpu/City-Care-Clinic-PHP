<?php
/* Name: M Umair | Reg No: 232201007 | Class: BSCS 6A 
   Institution: Khan Institute of Computer Science and IT */

$currentPage = 'report';
$pageTitle = 'Patient Report';

$name       = '';
$diagnosis  = '';
$medicines  = '';
$remarks    = '';
$status     = '';
$submitted  = false;
$nameUpper    = '';
$cleanDiag    = '';
$medicinesArr = [];
$wordCount    = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name      = trim($_POST['name'] ?? '');
    $diagnosis = $_POST['diagnosis'] ?? '';
    $medicines = trim($_POST['medicines'] ?? '');
    $remarks   = trim($_POST['remarks'] ?? '');
    $status    = $_POST['status'] ?? '';
    $submitted = true;
    $nameUpper = strtoupper($name);
    $cleanDiag = trim($diagnosis);
    $cleanDiag = preg_replace('/\s+/', ' ', $cleanDiag);
    $medicinesArr = array_map('trim', explode(',', $medicines));
    $medicinesArr = array_filter($medicinesArr);
    $wordCount = str_word_count($remarks);
}

include 'header.php';
?>
  <body style="background-image:url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=1920&q=80')">
    <nav class="navbar">
      <a class="navbar-logo" href="index.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg><div><span>City Care Clinic</span><small>Hospital Management System</small></div></a>
      <button class="nav-toggle" onclick="document.querySelector('.navbar-links').classList.toggle('open')" aria-label="Menu"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button>
      <ul class="navbar-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="task2_patient_registration.php">Register</a></li>
        <li><a href="task3_appointment_booking.php">Appointment</a></li>
        <li><a href="schedule.php">Schedule</a></li>
        <li><a href="report.php" class="active">Report</a></li>
        <li><a href="step1.php">Intake</a></li>
      </ul>
    </nav>

    <style>
      label{ display:block; margin-top:14px; font-weight:600; font-size:14px; color:var(--text); }
      input[type="text"], textarea, select{ width:100%; margin-top:4px; padding:10px 12px; border:1px solid var(--border); border-radius:10px; font-size:14px; font-family:inherit; color:var(--text); background:#f8fafc; }
      textarea{ resize:vertical; min-height:80px; }
      input:focus, textarea:focus, select:focus{ outline:none; border-color:var(--accent); box-shadow:0 0 0 3px rgba(37,99,235,.12); }
      button{ margin-top:18px; padding:10px 20px; border:1px solid var(--accent); border-radius:12px; background:var(--accent); color:#fff; font-size:14px; font-weight:600; cursor:pointer; }
      button:hover{ background:#1d4ed8; }
      .row{ display:flex; justify-content:space-between; gap:14px; padding:10px 14px; border-bottom:1px solid var(--border); font-size:14px; }
      .row:last-child{ border-bottom:none; }
      .label{ color:var(--muted); font-weight:600; }
      .value{ font-weight:500; text-align:right; max-width:60%; }
      ul.medList{ margin:6px 0 0; padding-left:20px; }
      ul.medList li{ font-size:14px; padding:2px 0; }
      .status-badge{ display:inline-block; padding:5px 14px; border-radius:999px; font-weight:650; font-size:13px; }
      .status-discharged{ background:#dcfce7; color:#16a34a; }
      .status-admitted{ background:#fee2e2; color:#dc2626; }
      .status-observation{ background:#fef3c7; color:#d97706; }
    </style>

    <div class="page-content">
      <div class="wrap">
        <section class="card">
          <h1>Patient Report Generator</h1>
          <p>Fill in the patient details below to generate a formatted medical report.</p>
          <form method="POST" action="">
            <label for="name">Patient Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required />
            <label for="diagnosis">Diagnosis</label>
            <textarea id="diagnosis" name="diagnosis" placeholder="Enter diagnosis details..."><?= htmlspecialchars($diagnosis) ?></textarea>
            <label for="medicines">Medicines (comma-separated)</label>
            <input type="text" id="medicines" name="medicines" value="<?= htmlspecialchars($medicines) ?>" placeholder="e.g. Panadol, Amoxicillin, Brufen" />
            <label for="remarks">Remarks</label>
            <textarea id="remarks" name="remarks" placeholder="Additional notes..."><?= htmlspecialchars($remarks) ?></textarea>
            <label for="status">Discharge Status</label>
            <select id="status" name="status" required>
              <option value="">-- Select Status --</option>
              <option value="Discharged" <?= $status === 'Discharged' ? 'selected' : '' ?>>Discharged</option>
              <option value="Admitted" <?= $status === 'Admitted' ? 'selected' : '' ?>>Admitted</option>
              <option value="Observation" <?= $status === 'Observation' ? 'selected' : '' ?>>Observation</option>
            </select>
            <button type="submit">Generate Report</button>
          </form>
        </section>

        <?php if ($submitted): ?>
        <section class="card">
          <h2>Generated Report</h2>
          <div class="row"><span class="label">Patient Name</span><span class="value"><?= htmlspecialchars($nameUpper) ?></span></div>
          <div class="row"><span class="label">Diagnosis</span><span class="value"><?= htmlspecialchars($cleanDiag) ?></span></div>
          <div class="row"><span class="label">Medicines</span><span class="value">
            <?php if (!empty($medicinesArr)): ?><ul class="medList"><?php foreach ($medicinesArr as $med): ?><li><?= htmlspecialchars($med) ?></li><?php endforeach; ?></ul><?php else: ?><em>None prescribed</em><?php endif; ?>
          </span></div>
          <div class="row"><span class="label">Remarks</span><span class="value"><?= htmlspecialchars($remarks) ?> (<?= $wordCount ?> words)</span></div>
          <div class="row"><span class="label">Status</span><span class="value">
            <?php $sc = ''; if ($status==='Discharged') $sc='status-discharged'; elseif ($status==='Admitted') $sc='status-admitted'; else $sc='status-observation'; ?>
            <span class="status-badge <?= $sc ?>"><?= htmlspecialchars($status) ?></span>
          </span></div>
        </section>
        <?php endif; ?>
      </div>
    </div>
  </body>
</html>
