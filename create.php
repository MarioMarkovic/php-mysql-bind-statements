<?php 
include_once '../../db.php';
$error = false;
if(!empty($_POST)) {
	$query = "INSERT INTO books(title, author_id, publisher_id, category_id, description, date_published, quantity, isbn) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
	$stmt = $db->prepare($query);
	if(!$stmt){
		$error = true;
		$errorMessage = 'An error has occured ' . $db->error;
	} else {
		$stmt->bind_param('siiissis', $_POST['title'], $_POST['author'], $_POST['publisher'], $_POST['categories'], $_POST['description'], $_POST['date'], $_POST['quantity'], $_POST['isbn']);
		$result = $stmt->execute();
		if(!$result) {
			$error = true;
			$errorMessage = 'An error has occured ' . $stmt->error;
		}
	}
}	
$_pageTitle = 'Add new book';
include_once '../header.php'; 
?>
<h1>Add new book</h1>
<?php
if($error === true) {
	echo '<div>' . $errorMessage . '</div>';
}
?>
<form action="" method="POST">
	<div class="form-group">
		<label for="title">Title</label>
		<input type="text" class="form-control" name="title" id="title" required autofocus>
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
						echo "<option value='$id'>$first_name $last_name</option>";
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
						echo "<option value='$id'>$label</option>";
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
						echo "<option value='$id'>$name</option>";
					}
					$result->free();
				}

			?>
		</select>
	</div>
	<div class="form-group">
		<label for="description">Description</label>
		<textarea name="description" id="description" class="form-control" rows="5"></textarea>
	</div>
	<div class="form-group">
		<label for="date">Date published</label>
		<input type="date" name="date" id="date">
	</div>
	<div class="form-group">
		<label for="quantity">Quantity</label>
		<input type="number" name="quantity" id="quantity" required class="form-control">
	</div>
	<div class="form-group">
		<label for="isbn">ISBN</label>
		<input type="text" name="isbn" id="isbn" class="form-control">
	</div>
	<button type="submit" class="btn btn-primary btn-lg">Save</button>
</form>