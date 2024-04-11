<?php

// データベース接続情報
$dsn = 'mysql:host=localhost;dbname=your_database;charset=utf8';
$username = 'your_username';
$password = 'your_password';

try {
    // データベース接続
    $db = new PDO($dsn, $username, $password);
    
    // トランザクション開始
    $db->beginTransaction();
    
    // トランザクション内で実行するクエリ
    $query1 = "INSERT INTO your_table (column1, column2) VALUES ('value1', 'value2')";
    $query2 = "UPDATE your_table SET column1 = 'new_value' WHERE id = 1";
    
    // クエリの実行
    $db->exec($query1);
    $db->exec($query2);
    
    // トランザクションのコミット
    $db->commit();
    
    echo "トランザクションが正常に完了しました。";
} catch (PDOException $e) {
    // トランザクションのロールバック
    $db->rollBack();
    
    // エラーメッセージの表示
    echo "エラーが発生しました：" . $e->getMessage();
}
