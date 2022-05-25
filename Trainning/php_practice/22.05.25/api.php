<?php
// database connection
defined('DB_HOST') or define('DB_HOST', 'localhost');
defined('DB_USER') or define('DB_USER', 'root');
defined('DB_PASSWORD') or define('DB_PASSWORD', '');
defined('DB_NAME') or define('DB_NAME', 'scroll_project');

$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$link) {
    die ('error'. mysqli_connect_error());
}

// get lorem posts
$file = file_get_contents('http://loripsum.net/api/3/short', true);

// check and insert posts into db
$posts_check = mysqli_query($link, "SELECT * FROM `posts`");
$count = mysqli_num_rows($posts_check);

if ($count == 0) {
    $ptime = date('Y-m-d H:i:s');
    for ($i = 0; $i < 50; $i++) {
        $query = "INSERT INTO `posts` (`content`, `date`) VALUES ('$file', '$ptime')";
        $result = mysqli_query($link, $query);
    }
}

// posts api
if ($_POST) {
    $limit = isset($_POST['item_load'])? $_POST['item_load']: 1;
    $offset = isset($_POST['offset'])? $_POST['offset']: 0;
    $get_posts = "SELECT * FROM `posts` ORDER BY `id` ASC LIMIT $limit OFFSET $offset";
    $posts = mysqli_query($link, $get_posts);

    $result = array();
    while ($row = mysqli_fetch_array($posts)) {
        $result[] = array(
            'id' => $row['id'],
            'content' => $row['content'],
            'date' => $row['date']
        );
    }
    $posts_array['content'] = $result;
    echo json_encode($posts_array);
}