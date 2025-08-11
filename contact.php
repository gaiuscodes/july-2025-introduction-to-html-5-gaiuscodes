<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("<div class='error-msg'>Connection failed: " . $conn->connect_error . "</div>");
}

$status = "";
$name = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        $status = "success";
    } else {
        $status = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Status - Timothy Gaius Portfolio</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, sans-serif;
        background: linear-gradient(135deg, #007acc, #005fa3);
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        color: white;
        opacity: 1;
        transition: opacity 1s ease;
    }
    .fade-out {
        opacity: 0;
    }
    .status-card {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(15px);
        padding: 40px;
        border-radius: 15px;
        text-align: center;
        max-width: 400px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        animation: slideFadeIn 1.2s ease forwards;
    }
    h1 {
        margin-bottom: 15px;
        font-size: 1.8rem;
        animation: popText 1.5s ease forwards;
    }
    p {
        margin-bottom: 15px;
        animation: fadeInUp 1.2s ease forwards;
    }
    .countdown {
        font-weight: bold;
        margin-top: 10px;
        color: #ffdd57;
        animation: fadeInUp 1.5s ease forwards;
    }
    .btn-home {
        background: #ffdd57;
        color: #333;
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s ease;
        display: inline-block;
        margin-top: 10px;
        animation: fadeInUp 1.8s ease forwards;
    }
    .btn-home:hover {
        background: #ffc107;
        transform: translateY(-3px);
    }
    @keyframes slideFadeIn {
        0% { opacity: 0; transform: translateY(50px) scale(0.95);}
        100% { opacity: 1; transform: translateY(0) scale(1);}
    }
    @keyframes popText {
        0% { transform: scale(0.8); opacity: 0; }
        50% { transform: scale(1.1); opacity: 1; }
        100% { transform: scale(1); }
    }
    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(20px);}
        100% { opacity: 1; transform: translateY(0);}
    }
</style>
<script>
    let seconds = 5;
    function countdown() {
        if (seconds > 0) {
            document.getElementById("timer").textContent = seconds;
            seconds--;
            setTimeout(countdown, 1000);
        } else {
            document.body.classList.add("fade-out");
            setTimeout(() => {
                window.location.href = "index.html";
            }, 1000);
        }
    }
    window.onload = countdown;
</script>
</head>
<body>

<div class="status-card">
    <?php if ($status === "success"): ?>
        <h1>✅ Message Sent!</h1>
        <p>Thank you, <strong><?php echo $name; ?></strong>. I will get back to you soon.</p>
    <?php else: ?>
        <h1>❌ Oops!</h1>
        <p>Something went wrong. Please try again later.</p>
    <?php endif; ?>
    <p class="countdown">Redirecting in <span id="timer">5</span> seconds...</p>
    <a href="index.html" class="btn-home">⬅ Back to Home</a>
</div>

</body>
</html>
