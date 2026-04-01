<?php
/* Name: M Umair | Reg No: 232201007 | Class: BSCS 6A 
   Institution: Khan Institute of Computer Science and IT */

$currentPage = 'register';
$pageTitle = 'Patient Registration';

/* ============================================================
   DATA PERSISTENCE LAYER
   ============================================================ */

$dataFile    = __DIR__ . '/patients_data.json';
$historyFile = __DIR__ . '/history_log.json';

function initJsonFile($file) {
    if (!file_exists($file) || filesize($file) === 0) {
        file_put_contents($file, json_encode([], JSON_PRETTY_PRINT));
    }
}
initJsonFile($dataFile);
initJsonFile($historyFile);

function loadJson($file) {
    $raw  = file_get_contents($file);
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}
function saveJson($file, $data) {
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}
function logHistory($historyFile, $action, $patientId, $details = '') {
    $log    = loadJson($historyFile);
    $log[]  = ['timestamp'=>date('Y-m-d H:i:s'), 'action'=>$action, 'patient_id'=>$patientId, 'details'=>$details];
    saveJson($historyFile, $log);
}
function getAgeCategory($age) {
    if ($age < 13) return 'Child';
    if ($age <= 17) return 'Teenager';
    if ($age <= 64) return 'Adult';
    return 'Senior';
}

$patients = loadJson($dataFile);

$errors     = [];
$editMode   = false;
$editId     = null;
$successMsg = '';
$name = $age = $gender = $phone = $email = $address = '';
$status = 'Admitted';

/* ============================================================
   POST HANDLER (runs BEFORE any HTML output)
   ============================================================ */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $delId = (int)($_POST['patient_id'] ?? 0);
        $delName = '';
        foreach ($patients as $p) { if ($p['id'] === $delId) { $delName = $p['name']; break; } }
        $patients = array_values(array_filter($patients, function($p) use ($delId) { return $p['id'] !== $delId; }));
        saveJson($dataFile, $patients);
        logHistory($historyFile, 'Delete', $delId, "Patient '{$delName}' (ID #{$delId}) permanently removed from active registry");
        header('Location: task2_patient_registration.php?msg=deleted&id=' . $delId);
        exit;
    }

    if ($action === 'discharge') {
        $disId = (int)($_POST['patient_id'] ?? 0);
        foreach ($patients as &$p) {
            if ($p['id'] === $disId) {
                $oldStatus = $p['status'];
                $p['status'] = ($oldStatus === 'Discharged') ? 'Admitted' : 'Discharged';
                $newStatus = $p['status'];
                $logAction = ($newStatus === 'Discharged') ? 'Discharge' : 'Readmit';
                logHistory($historyFile, $logAction, $disId, "Patient #{$disId} status changed: {$oldStatus} → {$newStatus}");
                break;
            }
        }
        unset($p);
        saveJson($dataFile, $patients);
        header('Location: task2_patient_registration.php?msg=discharged&id=' . $disId);
        exit;
    }

    $editId   = $_POST['edit_id'] ?? '';
    $name     = trim($_POST['name'] ?? '');
    $age      = trim($_POST['age'] ?? '');
    $gender   = trim($_POST['gender'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $address  = trim($_POST['address'] ?? '');
    $status   = trim($_POST['status'] ?? 'Admitted');

    if (strlen($name) < 3) $errors[] = 'Name must be at least 3 characters long.';
    if (!ctype_digit($age) || (int)$age < 1 || (int)$age > 120) $errors[] = 'Please enter a valid age between 1 and 120.';
    if ($gender === '') $errors[] = 'Please select a gender.';
    if (!preg_match('/^\d{11}$/', $phone)) $errors[] = 'Phone number must be exactly 11 digits.';
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';

    if (empty($errors)) {
        $ageInt = (int)$age;
        $ageCategory = getAgeCategory($ageInt);

        if ($editId !== '') {
            foreach ($patients as &$p) {
                if ($p['id'] === (int)$editId) {
                    $changes = [];
                    if ($p['name'] !== $name) $changes[] = "Name: '{$p['name']}' → '{$name}'";
                    if ($p['age'] !== $ageInt) $changes[] = "Age: {$p['age']} → {$ageInt}";
                    if ($p['status'] !== $status) $changes[] = "Status: {$p['status']} → {$status}";
                    $detailStr = empty($changes) ? 'Minor details updated' : implode('; ', $changes);
                    $p['name']=$name; $p['age']=$ageInt; $p['age_category']=$ageCategory;
                    $p['gender']=$gender; $p['phone']=$phone; $p['email']=$email;
                    $p['address']=$address; $p['status']=$status; $p['updated']=date('Y-m-d H:i:s');
                    break;
                }
            }
            unset($p);
            saveJson($dataFile, $patients);
            logHistory($historyFile, 'Edit', (int)$editId, $detailStr);
            header('Location: task2_patient_registration.php?msg=updated&id=' . (int)$editId);
            exit;
        } else {
            $newId = empty($patients) ? 1001 : max(array_column($patients, 'id')) + 1;
            $patients[] = ['id'=>$newId,'name'=>$name,'age'=>$ageInt,'age_category'=>$ageCategory,'gender'=>$gender,'phone'=>$phone,'email'=>$email,'address'=>$address,'status'=>$status,'registered'=>date('Y-m-d H:i:s')];
            saveJson($dataFile, $patients);
            logHistory($historyFile, 'Add', $newId, "Patient '{$name}' (ID #{$newId}) added — {$ageCategory}, {$gender}, {$status}");
            header('Location: task2_patient_registration.php?msg=added&id=' . $newId);
            exit;
        }
    }
    if ($editId !== '') { $editMode = true; $editId = (int)$editId; }
}

if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    foreach ($patients as $p) {
        if ($p['id'] === $editId) {
            $editMode = true;
            $name=$p['name']; $age=$p['age']; $gender=$p['gender'];
            $phone=$p['phone']; $email=$p['email']; $address=$p['address']; $status=$p['status'];
            break;
        }
    }
}

if (isset($_GET['msg'])) {
    $msgType = $_GET['msg'];
    $msgId   = $_GET['id'] ?? '';
    if ($msgType === 'added')      $successMsg = "Patient #{$msgId} registered successfully.";
    if ($msgType === 'updated')    $successMsg = "Patient #{$msgId} updated successfully.";
    if ($msgType === 'deleted')    $successMsg = "Patient #{$msgId} removed from active registry.";
    if ($msgType === 'discharged') $successMsg = "Patient #{$msgId} status updated.";
}

$history = loadJson($historyFile);
$historyReversed = array_reverse($history);

/* ============================================================
   ALL PHP DONE — NOW OUTPUT HTML
   ============================================================ */

include 'header.php';
?>
  <body style="background-image:url('https://images.unsplash.com/photo-1631815588090-d4bfec5b1ccb?w=1920&q=80')">
    <nav class="navbar">
      <a class="navbar-logo" href="index.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg><div><span>City Care Clinic</span><small>Hospital Management System</small></div></a>
      <button class="nav-toggle" onclick="document.querySelector('.navbar-links').classList.toggle('open')" aria-label="Menu"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button>
      <ul class="navbar-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="task2_patient_registration.php" class="active">Register</a></li>
        <li><a href="task3_appointment_booking.php">Appointment</a></li>
        <li><a href="schedule.php">Schedule</a></li>
        <li><a href="report.php">Report</a></li>
        <li><a href="step1.php">Intake</a></li>
      </ul>
    </nav>

    <style>
      .errors{ margin-top:12px; padding:12px 14px; border-radius:10px; background:#fee2e2; border:1px solid rgba(220,38,38,.2); }
      .errors p{ margin:4px 0; color:#dc2626; font-size:14px; font-weight:500; }
      .success{ margin-top:12px; padding:12px 14px; border-radius:10px; background:#dcfce7; border:1px solid rgba(22,163,74,.2); color:#16a34a; font-size:14px; font-weight:500; }
      label{ display:block; margin-top:14px; font-weight:600; font-size:14px; }
      input[type="text"], input[type="number"], input[type="email"], select, textarea{ width:100%; margin-top:4px; padding:10px 12px; border:1px solid var(--border); border-radius:10px; font-size:14px; font-family:inherit; color:var(--text); background:#f8fafc; }
      textarea{ resize:vertical; min-height:60px; }
      input:focus, select:focus, textarea:focus{ outline:none; border-color:var(--accent); box-shadow:0 0 0 3px rgba(37,99,235,.12); }
      button{ margin-top:18px; padding:10px 20px; border:1px solid var(--accent); border-radius:12px; background:var(--accent); color:#fff; font-size:14px; font-weight:600; cursor:pointer; }
      button:hover{ background:#1d4ed8; }
      .form-row{ display:grid; grid-template-columns:1fr 1fr; gap:14px; }
      @media(max-width:600px){ .form-row{ grid-template-columns:1fr; } }
      table{ width:100%; border-collapse:collapse; margin-top:12px; }
      th, td{ padding:10px 12px; text-align:left; border-bottom:1px solid var(--border); font-size:13px; }
      th{ background:#dbeafe; color:var(--accent); font-weight:650; border-radius:6px 6px 0 0; font-size:12px; text-transform:uppercase; letter-spacing:.5px; }
      tr:hover td{ background:#f8fafc; }
      .badge{ display:inline-block; padding:4px 10px; border-radius:999px; font-weight:650; font-size:11px; white-space:nowrap; }
      .badge-admitted{ background:#fee2e2; color:#dc2626; }
      .badge-discharged{ background:#dcfce7; color:#16a34a; }
      .badge-observation{ background:#fef3c7; color:#d97706; }
      .cat-badge{ display:inline-block; padding:3px 8px; border-radius:999px; font-weight:600; font-size:11px; }
      .cat-child{ background:#dbeafe; color:#2563eb; }
      .cat-teenager{ background:#ede9fe; color:#7c3aed; }
      .cat-adult{ background:#dcfce7; color:#16a34a; }
      .cat-senior{ background:#fef3c7; color:#d97706; }
      .tbl-actions{ display:flex; gap:6px; flex-wrap:wrap; }
      .btn-sm{ display:inline-flex; align-items:center; padding:5px 10px; border-radius:8px; border:1px solid var(--border); text-decoration:none; font-size:12px; font-weight:500; cursor:pointer; background:#f8fafc; color:var(--text); font-family:inherit; }
      .btn-sm:hover{ border-color:var(--accent); color:var(--accent); }
      .btn-sm.btn-danger{ border-color:#fca5a5; color:#dc2626; }
      .btn-sm.btn-danger:hover{ background:#fee2e2; }
      .btn-sm.btn-success{ border-color:#86efac; color:#16a34a; }
      .btn-sm.btn-success:hover{ background:#dcfce7; }
      .btn-sm.btn-warning{ border-color:#fcd34d; color:#d97706; }
      .btn-sm.btn-warning:hover{ background:#fef3c7; }
      .empty-state{ text-align:center; padding:30px 20px; color:var(--muted); }
      .empty-state p{ margin:0; font-size:14px; }
      .table-scroll{ overflow-x:auto; }
      .history-table th{ background:#f0fdf4; color:#16a34a; }
      .history-table tr:hover td{ background:#f0fdf4; }
      .act-add{ color:#16a34a; font-weight:600; }
      .act-edit{ color:#2563eb; font-weight:600; }
      .act-delete{ color:#dc2626; font-weight:600; }
      .act-discharge{ color:#d97706; font-weight:600; }
      .act-readmit{ color:#7c3aed; font-weight:600; }
      .timestamp{ color:var(--muted); font-size:12px; white-space:nowrap; }
      .section-header{ display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
      .section-header h1{ margin:0; }
      .count-pill{ display:inline-block; padding:4px 12px; border-radius:999px; background:#dbeafe; color:var(--accent); font-size:13px; font-weight:600; }
    </style>

    <div class="page-content">
      <div class="wrap">

        <?php if ($successMsg): ?>
        <div class="success">✓ <?= htmlspecialchars($successMsg) ?></div>
        <?php endif; ?>

        <?php if ($editMode): ?>
        <section class="card">
          <h1>Edit Patient #<?= $editId ?></h1>
          <p>Update the patient details below.</p>
          <?php if (!empty($errors)): ?><div class="errors"><?php foreach ($errors as $err): ?><p><?= htmlspecialchars($err) ?></p><?php endforeach; ?></div><?php endif; ?>
          <form method="POST" action="">
            <input type="hidden" name="edit_id" value="<?= $editId ?>" />
            <div class="form-row"><div><label for="name">Full Name</label><input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required /></div><div><label for="age">Age</label><input type="number" id="age" name="age" min="1" max="120" value="<?= htmlspecialchars($age) ?>" required /></div></div>
            <div class="form-row"><div><label for="gender">Gender</label><select id="gender" name="gender" required><option value="">-- Select --</option><option value="Male" <?= $gender==='Male'?'selected':'' ?>>Male</option><option value="Female" <?= $gender==='Female'?'selected':'' ?>>Female</option><option value="Other" <?= $gender==='Other'?'selected':'' ?>>Other</option></select></div><div><label for="phone">Phone Number</label><input type="text" id="phone" name="phone" value="<?= htmlspecialchars($phone) ?>" required /></div></div>
            <div class="form-row"><div><label for="email">Email (optional)</label><input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" /></div><div><label for="status">Status</label><select id="status" name="status" required><option value="Admitted" <?= $status==='Admitted'?'selected':'' ?>>Admitted</option><option value="Observation" <?= $status==='Observation'?'selected':'' ?>>Observation</option><option value="Discharged" <?= $status==='Discharged'?'selected':'' ?>>Discharged</option></select></div></div>
            <label for="address">Address</label><textarea id="address" name="address"><?= htmlspecialchars($address) ?></textarea>
            <button type="submit">Update Patient</button>
            <a href="task2_patient_registration.php" style="display:inline-block; margin-left:10px; padding:10px 20px; border-radius:12px; border:1px solid var(--border); text-decoration:none; color:var(--text); font-size:14px; font-weight:600;">Cancel</a>
          </form>
        </section>
        <?php else: ?>
        <section class="card">
          <h1>Patient Registration</h1>
          <p>Fill in the details below to register a new patient.</p>
          <?php if (!empty($errors)): ?><div class="errors"><?php foreach ($errors as $err): ?><p><?= htmlspecialchars($err) ?></p><?php endforeach; ?></div><?php endif; ?>
          <form method="POST" action="">
            <div class="form-row"><div><label for="name">Full Name</label><input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required /></div><div><label for="age">Age</label><input type="number" id="age" name="age" min="1" max="120" value="<?= htmlspecialchars($age) ?>" required /></div></div>
            <div class="form-row"><div><label for="gender">Gender</label><select id="gender" name="gender" required><option value="">-- Select --</option><option value="Male" <?= $gender==='Male'?'selected':'' ?>>Male</option><option value="Female" <?= $gender==='Female'?'selected':'' ?>>Female</option><option value="Other" <?= $gender==='Other'?'selected':'' ?>>Other</option></select></div><div><label for="phone">Phone Number</label><input type="text" id="phone" name="phone" placeholder="03XXXXXXXXX" value="<?= htmlspecialchars($phone) ?>" required /></div></div>
            <div class="form-row"><div><label for="email">Email (optional)</label><input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" /></div><div><label for="status">Status</label><select id="status" name="status" required><option value="Admitted" <?= $status==='Admitted'?'selected':'' ?>>Admitted</option><option value="Observation" <?= $status==='Observation'?'selected':'' ?>>Observation</option><option value="Discharged" <?= $status==='Discharged'?'selected':'' ?>>Discharged</option></select></div></div>
            <label for="address">Address</label><textarea id="address" name="address"><?= htmlspecialchars($address) ?></textarea>
            <button type="submit">Register Patient</button>
          </form>
        </section>
        <?php endif; ?>

        <section class="card">
          <div class="section-header"><div><h1>Active Patients</h1><p>Current registry of all patients in the system.</p></div><span class="count-pill"><?= count($patients) ?> patient<?= count($patients)!==1?'s':'' ?></span></div>
          <?php if (empty($patients)): ?>
          <div class="empty-state"><p>No patients in the registry. Use the form above to add patients.</p></div>
          <?php else: ?>
          <div class="table-scroll">
            <table><thead><tr><th>ID</th><th>Name</th><th>Age</th><th>Category</th><th>Gender</th><th>Phone</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody><?php foreach ($patients as $p): ?>
              <tr>
                <td><strong>#<?= $p['id'] ?></strong></td>
                <td><?= htmlspecialchars(strtoupper($p['name'])) ?></td>
                <td><?= $p['age'] ?></td>
                <td><?php $cc=''; if($p['age_category']==='Child')$cc='cat-child'; elseif($p['age_category']==='Teenager')$cc='cat-teenager'; elseif($p['age_category']==='Adult')$cc='cat-adult'; else $cc='cat-senior'; ?><span class="cat-badge <?= $cc ?>"><?= $p['age_category'] ?></span></td>
                <td><?= htmlspecialchars($p['gender']) ?></td>
                <td><?= htmlspecialchars($p['phone']) ?></td>
                <td><?php $sc=''; if($p['status']==='Discharged')$sc='badge-discharged'; elseif($p['status']==='Observation')$sc='badge-observation'; else $sc='badge-admitted'; ?><span class="badge <?= $sc ?>"><?= htmlspecialchars($p['status']) ?></span></td>
                <td><div class="tbl-actions">
                  <a href="task2_patient_registration.php?edit=<?= $p['id'] ?>" class="btn-sm">Edit</a>
                  <form method="POST" style="display:inline;" onsubmit="return confirm('<?= $p['status']==='Discharged'?'Readmit':'Discharge' ?> this patient?')"><input type="hidden" name="patient_id" value="<?= $p['id'] ?>"/><input type="hidden" name="action" value="discharge"/><button type="submit" class="btn-sm <?= $p['status']==='Discharged'?'btn-warning':'btn-success' ?>"><?= $p['status']==='Discharged'?'Readmit':'Discharge' ?></button></form>
                  <form method="POST" style="display:inline;" onsubmit="return confirm('Permanently remove patient #<?= $p['id'] ?>?')"><input type="hidden" name="patient_id" value="<?= $p['id'] ?>"/><input type="hidden" name="action" value="delete"/><button type="submit" class="btn-sm btn-danger">Delete</button></form>
                </div></td>
              </tr>
            <?php endforeach; ?></tbody></table>
          </div>
          <?php endif; ?>
        </section>

        <section class="card">
          <div class="section-header"><div><h1>Audit History Log</h1><p>Complete record of all patient registry actions.</p></div><span class="count-pill"><?= count($history) ?> event<?= count($history)!==1?'s':'' ?></span></div>
          <?php if (empty($history)): ?>
          <div class="empty-state"><p>No history recorded yet.</p></div>
          <?php else: ?>
          <div class="table-scroll">
            <table class="history-table"><thead><tr><th>Timestamp</th><th>Action</th><th>Patient ID</th><th>Details</th></tr></thead>
            <tbody><?php foreach ($historyReversed as $h): ?>
              <tr>
                <td class="timestamp"><?= htmlspecialchars($h['timestamp']) ?></td>
                <td><?php $ac=''; $act=$h['action']; if($act==='Add')$ac='act-add'; elseif($act==='Edit')$ac='act-edit'; elseif($act==='Delete')$ac='act-delete'; elseif($act==='Discharge')$ac='act-discharge'; elseif($act==='Readmit')$ac='act-readmit'; ?><span class="<?= $ac ?>"><?= htmlspecialchars($h['action']) ?></span></td>
                <td><strong>#<?= (int)$h['patient_id'] ?></strong></td>
                <td><?= htmlspecialchars($h['details'] ?? '') ?></td>
              </tr>
            <?php endforeach; ?></tbody></table>
          </div>
          <?php endif; ?>
        </section>

      </div>
    </div>
  </body>
</html>
