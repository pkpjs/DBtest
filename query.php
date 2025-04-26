<?php
include 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SQL 쿼리 실행</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            padding: 30px;
        }
        a {
            text-decoration: none;
            color: #0077cc;
        }
        textarea {
            width: 100%;
            height: 120px;
            font-family: monospace;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #0077cc;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        table {
            border-collapse: collapse;
            margin-top: 20px;
            width: 100%;
            background-color: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #0077cc;
            color: white;
        }
        .query-result, .error-debug {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 15px;
            margin-top: 15px;
            border-radius: 5px;
            font-family: monospace;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

<a href="index.php">← 메인으로 돌아가기</a>

<h2>💻 SQL 쿼리 입력</h2>
<form method="post">
    <textarea name="query" placeholder="예: SELECT * FROM users;"></textarea><br>
    <input type="submit" value="실행">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = $_POST["query"];

    echo "<div class='query-result'><strong>입력한 쿼리문:</strong><br><code>" . htmlspecialchars($query) . "</code></div>";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<p class='success'>✅ 쿼리 실행 성공!</p>";

        if (stripos(trim($query), "select") === 0) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table><tr>";
                while ($fieldinfo = mysqli_fetch_field($result)) {
                    echo "<th>{$fieldinfo->name}</th>";
                }
                echo "</tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>결과가 없습니다.</p>";
            }
        }
    } else {
        echo "<div class='error-debug'>";
        echo "<p class='error'>❌ 쿼리 실행 실패</p>";
        echo "<strong>MySQL 오류 메시지:</strong><br><code>" . mysqli_error($conn) . "</code>";
        echo "</div>";
    }
}
?>

</body>
</html>
