<?php include("templates/page_header.php");?>
<?php include("lib/auth.php") ?>
<?php

if($_SERVER['REQUEST_METHOD'] == 'GET') {
	$aid = $_GET['aid'];
	$result=get_article($dbconn, $aid);
	$row = pg_fetch_array($result, 0);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Sanitized Title -- XSS prevention
	$title_var = $_POST['title'];
	$title = htmlentities($title_var, ENT_QUOTES, 'UTF-8');
	$content = $_POST['content'];
	$aid = $_POST['aid'];
	$result=update_article($dbconn, $title, $content, $aid);
	Header ("Location: /");
}
?>

<!doctype html>
<html lang="en">
<head>
	<title>New Post</title>
	<?php include("templates/header.php"); ?>
</head>
<body>
	<?php include("templates/nav.php"); ?>
	<?php include("templates/contentstart.php"); ?>

<h2>New Post</h2>

<form action='#' method='POST'>
	<input type="hidden" value="<?php echo $row['aid'] ?>" name="aid">
	<div class="form-group">
	<label for="inputTitle" class="sr-only">Post Title</label>
	<!------------------- XSS prevention measures on title ---------------------->
	<input type="text" id="inputTitle" required autofocus name='title' value="<?php echo htmlentities($row['title'], ENT_QUOTES, 'UTF-8') ?>">
	</div>
	<div class="form-group">
	<label for="inputContent" class="sr-only">Post Content</label>
	<textarea name='content' id="inputContent"><?php echo $row['content'] ?></textarea>
	</div>
	<input type="submit" value="Update" name="submit" class="btn btn-primary">
</form>
<br>

	<?php include("templates/contentstop.php"); ?>
	<?php include("templates/footer.php"); ?>
</body>
</html>
