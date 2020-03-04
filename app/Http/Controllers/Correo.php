<?php

namespace App\Http\Controllers;

use App;

use Illuminate\Http\Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PhpMailer/Exception.php';
require 'PhpMailer/PHPMailer.php';
require 'PhpMailer/SMTP.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Cart;


class Correo extends Controller
{
    public function enviar($receptor, $asunto, $body, $pdf = "")
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                      // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'GameShopIesLaMarisma@gmail.com';                     // SMTP username
            $mail->Password   = 'marisma135';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('GameShopIesLaMarisma@gmail.com', 'Juanma');
            $mail->addAddress($receptor);               // Name is optional

            // // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = $body;
            if ($pdf != "") {
                $mail->AddStringAttachment($pdf, 'factura.pdf', 'base64', 'application/pdf');
            }



            $mail->send();
            echo 'Mesaje enviado correctamente.';
        } catch (Exception $e) {
            echo "El mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function correoCustom(Request $request)
    {
        $this->enviar($request->get('receptor'), $request->get('asunto'), $request->get('body'));
        return back();
    }

    public function correoPrueba()
    {
        $this->enviar(
            'juanmamp1998@gmail.com',
            'Este es un mensaje de prueba',
            'Cuerpo del mensaje de prueba :)'
        );
        return back();
    }

    public function recuperarContrasena(Request $form)
    {
        if (DB::table('lv_usuarios')->where('email', $form->email)->exists()) {
            $usuario = DB::table('lv_usuarios')->where('email', '=', $form->email)->get();
            foreach ($usuario as $dato) {

                $this->enviar(
                    $form->email,
                    'Recuperacion de cuenta',
                    'Su nombre de usuario es: ' . $dato->usuario . PHP_EOL . "\n<br>Su contraseña es: " . Crypt::decrypt($dato->contrasena) . "<br>Tenga mas cuidado la proxima vez :)"
                );
                return back();
            }
        } else {
            return back()->with('noCorreo', 'El correo no se ha encontrado');;
        }
    }
    public function enviarFactura(Request $form)
    {
        if (DB::table('lv_usuarios')->where('email', $form->email)->exists()) {
            $usuario = DB::table('lv_usuarios')->where('email', '=', $form->email)->get();
            foreach ($usuario as $dato) {

                $this->enviar(
                    $form->email,
                    'Recuperacion de cuenta',
                    'Su nombre de usuario es: ' . $dato->usuario . PHP_EOL . "\n<br>Su contraseña es: " . Crypt::decrypt($dato->contrasena) . "<br>Tenga mas cuidado la proxima vez :)"
                );
                return back();
            }
        } else {
            return back()->with('noCorreo', 'El correo no se ha encontrado');;
        }
    }


    public function realizarCompra(Request $form)
    {
        $form->validate([
            'provincia' => 'required',
            'direccion' => 'required'
        ]);
        $carrito = Cart::getContent();
        $fecha = date("y/m/d");
        $cod = rand(10000000, 99999999);
        if (DB::table('lv_facturas')->where('cod', $cod)->exists() == 1) {
            //generara numeros hasta que no coincida
            $cod = rand(10000000, 99999999);
        }
        //Parametros para el pdf
        $data = [
            'carrito' => $carrito,
            'provincia' => $form->provincia,
            'direccion' => $form->direccion,
            'fecha' => $fecha,
            'cod' => $cod
        ];
        //crear el pdf
        $pdf = \PDF::loadView('pdf_Factura', $data);

        //Creamos el mensaje que enviaremos por correo
        $mensaje = 'Hola<br>Su pedido se ha realizado correctamente<br>Aqui puede revisar su compra<br>';
        foreach ($carrito as $producto) {
            $mensaje .= $producto->name . '-->' . $producto->quantity . '-->' . ($producto->price * $producto->quantity) . "<br>";
        }
        $mensaje .= 'Total: ' . Cart::getTotal() . '<br>';
        $mensaje .= 'Codigo: cod-' . $cod . '<br>Fecha:' . $fecha;
        //Creamos el correo
        foreach (session('usuario') as $dato) {
            $this->enviar(
                $dato->email,
                'Su pedido',
                $mensaje
            );
        }
        //Guardar en la base de datos

        foreach ($carrito as $producto) {
            $factura = new App\Factura;

            $factura->cod = $cod;
            $factura->fecha = $fecha;

            $factura->provincia = $form->provincia;
            $factura->direccion = $form->direccion;

            foreach (session('usuario') as $dato) {
                $factura->nombre = $dato->nombre;
                $factura->apellidos = $dato->apellidos;
                $factura->dni = $dato->dni;
                $factura->telefono = $dato->telefono;
                $factura->email = $dato->email;
                $factura->usuario = $dato->usuario;
            }

            $factura->nom_producto = $producto->name;
            $factura->cant_producto = $producto->quantity;
            $factura->precio_producto = $producto->price;
            $factura->total = $producto->price * $producto->quantity;
            $factura->save();
        }
        Cart::clear();

        return $pdf->download('archivo.pdf');
        return redirect()->route('inicio',3);

        return back();
    }
}
