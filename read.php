<html>
<head>
<meta charset="utf-8">
<title>MySQL Connect</title>
</head>
<body>

<?php
$servername = "*****";
$username = "******";
$password = "*******";
$dbname = "*******";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<h2> Introduceti urmatoarele date pentru stocare in mysql: </h2>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
firstname : <input type="text" name="fn">
<br>
lastname : <input type="text" name="ln">
<br>
email: <input type="text" name="em">
<br>
poza: <input type="file" name="fileToUpload">
<input type="submit" name="submit" value="trimite">
</form>
<br><br><br>
 
<?php
if (isset($_POST["submit"])){
	$fn1=$_POST[fn];
	$ln1=$_POST[ln];
	$em1=$_POST[em];
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$tmpName = $_FILES['fileToUpload']['tmp_name'];
$fp = fopen($tmpName, 'r');
$data = fread($fp, filesize($tmpName));
$data = addslashes($data);
fclose($fp);

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";}	
	$sql = "INSERT INTO MyGuests (firstname, lastname, email, poza, calepoz)
		   	VALUES ('$fn1', '$ln1', '$em1', '$data', '$target_file')";
	if (mysqli_query($conn, $sql)) {
    	echo "New record created successfully";
	} else {
   	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	
$sql = "SELECT id, firstname, lastname, poza, calepoz FROM MyGuests";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
		"<br>";
        echo "id: " . $row["id"]. " - Numele: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
		$pozica=$row["calepoz"];
		echo "<img src=$pozica>";
		echo "<dt><strong>Technician Image:</strong></dt><dd>" . 
				'<img src="data:image/jpeg;base64,'.
				base64_encode($row['poza']).
				'" width="290" height="290">' . "</dd>";
		"<br>";
	 }
} else {
    echo "0 results";
}
mysqli_close($conn);
}
?>

</body>
</html>
