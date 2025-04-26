<?php
$host = "localhost"; // MySQL 서버 주소
$user = "root";      // MySQL 사용자명
$password = "root1234";      // MySQL 비밀번호
$database = "testdb"; // 사용하려는 데이터베이스 이름

// MySQL 연결
$conn = mysqli_connect($host, $user, $password, $database);

// 연결 확인
if (!$conn) {
    die("DB 연결 실패: " . mysqli_connect_error());
}
?>
