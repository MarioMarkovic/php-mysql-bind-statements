<?php
include_once '../../db.php';
$error = false;

$query = "SELECT b.id, b.title, b.author_id, first_name, last_name FROM books AS b JOIN authors AS a ON b.author_id=a.id";
$result = $db->query($query);
if(!$result) {
	$error = true;
	$errorMessage = "Došlo je do greške prilikom izvršavanja upita " . $db->error;
}
$_pageTitle = 'Books';
include_once '../header.php';
?>
<h1>Books</h1>
<?php
if($error === true) {
	echo '<div>' . $errorMessage . '</div>';
} else {
?>
<table class="table table-striped table-bordered">
	<thead class="thead-dark">
		<tr>
			<th>ID</th>
			<th>Book title</th>
			<th>Authors</th>
			<th>Operations</th>
		</tr>
	</thead>
	<tbody>
	<?php while($books = $result->fetch_assoc()) { ?>	
	<tr>
		<td><?php echo $books['id']; ?></td>
		<td><?php echo "<a href='show.php?id=" . $books['id'] . "'>" . $books['title'] . "</a>"; ?></td>
		<td><?php echo "<a href='../authors/show.php?id=" . $books['author_id'] . "'>" . $books['last_name'] . ", " . $books['first_name']; ?></td>
		<td>
			<a class="btn btn-sm btn-info" href="edit.php?id=<?php echo $books['id']; ?>">Edit</a>
			<a class="btn btn-sm btn-danger" href="delete.php?id=<?php echo $books['id']; ?>">Delete</a>
		</td>
	</tr>
	<?php } ?>
	


<?php
include_once '../footer.php';
}
?>
