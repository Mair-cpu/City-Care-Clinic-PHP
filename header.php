<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= isset($pageTitle) ? $pageTitle . ' — City Care Clinic' : 'City Care Clinic' ?></title>
    <style>
      :root{
        --nav-bg:#0f172a;
        --nav-border:#1e3a5f;
        --nav-text:#e5e7eb;
        --nav-hover:#38bdf8;
        --accent:#2563eb;
        --accent-light:#dbeafe;
        --bg:#f0f4f8;
        --card:#ffffff;
        --border:#d1d9e6;
        --text:#1e293b;
        --muted:#64748b;
        --shadow: 0 8px 30px rgba(0,0,0,.08);
        --radius: 14px;
      }
      *{ box-sizing:border-box; margin:0; padding:0; }
      body{
        min-height:100vh;
        font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
        color:var(--text);
        background-color:#0a1628;
        background-size:cover;
        background-position:center;
        background-attachment:fixed;
        background-repeat:no-repeat;
      }
      body::before{
        content:'';
        position:fixed;
        inset:0;
        background:rgba(10,22,40,.72);
        backdrop-filter:blur(6px);
        -webkit-backdrop-filter:blur(6px);
        z-index:0;
      }
      .page-content{
        position:relative;
        z-index:1;
        display:flex;
        align-items:center;
        justify-content:center;
        min-height:100vh;
        padding:80px 14px 28px;
      }
      .wrap{ width:min(900px, 100%); display:flex; flex-direction:column; gap:20px; }

      /* ===== NAVBAR ===== */
      .navbar{
        position:fixed;
        top:0; left:0; right:0;
        z-index:1000;
        display:flex;
        align-items:center;
        justify-content:space-between;
        padding:0 24px;
        height:56px;
        background:linear-gradient(180deg, #0f172a 0%, #0c1a2e 100%);
        border-bottom:1px solid var(--nav-border);
        box-shadow:0 2px 20px rgba(0,0,0,.4);
      }
      .navbar-logo{
        display:flex;
        align-items:center;
        gap:10px;
        text-decoration:none;
        color:var(--nav-text);
      }
      .navbar-logo svg{ width:28px; height:28px; }
      .navbar-logo span{
        font-size:16px;
        font-weight:700;
        letter-spacing:.3px;
        color:#fff;
      }
      .navbar-logo small{
        font-size:11px;
        color:var(--muted);
        font-weight:400;
        display:block;
        margin-top:-2px;
      }
      .navbar-links{
        display:flex;
        gap:4px;
        list-style:none;
      }
      .navbar-links a{
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:7px 14px;
        border-radius:8px;
        text-decoration:none;
        color:var(--nav-text);
        font-size:13px;
        font-weight:500;
        transition:background .15s, color .15s;
      }
      .navbar-links a:hover,
      .navbar-links a.active{
        background:rgba(56,189,248,.1);
        color:var(--nav-hover);
      }
      .navbar-links a.active{
        border:1px solid rgba(56,189,248,.25);
      }
      .nav-toggle{ display:none; cursor:pointer; background:none; border:none; color:var(--nav-text); }
      .nav-toggle svg{ width:24px; height:24px; }

      @media (max-width:820px){
        .navbar{ padding:0 14px; }
        .navbar-links{
          display:none;
          position:absolute;
          top:56px; left:0; right:0;
          flex-direction:column;
          background:#0f172a;
          border-bottom:1px solid var(--nav-border);
          padding:10px;
          gap:2px;
        }
        .navbar-links.open{ display:flex; }
        .nav-toggle{ display:block; }
      }

      /* ===== CARD (shared) ===== */
      .card{
        background:var(--card);
        border:1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding:24px;
        backdrop-filter:blur(2px);
      }
      h1{ margin:0; font-size:22px; color:var(--accent); }
      h2{ margin:18px 0 10px; font-size:17px; color:var(--accent); }
      p{ margin:6px 0 0; color:var(--muted); line-height:1.5; }
    </style>
  </head>
