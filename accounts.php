<?php include 'include/navbar.php' ?>

<div class="main">


    <main class="account-content">
        <div class="acc-header">
            <h2><i class="fas fa-user"></i> Accounts</h2>
            <button class="add-btn" title="New Post" id="openModal">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div class="table-grid" id="postContainer">
            <!-- table appear here -->
            <table class="accountsTable">
                <colgroup>
                    <col style="width: 150px;"> <!-- Account ID -->
                    <col style="width: 150px;"> <!-- Name -->
                    <col style="width: 150px;"> <!-- Username -->
                    <col style="width: 150px;"> <!-- User Type -->
                    <col style="width: 150px;"> <!-- Email -->
                    <col style="width: 150px;"> <!-- Email -->
                    <col style="width: 200px;"> <!-- Action -->
                </colgroup>
                <thead>
                    <tr>
                        <th>Account ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>User Type</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="accountBody">

                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal for Creating a Post -->
    <div class="modal" id="bulletinModal">
        <div class="modal-content">
            <h2>Create Accounts</h2>
            <form id="accForm">
                <input type="hidden" id="userId" placeholder="userId" minlength="4" maxlength="25" autocomplete="off" name="userId" />
                <input type="text" id="name" placeholder="Name" minlength="4" maxlength="25" autocomplete="off" name="name" required />
                <input type="username" id="username" placeholder="Username" minlength="4" maxlength="25" autocomplete="off" name="username" required />
                <input type="password" id="password" placeholder="Password" minlength="4" maxlength="25" autocomplete="off" name="password" required />
                <select class="user-type" id="user_type" name="user_type" required>
                    <option value="student" selected>Student</option>
                    <option value="admin">Admin</option>
                    <option value="professor">Professor</option>
                </select>
                <input type="email" id="email" placeholder="Email" minlength="4" maxlength="25" autocomplete="off" name="email" required />

                <div class="modal-footer">
                    <button type="button" class="btn" id="closeModal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="create-account">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'include/footer.php' ?>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        const accountForm = document.getElementById('accForm');
        const tableBody = document.getElementById('accountBody');
        const formBtn = document.getElementById('create-account');

        document.getElementById('openModal').addEventListener('click', function() {
            toggleModal();
        });

        document.getElementById('closeModal').addEventListener('click', function() {
            toggleModal();
            clearForm(document.getElementById('accForm'));
        });



        function toggleModal() {
            document.getElementById('bulletinModal').classList.toggle('show');
        }

        function clearForm(thisForm) {
            thisForm.reset();
        }

        tableBody.addEventListener('click', function(e) {
            if (e.target.classList.contains('edit')) {
                const userId = e.target.dataset.id;
                formBtn.innerText = "Update";
                toggleModal(); // Show the modal
                populateForm(userId);
            }

            if (e.target.classList.contains('delete')) {
                const userId = e.target.dataset.id;
                if (confirm("Are you sure you want to delete this account?")) {
                    fetch('db_queries/delete/delete_account.php', {
                            method: 'POST',
                            body: JSON.stringify({
                                userId: userId // Change user_id to userId to match PHP parameter
                            }),
                            headers: {
                                'Content-Type': 'application/json', // Set the correct content type
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                fetchAccounts(); // Refresh the accounts table
                            } else {
                                alert("Failed to delete account: " + data.message);
                            }
                        })
                        .catch(error => console.error("Error:", error));
                }
            }
        })

        function populateForm(userId) {
            fetch('db_queries/select/fetch_user_account.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        userId: userId // Change user_id to userId to match PHP parameter
                    }),
                    headers: {
                        'Content-Type': 'application/json', // Set the correct content type
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Accessing user data and populating the form
                        const user = data.data; // Since you're returning only one user, no need to use [0]
                        document.getElementById('userId').value = user.user_id;
                        document.getElementById('name').value = user.name;
                        document.getElementById('username').value = user.username;
                        document.getElementById('email').value = user.email;
                        document.getElementById('user_type').value = user.user_type;
                    } else {
                        alert("Failed to load user data: " + data.message);
                    }
                })
                .catch(error => console.error("Error:", error));
        }

        if (accountForm) {
            accountForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                const userId = document.getElementById('userId').value;
                let url = '';

                if (userId) {
                    // If userId is present, it's an update operation
                    url = 'db_queries/edit/update_account.php';
                    console.log('Updating account with ID:', userId);
                } else {
                    // If userId is not present, it's a create operation
                    url = 'db_queries/insert/create_account.php';
                    console.log('Creating new account');
                }
                // Get form data
                const formData = new FormData(accountForm);
                // Send the form data using Fetch API
                fetch(url, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            // Optionally, you can refresh the page or update the table here
                            accountForm.reset(); // Reset the form
                            formBtn.innerText = "Create"; // Reset button text
                            fetchAccounts(); // Refresh the accounts table
                        } else {
                            alert('Error creating account: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        }

        let previousData = []
        async function fetchAccounts() {
            try {
                const response = await fetch('db_queries/select/fetch_accounts.php');
                const data = await response.json();

                if (data.success) {
                    if (!isEqual(previousData, data.data)) {
                        previousData = data.data;
                        updateUserTable(data.data);
                    }
                } else {
                    alert("Failed to load user data: " + data.message);
                }
            } catch (error) {
                console.error("Error fetching user data:", error);
            }
        }

        // Deep comparison for object arrays
        function isEqual(arr1, arr2) {
            return JSON.stringify(arr1) === JSON.stringify(arr2);
        }
        fetchAccounts();
        setInterval(fetchAccounts, 5000);

        function updateUserTable(users) {
            const userTableBody = document.getElementById("accountBody");
            userTableBody.innerHTML = ""; // Clear existing rows

            users.forEach(item => {
                const row = document.createElement("tr");

                row.innerHTML = `
                    <td>${item.user_id}</td>
                    <td>${item.name}</td>
                    <td>${item.username}</td>
                    <td>${item.email}</td>
                    <td>${item.user_type}</td>
                    <td>${item.date}</td>
                    <td>
                        <div class="actions">
                            <button class="btn-icon btn-check edit" data-id="${item.user_id}"><i class="fas fa-edit"></i></button>
                            <button class="btn-icon btn-delete delete" data-id="${item.user_id}"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                `;

                userTableBody.appendChild(row);
            });
        }
    })
</script>
