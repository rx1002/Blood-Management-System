<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); exit;
}

// Admin gets their own dashboard
if ($_SESSION['role'] === 'admin') {
    include 'admindashboard.php'; exit;
}

$uid = $_SESSION['user_id'];

$my_requests = $pdo->prepare("SELECT COUNT(*) FROM blood_requests WHERE user_id=?");
$my_requests->execute([$uid]);
$req_count = $my_requests->fetchColumn();

$my_donations = $pdo->prepare("SELECT COUNT(*) FROM donations WHERE user_id=?");
$my_donations->execute([$uid]);
$don_count = $my_donations->fetchColumn();

$recent = $pdo->prepare("SELECT * FROM blood_requests WHERE user_id=? ORDER BY created_at DESC LIMIT 5");
$recent->execute([$uid]);
$recent = $recent->fetchAll();

$user_info = $pdo->prepare("SELECT * FROM users WHERE id=?");
$user_info->execute([$uid]);
$user_info = $user_info->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>User Dashboard - Blood Donation</title>
  <link rel="stylesheet" href="style.css"/>
</head>
<body>
<div class="dashboard">

  <?php include '../includes/header.php'; ?>

  <div class="main-content">
    <div class="topbar">
      <h2>Blood Donation Management</h2>
      <div class="topbar-right">
        <span>👤 <?= htmlspecialchars($_SESSION['user_name']) ?></span>
        <a href="logout.php">Logout</a>
      </div>
    </div>

    <div class="page-content">
      <p class="page-title">Welcome, <?= htmlspecialchars($user_info['firstname']) ?>! 👋</p>

      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon">🩸</div>
          <div class="stat-info">
            <h3><?= $user_info['blood_group'] ?></h3>
            <p>My Blood Group</p>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon">📋</div>
          <div class="stat-info">
            <h3><?= $req_count ?></h3>
            <p>My Requests</p>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon">📅</div>
          <div class="stat-info">
            <h3><?= $don_count ?></h3>
            <p>Donations Scheduled</p>
          </div>
        </div>
      </div>

      <div style="display:flex; gap:15px; margin-bottom:25px; flex-wrap:wrap;">
        <a href="Requestblood.php"><button class="btn-primary">🩸 Request Blood</button></a>
        <a href="scheduledonation.php"><button class="btn-secondary">📅 Donate Blood</button></a>
      </div>

      <div class="card">
        <div class="card-header">
          My Recent Blood Requests
          <a href="myrequest.php" style="color:white; font-size:13px;">View All →</a>
        </div>
        <div class="card-body">
          <table>
            <thead>
              <tr>
                <th>#</th><th>Patient Name</th><th>Blood Group</th>
                <th>Units</th><th>Hospital</th><th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if(empty($recent)): ?>
                <tr><td colspan="6" class="text-center">No requests yet. <a href="Requestblood.php" style="color:#c0392b;">Make one!</a></td></tr>
              <?php else: ?>
                <?php foreach($recent as $i => $r): ?>
                  <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= htmlspecialchars($r['patient_name']) ?></td>
                    <td><?= $r['blood_group'] ?></td>
                    <td><?= $r['units'] ?></td>
                    <td><?= htmlspecialchars($r['hospital']) ?></td>
                    <td><?php
                      $cls = ['pending'=>'badge-warning','approved'=>'badge-success','rejected'=>'badge-danger'];
                      echo "<span class='badge ".$cls[$r['status']]."'>".ucfirst($r['status'])."</span>";
                    ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>
</body>
</html>
