<?php
$method = $_SERVER["REQUEST_METHOD"];
$conn = new PDO("mysql:host=localhost;dbname=test", "root", "");

if ($method == "GET") {
    $query = $conn->query("SELECT * FROM posts WHERE visible = 1 ORDER BY id DESC");
    $rows = $query->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($rows);
}
else if ($method == "POST") {
    $jsonData = file_get_contents("php://input");
    $mydata = json_decode($jsonData, true);

    $title = $mydata["title"];
    $content = $mydata["content"];
    $category_id = $mydata["category_id"];
    $query = $conn->prepare("INSERT INTO posts (title, content, date, category_id) VALUES (?, ?, now(), ?)");
    $query->execute([$title, $content, $category_id]);
    if($query){
        $data = [ "status" => true, "message" => "Post inserted successfully!" ];
    }else{
        $data = [ "status" => false, "message" => "An error has occurred!" ];
    }
        
    


    echo json_encode($data);
}