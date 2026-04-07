<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile — Blood Donation Management</title>
  <link rel="stylesheet" href="profile.css" />
</head>
<body>

<div class="app-wrapper">

  <!-- Top accent bar -->
  <div class="top-bar"></div>

  <!-- ════════════════ NAVBAR ════════════════ -->
  <nav class="navbar">
    <div class="nav-logo">
      <div class="nav-logo-icon">🩸</div>
      <span class="nav-title">Blood Donation Management</span>
    </div>

    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="contact.php">Contact</a>
    </div>

    <div class="nav-avatar">ICON</div>
  </nav>

  <!-- ════════════════ MAIN LAYOUT ════════════════ -->
  <div class="main-layout">

    <!-- ════════ SIDEBAR ════════ -->
    <aside class="sidebar">
      <div class="sidebar-spacer"></div>

      <a class="sidebar-item" href="dashboard.php">
        <span class="icon">📊</span>
        <span>Dashboard</span>
      </a>

      <a class="sidebar-item" href="donation.php">
        <span class="icon">🩸</span>
        <span>Donation</span>
      </a>

      <a class="sidebar-item" href="eligibility.php">
        <span class="icon">✉️</span>
        <span>Eligibility Check</span>
      </a>

      <a class="sidebar-item" href="schedule.php">
        <span class="icon">🖥️</span>
        <span>Schedule Donation</span>
      </a>

      <a class="sidebar-item active" href="profile.php">
        <span class="icon">👤</span>
        <span>Profile</span>
      </a>

      <div class="sidebar-bottom">
        <a class="sidebar-logout" href="logout.php">
          <span class="icon">🚪</span>
          <span>Log-Out</span>
        </a>
      </div>
    </aside>

    <!-- ════════ CONTENT ════════ -->
    <main class="content">

      <!-- Decorative bubbles -->
      <div class="bubble b1"></div>
      <div class="bubble b2"></div>
      <div class="bubble b3"></div>
      <div class="bubble b4"></div>
      <div class="bubble b5"></div>

      <div class="form-card">

        <h1 class="form-title">Please fill in your details here</h1>

        <form method="POST" action="profile.php">

          <div class="form-grid">

            <!-- First Name -->
            <div class="form-group">
              <label for="first_name">First Name</label>
              <input type="text" id="first_name" name="first_name" placeholder="Enter first name" />
            </div>

            <!-- Last Name -->
            <div class="form-group">
              <label for="last_name">Last Name</label>
              <input type="text" id="last_name" name="last_name" placeholder="Enter last name" />
            </div>

            <!-- Contact Number -->
            <div class="form-group">
              <label for="contact">Contact Number</label>
              <input type="tel" id="contact" name="contact" placeholder="e.g. 9800000000" />
            </div>

            <!-- Email -->
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" placeholder="you@example.com" />
            </div>

            <!-- Gender / Age / Blood Group -->
            <div class="row-three">

              <div class="form-group">
                <label for="gender">Gender</label>
                <div class="select-wrap">
                  <select id="gender" name="gender">
                    <option value="">-- Select --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="age">Age</label>
                <div class="select-wrap">
                  <select id="age" name="age">
                    <option value="">--</option>
                    <?php for ($i = 17; $i <= 65; $i++): ?>
                      <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="blood_group">Blood Group</label>
                <div class="select-wrap">
                  <select id="blood_group" name="blood_group">
                    <option value="">-- Select --</option>
                    <?php foreach (['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg): ?>
                      <option value="<?= $bg ?>"><?= $bg ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

            </div><!-- /.row-three -->

          </div><!-- /.form-grid -->

          <button type="submit" class="btn-update">UPDATE</button>

        </form>
      </div><!-- /.form-card -->

    </main>
  </div><!-- /.main-layout -->

</div><!-- /.app-wrapper -->

</body>
</html>
