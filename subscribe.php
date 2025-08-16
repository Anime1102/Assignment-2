<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            echo "<p>✅ Thanks for subscribing!</p><a href='index.php'>Go back</a>";
        } else {
            echo "<p>❌ Already subscribed or error: " . $stmt->error . "</p>";
        }
    } else {
        echo "<p>Invalid email format.</p>";
    }
}
?>
