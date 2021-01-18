<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Barryvdh\DomPDF\Facade as PDF;

class EnviarEmail extends Model
{
    use HasFactory;

    function enviar($resul)
    {
        $infor = json_decode($resul);

        $html = '';
        $i = 0;
        foreach ($infor->eventos as $en) {
          
            if (count($en->subStatus) != 0) {
                $loc = str_replace("CTE", "Unidade de Tratamento", $en->subStatus[0]);

                $loc = str_replace("CDD", "Unidade de Distribuição", $loc);
                $loc = str_replace("AGF NBE", "Agência dos Correios", $loc);
                $loc = str_replace("Origem:", "de", $loc);
                $loc = str_replace("Destino:", "para", $loc);

                if (count($en->subStatus) == 2) {
                    $loc2 = str_replace("CTE", "Unidade de Tratamento", $en->subStatus[1]);
                    $loc2 = str_replace("CDD", "Unidade de Distribuição", $loc2);
                    $loc2 = str_replace("AGF NBE", "Agência dos Correios", $loc2);
                    $loc2 = str_replace("Origem:", "de", $loc2);
                    $loc2 = str_replace("Destino:", "para", $loc2);
                    $destino = "<br>" . $loc2;
                } else {
                    $destino = '';
                }
            }else{
                $loc = '';
                $destino = '';

            }

            if ($i == 0) {
                if ($en->status == "Objeto entregue ao destinatário") {
                    $ti = "<span style='color:blue; font-size:22px;'>Encomenda entregue!</span><br/><br/>";

                    $var_ti = "Sua encomenda ja foi entregue!";
                } else {
                    $ti = "<span style='color:blue; font-size:22px;'>Objeto em Tránsito!</span><br/><br/>";

                    $var_ti = "Sua encomenda está a caminho!";
                }
            } else {
                $ti = "";
            }

            $html .= $ti . '<table class="listEvent sro" style="width: 100%; border-top: 1px dotted #cccccc;"><tbody><tr><td class="sroDtEvent top" valign="top" style=" width: 20% !important;">' . $en->data . '<br>' . $en->hora . '<br><label style="text-transform:capitalize;">' . $en->local . '</label></td><td style=" width: 80% !important;" class="sroLbEvent"><strong>' . $en->status . '</strong><br>' . $loc . ' ' . $destino . '</td></tr></tbody> </table>';

            $i++;
        }

        $dados = "<br><br><span style='font-weight: bold;'>Dados do cliente</span><br/>";
        $dados .= "<span style='font-weight: bold;'>Nome:</span> William Gois<br/>";
        $dados .= "<span style='font-weight: bold;'>Tel:</span>62 98553-2945<br/>";

        $html .= $dados;

        $da['dados'] = $html;

        PDF::loadView('layouts.pdf', $da)->save('temp/rastreio_encomenda.pdf')->stream('download.pdf');


        $mail = new PHPMailer(false);
        try {
            $mail->CharSet = 'UTF-8';
            //Server settings
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'elastic.backend@gmail.com';                     // SMTP username
            $mail->Password   = 'teste@123';                               // SMTP password
            $mail->SMTPSecure = 'tsl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('joao.macedo@elastic.fit', 'william');
            $mail->addAddress('joao.macedo@elastic.fit', 'william');
            // $mail->FromName = ;

            // // Attachments
            $mail->addAttachment('temp/rastreio_encomenda.pdf');         // Add attachments

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $var_ti;
            $mail->Body    = $html;

            $mail->send();
        } catch (Exception $e) {
        }
    }
}
