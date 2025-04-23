<?php
$mysqli = new mysqli("localhost", "root", "root1234", "testdb");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['content'];
    $stmt = $mysqli->prepare("INSERT INTO messages (content) VALUES (?)");
    $stmt->bind_param("s", $content);
    $stmt->execute();
    $stmt->close();
    echo "<p>메시지 추가 완료!</p>";
}
$mysqli->close();
?>
<form method="POST">
    <input type="text" name="content" placeholder="메시지 입력">
    <button type="submit">추가</button>
</form>
<p><a href='index.php'>목록 보기</a></p>
