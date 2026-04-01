<?php
/* Name: M Umair | Reg No: 232201007 | Class: BSCS 6A 
   Institution: Khan Institute of Computer Science and IT */

$currentPage = 'home';
$pageTitle = 'Dashboard';

include 'header.php';
?>
  <body style="background-image:url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1920&q=80')">
    <nav class="navbar">
      <a class="navbar-logo" href="index.php">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <div><span>City Care Clinic</span><small>Hospital Management System</small></div>
      </a>
      <button class="nav-toggle" onclick="document.querySelector('.navbar-links').classList.toggle('open')" aria-label="Menu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
      <ul class="navbar-links">
        <li><a href="index.php" class="active">Home</a></li>
        <li><a href="task2_patient_registration.php">Register</a></li>
        <li><a href="task3_appointment_booking.php">Appointment</a></li>
        <li><a href="schedule.php">Schedule</a></li>
        <li><a href="report.php">Report</a></li>
        <li><a href="step1.php">Intake</a></li>
      </ul>
    </nav>

    <div class="page-content">
      <div class="wrap">
        <section class="card" style="background:linear-gradient(180deg, rgba(15,23,42,.88), rgba(2,6,23,.82)); backdrop-filter:blur(14px); border-color:var(--nav-border); color:var(--nav-text);">
          <div style="display:flex; gap:12px; align-items:flex-start; justify-content:space-between; flex-wrap:wrap;">
            <div>
              <h1 style="color:#fff; font-size:28px;">City Care Clinic — Management System</h1>
              <p style="color:#94a3b8; margin-top:6px;">Select a module below to get started.</p>
            </div>
            <div style="display:inline-flex; align-items:center; gap:8px; padding:9px 14px; border-radius:999px; border:1px solid var(--nav-border); background:rgba(2,6,23,.5); color:#94a3b8; font-size:13px; white-space:nowrap;">
              <span style="width:10px; height:10px; border-radius:50%; background:#22c55e; box-shadow:0 0 8px rgba(34,197,94,.4); display:inline-block;"></span>
              Ready on XAMPP
            </div>
          </div>
          <div style="margin-top:18px; display:grid; grid-template-columns:repeat(auto-fit, minmax(250px, 1fr)); gap:14px;">
            <article class="card" style="background:rgba(255,255,255,.06); border-color:rgba(255,255,255,.1); backdrop-filter:blur(10px);">
              <h2 style="color:#fff; font-size:15px;">PHP Basics</h2>
              <p>Variables, calculations, and conditional output for clinic info.</p>
              <div style="margin-top:12px;"><a href="task1_basics.php" style="display:inline-flex; padding:8px 14px; border-radius:10px; border:1px solid rgba(34,197,94,.3); background:rgba(34,197,94,.1); text-decoration:none; color:#86efac; font-size:13px; font-weight:500;">Open</a></div>
            </article>
            <article class="card" style="background:rgba(255,255,255,.06); border-color:rgba(255,255,255,.1); backdrop-filter:blur(10px);">
              <h2 style="color:#fff; font-size:15px;">Patient Registration</h2>
              <p>CRUD operations, patient table, discharge labels, history log.</p>
              <div style="margin-top:12px;"><a href="task2_patient_registration.php" style="display:inline-flex; padding:8px 14px; border-radius:10px; border:1px solid rgba(255,255,255,.15); background:rgba(255,255,255,.05); text-decoration:none; color:var(--nav-text); font-size:13px; font-weight:500;">Open</a></div>
            </article>
            <article class="card" style="background:rgba(255,255,255,.06); border-color:rgba(255,255,255,.1); backdrop-filter:blur(10px);">
              <h2 style="color:#fff; font-size:15px;">Appointment Booking</h2>
              <p>Book appointments with robust checks (no past dates).</p>
              <div style="margin-top:12px;"><a href="task3_appointment_booking.php" style="display:inline-flex; padding:8px 14px; border-radius:10px; border:1px solid rgba(255,255,255,.15); background:rgba(255,255,255,.05); text-decoration:none; color:var(--nav-text); font-size:13px; font-weight:500;">Open</a></div>
            </article>
            <article class="card" style="background:rgba(255,255,255,.06); border-color:rgba(255,255,255,.1); backdrop-filter:blur(10px);">
              <h2 style="color:#fff; font-size:15px;">Doctor Schedule</h2>
              <p>Multidimensional arrays, getDoctorsByDay() filter, average fee.</p>
              <div style="margin-top:12px;"><a href="schedule.php" style="display:inline-flex; padding:8px 14px; border-radius:10px; border:1px solid rgba(255,255,255,.15); background:rgba(255,255,255,.05); text-decoration:none; color:var(--nav-text); font-size:13px; font-weight:500;">Open</a></div>
            </article>
            <article class="card" style="background:rgba(255,255,255,.06); border-color:rgba(255,255,255,.1); backdrop-filter:blur(10px);">
              <h2 style="color:#fff; font-size:15px;">Patient Report</h2>
              <p>strtoupper, trim, preg_replace, explode, str_word_count.</p>
              <div style="margin-top:12px;"><a href="report.php" style="display:inline-flex; padding:8px 14px; border-radius:10px; border:1px solid rgba(255,255,255,.15); background:rgba(255,255,255,.05); text-decoration:none; color:var(--nav-text); font-size:13px; font-weight:500;">Open</a></div>
            </article>
            <article class="card" style="background:rgba(255,255,255,.06); border-color:rgba(255,255,255,.1); backdrop-filter:blur(10px);">
              <h2 style="color:#fff; font-size:15px;">Multi-Step Intake</h2>
              <p>3-step form with sessions, BMI calculation, classification.</p>
              <div style="margin-top:12px;"><a href="step1.php" style="display:inline-flex; padding:8px 14px; border-radius:10px; border:1px solid rgba(255,255,255,.15); background:rgba(255,255,255,.05); text-decoration:none; color:var(--nav-text); font-size:13px; font-weight:500;">Open</a></div>
            </article>
          </div>
        </section>
      </div>
    </div>
  </body>
</html>
