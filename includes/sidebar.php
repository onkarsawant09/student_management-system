<?php
$current_page = basename($_SERVER['PHP_SELF']);
$is_admin = isAdmin();
?>
<div class="sidebar">
    <div class="sidebar-header">
        <h3>SMS Portal</h3>
        <p><?php echo $_SESSION['full_name']; ?></p>
    </div>
    <div class="sidebar-nav">
        <?php if($is_admin): ?>
            <a href="../admin/dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="../admin/add-student.php"><i class="fas fa-user-plus"></i> Add Student</a>
            <a href="../admin/view-students.php"><i class="fas fa-users"></i> View Students</a>
            <a href="../admin/add-course.php"><i class="fas fa-plus-circle"></i> Add Course</a>
            <a href="../admin/view-courses.php"><i class="fas fa-list"></i> View Courses</a>
            <a href="../admin/manage-faculty.php"><i class="fas fa-chalkboard-user"></i> Manage Faculty</a>
            <a href="../admin/mark-attendance.php"><i class="fas fa-check-circle"></i> Mark Attendance</a>
            <a href="../admin/view-attendance.php"><i class="fas fa-eye"></i> View Attendance</a>
            <a href="../admin/create-assignment.php"><i class="fas fa-file-alt"></i> Create Assignment</a>
            <a href="../admin/view-submissions.php"><i class="fas fa-upload"></i> View Submissions</a>
            <a href="../admin/add-results.php"><i class="fas fa-chart-line"></i> Add Results</a>
            <a href="../admin/add-notice.php"><i class="fas fa-bullhorn"></i> Add Notice</a>
            <a href="../admin/manage-notices.php"><i class="fas fa-edit"></i> Manage Notices</a>
            <a href="../admin/send-messages.php"><i class="fas fa-paper-plane"></i> Send Messages</a>
            <a href="../admin/settings.php"><i class="fas fa-cog"></i> Settings</a>
        <?php else: ?>
            <a href="../student/dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="../student/profile.php"><i class="fas fa-user"></i> Profile</a>
            <a href="../student/edit-profile.php"><i class="fas fa-edit"></i> Edit Profile</a>
            <a href="../student/courses.php"><i class="fas fa-book"></i> My Courses</a>
            <a href="../student/attendance.php"><i class="fas fa-calendar-check"></i> Attendance</a>
            <a href="../student/assignments.php"><i class="fas fa-tasks"></i> Assignments</a>
            <a href="../student/results.php"><i class="fas fa-chart-line"></i> Results</a>
            <a href="../student/notices.php"><i class="fas fa-bullhorn"></i> Notices</a>
            <a href="../student/messages.php"><i class="fas fa-envelope"></i> Messages</a>
            <a href="../student/settings.php"><i class="fas fa-cog"></i> Settings</a>
        <?php endif; ?>
        <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>