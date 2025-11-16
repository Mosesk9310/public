<?php
// Optional: show only relevant errors (hide warnings/deprecations)
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED);

$server = 'mysql';
$username = 'student';
$password = 'student';
$schema = 'csy2089';

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$server;dbname=$schema;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle form submission
    if (isset($_POST['submit']) && !empty($_POST['title']) && !empty($_POST['genreid'])) {
        $stmt = $pdo->prepare('INSERT INTO film (title, genreid) VALUES (:title, :genreid)');
        $stmt->execute([
            'title' => $_POST['title'],
            'genreid' => $_POST['genreid']
        ]);

        // Redirect to same page (prevents double submission and refreshes list)
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Fetch all films and their genres
    $stmt = $pdo->prepare('
        SELECT film.id, film.title, genre.name AS genre_name
        FROM film
        LEFT JOIN genre ON film.genreid = genre.id
        ORDER BY film.id DESC
    ');
    $stmt->execute();

    echo '<h2>Films and Their Genres</h2>';
    echo '<ul>';
    foreach ($stmt as $row) {
        // Safely cast to strings to avoid null warnings
        $title = (string)($row['title'] ?? '');
        $genre = (string)($row['genre_name'] ?? 'Unknown Genre');

        echo '<li><strong>' . htmlspecialchars($title) . '</strong> — ' .
             htmlspecialchars($genre) . '</li>';
    }
    echo '</ul>';

    // Fetch genres for dropdown
    $genreStmt = $pdo->prepare('SELECT * FROM genre ORDER BY name');
    $genreStmt->execute();

} catch (PDOException $e) {
    echo '<p style="color:red;">Database error: ' . htmlspecialchars($e->getMessage()) . '</p>';
}
?>

<h2>Add a New Film</h2>
<form action="" method="POST">
    <label for="title">Film Title:</label>
    <input type="text" name="title" id="title" required />

    <label for="genreid">Genre:</label>
    <select name="genreid" id="genreid" required>
        <option value="">Select a genre</option>
        <?php
        if (isset($genreStmt)) {
            foreach ($genreStmt as $genre) {
                echo '<option value="' . htmlspecialchars($genre['id']) . '">' .
                     htmlspecialchars($genre['name']) . '</option>';
            }
        }
        ?>
    </select>

    <input type="submit" name="submit" value="Add Film" />
</form>
