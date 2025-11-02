<?php
require_once 'db_connection.php';

if (!isset($_GET['id'])) {
    header('Location: artikel.php');
    exit;
}

$id = intval($_GET['id']);

$result = pg_query($dbconn, "SELECT id FROM articles WHERE id = $id");
$article = pg_fetch_assoc($result);

if (!$article) {
    header('Location: artikel.php');
    exit;
}

$result = pg_query($dbconn, "DELETE FROM articles WHERE id = $id");

if ($result) {
    header('Location: artikel.php?deleted=1');
} else {
    header('Location: artikel.php?error=1');
}
pg_close($dbconn);
exit;
?>
