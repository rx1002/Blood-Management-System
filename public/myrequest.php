<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php"); exit;
}

$uid = $_SESSION['user_id'];

$requests = $pdo->prepare("SELECT * FROM blood_requests WHERE user_id=? ORDER BY created_at DESC");
$requests->execute([$uid]);
$requests = $requests->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>My Requests - Blood Donation</title>
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
      <p class="page-title">My Blood Requests</p>

      <div class="card">
        <div class="card-header">
          All My Requests
          <a href="Requestblood.php" style="color:white; font-size:13px;">+ New Request</a>
        </div>
        <div class="card-body">
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Patient Name</th>
                <th>Blood Group</th>
                <th>Units</th>
                <th>Hospital</th>
                <th>Contact</th>
                <th>Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if(empty($requests)): ?>
                <tr><td colspan="8" class="text-center">
                  No requests yet. <a href="Requestblood.php" style="color:#c0392b;">Make a request</a>
                </td></tr>
              <?php else: ?>
                <?php foreach($requests as $i => $r): ?>
                  <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= htmlspecialchars($r['patient_name']) ?></td>
                    <td><span class="badge badge-danger"><?= $r['blood_group'] ?></span></td>
                    <td><?= $r['units'] ?></td>
                    <td><?= htmlspecialchars($r['hospital']) ?></td>
                    <td><?= htmlspecialchars($r['contact']) ?></td>
                    <td><?= date('d M Y', strtotime($r['created_at'])) ?></td>
                    <td>
                      <?php
                        $cls = ['pending'=>'badge-warning','approved'=>'badge-success','rejected'=>'badge-danger'];
                        echo "<span class='badge ".$cls[$r['status']]."'>".ucfirst($r['status'])."</span>";
                      ?>
                    </td>
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
