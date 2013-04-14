<?php
  /*Validacion de formulario en tiempo real.
    Hecho por Luis A. Canales.
    cosaslac@gmail.com*/

/*Verifica si el recapcha fue introducido correctamenten*/
   if (isset($_POST['enviar']))
{
        /*Guarda los valores en cookies en caso de error
      Generar una cookie por cada elemento utilizando post*/
        setcookie('dirweb',$_POST['web'],time()+600);
        setcookie('nombre', $_POST['nombre'],time()+600);
        setcookie('email', $_POST['email'],time()+600);
        setcookie('telefono', $_POST['telefono'],time()+600);
        setcookie('Country', $_POST['select'],time()+600);
        setcookie('consulta', $_POST['consulta'],time()+600);
        require_once('recaptchalib.php');
        $privatekey = "6Lf-d98SAAAAAKfKyxNqyuguui3AgvWiaWmPt0AN";
        $resp = recaptcha_check_answer ($privatekey,
                                      $_SERVER["REMOTE_ADDR"],
                                      $_POST["recaptcha_challenge_field"],
                                      $_POST["recaptcha_response_field"]);
//si no se introdujo bien el recapcha manda un error
        if (!$resp->is_valid) {
          echo "<SCRIPT>window.location='formulario.php?error=e';</SCRIPT>";
        } else {
         //si se hiso bien se envia un mensaje y se envia el formulario.
          echo "<script>alert('Su consulta fue enviada correctamente');</script>";
           echo "<SCRIPT>window.location='formulario.php?enC=si';</SCRIPT>";
        }
  }

   include('paises.php');
   $paises = new Paises;
   include('correo.php');
   if (isset($_GET['error'])) {
                  echo "<script>alert('Error al introducir captcha');</script>";
            }

?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
	<title>Formulario</title>
	<style type="text/css">
            *
            {
               padding: 0;
               margin: 0;
               font-size: 17px;
            }
            body 
            {
               height: 750px;
               width: 950px;
            }
            label
            {
               margin-bottom: 5px;
               margin-top: 5px;
            }
            p
            {
               display: block;
               margin-top:5px;
            }
            #formu
            {
               background-color: #f7f7f7;
               border-radius: 15px;
               height: 550px;
               margin: 25px auto;
               width: 450px;
            }
   </style>
      <script src="jquery-1.9.1.js"></script>
	 <script type="text/javascript">
    /*Script que muestra u oculta los errores...*/
    function mostOcul(element,span, msn)
{
    
    var id = "#"+span;
    /*verifica si el elemento enviado a verificar es el elemento*/
    if (element.type=="select-one" || element.type == "textarea") 
    {
      if (element.type == "textarea") {
         var val=document.form1.consulta.value;
         if(val == "" || val == " " || val.length < 17)
         {
            $(id).text(msn);
            document.getElementById(span).style.background='#FF80FF';
         }else
         {
            
            $(id).text('excelente');
            document.getElementById(span).style.background='#C6FFE2';
         }
      }
      if(element.type=="select-one" )
      {
         var val=$(".select").val();
         if ( val=="0") 
         {
            $(id).text(msn);
            document.getElementById(span).style.background='#FF80FF';
         }
         else
         {
            $(id).text('excelente');
               document.getElementById(span).style.background='#C6FFE2';
         }
      }
    }else
    {
      var mos=element.checkValidity();
      if (!mos)
      {
         $(id).text(msn);
         document.getElementById(span).style.background='#FF80FF';

      }else 
      {
         $(id).text('excelente');
         document.getElementById(span).style.background='#C6FFE2';
      }
      
    }
    
}
      /*Parte del Recaptchap, esto es para la apariencia, si se
      elimina no pasa nada en el funcionamiento solo en la apariencia.*/
            var RecaptchaOptions = {
                  theme : 'clean'
            };
 </script>
</head>
<body>
      <div id="formu" name="formu">
            <h3>Compos obligatorios *</h3>
            <form id="form1" name="form1" method="post" action="formulario.php">
      <p>
            <label>Web de su empresa</label></br>
            <input type="text" name="web" required id="web" <?php if (isset($_GET['error'])) {?>value="<?php echo $_COOKIE['dirweb'];}?>"title="www.tupagina.com"pattern="(https?://)?(www\.)?([a-zA-Z0-9_%]*)\b\.[a-z]{2,4}(\.[a-z]{2})?((/[a-zA-Z0-9_%]*)+)?(\.[a-z]*)?" oninput="mostOcul(this,'url','Introdusca una url valida: www.dominio.com');">
               <span id="url">*</span>
                  </p>
         <!--Para colocar un elemento nuevo: 1-Colocar el nuevo elemento dentro de la misma estructura
          de las etiquetas p, dentro de los input se colocan el requiered si es obligatorio
          a demas colocar la linea <?php /*if (isset($_GET['error'])) {?>value="<?php echo $_COOKIE['nombre'];}*/?>"
          quitando los comentarios /**/ de php y colocar el nombre de la cookie creada al pricipio de la pagina
          en pattern colocar una exprecion regular que evalue el campo requerido en oninput se coloca
          mostOcul que es el nombre de la funcion y dentro de los parentecis se envia como
          parametros requeridos (this, 'id del span','mensaje de error')-->
         <p>
            <label>Su nombre</label></br>
            <input type="text" required name="nombre" id="nombre" <?php if (isset($_GET['error'])) {?>value="<?php echo $_COOKIE['nombre'];}?>"Title="Mas de tres caracteres sin numeros" pattern="[A-Za-zñÑáÁéÉíÍóÓúÚ ]{4,30}" oninput="mostOcul(this, 'acnombre','Mas de tres caracteres sin numeros')">
               <span id="acnombre">*</span>
                  </p>
         <p>
            <label>Apellido</label></br>
            <input type="text" required name="apellido" id="apellido" <?php if (isset($_GET['error'])) {?>value="<?php echo $_COOKIE['apellido'];}?>"Title="Mas de tres caracteres sin numeros" pattern="[A-Za-zñÑáÁéÉíÍóÓúÚ ]{4,30}" oninput="mostOcul(this, 'acapelldio','Mas de tres caracteres sin numeros')">
               <span id="acapelldio">*</span>
                  </p>
         <p>
            <label>Email</label></br>
            <input type="email" required name="email" id="email" <?php if (isset($_GET['error'])) {?>value="<?php echo $_COOKIE['email'];}?>" oninput="mostOcul(this,'mail','Introdusca un correo valido: correo@dominio.com');">
                  <span id="mail">*</span>
         </p>
         <p>
            <label>Telefono</label></br>
            <input type="tel" required name="telefono" id="telefono" <?php if (isset($_GET['error'])) {?>value="<?php echo $_COOKIE['telefono'];}?>" pattern="\(\d\d\d\) \d\d\d\d\-\d\d\d\d" title="(xxx) xxxx-xxxx" oninput="mostOcul(this, 'phon','Introdusca un formato de telefono valido: (xxx) xxxx-xxxx');">
                  <span id="phon">*</span>
                  </p>
         <p>
            <label>Cual es su ubicación</label></br>
            <!--En el caso de los elementos select solo se le tiene que agregar dos cosas
            1-una clase select(class="select") y 2-en lugar de el ininput utilizar onblur y onchange-->
            <select name="select" class="select"size="1" OnChange="mostOcul(this, 'selection','Seleccione un pais');" onBlur="mostOcul(this,'selection','Seleccione un pais');"> 
                              <?php 
                                 $paises->imPaises(); 
                              ?> 
                        </select><span id="selection">*</span>
         </p>
         <p>
            <label>Numero comprobante</label></br>
            <input type="number" name="comprobante" id="comprobante" required <?php if (isset($_GET['error'])) {?>value="<?php echo $_COOKIE['comprobante'];}?>" oninput="mostOcul(this,'comp','Introdusca un numero');">
            <span id="comp">*</span>
         </p>
         <p>
            <label>Consulta</label></br>
            <textarea name="consulta" id="consulta"  required oninput="mostOcul(this,'textA','Tiene que tener mas de 17 caracteres');"><?php if (isset($_GET['error'])) { echo $_COOKIE['consulta'];}?></textarea>
                 <span id="textA">*</span>
                  </p>
          <?php
               require_once('recaptchalib.php');
               $publickey = "6Lf-d98SAAAAANomxs75EPtP8sMV2BcaeiB73HYr"; // Ver archivo Datos_reCaptcha o generar key en https://www.google.com/recaptcha/admin/create
               echo recaptcha_get_html($publickey);
         ?>
         <input type="submit" name="enviar" id="enviar" value="Enviar">
      
            </form>
      </div>
</body>
</html>
