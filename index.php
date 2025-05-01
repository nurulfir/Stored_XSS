<?php
session_start();

// Simulasi database dengan session
if (!isset($_SESSION['comments'])) {
    $_SESSION['comments'] = [];
}

// Simpan komentar jika dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $_POST['comment'];
    $_SESSION['comments'][] = $comment;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Stored XSS Demo</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }

        h1 {
            color: #3498db;
            text-align: center;
            margin-bottom: 20px;
        } 

        h2 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-top: 20px;
        }

        h3 {
            color: #2c3e50;
            margin-top: 30px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
            box-sizing: border-box;
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .comment-container {
            margin-top: 20px;
        }

        .comment {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #3498db;
        }
    </style>
</head>

<body>
    <h1>Contoh Stored XSS</h1>
    <h2>Komentar</h2>
    <form method="POST">
        <textarea name="comment" rows="4" cols="50" placeholder="Tulis komentar di sini..."></textarea><br>
        <input type="submit" value="Kirim">
    </form>

    <h3>Daftar Komentar:</h3>
    <div class="comment-container">
        <?php foreach ($_SESSION['comments'] as $c): ?>
            <div class="comment">
                <?= $c ?> <!-- VULNERABLE: XSS terjadi di sini -->
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>