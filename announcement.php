<?php include 'include/navbar.php'; ?>
<div class="main">
    <div class="card-container">
        <div class="cards-grid">
            <!-- Display all the approved cards here -->
            <!-- <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_content">
                        <div class="ag-courses-item_category">Web Development</div>
                        <div class="ag-courses-item_title">Front-End Development with Vue.js</div>
                        <div class="ag-courses-item_desc">
                            Learn to build modern user interfaces using Vue.js, HTML, and CSS with real-world projects.
                        </div>
                        <div class="ag-courses-item_date-box">
                            Start:
                            <span class="ag-courses-item_date">15.05.2025</span>
                        </div>
                    </div>
                </a>
            </div> -->

        </div>
    </div>
</div>
<?php include 'include/footer.php'; ?>
<script>
    async function loadApprovedCards() {
        const response = await fetch('db_queries/select/fetch_approved_announcement.php');
        const result = await response.json();

        if (!result.success) {
            alert('Failed to load announcements.');
            return;
        }

        const grid = document.querySelector('.cards-grid');
        grid.innerHTML = '';

        result.data.forEach(post => {
            const card = document.createElement('div');
            card.className = 'ag-courses_item';

            const postDate = new Date(post.date);
            const now = new Date();
            const minutesAgo = (now - postDate) / 60000;
            const isNew = minutesAgo <= 5;
            card.innerHTML = `
            <a href="#" class="ag-courses-item_link">
                <div class="ag-courses-item_bg ${post.category}"></div>
                <div class="ag-courses-item_content">
                    ${isNew ? '<div class="new-badge">🆕 New</div>' : ''}
                    <div class="ag-courses-item_category">${post.category}</div>
                    <div class="ag-courses-item_title">${post.title}</div>
                    <div class="ag-courses-item_desc">${post.description}</div>
                    <div class="ag-courses-item_date-box">
                        Posted:
                        <span class="ag-courses-item_date">${new Date(post.date).toLocaleString()}</span>
                    </div>
                    <div class="ag-courses-item_date-box">
                        Posted by:
                        <span class="ag-courses-item_date">${post.postedByName || 'Unknown'}</span>
                    </div>
                </div>
            </a>
        `;

            grid.appendChild(card);
        });
    }


    loadApprovedCards();
</script>
