<?php
require_once 'db_connection.php';

$result = pg_query($dbconn, "SELECT id, title, content, created_at, updated_at FROM articles ORDER BY created_at DESC");
$articles = pg_fetch_all($result) ?: [];

$message = '';
$messageType = '';

if (isset($_GET['deleted']) && $_GET['deleted'] == '1') {
    $message = 'Artikel berhasil dihapus!';
    $messageType = 'success';
} elseif (isset($_GET['error']) && $_GET['error'] == '1') {
    $message = 'Terjadi kesalahan saat menghapus artikel.';
    $messageType = 'danger';
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Artikel - Pranata</title>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>📚 Artikel</h1>
            <a href="article_create.php" class="btn btn-primary">Create Article</a>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php if (empty($articles)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        <p>Belum ada artikel. <a href="article_create.php" class="alert-link">Buat artikel pertama!</a></p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($articles as $article): ?>
                    <div class="col-md-6 col-lg-4 mb-4 fade-in">
                        <div class="card h-100 card-hover" onclick="window.location.href='article_detail.php?id=<?php echo $article['id']; ?>'">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h5>
                                <p class="card-text">
                                    <?php 
                                    $content = htmlspecialchars($article['content']);
                                    echo strlen($content) > 100 ? substr($content, 0, 100) . '...' : $content;
                                    ?>
                                </p>
                                <small class="text-muted">📅 <?php echo date('d M Y', strtotime($article['created_at'])); ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
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

