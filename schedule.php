<?php
/* Name: M Umair | Reg No: 232201007 | Class: BSCS 6A 
   Institution: Khan Institute of Computer Science and IT */

$currentPage = 'schedule';
$pageTitle = 'Doctor Schedule';

$doctors = [
    ['Name'=>'Dr. Ahmed Khan','Specialization'=>'Cardiologist','Available_Days'=>['Monday','Wednesday','Friday'],'Fee'=>3000,'Room'=>'C-101'],
    ['Name'=>'Dr. Sara Malik','Specialization'=>'Dermatologist','Available_Days'=>['Tuesday','Thursday','Saturday'],'Fee'=>2500,'Room'=>'D-205'],
    ['Name'=>'Dr. Usman Tariq','Specialization'=>'Orthopedic Surgeon','Available_Days'=>['Monday','Wednesday','Thursday'],'Fee'=>3500,'Room'=>'O-302'],
    ['Name'=>'Dr. Fatima Noor','Specialization'=>'Pediatrician','Available_Days'=>['Monday','Tuesday','Wednesday','Friday'],'Fee'=>2000,'Room'=>'P-104'],
    ['Name'=>'Dr. Bilal Hussain','Specialization'=>'ENT Specialist','Available_Days'=>['Wednesday','Thursday','Saturday'],'Fee'=>2800,'Room'=>'E-201'],
    ['Name'=>'Dr. Ayesha Siddiqui','Specialization'=>'Gynecologist','Available_Days'=>['Monday','Wednesday','Friday','Saturday'],'Fee'=>3200,'Room'=>'G-110']
];

function getDoctorsByDay($doctors, $day) {
    $filtered = [];
    foreach ($doctors as $doctor) {
        if (in_array($day, $doctor['Available_Days'])) $filtered[] = $doctor;
    }
    return $filtered;
}

$wednesdayDoctors = getDoctorsByDay($doctors, 'Wednesday');
$fees = array_column($doctors, 'Fee');
$averageFee = array_sum($fees) / count($fees);

include 'header.php';
?>
  <body style="background-image:url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1920&q=80')">
    <nav class="navbar">
      <a class="navbar-logo" href="index.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg><div><span>City Care Clinic</span><small>Hospital Management System</small></div></a>
      <button class="nav-toggle" onclick="document.querySelector('.navbar-links').classList.toggle('open')" aria-label="Menu"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button>
      <ul class="navbar-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="task2_patient_registration.php">Register</a></li>
        <li><a href="task3_appointment_booking.php">Appointment</a></li>
        <li><a href="schedule.php" class="active">Schedule</a></li>
        <li><a href="report.php">Report</a></li>
        <li><a href="step1.php">Intake</a></li>
      </ul>
    </nav>

    <style>
      table{ width:100%; border-collapse:collapse; margin-top:12px; }
      th, td{ padding:10px 12px; text-align:left; border-bottom:1px solid var(--border); font-size:14px; }
      th{ background:#dbeafe; color:var(--accent); font-weight:650; border-radius:6px 6px 0 0; }
      tr:hover td{ background:#f8fafc; }
      .avg-badge{ display:inline-block; margin-top:12px; padding:8px 16px; border-radius:999px; background:#dbeafe; color:var(--accent); font-weight:650; font-size:14px; border:1px solid var(--border); }
    </style>

    <div class="page-content">
      <div class="wrap">
        <section class="card">
          <h1>Doctor Schedule</h1>
          <p>All doctors available at City Care Clinic.</p>
          <h2>All Doctors</h2>
          <table><thead><tr><th>#</th><th>Name</th><th>Specialization</th><th>Available Days</th><th>Fee (Rs.)</th><th>Room</th></tr></thead>
          <tbody><?php foreach ($doctors as $i => $doc): ?><tr><td><?= $i+1 ?></td><td><?= htmlspecialchars($doc['Name']) ?></td><td><?= htmlspecialchars($doc['Specialization']) ?></td><td><?= htmlspecialchars(implode(', ',$doc['Available_Days'])) ?></td><td><?= number_format($doc['Fee']) ?></td><td><?= htmlspecialchars($doc['Room']) ?></td></tr><?php endforeach; ?></tbody></table>
          <div class="avg-badge">Average Fee: Rs. <?= number_format($averageFee,2) ?></div>
          <h2>Doctors Available on Wednesday</h2>
          <table><thead><tr><th>#</th><th>Name</th><th>Specialization</th><th>Available Days</th><th>Fee (Rs.)</th><th>Room</th></tr></thead>
          <tbody><?php foreach ($wednesdayDoctors as $i => $doc): ?><tr><td><?= $i+1 ?></td><td><?= htmlspecialchars($doc['Name']) ?></td><td><?= htmlspecialchars($doc['Specialization']) ?></td><td><?= htmlspecialchars(implode(', ',$doc['Available_Days'])) ?></td><td><?= number_format($doc['Fee']) ?></td><td><?= htmlspecialchars($doc['Room']) ?></td></tr><?php endforeach; ?></tbody></table>
        </section>
      </div>
    </div>
  </body>
</html>
