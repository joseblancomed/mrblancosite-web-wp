<?php
	$cFile = include("db.php");
	if ($cFile)
	{
		$person = new dbConnection();
	}
	else
		echo "<script language='JavaScript'>alert('Fail to choose the file PHP');</script>";
	
?>
<html>

<head>

<title>Example databases with Classes</title>

<link rel="stylesheet" type="text/css" href="css.css" />
<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="js.js"></script>

</head>
<body>

<form action="#" method="POST">

<fieldset><legend>Contact details</legend>

Name:&nbsp; <input type="text" name="iName" maxlength="70" /><br/><br/>

Address:&nbsp;<input type="text" name="iAddress" maxlength="70" /><br/><br/>

Telephone:&nbsp;<input type="text" name="iNumber" maxlength="15" /><br/><br/>

Add mobile:&nbsp;<input type="checkbox" id="pressIt" checked onClick='change()'/><br/><br/>

<span id="eNum">Other number:&nbsp;<input type="text" name="iExtraNum" maxlength="15" /></span><br/><br/>

<input type="submit" value="Add" name="saveIt" id="saveIt" onclick='reloadTable();' /><input type="reset" value="Delete form" /><br/><br/>
<input type="submit" value="Delete contact" name="dContact" /><input type="submit" value="Update contact" name="uContact" />


</fieldset>

<fieldset id="tableIC"><legend>Table details</legend>
<?php $person->printTable(); ?>
</fieldset>

</form>

<?php
	
if (isset($_POST['saveIt']))
{
	$person->addRegister($_POST['iName'], $_POST['iAddress'],$_POST['iNumber'],$_POST['iExtraNum']);	
}
else if (isset($_POST['dContact']))
{
	$person->deleteRegister();
}
else if (isset($_POST['uContact']))
{
	$person->updateRegister();
}
else if (isset($_POST['deleteOne']))
{
	$person->deleteContact($_POST['chCont']);
}
else if (isset($_POST['updateOne']))
{
	$person->updateContact($_POST['chOne'],$_POST['nName'], $_POST['nAddress'],$_POST['nNumber'],$_POST['nExtraNum']);
}

?>

</body>

</html>