<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>DB 테이블 목록</title>
    <script>
        // 페이지 로드 시 sessionStorage 값을 확인하여 새로 고침 여부를 결정
        window.onload = function() {
            // sessionStorage에 "refreshed" 키가 있는지 확인
            if (!sessionStorage.getItem('refreshed')) {
                // 페이지 로드 시 새로 고침
                sessionStorage.setItem('refreshed', 'true');
                location.reload();  // 페이지 새로 고침
            }
        }
    </script>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #0077cc;
            text-align: center;
        }
        a {
            color: #0077cc;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin: 8px 0;
        }
        .link-container {
            text-align: center;
            margin: 20px 0;
        }
        .table-list {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table-list ul {
            padding-left: 20px;
        }
    </style>
</head>
<body>

<h2>📋 현재 데이터베이스 테이블 목록</h2>

<div class="link-container">
    <a href="query.php">→ 쿼리 직접 실행하러 가기</a> |
    <a href="sql.php">→ SQL 예시 보기</a>
</div>

<br>

<div class="table-list">
    <?php
    // 테이블 목록 가져오기
    $tables = mysqli_query($conn, "SHOW TABLES");

    if ($tables) {
        echo "<ul>";
        while ($row = mysqli_fetch_array($tables)) {
            $table = $row[0];
            echo "<li><a href='view_table.php?table=" . urlencode($table) . "'>$table</a></li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color:red;'>테이블 불러오기 실패: " . mysqli_error($conn) . "</p>";
    }
    ?>
</div>

</body>
</html>
