<?php
$mysqli = new mysqli("localhost", "root", "root1234", "testdb");

if (isset($_GET['table'])) {
    $table = $_GET['table'];
    $result = $mysqli->query("SELECT * FROM `$table`");
} else {
    die("테이블이 지정되지 않았습니다.");
}

if (!$result) {
    die("Query failed: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>테이블 데이터 보기</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1 class="mb-4">📄 <?= htmlspecialchars($table) ?> 테이블 데이터</h1>
    
    <!-- 테이블 출력 -->
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <?php while ($field = $result->fetch_field()): ?>
                    <th><?= htmlspecialchars($field->name) ?></th>
                <?php endwhile; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <?php foreach ($row as $cell): ?>
                        <td><?= htmlspecialchars($cell) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-link">👈 테이블 목록으로 돌아가기</a>
</body>
</html>
