#!/bin/bash

PORT=9000

echo "서버가 포트 $PORT에서 실행 중입니다."

echo "🔧 시스템 업데이트 및 패키지 설치 중..."
sudo apt update
sudo apt install -y apache2 php libapache2-mod-php php-mysql mysql-server

echo "✅ Apache 및 MySQL 설치 완료"

echo "🔐 MySQL 보안 설정 중..."
sudo mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'root1234'; FLUSH PRIVILEGES;"

echo "🗃 DB 및 테이블 생성 중..."
sudo mysql -u root -proot1234 <<EOF
CREATE DATABASE IF NOT EXISTS testdb;
USE testdb;
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
EOF

echo "📂 웹 파일 생성 중..."

# form.php
cat <<EOL | sudo tee /var/www/html/form.php > /dev/null
<?php
\$mysqli = new mysqli("localhost", "root", "root1234", "testdb");
if (\$_SERVER["REQUEST_METHOD"] == "POST") {
    \$content = \$_POST['content'];
    \$stmt = \$mysqli->prepare("INSERT INTO messages (content) VALUES (?)");
    \$stmt->bind_param("s", \$content);
    \$stmt->execute();
    \$stmt->close();
    echo "<p>메시지 추가 완료!</p>";
}
\$mysqli->close();
?>
<form method="POST">
    <input type="text" name="content" placeholder="메시지 입력">
    <button type="submit">추가</button>
</form>
<p><a href='index.php'>목록 보기</a></p>
EOL

# index.php
cat <<EOL | sudo tee /var/www/html/index.php > /dev/null
<?php
\$mysqli = new mysqli("localhost", "root", "root1234", "testdb");
if (\$mysqli->connect_error) {
    die("DB 연결 실패: " . \$mysqli->connect_error);
}
\$result = \$mysqli->query("SELECT * FROM messages ORDER BY created_at DESC");
echo "<h1>메시지 목록</h1><ul>";
while (\$row = \$result->fetch_assoc()) {
    echo "<li>" . htmlspecialchars(\$row['content']) . " - " . \$row['created_at'] . "</li>";
}
echo "</ul>";
\$mysqli->close();
?>
<meta http-equiv="refresh" content="10">
<p><a href='form.php'>메시지 입력하기</a></p>
EOL

echo "🔄 Apache 재시작 중..."
sudo systemctl restart apache2

echo "🎉 완료! 브라우저에서 접속:"
echo "👉 http://<VM IP>/form.php 로 메시지 입력"
echo "👉 http://<VM IP>/index.php 로 메시지 목록 확인"
