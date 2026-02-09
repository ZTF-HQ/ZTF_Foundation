document.addEventListener('DOMContentLoaded', () => {
    // Select all necessary elements for the dashboard functionality.
    const navLinks = document.querySelectorAll('.nav-link');
    const hamburgerMenu = document.querySelector('.hamburger-menu');
    const dashboardContainer = document.querySelector('.dashboard-container');
    const contentSections = document.querySelectorAll('.content-section');

    // Select all the forms.
    const editForm = document.getElementById('edit-form');
    const addStaffForm = document.getElementById('add-staff-form');
    const deleteStaffForm = document.getElementById('delete-staff-form');

    // Elements for image upload/URL functionality.
    const uploadOption = document.getElementById('upload-option');
    const urlOption = document.getElementById('url-option');
    const uploadSection = document.getElementById('upload-section');
    const urlSection = document.getElementById('url-section');
    const fileInput = document.getElementById('file-input-edit');
    const profilePicPreview = document.getElementById('profile-pic-preview');

    // Handle the hamburger menu click to toggle the sidebar.
    if (hamburgerMenu) {
        hamburgerMenu.addEventListener('click', () => {
            dashboardContainer.classList.toggle('expanded');
        });
    }

    // Handle navigation clicks for all sidebar links.
    navLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            // Prevent the default link behavior
            event.preventDefault();

            // Remove the 'active' class from all links.
            navLinks.forEach(l => l.classList.remove('active'));
            // Add the 'active' class to the clicked link.
            event.currentTarget.classList.add('active');

            // Get the ID of the target content section from the href attribute.
            const targetId = event.currentTarget.getAttribute('href').substring(1);

            // Hide all content sections.
            contentSections.forEach(section => {
                section.style.display = 'none';
            });

            // Show only the target content section.
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                targetSection.style.display = 'block';
            }
        });
    });

    // On initial page load, display the 'Manage Staff' section by default.
    const initialLink = document.querySelector('[href="#manage-staff-content"]');
    if (initialLink) {
        initialLink.click();
    }

    // Handle the image source radio buttons to show/hide the correct input field.
    if (uploadOption && urlOption) {
        uploadOption.addEventListener('change', () => {
            uploadSection.style.display = 'block';
            urlSection.style.display = 'none';
        });
        urlOption.addEventListener('change', () => {
            urlSection.style.display = 'block';
            uploadSection.style.display = 'none';
        });
    }

    // Handle image file upload and preview.
    if (fileInput) {
        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    profilePicPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Handle 'Edit Profile' form submission.
    if (editForm) {
        editForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const alertMessage = document.getElementById('alert-message');
            alertMessage.style.display = 'block';
            setTimeout(() => {
                alertMessage.style.opacity = 1;
            }, 10);
            
            // Hide the message after a delay and redirect to the view page.
            setTimeout(() => {
                alertMessage.style.opacity = 0;
                setTimeout(() => alertMessage.style.display = 'none', 500);
            }, 1500);
        });
    }

    // Handle 'Add Staff' form submission.
    if (addStaffForm) {
        addStaffForm.addEventListener('submit', (event) => {
            event.preventDefault();
            console.log('Adding new staff member...');
            // In a real application, you would send this data to a server.
            const formData = new FormData(addStaffForm);
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }
            // Use a simple alert for demonstration.
            alert('Staff member added successfully!');
            addStaffForm.reset();
        });
    }

    // Handle 'Delete Staff' form submission.
    if (deleteStaffForm) {
        deleteStaffForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const staffIdOrName = document.getElementById('delete-staff-id').value;
            console.log(`Attempting to delete staff member: ${staffIdOrName}`);
            // Use a simple alert for demonstration.
            alert(`Staff member '${staffIdOrName}' has been deleted.`);
            deleteStaffForm.reset();
        });
    }

    // Add event listeners to the 'Manage Staff' table for Edit and Delete buttons.
    const staffTableBody = document.querySelector('.staff-table tbody');
    if (staffTableBody) {
        staffTableBody.addEventListener('click', (event) => {
            const target = event.target;
            const row = target.closest('tr');
            if (!row) return;

            const staffId = row.cells[0].textContent;

            // Handle edit button click.
            if (target.closest('.edit-btn')) {
                console.log(`Editing staff member with ID: ${staffId}`);
                
                const editLink = document.querySelector('[href="#edit-profile-content"]');
                if (editLink) {
                    editLink.click();
                }
            // Handle delete button click.
            } else if (target.closest('.delete-btn')) {
                console.log(`Deleting staff member with ID: ${staffId}`);
                
                alert(`Staff member with ID '${staffId}' has been deleted.`);
            }
        });
    }
});
