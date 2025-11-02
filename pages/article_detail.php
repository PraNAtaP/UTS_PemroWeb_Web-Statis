<?php
require_once 'db_connection.php';

if (!isset($_GET['id'])) {
    header('Location: artikel.php');
    exit;
}

$id = intval($_GET['id']);
$result = pg_query($dbconn, "SELECT id, title, content, created_at, updated_at FROM articles WHERE id = $id");
$article = pg_fetch_assoc($result);

if (!$article) {
    header('Location: artikel.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($article['title']); ?> - Pranata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/artikel.css" />
</head>

<body>
    <nav>
        <div class="nav-container">
            <a href="profile.php" class="logo">
                <div class="logo-icon">
                    <img src="../assets/profile.png" alt="" />
                </div>
                <span class="logo-text">Pranata Putrandana</span>
            </a>
            <ul class="nav-links">
                <li><a href="../index.html">Home</a></li>
                <li><a href="artikel.php">Artikel</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <a href="artikel.php" class="back-link">← Kembali ke Daftar Artikel</a>

        <div class="article fade-in">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h1><?php echo htmlspecialchars($article['title']); ?></h1>
                    <div class="article-meta">
                        📅 <?php echo date('d M Y', strtotime($article['created_at'])); ?> | 
                        ✏️ Terakhir diperbarui: <?php echo date('d M Y H:i', strtotime($article['updated_at'])); ?>
                    </div>
                </div>
                <div class="btn-group">
                    <a href="article_edit.php?id=<?php echo $article['id']; ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                    <a href="article_delete.php?id=<?php echo $article['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">🗑️ Delete</a>
                </div>
            </div>

            <div class="content">
                <?php echo nl2br(htmlspecialchars($article['content'])); ?>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Pranata Putrandana.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../script/artikel.js"></script>
</body>

</html>
<?php pg_close($dbconn); ?>

