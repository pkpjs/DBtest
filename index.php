<?php
$mysqli = new mysqli("localhost", "root", "root1234", "testdb");
$tables_result = $mysqli->query("SHOW TABLES");

if (!$tables_result) {
    die("Query failed: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>테이블 목록 보기</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1 class="mb-4">📄 테이블 목록</h1>
    
    <!-- query.php로 이동할 수 있는 링크 추가 -->
    <div class="alert alert-info">
        <h4 class="alert-heading">새로운 테이블 만들기</h4>
        <p>테이블을 새로 만들거나 데이터베이스에 쿼리문을 실행하고 싶다면, 아래 링크를 클릭하여 SQL 쿼리문을 입력해 주세요.</p>
        <a href="query.php" class="btn btn-primary">SQL 쿼리문 입력하기</a>
    </div>

    <ul class="list-group">
        <?php while ($table = $tables_result->fetch_row()): ?>
            <li class="list-group-item">
                <a href="view_table.php?table=<?= $table[0] ?>"><?= htmlspecialchars($table[0]) ?></a>
            </li>
        <?php endwhile; ?>
    </ul>

    <a href="query.php" class="btn btn-success mt-3">✍️ 새 테이블 생성</a>
</body>
</html>
