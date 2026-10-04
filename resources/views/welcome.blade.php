
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Notice Board | Welcome</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f7fb;
            color: #222;
        }

        /* Navbar */
        .navbar {
            background: #1e3a8a;
            color: white;
            padding: 18px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-size: 16px;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        /* Hero Section */
        .hero {
            min-height: 75vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px 20px;
        }

        .hero-content {
            max-width: 800px;
        }

        .hero h1 {
            font-size: 48px;
            color: #1e3a8a;
            margin-bottom: 20px;
        }

        .hero h2 {
            font-size: 28px;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 18px;
            color: #555;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        /* Buttons */
        .buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn {
            padding: 13px 28px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }

        .btn-primary {
            background: #1e3a8a;
            color: white;
        }

        .btn-primary:hover {
            background: #162d6b;
        }

        .btn-secondary {
            border: 2px solid #1e3a8a;
            color: #1e3a8a;
        }

        .btn-secondary:hover {
            background: #1e3a8a;
            color: white;
        }

        /* Features */
        .features {
            background: white;
            padding: 50px 8%;
            text-align: center;
        }

        .features h2 {
            color: #1e3a8a;
            margin-bottom: 30px;
        }

        .feature-container {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
        }

        .feature-card {
            width: 280px;
            padding: 25px;
            background: #f4f7fb;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .feature-card h3 {
            margin-bottom: 10px;
            color: #1e3a8a;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Footer */
        footer {
            background: #1e3a8a;
            color: white;
            text-align: center;
            padding: 18px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .nav-links a {
                margin: 0 8px;
            }

            .hero h1 {
                font-size: 36px;
            }

            .hero h2 {
                font-size: 22px;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                width: 200px;
                margin: auto;
            }
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">
            📢 Notice Board
        </div>

        <div class="nav-links">
            <a href="#">Home</a>
            <a href="#">Notices</a>
            <a href="#">Login</a>
        </div>
    </nav>

    <!-- Welcome Section -->
    <section class="hero">

        <div class="hero-content">

            <h1>Welcome to Notice Board</h1>

            <h2>Stay Updated. Stay Informed.</h2>

            <p>
                Welcome to our Online Notice Board Portal.
                Find important announcements, academic notices,
                events, examination updates and other information
                in one convenient place.
            </p>

            <div class="buttons">
                <a href="#" class="btn btn-primary">
                    View Notices
                </a>

                <a href="#" class="btn btn-secondary">
                    Login
                </a>
            </div>

        </div>

    </section>

    <!-- Features -->
    <section class="features">

        <h2>What You Can Find</h2>

        <div class="feature-container">

            <div class="feature-card">
                <h3>📢 Latest Notices</h3>
                <p>
                    View the latest announcements and important
                    college updates.
                </p>
            </div>

            <div class="feature-card">
                <h3>📅 Events & Exams</h3>
                <p>
                    Stay informed about upcoming events,
                    examinations and academic activities.
                </p>
            </div>

            <div class="feature-card">
                <h3>🔔 Important Updates</h3>
                <p>
                    Get important information and notifications
                    from the administration.
                </p>
            </div>

        </div>

    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 Online Notice Board Portal. All Rights Reserved.</p>
    </footer>

</body>
</html>

