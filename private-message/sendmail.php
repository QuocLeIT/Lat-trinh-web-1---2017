<?php
	//goi thu vien
	
	require_once 'smtpmail/class.SMTP.php';
	require_once 'smtpmail/class.PHPMailer.php'; 
	$nFrom = "BTCN09";	//mail duoc gui tu dau, thuong de ten cong ty ban
	$mFrom = 'lebinh21071991@gmail.com';	//dia chi email cua ban 
	$mPass = '21071996';		//mat khau email cua ban
	$nTo = 'Binh';	//Ten nguoi nhan
	$mTo = 'quoc.le.2107@gmail.com';	//dia chi nhan mail
	$mail             = new PHPMailer();
	$body             = 'Click vào link sau để khôi phục mật khẩu: ';	// Noi dung email
	$title = 'KHOI PHUC MAT KHAU BTCN09';	//Tieu de gui mail
	$mail->IsSMTP();             
	$mail->CharSet  = "utf-8";
	$mail->SMTPDebug  = 0;	// enables SMTP debug information (for testing)
	$mail->SMTPAuth   = true;	// enable SMTP authentication
	$mail->SMTPSecure = "ssl"; 	// sets the prefix to the servier
	$mail->Host       = "smtp.gmail.com";	// sever gui mail.
	$mail->Port       = 465;			// cong gui mail de nguyen
	// xong phan cau hinh bat dau phan gui mail
	$mail->Username   = $mFrom;  // khai bao dia chi email
	$mail->Password   = $mPass;              // khai bao mat khau
	$mail->SetFrom($mFrom, $nFrom);
	$mail->AddReplyTo('lebinh21071991@gmail.com', 'Binh'); //khi nguoi dung phan hoi se duoc gui den email nay
	$mail->Subject    = $title;// tieu de email 
	$mail->MsgHTML($body);// noi dung chinh cua mail se nam o day.
	$mail->AddAddress($mTo, $nTo);
	// thuc thi lenh gui mail 
	if(!$mail->Send()) {
		echo 'Co loi!';
		
	} else {
		
		echo 'mail của bạn đã được gửi đi hãy kiếm tra hộp thư đến để xem kết quả. ';
	}
