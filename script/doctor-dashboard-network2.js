document.addEventListener("DOMContentLoaded", function () {
    // Sidebar animation
    const sidebarItems = document.querySelectorAll(".sidebar ul li");
    sidebarItems.forEach((item, index) => {
        setTimeout(() => {
            item.classList.add("show");
        }, index * 100); // delay each item by 100ms
    });

    // Menu toggle functionality
    let menuToggle = document.querySelector('.menuToggle');
    let sidebar = document.querySelector('.sidebar');
    let content = document.querySelector('.content');
    if (menuToggle && sidebar && content) {
        menuToggle.onclick = function () {
            menuToggle.classList.toggle('active');
            sidebar.classList.toggle('active');
            content.classList.toggle('shifted');
        };
    }

    // Menu list and section handling
    let menuList = document.querySelectorAll('.Menulist li');
    let sections = document.querySelectorAll('.content > div');
    function activeLink() {
        menuList.forEach((item) => item.classList.remove('active'));
        sections.forEach((section) => section.classList.remove('active-section'));
        this.classList.add('active');
        const sectionClass = this.getAttribute('data-section');
        const section = document.querySelector(`.${sectionClass}`);
        if (section) {
            section.classList.add('active-section');
        }
    }
    menuList.forEach((item) => item.addEventListener('click', activeLink));

    function showView(view) {
        // Hide all views
        const views = document.getElementsByClassName('view');
        for (let i = 0; i < views.length; i++) {
            views[i].style.display = 'none';
        }

        // Show the selected view and populate the table
        const selectedView = document.getElementById(view + '-view');
        if (selectedView) {
            selectedView.style.display = 'block';
            populateTable(view);
        }
    }

    function populateTable(view) {
        const tbody = document.getElementById(view + '-tbody');
        if (!tbody) return;
        tbody.innerHTML = '';

        data[view].forEach(user => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${user.id}</td>
                <td>${user.name}</td>
                <td>${user.surname}</td>
                <td>${user.age}</td>
                <td>${user.timeAdded}</td>
            `;
            tbody.appendChild(row);
        });
    }

    function searchUsers() {
        const input = document.getElementById('search-input');
        const filter = input.value.toLowerCase();
        const view = document.querySelector('.view:not([style*="display: none"])').id.split('-')[0];
        const tbody = document.getElementById(view + '-tbody');
        const rows = tbody.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            const name = cells[1].textContent.toLowerCase();
            rows[i].style.display = name.includes(filter) ? '' : 'none';
        }
    }

    // Report generation and settings
    function generateReport() {
        const reportOutput = document.getElementById('report-output');
        if (reportOutput) {
            reportOutput.innerHTML = `
                <h2>Sample Report</h2>
                <p>Date: ${new Date().toLocaleDateString()}</p>
                <p>Generated data goes here...</p>
            `;
        }
    }

    //Function to Save Settings
    function saveSettings() {
        const siteTitle = document.getElementById('site-title');
        const timezone = document.getElementById('timezone');
        if (siteTitle && timezone) {
            console.log('Settings saved:', {
                siteTitle: siteTitle.value,
                timezone: timezone.value
            });
            alert('Settings saved successfully!');
        }
    }
});
