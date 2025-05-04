<?php include 'include/navbar.php'; ?>

<div class="main">
    <div class="post-container">
        <div class="form-container">
            <form id="postForm" class="modern-form">
                <h2>Post Announcement</h2>

                <input type="hidden" id="announcement_id" name="announcement_id">

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter title" minlength="3" maxlength="40" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="urgent">Urgent</option>
                        <option value="reminder" selected>Reminder</option>
                        <option value="due date">Due Date</option>
                        <option value="important">Important</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Enter description" minlength="3" maxlength="200" autocomplete="off" required></textarea>
                </div>

                <!-- <div class="form-group">
                    <label for="expired_date">Expired Date</label>
                    <input type="date" id="expired_date" name="expired_date" required>
                </div> -->

                <button type="submit" class="submit-btn">Post Announcement</button>
                <button type="cancel" class="cancel-btn">Cancel</button>
            </form>

        </div>

        <div class="postTable">
            <div class="acc-header">
                <h2><i class="fas fa-file-alt"></i> My Posts</h2>
            </div>
            <div class="table-grid post-grid">
                <table class="postsTable">
                    <colgroup>
                        <col style="width: 150px;"> <!-- Account ID -->
                        <col style="width: 100px;"> <!-- Name -->
                        <col style="width: 300px;"> <!-- Username -->
                        <col style="width: 100px;"> <!-- User Type -->
                        <!-- <col style="width: 100px;">  -->
                        <col style="width: 100px;"> <!-- Email -->
                        <col style="width: 100px;"> <!-- Action -->
                        <col style="width: 150px;"> <!-- Action -->
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Date</th>
                            <!-- <th>Expired Date</th> -->
                            <th>Status</th>
                            <th>Approved By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="postsTableBody">
                        <!-- Dynamic content will be inserted here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include 'include/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchMyPosts();
        async function fetchMyPosts() {
            const token = localStorage.getItem("jwt_token");
            // console.log("JWT Token: ", token);
            if (!token) {
                // Redirect to login page if token is not present
                // console.log("No token found. Redirecting to login page.");
                window.location.href = "index.php";

            }
            const payloadBase64 = token.split('.')[1];
            const payloadJson = atob(payloadBase64);
            const payload = JSON.parse(payloadJson);
            const userId = payload.user_id; // Get user ID from the token
            // console.log(userId);

            try {
                const response = await fetch('db_queries/select/get_my_posts.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        user_id: userId
                    })
                })
                const result = await response.json();

                if (result.success) {
                    // console.log(result.posts);
                    updateTable(result.posts);
                } else {
                    console.log('Error fetching users posts.')
                }
            } catch (error) {
                console.error("Error fetching user posts:", error);
            }
        }

        function updateTable(posts) {
            const tbody = document.getElementById("postsTableBody");
            tbody.innerHTML = ""; // Clear any existing rows

            posts.forEach(post => {
                const tr = document.createElement("tr");

                tr.innerHTML = `
                    <td>${post.title}</td>
                    <td>${post.category}</td>
                    <td><p class="description">${post.description}</p></td>
                    <td>${formatDate(post.date)}</td>
                    <td><p class="${post.status}">${capitalize(post.status)}</p></td>
                    <td>${post.approved_by || 'N/A'}</td>
                    <td>
                        <button class="btn-icon btn-check edit-post" data-id="${post.announcement_id}"><i class="fas fa-edit"></i></button>
                        <button class="btn-icon btn-delete delete-post" data-id="${post.announcement_id}"><i class="fas fa-trash"></i></button>
                    </td>
                    `;
                    // <td>${formatDate(post.expired_date)}</td>

                tbody.appendChild(tr);
            });
        }

        // Helper functions
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString(); // You can customize this
        }

        function capitalize(text) {
            return text.charAt(0).toUpperCase() + text.slice(1);
        }

        const postTable = document.querySelector('.postsTable');
        const formBtn = document.querySelector('.submit-btn');

        postTable.addEventListener('click', function(e) {
            if (e.target.classList.contains('edit-post')) {
                const announcementId = e.target.dataset.id
                populatePostForm(announcementId);
            }
            if (e.target.classList.contains('delete-post')) {
                const announcementId = e.target.dataset.id
                const confirmation = confirm("Are you sure you want to delete this post?");
                if (confirmation) {
                    fetch('db_queries/delete/delete_post.php', {
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
                            if (data.success) {
                                alert(data.message);
                                fetchMyPosts(); // Refresh the posts table
                                clearForm(); // Clear the form
                            } else {
                                alert("Failed to delete post: " + data.message);
                            }
                        })
                        .catch(error => console.error("Error:", error));
                }

            }
        })

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

                        formBtn.innerText = 'Update Announcement';
                    } else {
                        alert("Failed to load announcement: " + data.message);
                    }
                })
                .catch(error => console.error("Error:", error));
        }

        document.querySelector('.cancel-btn').addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default action
            clearForm();
        })

        function clearForm() {
            const postForm = document.getElementById('postForm');
            postForm.reset(); // Reset the form
            formBtn.innerText = "Post Announcement"; // Reset button text
        }

        const postForm = document.getElementById('postForm');

        if (postForm) {
            postForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const token = localStorage.getItem("jwt_token");
                // console.log("JWT Token: ", token);
                if (!token) {
                    // Redirect to login page if token is not present
                    // console.log("No token found. Redirecting to login page.");
                    window.location.href = "index.php";

                }
                const payloadBase64 = token.split('.')[1];
                const payloadJson = atob(payloadBase64);
                const payload = JSON.parse(payloadJson);
                const userId = payload.user_id;

                const announcementId = document.getElementById('announcement_id').value;
                let url = '';

                if (announcementId) {
                    //update
                    url = 'db_queries/edit/update_post.php'
                } else {
                    //insert
                    url = 'db_queries/insert/insert_post.php'
                }

                const formData = new FormData(this);
                formData.append('user_id', userId)
                fetch(url, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            // Optionally, you can refresh the page or update the table here
                            postForm.reset(); // Reset the form
                            formBtn.innerText = "Post Announcement"; // Reset button text
                            fetchMyPosts();
                        } else {
                            alert('Error creating account: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            })
        }

        
    })
</script>
