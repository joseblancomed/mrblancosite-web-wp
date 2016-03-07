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
			$tbl = mysqli_query($this->connection,"create table if not exists contactPeople(id int auto_increment, name varchar(70), address varchar(70), telephone varchar(70), primary key(id));");
			if(!($tbl))
				echo "<script language='JavaScript'>alert('Table no created');</script>";
		}
		else
			echo "<script language='JavaScript'>alert('Database no created');</script>";
		
	}

	// When you have the class created, you should start to program the functions

	function addRegister($fullName,$fullAddress,$numTele)
	{
		$this->connection = mysqli_connect("localhost","root","","contactNote");
		//echo $this->connection;
		if (($fullName=="") && ($numTele=="" || $fullAddress==""))
			echo "<script language='JavaScript'>alert('The field telephone or address are mandatory');</script>";
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
	
	function readRegisters()
	{
		echo "<form action='#' method='POST'><select name='chooseId'>";
		$this->connection = mysqli_connect("localhost","root","","contactNote");
		//echo $this->connection;
		$eachReg = mysqli_query($this->connection, "select id,name,address,telephone from contactPeople;");
		$eachRegTab = mysqli_query($this->connection, "select id,name,address,telephone from contactPeople;");
		
		if (mysqli_num_rows($eachReg)>0)
		{
			while ($item = mysqli_fetch_array($eachReg,MYSQL_BOTH))
				echo "<option value=".$item['id'].">".$item['name']." > ".$item['telephone']." > ".$item['address']."</option>";
			echo "<input type='submit' value='Delete' name='deleteIt' /></select></form>";
			
			echo "<table border=2><tr><td>Name</td><td>Address</td><td>Telephone</td></tr>";
			while ($regSaved = mysqli_fetch_array($eachRegTab,MYSQL_BOTH))
				echo "<tr><td>".$regSaved['name']."</td><td>".$regSaved['address']."</td><td>".$regSaved['telephone']."</td></tr>";
			echo "</table>";
		}
		else
			echo "<option>The contactBook is empty</option></select>";
		
		
	}
	
	function deleteRegister($id)
	{
		$this->connection = mysqli_connect("localhost","root","","contactNote");
		/*echo $this->connection;
		echo "<script language='JavaScript'>alert('".$id."');</script>";*/
		$delReg = mysqli_query($this->connection, "delete from contactPeople where id=".$id.";");
		if (!($delReg))
			echo "<script language='JavaScript'>alert('Had an issue deleting the contact');</script>";
		readRegisters();
	}
	
		
	function __destruct()
	{
	}
};

?>