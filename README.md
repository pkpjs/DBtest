# DBtest

MySQL 데이터베이스와 웹을 연동하여 작동하는 테스트 프로젝트입니다.

## 📦 구성 파일
- OS : ubuntu
- `index.php` : DB에서 데이터를 조회하여 테이블 형태로 출력  
- `query.php` : 사용자 입력을 받아 DB에 새로운 데이터 추가  
- `style.css` : 웹페이지 스타일 시트  
- `config.php` : MySQL 접속 설정  
- `setup_web_db.sh` : 웹 서버 및 DB 초기화 자동 스크립트

## 🚀 서버 실행 방법

1. **VM 환경에서 다음 포트로 Apache 실행 중이어야 합니다:**
http://127.0.0.1:9001/index.php http://127.0.0.1:9001/query.php

3. **최초 환경 구축은 아래 스크립트 한 줄로 완료됩니다:**

```bash
./setup_web_db.sh

 MySQL 설정 정보
DB 이름: testdb

테이블 이름: test

컬럼 구성:

id (INT, AUTO_INCREMENT, PRIMARY KEY)

name (VARCHAR(50), NOT NULL)

🧾 쿼리문 예시

CREATE DATABASE testdb;
USE testdb;

CREATE TABLE test (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

INSERT INTO test (name) VALUES ('테스트1'), ('테스트2');

🌐 URL 경로 안내
데이터 조회: http://127.0.0.1:9001/index.php

데이터 입력: http://127.0.0.1:9001/query.php
