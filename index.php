<?php 
	require_once 'inc/functions.php';
	$task = $_REQUEST['task'] ?? 'report';
	$error = $_REQUEST['error'] ?? '0';
	$info = '';
	if ('seed' == $task) {
		seed();
		$info = 'Seeding is completed';
	}

	$fname = '';
	$lname = '';
	$roll = '';
	if(isset($_POST['save'])){
		$fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
		$lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
		$roll = filter_input(INPUT_POST, 'roll', FILTER_SANITIZE_STRING);

		if($fname != '' && $lname != '' && $roll != ''){
			// addStudent($fname, $lname, $roll);
			$result = addStudent($fname, $lname, $roll);
			if ($result) {
				header('location: /crud/index.php?task=report');
			} else {
				$error = 1;
			}
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<title>Document</title>
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-8 offset-2">
				<h1>Project 2- CRUD</h1>
				<p>A Sample project to perform CRUD operations using plain files and php.</p>
				<?php include_once('inc/templates/nav.php'); ?>
				<hr>
				
				<?php echo ($info != '') ? "<p>{$info}</p>" : ''; ?>
			</div>
		</div>

		<?php if('1' == $error): ?>
			<div class="row">
				<div class="col-8 offset-2">
				<blockquote>Duplicate Roll Number.</blockquote>
				</div>
			</div>
		<?php endif; ?>

		<?php if('report' == $task): ?>
			<div class="row">
				<div class="col-8 offset-2">					
					<?php generateReport(); ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if('add' == $task): ?>
			<div class="row">
				<div class="col-8 offset-2">
					<form action="/crud/index.php?task=add" method="POST">
						<label for="fname">First Name</label>
						<input class="form-control" type="text" name="fname" id="fname" value="<?php echo $fname;?>">
						<label for="lname">Last Name</label>
						<input class="form-control" type="text" name="lname" id="lname" value="<?php echo $lname;?>">
						<label for="roll">Roll No</label>
						<input class="form-control" type="number" name="roll" id="roll" value="<?php echo $roll;?>">
						<button class="btn btn-primary mt-4" type="submit" name="save">Save</button>
					</form>
				</div>
			</div>
		<?php endif; ?>
	</div>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
