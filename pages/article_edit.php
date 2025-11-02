<?php
require_once 'db_connection.php';

if (!isset($_GET['id'])) {
    header('Location: artikel.php');
    exit;
}

$id = intval($_GET['id']);
$error = '';
$success = '';

$result = pg_query($dbconn, "SELECT id, title, content FROM articles WHERE id = $id");
$article = pg_fetch_assoc($result);

if (!$article) {
    header('Location: artikel.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if (empty($title) || empty($content)) {
        $error = 'Judul dan konten harus diisi!';
    } else {
        $title = pg_escape_string($dbconn, $title);
        $content = pg_escape_string($dbconn, $content);
        
        $result = pg_query($dbconn, "UPDATE articles SET title = '$title', content = '$content', updated_at = CURRENT_TIMESTAMP WHERE id = $id");
        
        if ($result) {
            $success = 'Artikel berhasil diperbarui!';
            header('refresh:1;url=article_detail.php?id=' . $id);
            exit;
        } else {
            $error = 'Gagal memperbarui artikel: ' . pg_last_error($dbconn);
        }
    }
} else {
    $_POST['title'] = $article['title'];
    $_POST['content'] = $article['content'];
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Article - Pranata</title>
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
        <a href="article_detail.php?id=<?php echo $id; ?>" class="back-link">← Kembali ke Artikel</a>

        <div class="article fade-in" style="max-width: 800px; margin: 0 auto;">
            <h1>✏️ Edit Article</h1>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($success); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="POST" action="article_edit.php?id=<?php echo $id; ?>">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required 
                           value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>">
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="content" name="content" rows="15" required><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">💾 Save Changes</button>
                    <a href="article_detail.php?id=<?php echo $id; ?>" class="btn btn-secondary">❌ Cancel</a>
                </div>
            </form>
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

