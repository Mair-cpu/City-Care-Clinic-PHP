<?php
/* Name: M Umair | Reg No: 232201007 | Class: BSCS 6A 
   Institution: Khan Institute of Computer Science and IT */
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Billing</title>
    <style>
      :root{
        --bg1:#0f172a;
        --bg2:#111827;
        --card:#0b1220cc;
        --border:#24314a;
        --text:#e5e7eb;
        --muted:#a7b0be;
        --shadow: 0 18px 55px rgba(0,0,0,.45);
        --radius: 18px;
      }
      *{ box-sizing:border-box; }
      body{
        margin:0;
        min-height:100vh;
        font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
        color:var(--text);
        background: radial-gradient(900px 520px at 18% 12%, rgba(34,197,94,.22), transparent 55%),
                    radial-gradient(900px 520px at 84% 18%, rgba(59,130,246,.18), transparent 56%),
                    linear-gradient(180deg, var(--bg1), var(--bg2));
        display:flex;
        align-items:center;
        justify-content:center;
        padding:28px 14px;
      }
      .wrap{ width:min(860px, 100%); }
      .card{
        background:linear-gradient(180deg, rgba(15,23,42,.70), rgba(2,6,23,.65));
        border:1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding:22px;
        backdrop-filter: blur(10px);
      }
      h1{ margin:0; font-size: 24px; }
      p{ margin:8px 0 0; color:var(--muted); line-height:1.55; }
      .actions{ margin-top:16px; display:flex; gap:10px; flex-wrap:wrap; }
      a.btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        padding:10px 12px;
        border-radius: 12px;
        border:1px solid var(--border);
        text-decoration:none;
        color:var(--text);
        background: rgba(2,6,23,.35);
      }
      a.btn:hover{ border-color:#35507a; background: rgba(2,6,23,.50); }
    </style>
  </head>
  <body>
    <main class="wrap">
      <section class="card">
        <h1>Task 5 — Billing</h1>
        <p>This page is ready for implementation (calculations + receipt card).</p>
        <div class="actions">
          <a class="btn" href="index.php">Back to Dashboard</a>
        </div>
      </section>
    </main>
  </body>
</html>
