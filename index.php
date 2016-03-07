<?php
	$cFile = include("db.php");
	if ($cFile)
		$person = new dbConnection();
	else
		echo "<script language='JavaScript'>alert('Fail to choose the file PHP');</script>";
?>

<html>

<head>

<title>Example databases with Classes</title>

</head>

<body>

<form action="#" method="POST">

<fieldset><legend>Contact details</legend>

Name:&nbsp; <input type="text" name="iName" maxlength="70" /><br/><br/>

Address:&nbsp;<input type="text" name="iAddress" maxlength="70" /><br/><br/>

Telephone:&nbsp;<input type="text" name="iNumber" maxlength="15" /><br/><br/>

<input type="submit" value="Add" name="saveIt" /><input type="submit" value="Delete contactBook" name="cBook" /><input type="reset" value="Delete form" />


</fieldset>

</form>

</body>

</html>

<?php
if (isset($_POST['saveIt']))
{
	$contact = new dbConnection();
	$contact->addRegister($_POST['iName'], $_POST['iAddress'],$_POST['iNumber']);	
}
else if (isset($_POST['cBook']))
{
	$person->readRegisters();
}
else if (isset($_POST['deleteIt']))
{
	$person->deleteRegister($_POST['chooseId']);
}
?>
