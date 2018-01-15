<?php 
include_once '../../db.php';
$id_get= $_GET['id'];

$error = false;
if(!empty($_POST)) {
	$query = "UPDATE books SET title=?, author_id=?, publisher_id=?, category_id=?, description=?, date_published=?, quantity=?, isbn=? WHERE id=?";
	$stmt = $db->prepare($query);
	if(!$stmt){
		$error = true;
		$errorMessage = 'An error has occured ' . $db->error;
	} else {
		$stmt->bind_param('siiissisi', $_POST['title'], $_POST['author'], $_POST['publisher'], $_POST['categories'], $_POST['description'], $_POST['date'], $_POST['quantity'], $_POST['isbn'], $id_get);
		$result = $stmt->execute();
		if(!$result) {
			$error = true;
			$errorMessage = 'An error has occured ' . $stmt->error;
		}
		$stmt->close();
	}
}	
$query = "SELECT title, author_id, publisher_id, category_id, description, date_published, quantity, isbn FROM books WHERE id=?";
$stmt = $db->prepare($query);
if(!$stmt) {
		$error = true;
		$errorMessage = 'An error has occured ' . $db->error;
} else {
	$stmt->bind_param('i', $id_get);
	$stmt->bind_result($title, $author_id, $publisher_id, $category_id, $description, $date_published, $quantity, $isbn);
	$result = $stmt->execute();
	if(!$result) {
		$error = true;
		$errorMessage = 'An error has occured ' . $stmt->error;
	} else {
		$stmt->fetch();	
		$stmt->close();
	}
}
?>
<?php 
	$_pageTitle = 'Edit author';
	include_once '../header.php'; 
?>
<h1>Edit book</h1>
<?php if(!empty($_POST) && (isset($result) && $result === true)) { ?>
<div class="alert alert-success">Book has been saved!</div>
<?php } ?>

<form action="" method="POST">
	<div class="form-group">
		<label for="title">Title</label>
		<input value="<?php echo $title; ?>" type="text" class="form-control" name="title" id="title" required autofocus>
	</div>
	<div class="form-group">
		<label for="author">Author</label>
		<select name="author" id="author" required>
			<option value="null">--/--</option>
			<?php
				$query = "SELECT id, first_name, last_name FROM authors";
				$result = $db->query($query);
				if(!$result) {
					$error = true;
					$errorMessage = "Došlo je do greške prilikom izvršavanja upita " . $db->error;
				} else {
					while ($author = $result->fetch_assoc()) {
						$id = $author['id'];
						$first_name = $author['first_name'];
						$last_name = $author['last_name'];
						if($author_id==$id) {
							echo "<option value='$id' selected>$first_name $last_name</option>";
						} else {
							echo "<option value='$id'>$first_name $last_name</option>";
						}
					}
					$result->free();
				}
			?>
		</select>
	</div>
	<div class="form-group">
		<label for="publisher">Publisher</label>
		<select name="publisher" id="publisher" required>
			<option value="null">--/--</option>
			<?php
				$query = "SELECT id, label FROM publisher";
				$result = $db->query($query);
				if(!$result) {
					$error = true;
					$errorMessage = "Došlo je do greške prilikom izvršavanja upita " . $db->error;
				} else {
					while ($publisher = $result->fetch_assoc()) {
						$id = $publisher['id'];
						$label = $publisher['label'];
						if($publisher_id==$id) {
							echo "<option value='$id' selected>$label</option>";
						} else {
							echo "<option value='$id'>$label</option>";
						}
					}
					$result->free();
				}
			?>
		</select>
	</div>
	<div class="form-group">
		<label for="categories">Categories</label>
		<select name="categories" id="categories" required>
			<option value="null">--/--</option>
			<?php
				$query = "SELECT id, name FROM categories";
				$result = $db->query($query);
				if(!$result) {
					$error = true;
					$errorMessage = "Došlo je do greške prilikom izvršavanja upita " . $db->error;
				} else {
					while ($categories = $result->fetch_assoc()) {
						$id = $categories['id'];
						$name = $categories['name'];
						if($category_id == $id)
							echo "<option value='$id' selected>$name</option>";
						else {
							echo "<option value='$id'>$name</option>";
						}
					}
					$result->free();
					$db->close();
				}
			?>
		</select>
	</div>
	<div class="form-group">
		<label for="description">Description</label>
		<textarea name="description" id="description" class="form-control" rows="5"><?php echo $description; ?></textarea>
	</div>
	<div class="form-group">
		<label for="date">Date published</label>
		<input type="date" name="date" id="date" value="<?php echo $date_published; ?>">
	</div>
	<div class="form-group">
		<label for="quantity">Quantity</label>
		<input type="number" name="quantity" id="quantity" required class="form-control" value="<?php echo $quantity; ?>">
	</div>
	<div class="form-group">
		<label for="isbn">ISBN</label>
		<input type="text" name="isbn" id="isbn" class="form-control" value="<?php echo $isbn; ?>">
	</div>
	<button type="submit" class="btn btn-primary btn-lg">Save</button>
</form>
<?php include_once '../footer.php';