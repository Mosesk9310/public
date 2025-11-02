<?php
// Database connection settings
$server = 'mysql';
$username = 'student';
$password = 'student';
$schema = 'csy2089';

// Connect using PDO
try {
    $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle search input
$search = isset($_GET['search_term']) ? trim($_GET['search_term']) : "";
$search_field = isset($_GET['search_field']) ? $_GET['search_field'] : "all";

// Build SQL query dynamically
$allowed_fields = [
    'firstname' => 'firstname',
    'surname' => 'surname',
    'email' => 'email',
    'phone_number' => 'phone_number',
    'address' => 'address',
    'date_of_birth' => 'date_of_birth'
];

if ($search !== "") {
    if ($search_field !== "all" && isset($allowed_fields[$search_field])) {
        // Search in a specific field
        $sql = "SELECT firstname, surname, email, date_of_birth, phone_number, address
                FROM person
                WHERE {$allowed_fields[$search_field]} LIKE :search
                ORDER BY surname ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['search' => "%$search%"]);
    } else {
        // Search across all fields
        $sql = "SELECT firstname, surname, email, date_of_birth, phone_number, address
                FROM person
                WHERE firstname LIKE :search OR surname LIKE :search 
                   OR email LIKE :search OR phone_number LIKE :search 
                   OR address LIKE :search OR date_of_birth LIKE :search
                ORDER BY surname ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['search' => "%$search%"]);
    }
} else {
    // Default: show all
    $sql = "SELECT firstname, surname, email, date_of_birth, phone_number, address
            FROM person
            ORDER BY surname ASC";
    $stmt = $pdo->query($sql);
}

// Fetch results
$people = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
        <title>People List</title>
</head>

<body>
    <h1>People in Database</h1>

    <!-- Search Form -->
    <form method="get" action="">
        <label for="search-field">Search by:</label>
        <select name="search_field" id="search-field">
            <option value="all" <?php if ($search_field === "all") echo "selected"; ?>>All Fields</option>
            <option value="surname" <?php if ($search_field === "surname") echo "selected"; ?>>Surname</option>
            <option value="firstname" <?php if ($search_field === "firstname") echo "selected"; ?>>First Name</option>
            <option value="email" <?php if ($search_field === "email") echo "selected"; ?>>Email</option>
            <option value="phone_number" <?php if ($search_field === "phone_number") echo "selected"; ?>>Phone Number
            </option>
            <option value="address" <?php if ($search_field === "address") echo "selected"; ?>>Address</option>
            <option value="date_of_birth" <?php if ($search_field === "date_of_birth") echo "selected"; ?>>Date of Birth
            </option>
        </select>

        <input type="text" name="search_term" placeholder="Enter search term..."
            value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
        <button type="reset" onclick="window.location='?'">Reset</button>
    </form>

    <ul>
        <?php if (count($people) > 0): ?>
        <?php foreach ($people as $person): ?>
        <li>
            <?php echo htmlspecialchars($person['firstname']); ?>
            <?php echo htmlspecialchars($person['surname']); ?>
            was born on
            <?php echo htmlspecialchars($person['date_of_birth']); ?>,
            lives at
            <?php echo htmlspecialchars($person['address']); ?>,
            and their email address is
            <?php echo htmlspecialchars($person['email']); ?>
            (phone: <?php echo htmlspecialchars($person['phone_number']); ?>).
        </li>
        <?php endforeach; ?>
        <?php else: ?>
        <li>No results found.</li>
        <?php endif; ?>
    </ul>
</body>

</html>