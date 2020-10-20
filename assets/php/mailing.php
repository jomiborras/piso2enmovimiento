<?php 
    // use the phpmailer we installed via composer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $email = $_POST['email'];
    $username = substr(strip_tags($_POST['username']), 0, 255);
    $cel = substr(strip_tags($_POST['cel']), 0, 16384);

    $body = "Nuevo pedido de Clases Online<br>"."<br>Nombre: " . $username . "<br>Celular: " . $cel . "<br>Email: " . $email; 
    

    //Make sure the address they provided is valid before trying to use it
    if (array_key_exists('email', $_POST) and PHPMailer::validateAddress($_POST['email'])) {
        if (array_key_exists('attachment', $_FILES)) {
            $img_name = $_FILES['attachment']['name'];
            $upload = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['attachment']['name']));
            $uploadfile = $_SERVER['DOCUMENT_ROOT'].'/assets/images/mailing/'.$img_name;

            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadfile)) {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                // SMTPDebug turns on error display mssg 
                // $mail->SMTPDebug = 3;
                $mail->SMTPSecure = 'tls';
                $mail->Host = 'smtp.gmail.com';
                // set a port
                $mail->Port = 587;
                $mail->SMTPAuth = true;
                // set login detail for gmail account
                $mail->Username = '**********';
                $mail->Password = '**********';
                $mail->CharSet = 'utf-8';
                // set subject
                $mail->setFrom($email, $username);
                $mail->addAddress('**********');
                $mail->addReplyTo($email, $username);
                $mail->addAttachment($uploadfile, 'Comprobante de: '.$username);
                $mail->IsHTML(true);
                $mail->Subject = 'Clases Online: '.$username;
                $mail->Body = $body;
                if (!$mail->send()) {
                    echo '
                        <script>
                            alert("Hubo un error al intentar enviar el mensaje, intente nuevamente. Si el error persiste, es culpa del DEV, así que perdonalo y por favor, enviá todos tus datos con el comprobante a piso2clasesonline@gmail.com.");
                            window.location="https://piso2enmovimiento.com.ar/confirmation.html"
                        </script>
                    ';
                } else {
                    echo '
                        <script>
                            alert("Tus datos han sido enviados correctamente. Revisá el correo de confirmación, y pronto nos pondremos en contacto con vos para enviarte los links de las clases... Gracias!!");
                            window.location="https://piso2enmovimiento.com.ar/"
                        </script>
                    ';
                    $mail2 = new PHPMailer(true);
                    try {
                        //Server settings
                        $mail2->SMTPDebug = 0;
                        $mail2->isSMTP();
                        $mail2->Host = 'smtp.gmail.com';
                        $mail2->SMTPAuth = true;
                        $mail2->Username = '**********';
                        $mail2->Password = '**********';
                        $mail2->SMTPSecure = 'tls';
                        $mail2->Port = 587;

                        $mail2->setFrom('**********', 'Piso 2 en Movimiento');
                        $mail2->addAddress($email, $username);

                        $mail2->isHTML(true);
                        $mail2->Subject = 'Clases Online';
                        $mail2->Body    = 'Te damos la Bienvenida a los COMBOS DE CLASES REFUERZO.<br>Pronto te enviaremos los links de las clases que elegiste.<br>Gracias!!<br><br>Piso2enmovimiento.';
                        $mail2->send();

                    } catch (Exception $e) {
                         echo '
                            <script>
                                alert("Ha habido un error al enviarte la confirmación. Pero no te preocupes, tu mensaje ha sido recibido correctamente, y podés ponerte en contacto con piso2clasesonline@gmail.com. Gracias!!");
                                window.location="https://piso2enmovimiento.com.ar/"
                            </script>
                        ';
                        }

                }

            } else {
                echo '
                    <script>
                        alert("No se pudo mover al archivo, intentá nuevamente. Si el error persiste, es culpa del DEV, así que perdonalo y por favor, enviá todos tus datos con el comprobante a piso2clasesonline@gmail.com.");
                        window.location="https://piso2enmovimiento.com.ar/confirmation.html"
                    </script>
                ';
            }

        } else {
            echo '
                    <script>
                        alert("No se pudo acceder al archivo, intentá nuevamente. Si el error persiste, es culpa del DEV, así que perdonalo y por favor, enviá todos tus datos con el comprobante a piso2clasesonline@gmail.com.");
                        window.location="https://piso2enmovimiento.com.ar/confirmation.html"
                    </script>
                ';
        }
        
    } else {
        echo '
            <script>
                alert("El correo es inválido!! Intentá nuevamente con una dirección de correo correcta...  Si el error persiste, es culpa del DEV, así que perdonalo y por favor, enviá todos tus datos con el comprobante a piso2clasesonline@gmail.com.");
                window.location="https://piso2enmovimiento.com.ar/confirmation.html"
            </script>
        ';
    }


    // Respuesta de confirmación

    $mail2 = new PHPMailer(true);
try {
    //Server settings
    $mail2->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail2->isSMTP();                                      // Set mailer to use SMTP
    $mail2->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
    $mail2->SMTPAuth = true;                               // Enable SMTP authentication
    $mail2->Username = 'piso2clasesonline@gmail.com';      // SMTP username
    $mail2->Password = 'Jomi5051';                         // SMTP password
    $mail2->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail2->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail2->setFrom('piso2clasesonline@gmail.com', 'Piso 2 en Movimiento');
    $mail2->addAddress($correo, $nombre);     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail2->isHTML(true);                                  // Set email format to HTML
    $mail2->Subject = 'Clases Online';
    $mail2->Body    = 'Te damos la Bienvenida a los COMBOS DE CLASES REFUERZO.<br>Envianos adjunto tu comprobante de pago para mandarte los links de tus clases.<br><br>Piso2enmovimiento.';
   // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail2->send();
    
   
} catch (Exception $e) {
    echo 'Error al enviar la confirmación';
    echo 'Error en el Mailer: ' . $mail2->ErrorInfo;
}
?>
