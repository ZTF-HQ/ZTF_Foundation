<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Head Dashboard</title>
    <!-- Font Awesome library for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Link to your local CSS file -->
    <link rel="stylesheet" href="/staff dashboard.css">
</head>
<body>
    <?php include 'include_dashboard_header.php'; ?>
    
    <div class="dashboard-container expanded">
        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Hamburger menu button to toggle sidebar -->
            <button class="hamburger-menu" aria-label="Toggle Menu"><i class="fas fa-bars"></i></button>
            <div class="sidebar-header">
                <h2>My Department</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <!-- Navigation links for managing my staff and my personal info -->
                    <li><a href="#manage-staff-content" class="nav-link"><i class="fas fa-users"></i><span>Manage My Staff</span></a></li>
                    <li><a href="#add-staff-content" class="nav-link"><i class="fas fa-user-plus"></i><span>Add Staff</span></a></li>
                    <li><a href="#delete-staff-content" class="nav-link"><i class="fas fa-user-minus"></i><span>Delete Staff</span></a></li>
                    <li><a href="#view-profile-content" class="nav-link"><i class="fas fa-user-circle"></i><span>View My Profile</span></a></li>
                    <li><a href="#edit-profile-content" class="nav-link"><i class="fas fa-edit"></i><span>Edit My Profile</span></a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <div id="content-area" class="content-area">
                <!-- Section: Manage My Staff -->
                <div id="manage-staff-content" class="content-section card">
                    <h2>Manage My Staff</h2>
                    <table class="staff-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example Staff Member Rows (you can generate these with JavaScript) -->
                            <tr>
                                <td>101</td>
                                <td>Sarah Azimpey</td>
                                <td>Software Engineer</td>
                                <td class="actions">
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>102</td>
                                <td>Tchamga Daniel</td>
                                <td>Project Manager</td>
                                <td class="actions">
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Section: Add Staff to My Department -->
                <div id="add-staff-content" class="content-section card">
                    <h2>Add Staff to My Department</h2>
                    <form id="add-staff-form" class="edit-form">
                        <label for="new-name">Name</label>
                        <input type="text" id="new-name" name="name" required>
                        
                        <label for="new-position">Position</label>
                        <input type="text" id="new-position" name="position" required>
                        
                        <label for="new-department">Department</label>
                        <input type="text" id="new-department" name="department" required>
                        
                        <label for="new-email">Email</label>
                        <input type="email" id="new-email" name="email" required>
                        
                        <label for="new-phone">Phone</label>
                        <input type="tel" id="new-phone" name="phone" required>
                        
                        <button type="submit">Add Staff</button>
                    </form>
                </div>

                <!-- Section: Delete Staff from My Department -->
                <div id="delete-staff-content" class="content-section card">
                    <h2>Delete Staff from My Department</h2>
                    <form id="delete-staff-form" class="edit-form">
                        <p class="delete-warning"></p>
                        
                        <label for="delete-staff-id">Staff ID or Name</label>
                        <input type="text" id="delete-staff-id" name="staff-id" required placeholder="Enter Staff ID or Name">
                        
                        <button type="submit" class="delete-confirm-btn">Delete Staff</button>
                    </form>
                </div>
                
                <!-- Section: View My Profile -->
                <div id="view-profile-content" class="content-section card">
                    <h2>View My Profile</h2>
                    <div class="profile-info">
                        <div class="image-upload-wrapper">
                            <img id="profile-pic-preview" src="3768.jpg" alt="Profile Picture">
                        </div>
                        <h3>Sarah Azimpey</h3>
                        <p>Department Head</p>
                        <div class="profile-info-grid">
                            <div class="profile-info-item">
                                <strong>Department:</strong> 
                                <span>Software Development</span>
                            </div>
                            <div class="profile-info-item">
                                <strong>Email:</strong> 
                                <span>sarah.j@ztffoundation.com</span>
                            </div>
                            <div class="profile-info-item">
                                <strong>Phone:</strong> 
                                <span>+237 683 067 844</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Edit My Profile -->
                <div id="edit-profile-content" class="content-section card">
                    <h2>Edit My Profile</h2>
                    <form id="edit-form" class="edit-form">
                        <!-- Image Upload Options -->
                        <div class="image-upload-options">
                            <label>Change Profile Picture</label>
                            <div>
                                <input type="radio" id="upload-option" name="image-source" value="upload" checked>
                                <label for="upload-option">Upload Image</label>
                            </div>
                            <div>
                                <input type="radio" id="url-option" name="image-source" value="url">
                                <label for="url-option">Image URL</label>
                            </div>
                        </div>

                        <!-- Image Upload Section -->
                        <div id="upload-section" class="form-section active">
                            <label for="file-input-edit">Select Image File</label>
                            <input type="file" id="file-input-edit" accept=".png, .jpg, .jpeg">
                        </div>

                        <!-- Image URL Section -->
                        <div id="url-section" class="form-section">
                            <label for="url-input-edit">Enter Image URL</label>
                            <input type="url" id="url-input-edit" placeholder="https://----/image.jpg">
                        </div>

                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="Sarah Azimpey" required>
                        
                        <label for="position">Position</label>
                        <input type="text" id="position" name="position" value="Software Engineer" required>
                        
                        <label for="department">Department</label>
                        <input type="text" id="department" name="department" value="Software Development" required>
                        
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="sarah.j@ztffoundation.com" required>
                        
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" value="+237 683 067 844" required>

                        <button type="submit">Save Changes</button>
                    </form>
                    <div id="alert-message" class="alert-message">Profile updated successfully!</div>
                </div>
            </div>
        </main>
    </div>
    <script src="/staff dashboard.js"></script>
</body>
</html>
