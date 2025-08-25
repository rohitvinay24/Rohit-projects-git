<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fake News Detector</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        /* Background Styling */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-image: url('https://www.naukri.com/campus/career-guidance/wp-content/uploads/2024/07/what-is-machine-learning.jpg'); /* Replace with your image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
            position: relative;
        }

        /* Dark overlay for readability */
        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }

        h1 {
            font-size: 28px;
            font-weight: bold;
        }

        textarea, input {
            width: 95%;
            height: 50px;
            border: none;
            border-radius: 8px;
            padding: 15px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        }

        button {
            margin-top: 15px;
            padding: 12px 20px;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            background: linear-gradient(45deg, #4CAF50, #45a049);
            color: white;
            transition: 0.3s ease;
        }

        button:hover {
            background: linear-gradient(45deg, #45a049, #388E3C);
        }

        /* Logout Button Styling */
        .logout-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            background: #e74c3c;
            color: white;
            text-decoration: none;
            transition: 0.3s ease-in-out;
        }

        .logout-btn:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Fake News Detection</h1>
        <form method="POST">
            <textarea name="news_text" placeholder="Enter news article..." required></textarea>
            <button type="submit">Analyze News</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["news_text"])) {
                $news_text = escapeshellarg($_POST["news_text"]);
                $command = "python analyze.py $news_text";
                $output = shell_exec($command);
                echo "<h2>Result:</h2><p>$output</p>";
            } else {
                echo "<h2>Error:</h2><p>News text input is missing!</p>";
            }
        }
        ?>

        <hr>
        <h3>Fetch Live News</h3>
        <form method="POST">
            <input type="text" name="query" placeholder="Search topic (e.g., AI, politics, sports)" required>
            <button type="submit" name="fetch_news">Fetch News</button>
        </form>

        <?php
        if (isset($_POST["fetch_news"])) {
            $query = escapeshellarg($_POST["query"]);
            $command = "python fetch_news.py $query";
            $news_output = shell_exec($command);
            echo "<h2>Latest News:</h2><p>$news_output</p>";
        }
        ?>

        <hr>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>