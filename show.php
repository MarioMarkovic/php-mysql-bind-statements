<?php
include_once '../../db.php';
$error = false;
if(isset($_GET['id'])) {
	$id = $_GET['id'];
}
$query = "SELECT b.id, b.title, b.author_id, b.publisher_id, b.category_id, b.description, b.date_published, b.quantity, first_name, last_name, label, name FROM books as b JOIN authors as a ON b.author_id=a.id JOIN publisher as p ON b.publisher_id=p.id JOIN categories as c ON  b.category_id=c.id WHERE b.id=?";
$stmt = $db->prepare($query);
if(!$stmt) {
	$error = true;
	$errorMessage = 'An error has occured ' . $db->error;
} else {
	$stmt->bind_param('i', $id);
	$stmt->bind_result($id, $title, $author_id, $publisher_id, $category_id, $description, $date_published, $quantity, $first_name, $last_name, $label, $name);
	$result = $stmt->execute();
		if(!$result) {
		$error = true;
		$errorMessage = 'An error has occured ' . $stmt->error;
	} else {
		$stmt->fetch();	
		$stmt->close();
	}
}	
$db->close();
$_pageTitle = 'Books';
include_once '../header.php';
?>
<h1>Display book details</h1>
<dl class="row">
	<dt class="col-sm-3">Book title</dt>
	<dd class="col-sm-9"><?php echo $title; ?></dd>
	<dt class="col-sm-3">Book author</dt>
	<dd class="col-sm-9"><?php echo "<a href='../authors/show.php?id=$author_id'>" . $last_name . ", " . $first_name . "</a>"; ?></dd>
	<dt class="col-sm-3">Category</dt>
	<dd class="col-sm-9"><?php echo $name; ?></dd>
	<dt class="col-sm-3">Publisher</dt>
	<dd class="col-sm-9"><?php echo $label; ?></dd>
	<dt class="col-sm-3">Date published</dt>
	<dd class="col-sm-9"><?php echo $date_published; ?></dd>
	<dt class="col-sm-3">Quantity</dt>
	<dd class="col-sm-9"><?php echo $quantity; ?></dd>
	<dt class="col-sm-3">Description</dt>
	<dd class="col-sm-9"><?php if(isset($description)) {echo $description; } else {echo "No description"; } ?></dd>
</dl>
<?php
include_once '../footer.php';