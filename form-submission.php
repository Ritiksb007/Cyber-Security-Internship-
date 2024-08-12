<?php
	error_reporting(0);
	if(!empty($_POST)) 
	{
		$num1 = $_POST['n1'];
		$num2 = $_POST['n2'];
		$add = $num1 + $num2;
	}
?>
<html>
	<head>
    	<title> FORM-SUBMISSION </title>
    </head>
<body>
<div align="center">
	<h2> MATHEMATICS </h2>
    <form method="post" action="">
    	Enter any number: <input type="number" name="n1"><br><br>
        Enter any number: <input type="number" name="n2"><br><br>
        <input type="submit" value="SEND" />
    </form>
    <br>
	<br>
	<h3>Addition : <?php echo $add;?></h3>
</div>
</body>
</html>