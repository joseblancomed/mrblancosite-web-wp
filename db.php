<?php

class dbConnection
{
	//In this point depend of you if you want create the variable as public o private

	//private $connection = mysqli_connect("server_name","user","password","database_name");
	
	public $connection ="";
	
	function __construct()
	{
		$this->connection = mysqli_connect("localhost","root","");
		$cDb=mysqli_query($this->connection, "create database if not exists contactNote");
		
		if($cDb)
		{
			$this->connection = mysqli_connect("localhost","root","","contactNote");
			$tbl = mysqli_query($this->connection,"create table if not exists contactPeople(id int auto_increment, name varchar(70), address varchar(70), telephone varchar(15),other_number varchar(15), primary key(id));");
			if(!($tbl))
				echo "<script language='JavaScript'>alert('Table no created');</script>";
		}
		else
			echo "<script language='JavaScript'>alert('Database no created');</script>";
		
	}
	
	function addRegister($fullName,$fullAddress,$numTele,$otherNum=0)
	{
		$this->connection = mysqli_connect("localhost","root","","contactNote");
		//echo $this->connection;
		if (($fullName=="") && ($numTele=="" || $fullAddress==""))
			echo "<script language='JavaScript'>alert('The field telephone or address are mandatory, almost one of them');</script>";
		else
		{
			$regExists = mysqli_query($this->connection, "select id from contactPeople where name='".$fullName."' and telephone='".$numTele."' or address= '".$fullAddress."';");
			if (mysqli_num_rows($regExists)==0)
			{
				$reg = mysqli_query($this->connection, "insert into contactPeople (name, address, telephone) values (\"".$fullName."\",\"".$fullAddress."\",\"".$numTele."\");");
				if (!($reg))
					echo "<script language='JavaScript'>alert('Please check the connection\nor check the parameters');</script>";
				readRegisters();
			}
			else
				echo "<script language='JavaScript'>alert('The contact already exists in the database');</script>";
				
		}
		
	}

	function deleteRegister()
	{
		echo "<fieldset id='viewTable'>";
		
		$this->connection = mysqli_connect("localhost","root","","contactNote");
		$eachreg = mysqli_query($this->connection, "select id,name,address,telephone,other_number from contactpeople;");
		
		echo "<form action='#' method='post' id='viewform'>";

		echo "<br/><input type='hidden' name='chCont' id='chCont' readonly />";
		echo "<br/><br/>Choose the contact:<br/><select id='chooseid' onchange=\"document.getElementById('chCont').value = document.getElementById('chooseid').value\">";
		
		if (mysqli_num_rows($eachreg)>0)
		{
			echo "<option value='null'>-- choose one --</option>";
			while ($pos = mysqli_fetch_array($eachreg,MYSQLI_BOTH))
			{
				echo "<option value=".$pos['id'].">".$pos['name']."</option>";
			}
			
			echo "</select><input type='submit' value='Delete' name='deleteOne'/>";
			//alert(document.getElementById('chooseid').value)\" />";
		}
		else
			echo "<option>The contactnote is empty</option></select></div>";
		echo "</form></fieldset>";
	
	}
	
	function printTable()
	{
		$this->connection = mysqli_connect("localhost","root","","contactNote");
		//echo $this->connection;
		$eachRegTab = mysqli_query($this->connection, "select id,name,address,telephone,other_number from contactPeople;");
		
		if (mysqli_num_rows($eachRegTab)>0)
		{
			echo "<table border=0 width='100%'><tr><th>Name</th><th>Address</th><th>Telephone</th><th>Other number</th></tr>";
			while ($regSaved = mysqli_fetch_array($eachRegTab,MYSQLI_BOTH))
				echo "<tr><td>".$regSaved['name']."</td><td>".$regSaved['address']."</td><td>".$regSaved['telephone']."</td><td>".$regSaved['other_number']."</td></tr>";
			echo "</table>";
		}
		else
			echo "<option>The contactBook is empty, PLEASE MAKE FRIENDS</option></select>";
		
		//echo "<br/><br/><input type='button' value='Close table' onClick='closeView();' />";
	}

	function deleteContact($id)
	{
		//echo "<script language='JavaScript'>alert('".$id."');</script>";
		$this->connection = mysqli_connect("localhost","root","","contactNote");
		//echo $this->connection;
		//echo "<script language='JavaScript'>alert('".$id."');</script>";
		$delReg = mysqli_query($this->connection, "delete from contactPeople where id=".$id.";");
		if (!($delReg))
			echo "<script language='JavaScript'>alert('Had an issue deleting the contact');</script>";
	}
	
	function updateContact($id, $nName, $nAddress, $nPhone, $nExtraPhone)
	{	
		
		//echo "<script language='JavaScript'>alert('".$id." ' +  'Name: ".$nName." ' + 'Address: ".$nAddress." ' + 'New Phone: ".$nPhone." ' + ' - ".$nExtraPhone."');</script>";
		$this->connection = mysqli_connect("localhost","root","","contactNote");
		//echo $this->connection;
		//echo "<script language='JavaScript'>alert('".$id."');</script>";
		$updReg = mysqli_query($this->connection, "update contactPeople set name='".$nName."', address='".$nAddress."', telephone='".$nPhone."', other_number='".$nExtraPhone."' where id=".$id.";");
		if (!($updReg))
			echo "<script language='JavaScript'>alert('Had an issue updating the contact');</script>";
	}
	
	function updateRegister()
	{
		echo "<fieldset id='viewTable'>";
		
		$this->connection = mysqli_connect("localhost","root","","contactNote");
		$eachreg = mysqli_query($this->connection, "select id,name,address,telephone,other_number from contactpeople;");
		
		echo "<form action='#' method='post' id='viewform'>";

		echo "<br/><input type='hidden' name='chOne' id='chOne' readonly />";
		echo "<br/><br/>Choose the contact:<br/><select id='chooseCt' onchange=\"document.getElementById('chOne').value = document.getElementById('chooseCt').value\">";
		
		if (mysqli_num_rows($eachreg)>0)
		{
			echo "<option value='null'>-- choose one --</option>";
			while ($pos = mysqli_fetch_array($eachreg,MYSQLI_BOTH))
			{
				echo "<option value=".$pos['id'].">".$pos['name']."</option>";
			}
			
			echo "</select>
			Name:&nbsp; <input type='text' name='nName' maxlength='70' /><br/><br/>

			Address:&nbsp;<input type='text' name='nAddress' maxlength='70' /><br/><br/>

			Telephone:&nbsp;<input type='text' name='nNumber' maxlength='15' /><br/><br/>

			Add mobile:&nbsp;<input type='checkbox' id='pressIt' checked onClick='change()'/><br/><br/>

			<span id='eNum'>Other number:&nbsp;<input type='text' name='nExtraNum' maxlength='15' /></span>";
			//alert(document.getElementById('chooseid').value)\" />";
		}
		else
			echo "<option>The notebook is empty</option></select></fieldset>";
		echo "<input type='submit' value='Update' name='updateOne'/></form></fieldset>";
	}
		
	function __destruct()
	{
	}
};

?>