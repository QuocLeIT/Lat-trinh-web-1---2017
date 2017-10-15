<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
	$number1 = $_POST['number1'];
	$number2 = $_POST['number2'];
	
	if($number1=="" || $number2)
	{
		$err="nhập đủ thông tin";
		$kt=false;
	}
	
	else if(!is_numeric($$number1) || !is_numeric($$number2))
	{
		$err="Số nhập vào không phải là sô";
		$kt=false;
	}
	
	$operator = $_GET['operator'];
	$operator = $number1 + $number2;
	echo "Bạn đã gửi lên hai số $number1 và $number2 với $operator";
?>
</body>

</html>