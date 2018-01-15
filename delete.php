<?php

include_once '../../db.php';

$error = false;

$id = $_GET['id'];

$query = "DELETE FROM books WHERE id=?";

$stmt = $db ->prepare($query);
if(!$stmt) {
	$error = true;
	$errorMessage = 'This is an error Message ' . $db->error;
}else{
	$stmt->bind_param('i',$id);
	$result=$stmt->execute();
	if(!$result){
		$error = true;
		$errorMessage = 'This is an error Message' . $stmt->error;
	}
	$stmt->close();
}
$db->close();
?>

<?php 
	$_pageTitle = 'Delete book';
	include_once '../header.php'; 
?>

<h1>Delete book</h1>
<?php if($result === true) { ?>
<div class="alert alert-warning">Book has been deleted!</div>
<?php } ?>

<?php include_once '../footer.php'; ?>
