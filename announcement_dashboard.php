<?php include 'include/navbar.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<div class="main">

    <div class="dashboard-container flex">
        <div class="dashboard-cards-and-chart">
            <div class="dashboard-cards fixed-cards">
                <div class="card card-primary">
                    <i class="fas fa-bullhorn icon"></i>
                    <div>
                        <h3>Total Announcements</h3>
                        <p id="total-announcements">0</p>
                    </div>
                </div>
                <div class="card card-user">
                    <i class="fas fa-users icon"></i>
                    <div>
                        <h3>Total Users</h3>
                        <p id="total-users">0</p>
                    </div>
                </div>
                <div class="card card-cancel">
                    <i class="fas fa-hourglass-half icon"></i>
                    <div>
                        <h3>Pending</h3>
                        <p id="pending-count">0</p>
                    </div>
                </div>
                <div class="card card-approve">
                    <i class="fas fa-check-circle icon"></i>
                    <div>
                        <h3>Approved</h3>
                        <p id="approved-count">0</p>
                    </div>
                </div>
                <div class="card card-disabled">
                    <i class="fas fa-times-circle icon"></i>
                    <div>
                        <h3>Dismissed</h3>
                        <p id="dismissed-count">0</p>
                    </div>
                </div>
                <div class="card card-delete">
                    <i class="fas fa-trash-alt icon"></i>
                    <div>
                        <h3>Deleted</h3>
                        <p id="deleted-count">0</p>
                    </div>
                </div>
                <div class="card card-export">
                    <i class="fas fa-file-export"></i>
                    <button type="button" class="export-btn">Export</button>
                </div>
            </div>
        </div>

        <div class="charts-flex">
            <main class="account-content">
                <div class="acc-header">
                    <h2><i class="fas fa-check-circle"></i> Approved</h2>
                </div>
                <div class="table-grid" id="postContainer">
                    <!-- table appear here -->
                    <table class="approvedTable">
                        <colgroup>
                            <col style="width: 150px;"> <!-- Account ID -->
                            <col style="width: 100px;"> <!-- Name -->
                            <col style="width: 250px;"> <!-- Username -->
                            <col style="width: 100px;"> <!-- User Type -->
                            <col style="width: 100px;"> <!-- Email -->
                            <col style="width: 120px;"> <!-- Email -->
                            <col style="width: 120px;"> <!-- Email -->
                            <col style="width: 200px;"> <!-- Action -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Posted By</th>
                                <th>Approved By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="accountBody">

                        </tbody>
                    </table>
                </div>
            </main>
            <main class="account-content">
                <div class="acc-header">
                    <h2><i class="fas fa-hourglass-half"></i> Pending</h2>
                </div>
                <div class="table-grid" id="postContainer">
                    <!-- table appear here -->
                    <table class="pendingTable">
                        <colgroup>
                            <col style="width: 150px;"> <!-- Account ID -->
                            <col style="width: 100px;"> <!-- Name -->
                            <col style="width: 250px;"> <!-- Username -->
                            <col style="width: 100px;"> <!-- User Type -->
                            <col style="width: 100px;"> <!-- Email -->
                            <col style="width: 120px;"> <!-- Email -->
                            <col style="width: 120px;"> <!-- Email -->
                            <col style="width: 200px;"> <!-- Action -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Posted By</th>
                                <th>Approved By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="accountBody">

                        </tbody>
                    </table>
                </div>
            </main>
            <main class="account-content">
                <div class="acc-header">
                    <h2><i class="fas fa-times-circle"></i> Dismissed</h2>
                </div>
                <div class="table-grid" id="postContainer">
                    <!-- table appear here -->
                    <table class="dismissedTable">
                        <colgroup>
                            <col style="width: 150px;"> <!-- Account ID -->
                            <col style="width: 100px;"> <!-- Name -->
                            <col style="width: 250px;"> <!-- Username -->
                            <col style="width: 100px;"> <!-- User Type -->
                            <col style="width: 100px;"> <!-- Email -->
                            <col style="width: 120px;"> <!-- Email -->
                            <col style="width: 120px;"> <!-- Email -->
                            <col style="width: 200px;"> <!-- Action -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Posted By</th>
                                <th>Approved By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="accountBody">

                        </tbody>
                    </table>
                </div>
            </main>
            <main class="account-content">
                <div class="acc-header">
                    <h2><i class="fas fa-trash"></i> Deleted</h2>
                </div>
                <div class="table-grid" id="postContainer">
                    <!-- table appear here -->
                    <table class="deletedTable">
                        <colgroup>
                            <col style="width: 150px;"> <!-- Account ID -->
                            <col style="width: 100px;"> <!-- Name -->
                            <col style="width: 250px;"> <!-- Username -->
                            <col style="width: 100px;"> <!-- User Type -->
                            <col style="width: 100px;"> <!-- Email -->
                            <col style="width: 120px;"> <!-- Email -->
                            <col style="width: 120px;"> <!-- Email -->
                            <col style="width: 200px;"> <!-- Action -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Posted By</th>
                                <th>Approved By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="accountBody">

                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal for Creating a Post -->
    <div class="modal" id="bulletinModal">
        <div class="modal-content">
            <h2>Create Accounts</h2>
            <form id="accForm">
                <input type="hidden" id="announcement_id" placeholder="announcement_id" minlength="4" maxlength="25" autocomplete="off" name="announcement_id" />
                <input type="text" id="title" placeholder="Title" minlength="4" maxlength="25" autocomplete="off" name="title" required />
                <select class="category" id="category" name="category" required>
                    <option value="reminder" selected>Reminder</option>
                    <option value="urgent">Urgent</option>
                    <option value="due date">Due Date</option>
                    <option value="important">Important</option>
                </select>
                <textarea id="description" placeholder="Description" minlength="4" maxlength="500" autocomplete="off" name="description"></textarea>
                <div class="modal-footer">
                    <button type="button" class="btn" id="closeModal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="create-account">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'include/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchAnnouncements();

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('bulletinModal').classList.remove('show');
            clearForm(document.getElementById('accForm'));
        });

        function toggleModal() {
            document.getElementById('bulletinModal').classList.toggle('show');
        }

        function clearForm(thisForm) {
            thisForm.reset();
        }

        function fetchDashboardData() {
            fetch('db_queries/select/dashboard_data.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total-users').textContent = data.total_users ?? 0;
                    document.getElementById('total-announcements').textContent = data.total_announcements ?? 0;
                    document.getElementById('pending-count').textContent = data.pending ?? 0;
                    document.getElementById('approved-count').textContent = data.approved ?? 0;
                    document.getElementById('dismissed-count').textContent = data.dismissed ?? 0;
                    document.getElementById('deleted-count').textContent = data.deleted ?? 0;
                })
                .catch(error => console.error('Error fetching dashboard data:', error));
        }

        fetchDashboardData();

        function fetchAnnouncements() {
            fetch('db_queries/select/fetch_announcements_data.php')
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        populateTables(data.data)
                    } else {
                        alert("Failed to load announcements.");
                    }
                })
                .catch(err => console.error("Error fetching announcements:", err));
        }

        function populateTables(posts) {
            const approvedTbody = document.querySelector('.approvedTable tbody');
            const pendingTbody = document.querySelector('.pendingTable tbody');
            const dismissedTbody = document.querySelector('.dismissedTable tbody');
            const deletedTbody = document.querySelector('.deletedTable tbody');

            // Clear old data
            approvedTbody.innerHTML = '';
            pendingTbody.innerHTML = '';
            dismissedTbody.innerHTML = '';
            deletedTbody.innerHTML = '';

            posts.forEach(post => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                        <td>${post.title}</td>
                        <td>${post.category}</td>
                        <td><p class="description">${post.description}</p></td>
                        <td>${formatDate(post.date)}</td>
                        <td><span class="${post.status}">${capitalize(post.status)}</span></td>
                        <td>${post.postedByName || 'N/A'}</td>
                        <td>${post.approvedByName || 'N/A'}</td>
                        <td>
                            <button class="btn-icon btn-check check-post" data-id="${post.announcement_id}"><i class="fas fa-check"></i></button>
                            <button class="btn-icon btn-edit edit-post" data-id="${post.announcement_id}"><i class="fas fa-edit"></i></button>
                            <button class="btn-icon btn-dismiss dismiss-post" data-id="${post.announcement_id}"><i class="fas fa-times"></i></button>
                            <button class="btn-icon btn-delete delete-post" data-id="${post.announcement_id}"><i class="fas fa-trash"></i></button>
                        </td>
                    `;

                // Append to correct table
                switch (post.status.toLowerCase()) {
                    case 'approved':
                        approvedTbody.appendChild(tr);
                        break;
                    case 'pending':
                        pendingTbody.appendChild(tr);
                        break;
                    case 'dismissed':
                        dismissedTbody.appendChild(tr);
                        break;
                    case 'deleted':
                        deletedTbody.appendChild(tr);
                        break;
                }
            });
        }

        // Optional helpers
        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        function formatDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString(); // Or customize format
        }

        // Load on page load


        const token = localStorage.getItem("jwt_token");
        // console.log("JWT Token: ", token);
        if (!token) {
            window.location.href = "index.php";
        }
        const payloadBase64 = token.split('.')[1];
        const payloadJson = atob(payloadBase64);
        const payload = JSON.parse(payloadJson);
        const userId = payload.user_id;



        const tables = document.querySelectorAll('table');

        tables.forEach(table => {
            table.addEventListener('click', function(e) {
                const button = e.target.closest('button');
                if (!button) return;

                const postId = button.dataset.id;

                if (button.classList.contains('check-post')) {
                    console.log('Check post:', postId);
                    if (confirm("Are you sure you want to approve this post?")) {
                        updateStatus(postId, 'approved', userId);
                    }
                    // handle check post logic
                } else if (button.classList.contains('edit-post')) {
                    console.log('Edit post:', postId);
                    populatePostForm(postId);
                    document.getElementById('bulletinModal').classList.add('show');
                    // handle edit post logic
                } else if (button.classList.contains('dismiss-post')) {
                    console.log('Dismiss post:', postId);
                    if (confirm("Are you sure you want to dismiss this post?")) {
                        updateStatus(postId, 'dismissed');
                    }
                    // handle dismiss post logic
                } else if (button.classList.contains('delete-post')) {
                    console.log('Delete post:', postId);
                    if (confirm("Are you sure you want to delete this post?")) {
                        updateStatus(postId, 'deleted');
                    }
                    // handle delete post logic
                }
            });
        });

        async function updateStatus(id, status, approvedBy = null) {
            try {
                const formData = new FormData();
                formData.append('id', id);
                formData.append('status', status);
                if (approvedBy) {
                    formData.append('approvedBy', approvedBy);
                }

                const response = await fetch('db_queries/edit/update_announcement_status.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                if (result.success) {
                    // Optionally re-fetch data or update UI manually
                    fetchAnnouncements();
                    fetchDashboardData();
                } else {
                    alert('Update failed: ' + result.message);
                }
            } catch (error) {
                console.error(error);
                alert('Something went wrong.');
            }
        }
        const modalBtn = document.getElementById('create-account');

        function populatePostForm(announcementId) {
            fetch('db_queries/select/fetch_my_post.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        announcement_id: announcementId
                    }),
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data) {
                        const post = data.data;

                        document.getElementById('announcement_id').value = post.announcement_id;
                        document.getElementById('title').value = post.title;
                        document.getElementById('category').value = post.category;
                        document.getElementById('description').value = post.description;
                        // document.getElementById('expired_date').value = post.expired_date;

                        modalBtn.innerText = 'Update';

                    } else {
                        alert("Failed to load announcement: " + data.message);
                    }
                })
                .catch(error => console.error("Error:", error));
        }

        const accForm = document.getElementById('accForm');

        if (accForm) {
            accForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                // Update existing post
                fetch('db_queries/edit/update_post.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Announcement updated successfully.");
                            fetchAnnouncements();
                            clearForm(accForm);
                            toggleModal();
                        } else {
                            alert("Failed to update announcement: " + data.message);
                        }
                    })
                    .catch(error => console.error("Error:", error));
            })
        }


        async function exportToExcel() {
            try {
                const res = await fetch('db_queries/select/fetch_announcements_data.php');
                const result = await res.json();

                if (!result.success || !result.data || result.data.length === 0) {
                    alert("No data to export.");
                    return;
                }

                // Format and reorder columns
                const cleanedData = result.data.map(item => ({
                    "Title": item.title,
                    "Category": item.category,
                    "Description": item.description,
                    "Posted Date": new Date(item.date).toLocaleString(),
                    "Expiration Date": new Date(item.expiredDate).toLocaleDateString(),
                    "Posted By": item.postedByName || "Unknown"
                }));

                // Generate Excel file
                const worksheet = XLSX.utils.json_to_sheet(cleanedData);
                const workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(workbook, worksheet, "Announcements");

                XLSX.writeFile(workbook, "announcements_export.xlsx");

            } catch (error) {
                console.error("Error exporting to Excel:", error);
            }
        }
        const exportBtn = document.querySelector('.export-btn');
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                exportToExcel();
            });
        }

    })
</script>
