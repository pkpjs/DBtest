<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>SQL 예제 쿼리 목록</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            padding: 30px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        h2 {
            color: #0077cc;
        }
        .query-list {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .query-item {
            margin-bottom: 20px;
        }
        .query-item h3 {
            color: #333;
        }
        .query-item p {
            color: #555;
        }
        .query-item code {
            display: block;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
            margin-top: 5px;
            white-space: pre-wrap;
        }
        a {
            text-decoration: none;
            color: #0077cc;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>💻 SQL 예제 쿼리 목록</h2>
    <div class="query-list">

        <!-- SELECT 예제 -->
        <div class="query-item">
            <h3>1. 모든 사용자 조회</h3>
            <p>'users' 테이블의 모든 데이터를 조회합니다.</p>
            <code>SELECT * FROM users;</code>
        </div>

        <!-- INSERT 예제 -->
        <div class="query-item">
            <h3>2. 새 사용자 추가</h3>
            <p>'users' 테이블에 새로운 사용자를 추가합니다.</p>
            <code>INSERT INTO users (name, email) VALUES ('홍길동', 'hong@example.com');</code>
        </div>

        <!-- UPDATE 예제 -->
        <div class="query-item">
            <h3>3. 사용자 이메일 수정</h3>
            <p>ID가 1인 사용자의 이메일을 수정합니다.</p>
            <code>UPDATE users SET email = 'new@example.com' WHERE id = 1;</code>
        </div>

        <!-- DELETE 예제 -->
        <div class="query-item">
            <h3>4. 사용자 삭제</h3>
            <p>ID가 1인 사용자를 삭제합니다.</p>
            <code>DELETE FROM users WHERE id = 1;</code>
        </div>

        <!-- ORDER BY 예제 -->
        <div class="query-item">
            <h3>5. 이름순 정렬</h3>
            <p>'users' 테이블을 이름 기준으로 오름차순 정렬합니다.</p>
            <code>SELECT * FROM users ORDER BY name ASC;</code>
        </div>

        <!-- GROUP BY 예제 -->
        <div class="query-item">
            <h3>6. 상품 카테고리별 개수</h3>
            <p>'products' 테이블에서 카테고리별 상품 수를 조회합니다.</p>
            <code>SELECT category, COUNT(*) FROM products GROUP BY category;</code>
        </div>

        <!-- JOIN 예제 -->
        <div class="query-item">
            <h3>7. 사용자와 주문 정보 조인</h3>
            <p>'users'와 'orders' 테이블을 user_id 기준으로 조인합니다.</p>
            <code>
SELECT users.name, orders.order_date
FROM users
JOIN orders ON users.id = orders.user_id;
            </code>
        </div>

        <!-- 서브쿼리 예제 -->
        <div class="query-item">
            <h3>8. 평균 가격보다 높은 상품 조회</h3>
            <p>평균 가격보다 비싼 상품들을 조회합니다.</p>
            <code>
SELECT * FROM products
WHERE price > (SELECT AVG(price) FROM products);
            </code>
        </div>

        <!-- DISTINCT 예제 -->
        <div class="query-item">
            <h3>9. 중복 제거된 도시 목록 조회</h3>
            <p>'users' 테이블에서 중복 없이 도시 목록을 조회합니다.</p>
            <code>SELECT DISTINCT city FROM users;</code>
        </div>

        <!-- LIMIT 예제 -->
        <div class="query-item">
            <h3>10. 상위 5개 상품 조회</h3>
            <p>'products' 테이블에서 상위 5개 상품만 조회합니다.</p>
            <code>SELECT * FROM products LIMIT 5;</code>
        </div>

        <!-- VIEW 예제 -->
        <div class="query-item">
            <h3>11. 사용자 이메일 뷰 생성</h3>
            <p>'users' 테이블의 이름과 이메일을 포함하는 뷰를 생성합니다.</p>
            <code>CREATE VIEW user_emails AS SELECT name, email FROM users;</code>
        </div>

        <!-- DROP 예제 -->
        <div class="query-item">
            <h3>12. 테이블 삭제</h3>
            <p>'users' 테이블을 완전히 삭제합니다.</p>
            <code>DROP TABLE users;</code>
        </div>

        <!-- TRUNCATE 예제 -->
        <div class="query-item">
            <h3>13. 테이블 데이터 전체 삭제</h3>
            <p>'users' 테이블의 모든 데이터를 삭제합니다.</p>
            <code>TRUNCATE TABLE users;</code>
        </div>

        <!-- FOR UPDATE 예제 -->
        <div class="query-item">
            <h3>14. 행 잠금 조회</h3>
            <p>'users' 테이블에서 특정 행을 잠금 상태로 조회합니다.</p>
            <code>SELECT * FROM users WHERE id = 1 FOR UPDATE;</code>
        </div>

        <!-- INDEX 예제 -->
        <div class="query-item">
            <h3>15. 인덱스 생성</h3>
            <p>'users' 테이블의 email 컬럼에 인덱스를 생성합니다.</p>
            <code>CREATE INDEX idx_email ON users(email);</code>
        </div>

        <!-- SQL Injection 방어 예제 -->
        <div class="query-item">
            <h3>16. SQL Injection 방어</h3>
            <p>사용자 입력을 안전하게 처리하여 SQL Injection을 방지합니다.</p>
            <code>
-- PHP 예제
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $input_email]);
            </code>
        </div>

    </div>

    <a href="index.php">← 메인 페이지로 돌아가기</a>
</div>

</body>
</html>
