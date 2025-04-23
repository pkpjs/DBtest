<?php
$mysqli = new mysqli("localhost", "root", "root1234", "testdb");
$result = null;
$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = $_POST["sql"];
    if (!empty($sql)) {
        try {
            // SQL 쿼리 실행
            $result = $mysqli->query($sql);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SQL 쿼리 실습</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1 class="mb-4">🧪 SQL 쿼리 실습</h1>

    <!-- 쿼리문 가이드 추가 -->
    <div class="alert alert-info">
        <h4 class="alert-heading">쿼리문 예시</h4>
        <p>새로운 테이블을 만들거나 데이터를 추가하려면 아래 예시들을 참고해 주세요.</p>
        <ul>
            <li><code>CREATE TABLE 테이블명 (열1 자료형, 열2 자료형);</code> - 새 테이블 생성</li>
            <li><code>INSERT INTO 테이블명 (열1, 열2) VALUES (값1, 값2);</code> - 데이터 삽입</li>
            <li><code>SELECT * FROM 테이블명;</code> - 테이블의 모든 데이터 조회</li>
        </ul>
    </div>

    <!-- SQL 입력 폼 -->
    <form method="POST">
        <textarea name="sql" class="form-control mb-3" rows="4" placeholder="예: CREATE TABLE test (id INT PRIMARY KEY, name VARCHAR(100));" required><?= isset($_POST['sql']) ? htmlspecialchars($_POST['sql']) : '' ?></textarea>
        <button type="submit" class="btn btn-primary">실행</button>
    </form>

    <?php if ($error): ?>
        <div class="alert alert-danger mt-4">❌ 오류: <?= htmlspecialchars($error) ?></div>
    <?php elseif ($result): ?>
        <div class="alert alert-success mt-4">✅ 쿼리 실행 성공</div>
    <?php endif; ?>
</body>
</html>
