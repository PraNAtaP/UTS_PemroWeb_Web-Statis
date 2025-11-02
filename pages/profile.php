<?php

require_once 'db_connection.php';

$result_profile = pg_query($dbconn, "SELECT * FROM profiles WHERE id = 1");
$profile = pg_fetch_assoc($result_profile);

$result_skills = pg_query($dbconn, "SELECT name FROM skills ORDER BY id");
$skills = pg_fetch_all($result_skills);

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile - <?php echo htmlspecialchars($profile['name']); ?></title>
    <link rel="stylesheet" href="../styles/profile.css" />
</head>

<body>
    <nav>
        <div class="nav-container">
            <a href="profile.php" class="logo">
                <div class="logo-icon">
                    <img src="../assets/profile.png" alt="" />
                </div>
                <span class="logo-text"><?php echo htmlspecialchars($profile['name']); ?></span>
            </a>
            <ul class="nav-links">
                <li><a href="../index.html">Home</a></li>
                <li><a href="artikel.php">Artikel</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="profile-header fade-in">
            <div class="profile-avatar">
                <img src="../assets/profile.png" alt="" />
            </div>
            <h1><?php echo htmlspecialchars($profile['name']); ?></h1>
            <p><?php echo htmlspecialchars($profile['title']); ?></p>
        </div>

        <div class="card fade-in">
            <h2>📖 Tentang Saya</h2>
            <p>
                <?php echo htmlspecialchars($profile['about']); ?>
            </p>
        </div>

        <div class="card fade-in">
            <h2>💻 Skills</h2>
            <div class="skills">
                <?php
                if ($skills) {
                    foreach ($skills as $skill) {
                        echo '<span class="skill-tag">' . htmlspecialchars($skill['name']) . '</span>';
                    }
                } else {
                    echo '<p>Belum ada skill yang ditambahkan.</p>';
                }
                ?>
            </div>
        </div>

        <div class="card fade-in">
            <h2>📬 Kontak (Click to Go)</h2>
            <a href="mailto:<?php echo htmlspecialchars($profile['email']); ?>">
                <p>📧 EMAIL</p>
            </a>
            <a href="<?php echo htmlspecialchars($profile['github_url']); ?>" target="_blank" rel="noopener noreferrer">
                <p>🐙 GITHUB</p>
            </a>
            <a href="<?php echo htmlspecialchars($profile['linkedin_url']); ?>" target="_blank" rel="noopener noreferrer">
                <p>🔗 LINKEDIN</p>
            </a>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Pranata Putrandana.</p>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../script/profile.js"></script>
</body>

</html>
<?php pg_close($dbconn); ?>