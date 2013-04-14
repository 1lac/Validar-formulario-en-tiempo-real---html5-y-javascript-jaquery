<?php
  	if (isset($_GET['enC']))
		{	
			if (isset($_COOKIE['dirweb'])) {
				$cont=$_COOKIE['Country'];
				$destinatario = "correoDel@destinatario.com"; 
				$asunto = "Consulta de:".$_COOKIE['nombre']; 
				$cuerpo = ' 
				<html> 
				<head> 
				   <title>'.$_POST['web'].'</title> 
				</head> 
				<body> 
				<p> 
					Web:'.$_COOKIE['dirweb'].'<br>
					Nombre: '.$_COOKIE['nombre'].'<br>
					Email: '.$_COOKIE['email'].'<br>
					Telefono: '.$_COOKIE['telefono'].'<br>
					Pais: '.$paises->imPaises($cont).'<br>
				</p>
				<p>Consulta:'.$_COOKIE['consulta'].'</p>
				</body> 
				</html> 
				'; 

				//para el envío en formato HTML 
				$headers = "MIME-Version: 1.0\r\n"; 
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

				//dirección del remitente 
				$headers .= "From: ".$_POST['nombre']." <CorreoDel@remitente.com>\r\n"; 

				//dirección de respuesta, si queremos que sea distinta que la del remitente 
				$headers .= "Reply-To: CorreoDel@remitente.com\r\n";

				mail($destinatario,$asunto,$cuerpo,$headers);
					echo "<script>alert('Consulta realizada con exito');</script>";
			}else{echo "<script>alert('Error al enviar formulario');</script>";}
		}	
	?>
