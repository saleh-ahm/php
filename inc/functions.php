<?php
define('DB_NAME', 'C:\\Users\\Saleh Ahmad\\Desktop\\php\\crud\\data\\db.txt');

function seed(){
	$data = array(
		array(
			'id' => 1,
			'fname' => 'Kamal',
			'lname' => 'Ahmad',
			'roll' => '11',
		),
		array(
			'id' => 2,
			'fname' => 'Jamal',
			'lname' => 'Ahmad',
			'roll' => '10',
		),
		array(
			'id' => 3,
			'fname' => 'Ripon',
			'lname' => 'Ahmad',
			'roll' => '9',
		),
		array(
			'id' => 4,
			'fname' => 'Shipon',
			'lname' => 'Ahmad',
			'roll' => '8',
		),
		array(
			'id' => 5,
			'fname' => 'Rahim',
			'lname' => 'Ahmad',
			'roll' => '7',
		),
	);
	
	$serializedData = serialize($data);
	file_put_contents(DB_NAME, $serializedData, LOCK_EX);
	
}

function generateReport() {
	$serializedData = file_get_contents(DB_NAME);
	$students = unserialize($serializedData);
	?>
	<table class="table">
		<tr>
			<th>Name</th>
			<th>Roll</th>
			<th>Action</th>
		</tr>
		<?php foreach ($students as $student) : ?>
			<tr>
				<td><?php printf('%s %s',$student['fname'],$student['lname']); ?></td>
				<td><?php printf('%s',$student['roll']);?></td>
				<td><?php printf('<a href="/crud/index.php?task=edit&id=%s">Edit</a> | <a href="/crud/index.php?task=delete&id=%s">Delete</a>', $student['id'], $student['id']);  ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<?php
}


function addStudent($fname, $lname, $roll) {
	$found = false;
	$serializedData = file_get_contents(DB_NAME);
	$students = unserialize($serializedData);
	foreach($students as $_student){
		if($_student['roll'] == $roll) {
			$found = true;
			break;
		}
	}

	if(!$found){
		$newId = count($students)+1;
		$student = array(
			'id' => $newId,
			'fname' => $fname,
			'lname' => $lname,
			'roll' => $roll,
		);

		array_push($students, $student);
		$serializedData = serialize($students);
		file_put_contents(DB_NAME, $serializedData, LOCK_EX);
		return true;
	}
	return false;
}


function getStudent($id) {
	$serializedData = file_get_contents(DB_NAME);
	$students = unserialize($serializedData);
	foreach($students as $student){
		if($student['id'] == $id) {
			return $student;
		}
	}
	return false;
}

function updateStudent($id, $fname, $lname, $roll) {
	$found = false;
	$serializedData = file_get_contents(DB_NAME);
	$students = unserialize($serializedData);
	foreach($students as $_student){
		if($_student['roll'] == $roll && $_student['id'] != $id) {
			$found = true;
			break;
		}
	}

	if (!$found) {
		$students[$id-1]['fname'] = $fname; 
		$students[$id-1]['lname'] = $lname; 
		$students[$id-1]['roll'] = $roll; 

		$serializedData = serialize($students);
		file_put_contents(DB_NAME, $serializedData, LOCK_EX);
		return true;
	}
	return false;
}