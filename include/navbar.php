<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>School Bulletin Board</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <header>
        <div class="header-top">
            <div class="logo"><i class="fas fa-bullhorn"></i> School Bulletin</div>
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <nav class="nav-links">
            <a href="dashboard.php" class="admin"><i class="fas fa-chart-line"></i> Dashboard</a>
            <a href="announcement.php" class="student professor admin"><i class="fas fa-bullhorn"></i> Announcements</a>
            <a href="announcement_dashboard.php" class="admin"><i class="fas fa-comment-dots"></i> Announcements Dashboard</a>
            <a href="posts.php" class="professor admin"><i class="fas fa-file-alt"></i> Post</a>
            <a href="accounts.php" class="admin"><i class="fas fa-users"></i> Accounts</a>
            <button class="icon-btn toggle-theme" onclick="toggleTheme()" title="Toggle Dark Mode">
                <i class="fas fa-moon"></i>
            </button>
            <h3 class="user"></h3>
            <button class="logout" id="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </nav>
    </header>


    <script>
        function toggleMobileMenu() {
            document.querySelector('.nav-links').classList.toggle('show');
        }


        function toggleTheme() {
            document.body.classList.toggle('dark');
        }

        window.addEventListener("pageshow", function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
        const token = localStorage.getItem("jwt_token");
        // console.log("JWT Token: ", token);
        if (!token) {
            // Redirect to login page if token is not present
            // console.log("No token found. Redirecting to login page.");
            window.location.href = "index.php";

        }
        try {
            const payloadBase64 = token.split('.')[1];
            const payloadJson = atob(payloadBase64);
            const payload = JSON.parse(payloadJson);
            const user_type = payload.user_type;
            document.querySelector('.user').innerText = user_type.charAt(0).toUpperCase() + user_type.slice(1); // Capitalize first letter

            // Utility function to show items by class
            function showItems(className) {
                document.querySelectorAll(`.${className}`).forEach(el => el.classList.add('show'));
            }

            if (user_type === 'admin') {
                showItems('admin');
                showItems('student');
                showItems('professor');
            } else if (user_type === 'professor') {
                showItems('professor');
                showItems('student');
            } else if (user_type === 'student') {
                showItems('student');
            }

            const currentTime = Math.floor(Date.now() / 1000); // current time in seconds

            if (payload.exp && currentTime > payload.exp) {
                // Token is expired
                console.warn("Token expired. Redirecting to login.");
                localStorage.removeItem("jwt_token");
                window.location.href = "index.php";

            }

            // Optional: Handle showing admin nav
            const admin = document.querySelectorAll('.admin');
            if (payload.user_type === 'admin') {
                admin.forEach(function(element) {
                    element.classList.add('show-nav');
                });
            } else {
                admin.forEach(function(element) {
                    element.classList.remove('show-nav');
                });
            }


        } catch (e) {
            console.error("Invalid token or decoding failed.", e);
            localStorage.removeItem("jwt_token");
            window.location.href = "index.php";
        }



        const mobileLogoutBtn = document.getElementById("mobile-logout");

        if (mobileLogoutBtn) {
            mobileLogoutBtn.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default action

                // Remove JWT token from local storage
                localStorage.removeItem("jwt_token");

                // Redirect to the login page after logout
                window.location.href = "index.php";

            })
        }

        const logoutBtn = document.getElementById("logout-btn");

        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default action

                // Remove JWT token from local storage
                localStorage.removeItem("jwt_token");

                // Redirect to the login page after logout
                window.location.href = "index.php";

            })
        }

        // Function to refresh the access token using the refresh token
        function refreshAccessToken() {
            const refreshToken = localStorage.getItem('refresh_token');

            if (!refreshToken) {
                // No refresh token, redirect to login
                window.location.href = 'index.php';
                return;
            }

            // Make an API request to refresh the access token
            fetch('db_queries/edit/refresh_token.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        refresh_token: refreshToken
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Store the new access token
                        localStorage.setItem('jwt_token', data.token);
                    } else {
                        // Token refresh failed, redirect to login
                        window.location.href = 'index.php';
                    }
                })
                .catch(error => {
                    console.error('Error refreshing token:', error);
                });
        }

        // Function to check if the JWT is about to expire
        function checkTokenExpiration() {
            const token = localStorage.getItem('jwt_token');
            if (!token) return;

            const payloadBase64 = token.split('.')[1];
            const payloadJson = atob(payloadBase64);
            const payload = JSON.parse(payloadJson);

            const expTime = payload.exp * 1000; // Convert to milliseconds
            const currentTime = Date.now();

            // If the token is about to expire in 10 minutes or already expired, refresh it
            if (expTime - currentTime <= 10 * 60 * 1000) {
                refreshAccessToken();
            }
        }

        // Run the token expiration check on page load and periodically
        document.addEventListener('DOMContentLoaded', () => {
            checkTokenExpiration();
            setInterval(checkTokenExpiration, 5 * 60 * 1000); // Check every 5 minutes
        });
    </script>
