<?php include 'include/navbar.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="main">
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>Welcome to the Dashboard</h2>
            <p>Here you can manage your announcements and posts.</p>
        </div>

        <div class="dashboard-cards-and-chart">
            <div class="dashboard-cards">
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
            </div>


            <div class="charts-flex">
                <div class="chart-container">
                    <h3>Post Status</h3>
                    <canvas id="postStatusChart" width="400" height="300"></canvas>
                </div>
                <div class="dashboard-chart-container">
                    <h3>Weekly Post Status Trend</h3>
                    <canvas id="postTrendChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'include/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function fetchTrendData() {
            fetch('db_queries/select/weekly_post_trend.php')
                .then(res => res.json())
                .then(trendData => {
                    const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

                    const getStyle = key => getComputedStyle(document.documentElement).getPropertyValue(key);

                    const datasets = [{
                            label: 'Pending',
                            data: days.map(day => trendData.pending?.[day] ?? 0),
                            borderColor: getStyle('--color-cancel'),
                            backgroundColor: 'transparent',
                            tension: 0.3,
                            borderWidth: 2
                        },
                        {
                            label: 'Approved',
                            data: days.map(day => trendData.approved?.[day] ?? 0),
                            borderColor: getStyle('--color-approve'),
                            backgroundColor: 'transparent',
                            tension: 0.3,
                            borderWidth: 2
                        },
                        {
                            label: 'Dismissed',
                            data: days.map(day => trendData.dismissed?.[day] ?? 0),
                            borderColor: '#c0392b',
                            backgroundColor: 'transparent',
                            tension: 0.3,
                            borderWidth: 2
                        },
                        {
                            label: 'Deleted',
                            data: days.map(day => trendData.deleted?.[day] ?? 0),
                            borderColor: getStyle('--color-delete'),
                            backgroundColor: 'transparent',
                            tension: 0.3,
                            borderWidth: 2
                        }
                    ];

                    const ctx = document.getElementById('postTrendChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: days,
                            datasets: datasets
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Number of Posts'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                })
                .catch(err => console.error('Error loading trend chart:', err));
        }

        function fetchPostStatusData() {
            fetch('db_queries/select/post_status_chart.php')
                .then(res => res.json())
                .then(statusData => {
                    const ctx = document.getElementById('postStatusChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Pending', 'Approved', 'Dismissed', 'Deleted'],
                            datasets: [{
                                label: 'Post Status Counts',
                                data: [
                                    statusData.pending || 0,
                                    statusData.approved || 0,
                                    statusData.dismissed || 0,
                                    statusData.deleted || 0
                                ],
                                backgroundColor: ['#f39c12', '#27ae60', '#c0392b', '#7f8c8d']
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error loading post status chart:', error));
        }
        fetchPostStatusData();
        fetchTrendData();
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
    });
</script>
