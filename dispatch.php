<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Police Emergency Service System</title>
</head>
<body>
<!-- display the incident information passed from logcall.php -->
<form name="form1" method="post" action"<?php echo htmlentities($_SERVER['PHP_SELF']); ?> ">
<table>
  <tr>
    <td colspan="2">Incident Detail</td>
  </tr>
  <tr>
    <td>Caller's Name :</td>
	<td><?php echo $_POST['callerName'] ?>
		<input type="hidden" name="callerName" id="callerName"
		value="<?php echo $_POST['callerName'] ?>"></td>
  </tr>
  <tr>
    <td>Contact No :</td>
	<td><?php echo $_POST['contactNo'] ?>
		<input type="hidden" name="contactNo" id="contactNo"
		value="<?php echo $_POST['contactNo'] ?>"></td>
  </tr>
  <tr>
    <td>Location :</td>
	<td><?php echo $_POST['location'] ?>
		<input type="hidden" name="location" id="location"
		value="<?php echo $_POST['location'] ?>"></td>
  </tr>
  <tr>
    <td>Incident Type :</td>
	<td><?php echo $_POST['incidentType'] ?>
		<input type="hidden" name="incidentType" id="incidentType"
		value="<?php echo $_POST['incidentType'] ?>"></td>
  </tr>
  <tr>
    <td>Description :</td>
	<td><textarea name="incidentDesc" cols="45" rows="5" readonly id="incidentDesc"><?php echo $_POST['incidentDesc'] ?></textarea>
	<input type="hidden" name="incidentDesc" id="incidentDesc" 
	value="<?php echo $_POST['incidentDesc'] ?>"></td>
  </tr>
</table>
<?php
// connect to a database
require_once 'db.php';
// Create connection
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// retrieve from patrolcar table those patrol cars that are 2:Patrol or 3:Free
$sql = "SELECT patrolcar_id, patrolcar_status_desc FROM patrolcar JOIN
patrolcar_status
ON patrolcar.patrolcar_status_id=patrolcar_status.patrolcar_status_id
WHERE patrolcar.patrolcar_status_id='2' OR patrolcar.patrolcar_status_id='3'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$patrolcarArray[$row['patrolcar_id']] = $row['patrolcar_status_desc'];
	}
}
$conn->close();
?>
<!-- populate table with patrol car data -->
<table>
  <tr>
    <td colspan="3">Dispatch Patrolcar Panel</td>
  </tr>
  <?php
	  foreach($patrolcarArray as $key=>$value){
  ?>
  <tr>
    <td><input type="checkbox" name="chkPatrolcar[]"
		value="<?php echo $key?>"></td>
	<td><?php echo $key ?></td>
	<td><?php echo $value ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td><input type="reset" name="btnCancel" id="btnCancel" value="Reset"></td>
	<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btnDispatch" id="btnDispatch" value="Dispatch">
	</td>
  </tr>
</table>
<?php
// if postback via clicking Dispatch button
if (isset($_POST["btnDispatch"]))
{
	require_once 'db.php';
}
?>
</form>
</body>
</html>