document.addEventListener("DOMContentLoaded", function () {
    const sidebarItems = document.querySelectorAll(".sidebar ul li");
    const menuToggle = document.querySelector('.menuToggle');
    const sidebar = document.querySelector('.sidebar');
    const content = document.querySelector('.content');
    const menuList = document.querySelectorAll('.Menulist li');
    const sections = document.querySelectorAll('.content > div');

    // Show sidebar items with a delay
    sidebarItems.forEach((item, index) => {
        setTimeout(() => {
            item.classList.add("show");
        }, index * 100); // delay each item by 100ms
    });

    // Toggle sidebar and content shift
    menuToggle.onclick = function () {
        menuToggle.classList.toggle('active');
        sidebar.classList.toggle('active');
        content.classList.toggle('shifted');
    };

    // Handle menu item click and section display
    function activeLink() {
        menuList.forEach((item) => item.classList.remove('active'));
        sections.forEach((section) => section.classList.remove('active-section'));
        this.classList.add('active');
        document.querySelector(`.${this.getAttribute('data-section')}`).classList.add('active-section');
    }

    menuList.forEach((item) => item.addEventListener('click', activeLink));

    // Show the default view on page load
    showView('admin');
    document.getElementById('user_type').addEventListener('change', toggleFields);
    toggleFields(); // Set initial state based on user type
});

// Function to show the selected view
function showView(view) {
    const views = document.getElementsByClassName('view');

    // Hide all views
    for (let i = 0; i < views.length; i++) {
        views[i].style.display = 'none';
    }

    // Show the selected view
    document.getElementById(view + '-view').style.display = 'block';

    // Populate the table based on the selected view
    populateTable(view);
}

// Function to populate the table based on the selected view
function populateTable(view) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `view_users.php?view=${encodeURIComponent(view)}`, true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            const tbody = document.getElementById(`${view}-tbody`);
            tbody.innerHTML = ''; // Clear existing data

            data.forEach(item => {
                const row = document.createElement('tr');
                for (const key in item) {
                    const cell = document.createElement('td');
                    cell.textContent = item[key];
                    row.appendChild(cell);
                }

                // Add edit and delete buttons
                const editCell = document.createElement('td');
                const editButton = document.createElement('button');
                editButton.textContent = 'Edit';
                editButton.onclick = () => editUser(editButton);
                editCell.appendChild(editButton);
                row.appendChild(editCell);

                const deleteCell = document.createElement('td');
                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Delete';
                deleteButton.onclick = () => deleteUser(deleteButton);
                deleteCell.appendChild(deleteButton);
                row.appendChild(deleteCell);

                tbody.appendChild(row);
            });
        } else {
            alert('Failed to load data. Please try again.');
        }
    };

    xhr.onerror = function () {
        alert('Request failed. Please try again.');
    };

    xhr.send();
}

// Function to search users based on input
function searchUsers() {
    const input = document.getElementById('search-input');
    const filter = input.value.toLowerCase();
    const view = document.querySelector('.view:not([style*="display: none"])').id.split('-')[0];
    const tbody = document.getElementById(`${view}-tbody`);
    const rows = tbody.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        const name = cells[1] ? cells[1].textContent.toLowerCase() : '';
        rows[i].style.display = name.includes(filter) ? '' : 'none';
    }
}

// Placeholder function for editing a user
function editUser(button) {
    const row = button.parentElement.parentElement;
    const userId = row.children[0].textContent; // Assuming ID is in the first column
    alert(`Edit functionality for user ID ${userId} will be implemented soon.`);
}

// Function to delete a user
function deleteUser(button) {
    if (confirm('Are you sure you want to delete this user?')) {
        const row = button.parentElement.parentElement;
        const userId = row.children[0].textContent; // Assuming ID is in the first column
        const view = document.querySelector('.view:not([style*="display: none"])').id.split('-')[0];

        const xhr = new XMLHttpRequest();
        xhr.open("GET", `delete_user.php?id=${encodeURIComponent(userId)}&view=${encodeURIComponent(view)}`, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert("User deleted successfully");
                    populateTable(view); // Refresh the view or update the UI accordingly
                } else {
                    alert("Failed to delete user: " + response.message);
                }
            } else {
                alert('Failed to delete user. Please try again.');
            }
        };

        xhr.onerror = function () {
            alert('Request failed. Please try again.');
        };

        xhr.send();
    }
}

// Function to toggle form fields based on user type
function toggleFields() {
    const userType = document.getElementById('user_type').value;
    const passwordContainer = document.getElementById('password_container');
    const specialistContainer = document.getElementById('specialist_container');
    const departmentContainer = document.getElementById('department_container');
    const sicknessContainer = document.getElementById('sickness_container');

    // Hide all extra fields initially
    passwordContainer.style.display = 'block'; // Show by default
    specialistContainer.style.display = 'none';
    departmentContainer.style.display = 'none';
    sicknessContainer.style.display = 'none';

    // Show fields based on user type
    switch (userType) {
        case 'Admin':
            break;
        case 'Doctor':
            specialistContainer.style.display = 'block';
            break;
        case 'Health Worker':
            departmentContainer.style.display = 'block';
            break;
        case 'Patient':
            passwordContainer.style.display = 'none';
            sicknessContainer.style.display = 'block';
            break;
    }
}

// open dashbboard -->

    window.onload = function() {
        // Automatically expand the sidebar when loading the dashboard
        document.querySelector('.sidebar').classList.add('active');
        document.querySelector('.content').classList.add('shifted');
    };

    //<!-- username to appear-->
        document.addEventListener('DOMContentLoaded', function() {
        fetch('php/getUsername.php') // Ensure the path is correct
        .then(response => response.json())
        .then(data => {
            if (data.username) {
                document.getElementById('username-placeholder').textContent = data.username;
            } else {
                console.error('Error:', data.error);
            }
        })
        .catch(error => console.error('Error fetching username:', error));
        });

//SHOW VIEW of the functions
        function showView(view) 
            {
                // Hide all views
                    document.querySelectorAll('.view').forEach(function(el) {
                    el.style.display = 'none';
                 });

                // Show selected view
                const viewElement = document.getElementById(view + '-view');
                if (viewElement) {
                viewElement.style.display = 'block';
                } else {
                console.error('View element not found for:', view);
                }

                // Fetch data for the selected view
                fetch(`php/view_users.php?view=${view}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data:', data); // Check the data received
                    const tbody = document.getElementById(view + '-tbody');
                    if (tbody) {
                        tbody.innerHTML = ''; // Clear existing rows

                        if (data.length > 0) {
                            data.forEach(row => {
                                let tr = '<tr>';
                                for (const [key, value] of Object.entries(row)) {
                                    tr += `<td>${value}</td>`;
                                }
                                tr += '</tr>';
                                tbody.innerHTML += tr;
                            });
                        } else {
                            tbody.innerHTML = '<tr><td colspan="15">No records found</td></tr>';
                        }
                    } else {
                        console.error('Tbody element not found for:', view);
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
                }

                // Initial view load
                showView('admin');

                function searchUsers() {
                const input = document.getElementById("search-input").value.toLowerCase();
                const activeView = document.querySelector(".view[style='display: block;']");
                const rows = activeView.querySelectorAll("tbody tr");

                rows.forEach(row => {
                const cells = row.getElementsByTagName("td");
                let match = false;

                for (let i = 0; i < cells.length; i++) {
                    if (cells[i].innerText.toLowerCase().includes(input)) {
                        match = true;
                        break;
                    }
                }

                if (match) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
                });
                }

//            <!-- for radio buttons for different users -->
                function showForm(userType) {
                    // Hide all forms
                    const forms = document.querySelectorAll('.user-form-section');
                    forms.forEach(form => {
                        form.style.display = 'none';
                        form.querySelectorAll('input, select').forEach(input => {
                            input.removeAttribute('required');
                        });
                    });

                    // Show the selected form and set required attributes
                    const selectedForm = document.getElementById(`${userType}_form`);
                    if (selectedForm) {
                        selectedForm.style.display = 'block';
                        selectedForm.querySelectorAll('input, select').forEach(input => {
                            input.setAttribute('required', 'required');
                        });
                    }
                }
