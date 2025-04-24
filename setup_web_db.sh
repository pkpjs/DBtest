#!/bin/bash

PORT=9001

echo "✅ 서버 설정 스크립트 실행 시작..."

# 1. 패키지 설치
echo "📦 Apache, PHP, MySQL 설치 중..."
sudo apt update
sudo apt install -y apache2 php libapache2-mod-php php-mysql mysql-server

# 2. MySQL 비밀번호 설정 및 DB, 테이블 생성
echo "🔐 MySQL 초기 설정 및 DB 생성 중..."
sudo mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'root1234'; FLUSH PRIVILEGES;"

sudo mysql -u root -proot1234 <<EOF
CREATE DATABASE IF NOT EXISTS testdb;
USE testdb;
CREATE TABLE IF NOT EXISTS test (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);
INSERT INTO test (name) VALUES ('테스트1'), ('테스트2');
EOF

# 3. PHP 파일 생성
echo "📄 PHP 파일 생성 중..."

# index.php
sudo tee /var/www/html/index.php > /dev/null <<'EOF'
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
EOF

# query.php
sudo tee /var/www/html/query.php > /dev/null <<'EOF'
<?php
$mysqli = new mysqli("localhost", "root", "root1234", "testdb");
$result = null;
$error = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = $_POST["sql"];
    if (!empty($sql)) {
        try {
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
    <div class="alert alert-info">
        <h4 class="alert-heading">쿼리문 예시</h4>
        <p>새로운 테이블을 만들거나 데이터를 추가하려면 아래 예시들을 참고해 주세요.</p>
        <ul>
            <li><code>CREATE TABLE 테이블명 (열1 자료형, 열2 자료형);</code> - 새 테이블 생성</li>
            <li><code>INSERT INTO 테이블명 (열1, 열2) VALUES (값1, 값2);</code> - 데이터 삽입</li>
            <li><code>SELECT * FROM 테이블명;</code> - 테이블의 모든 데이터 조회</li>
        </ul>
    </div>
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
EOF

# view_table.php
sudo tee /var/www/html/view_table.php > /dev/null <<'EOF'
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
EOF

# 4. Apache 포트 변경
echo "🔧 Apache 포트 $PORT 로 변경 중..."
sudo sed -i "s/Listen 80/Listen $PORT/" /etc/apache2/ports.conf
sudo sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:$PORT>/" /etc/apache2/sites-available/000-default.conf

# 5. Apache 재시작
echo "🔁 Apache 서버 재시작 중..."
sudo systemctl restart apache2

echo "🎉 설정 완료!"
echo "🌐 접속 주소: http://127.0.0.1:$PORT/index.php"
