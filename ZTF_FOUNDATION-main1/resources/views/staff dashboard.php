<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>General Staff Dasboard</title>
    <!-- Font Awesome library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Boxicons library (CDN) -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <link rel="stylesheet" href="staff dashboard.css">
</head>
<body>

    <div class="dashboard-container expanded">
        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Hamburger menu button -->
            <button class="hamburger-menu" aria-label="Toggle Menu"><i class="fas fa-bars"></i></button>
            <div class="sidebar-header">
                <h2>Staff Member</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    
                    <li><a href="#view-profile-content" class="nav-link active"><i class="fas fa-user-circle"></i><span>View Profile</span></a></li>
                    <li><a href="#edit-profile-content" class="nav-link"><i class="fas fa-edit"></i><span>Edit Profile</span></a></li>
                </ul>
            </nav>
        </aside>

        <div id="content-area" class="content-area">
                <!-- Content sections are now directly in the HTML -->
                <div id="view-profile-content" class="content-section card">
                    <div class="profile-info">
                        <div class="image-upload-wrapper">
                            <img id="profile-pic-preview" src="3768.jpg" alt="Profile Picture">
                            
                        </div>
                        <h3>Sarah Azimpey</h3>
                        <p>Software Engineer</p>
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


    <div id="edit-profile-content" class="content-section card">
    <h2>Edit Profile</h2>
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

        </main>
    </div>
<script src="staff dashboard.js"></script>
    </body>
</html>