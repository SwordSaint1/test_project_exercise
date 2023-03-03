<?php 
include 'conn.php';
//MODEL
$method = $_POST['method'];

if ($method == 'save_data') {
	$iata_code = $_POST['iata_code'];
	$name = $_POST['name'];
	$name = preg_replace("/'/", '`', $name); 
	$icao_code = $_POST['icao_code'];
	$icao_name = $icao_code.''.$name;
	
	$query = "INSERT INTO records(`iata_code`,`name`,`icao_name`)VALUES('$iata_code','$name','$icao_name')";
	$stmt = $conn->prepare($query);
	if ($stmt->execute()) {
		echo 'success';
		$stmt = NULL;
	}else{
		echo 'error';
		$stmt = NULL;
	}

}

if ($method == 'fetch_records') {
	$c = 0;

	$query = "SELECT * FROM records";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchAll() as $j){
			$c++;
			echo '<tr>';
				echo '<td>'.$c.'</td>';
				echo '<td>'.$j['iata_code'].'</td>';
				echo '<td>'.$j['name'].'</td>';
				echo '<td>'.$j['icao_name'].'</td>';
			echo '</tr>';
		}
	}else{
		echo '<tr>';
			echo '<td colspan="4" style="text-align:center; color:red;"><h4>No Result !!!</h4></td>';
		echo '</tr>';
	}
}

$conn = NULL;
?>