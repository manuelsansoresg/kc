<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud descuento SOD - Firma App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        
        h1, h2, h3, h4 {
            color: #333;
        }
        ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        p {
            margin: 10px 0;
        }
        .section-title {
            font-weight: bold;
            margin-top: 20px;
        }

        body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .content {
      flex: 1;
    }

    footer {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      background-color: #f8f9fa;
      border-top: 1px solid #dee2e6;
      padding: 10px 0px;
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
    }

    footer button {
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
    }

    

    </style>
</head>
<body>
    <h1>KC - Solicitud descuento SOD</h1>
    <h2>Autorización de Salario Bajo Demanda</h2>

    <h3>Información del Receptor</h3>
    <table>
        <tr>
            <th>Campo</th>
            <th>Detalle</th>
        </tr>
        <tr>
            <td>Nombre del receptor</td>
            <td>{Apellido paterno} {Apellido materno} {primer nombre} {segundo nombre}</td>
        </tr>
        <tr>
            <td>RFC</td>
            <td></td>
        </tr>
        <tr>
            <td>Banco donde reside la cuenta del receptor</td>
            <td>{Banco cliente}</td>
        </tr>
        <tr>
            <td>Número de CLABE de cuenta bancaria del receptor</td>
            <td>{CLABE}</td>
        </tr>
    </table>

    <h3>Información del Salario Bajo Demanda</h3>
    <table>
        <tr>
            <th>Campo</th>
            <th>Detalle</th>
        </tr>
        <tr>
            <td>Folio</td>
            <td>{Folio}</td>
        </tr>
        <tr>
            <td>Fecha</td>
            <td>{Fecha actual}</td>
        </tr>
        <tr>
            <td>Monto Retirado</td>
            <td>${Capital}</td>
        </tr>
        <tr>
            <td>Comisión</td>
            <td>${Comisión apertura}</td>
        </tr>
        <tr>
            <td>Monto total a pagar</td>
            <td>${Total}</td>
        </tr>
        <tr>
            <td>Número de pagos parciales</td>
            <td>{Plazo}</td>
        </tr>
        <tr>
            <td>Fecha de pago</td>
            <td>{Fecha pago}</td>
        </tr>
        <tr>
            <td>Tasa de interés fija anual</td>
            <td>{tasa} %</td>
        </tr>
        <tr>
            <td>Costo anual total</td>
            <td>Todos los montos incluyen IVA</td>
        </tr>
    </table>

    <h3>Consulta de saldo:</h3>
    <ul>
        <li>Consulta de saldo a través de internet: <a href="http://www.kaaxclub.com">www.kaaxclub.com</a></li>
    </ul>

    <h3>Aclaraciones y reclamaciones:</h3>
    <ul>
        <li>Unidad Especializada de Atención a Usuarios de "KAAXCLUB": <a href="http://www.kaaxclub.com">www.kaaxclub.com</a></li>
    </ul>

    <h3>Aceptación:</h3>
    <p>El Receptor reconoce que la recepción de la transferencia a la cuenta especificada en este documento se considerará como:</p>
    <ol>
        <li>La disposición del Monto Retirado y, por ende, su recepción por parte del Receptor.</li>
        <li>La entrega del Monto Retirado a cargo de YALKU SERVICIOS SAPI DE CV y a favor del Receptor.</li>
        <li>La disposición del Monto Retirado se considerará como el cumplimiento por parte de YALKU SERVICIOS SAPI DE CV, en lo que respecta, de las obligaciones que le corresponden a la empresa y a favor del Receptor, según lo estipulado en el Contrato previamente firmado.</li>
    </ol>
    <p>El Receptor reconoce que al dar clic en el recuadro de aceptación otorgará su conformidad al presente documento, de conformidad con lo establecido en:</p>
    <ul>
        <li>Artículo 1803 del Código Civil</li>
        <li>Artículo 210-A del Código Federal de Procedimientos Civiles</li>
        <li>Artículos 80, 93, 96 y 97 del Código de Comercio</li>
    </ul>
    <p>Además, que cumple con la Norma Oficial Mexicana, NOM-151, sobre la conservación de mensajes de datos y digitalización de documentos, reconocimiento IP, token, autenticación y certificado digital con encriptación AES-256.</p>
    <p>En caso de no aceptar en forma absoluta y completa los términos y condiciones de las Actividades, el Acreditado deberá abstenerse de dar clic en el recuadro de aceptación.</p>

    <h2>Carta Instrucción Irrevocable:</h2>
    <p><strong>{FECHA HOY}</strong></p>
    <table>
        <tr>
            <th>Campo</th>
            <th>Detalle</th>
        </tr>
        <tr>
            <td>Empresa</td>
            <td>{EMPRESA}</td>
        </tr>
        <tr>
            <td>Trabajador</td>
            <td>{ACREDITADO}</td>
        </tr>
        <tr>
            <td>RFC del Trabajador</td>
            <td>{RFC ACREDITADO}</td>
        </tr>
        <tr>
            <td>Fecha del Contrato de Crédito Simple</td>
            <td>{FECHA DE CONTRATO CRÉDITO SIMPLE}</td>
        </tr>
        <tr>
            <td>Folio del Contrato</td>
            <td>{FOLIO DEL CONTRATO}</td>
        </tr>
        <tr>
            <td>Monto Total del Crédito</td>
            <td>${TOTAL DE CRÉDITO}</td>
        </tr>
        <tr>
            <td>Número de Pagos</td>
            <td>{NÚMERO DE PAGOS}</td>
        </tr>
        <tr>
            <td>Monto Total</td>
            <td>${TOTAL}</td>
        </tr>
    </table>

    <h3>Autorizaciones del Trabajador:</h3>
    <ol>
        <li>
            Manifiesto mi voluntad para que se me realice la retención nominal automática del sueldo que recibo...
        </li>
        <li>
            Que a mi nombre y representación le sean depositadas y/o entregadas a YALKU SERVICIOS, SAPI DE CV...
        </li>
        <li>
            En caso de terminación de la relación laboral, cualquiera que sea el motivo y forma, autorizo...
        </li>
    </ol>

    <p>
        El suscrito reconoce que al dar clic en el recuadro de aceptación otorgará su conformidad al presente
        documento, de conformidad con lo establecido en:
    </p>
    <ul>
        <li>Artículo 1803 del Código Civil</li>
        <li>Artículo 210-A del Código Federal de Procedimientos Civiles</li>
        <li>Artículos 80, 93, 96 y 97 del Código de Comercio</li>
    </ul>
    <p>
        Además, que cumple con la Norma Oficial Mexicana, NOM-151, sobre la conservación de mensajes de datos y
        digitalización de documentos, reconocimiento IP, token, autenticación y certificado digital con encriptación
        AES-256.
    </p>
    @if ($isFirma === true && $token == null)
        <footer>
            <a  href="/client/sod/{{ $credit->id}}/2/exit" class="btn btn-outline-danger">Cancelar</a>
            <a href="/client/sod/{{ $credit->id}}/firmar" class="btn btn-outline-primary">Aceptar</a>
        </footer>
    @endif
    
    @if ($token != null && $isFirma === false)
    <footer>
        Firma: {{ $firma}}
        La IP es: {{ $ip}}
        Fecha: {{ $dateTime }}
        Hostname: {{ $hostname}}
    </footer>
    @endif
</body>
</html>
