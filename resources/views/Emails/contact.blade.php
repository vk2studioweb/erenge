<html>

<head>
    <title>Contato</title>
    <meta name="robots" content="noindex,nofollow" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
</head>

<body>
    <table cellpadding="0" cellspacing="0" align="center" bgcolor="#f1f1f1" leftmargin="0" border="0" topmargin="0"
        marginwidth="0" marginheight="0"
        style="background-color:#f1f1f1; font-family: 'Helvetica', Arial; -webkit-font-smoothing:antialiased;"
        width="100%">
        <tr height="45">
            <td></td>
        </tr>
        <tr>
            <td>
                <table cellpadding="0" cellspacing="0" align="center" bgcolor="#fff" leftmargin="0" border="0"
                    topmargin="0" marginwidth="0" marginheight="0"
                    style="background-color:#fff; font-family: 'Helvetica', Arial; -webkit-font-smoothing:antialiased;"width="600">
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" align="center" bgcolor="#fff" leftmargin="0"
                                border="0" topmargin="0" marginwidth="0" marginheight="0"
                                style="background-color:#fff; font-family: 'Helvetica', Arial; -webkit-font-smoothing:antialiased;"
                                width="580">
                                <tr height="110">
                                    <td style="text-align: center;">
                                        <img src="{{ url('/images/logo.png') }}" alt="Logo Giovelli" width="400">
                                    </td>
                                </tr>
                                <tr height="25">
                                    <td>
                                        <hr style="color: #ff5e14;display: block;border: 1px inset;margin: 0;padding: 0;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span width="580" style="width: 580px; line-height:auto; font-size:0 background-color:#df5a37; font-size: 24px; font-family: Arial; color: #474747; margin: 0 auto; display: block; font-weight: bold;">
                                            Ol&aacute;, nova mensagem pelo site
                                        </span>
                                    </td>
                                </tr>
                                <tr height="25">
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span width="580"
                                            style="width: 580px; line-height:auto; font-size:0 background-color:#df5a37; font-size: 14px; font-family: Arial; color: #474747; margin: 0 auto; display: block;">
                                            Voc&ecirc; recebeu uma mensagem atraves do site do senhor(a)
                                            <strong>{{ $name ?? null }}</strong>, abaixo todas as
                                            informa&ccedil;&otilde;es encaminhadas por ele(a).
                                        </span>
                                    </td>
                                </tr>
                                <tr height="20">
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span width="580" style="width: 580px; line-height:auto; font-size:0 background-color:#df5a37; font-size: 16px; font-family: Arial; color: #474747; margin: 0 auto; display: block;">
                                            Mensagem: {{ $description ?? '' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr height="30">
                                    <td>
                                        <hr style="color: #ff5e14;display: block;border: 1px inset;margin: 0;padding: 0;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>
                                                    <span width="280" style="width: 280px; line-height:auto; font-size:0 background-color:#df5a37; font-size: 14px; font-family: Arial; color: #474747; margin: 0 0 0 20px; display: block;">
                                                        <strong>Nome: </strong> {{ $name ?? null }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span width="280" style="width: 280px; line-height:auto; font-size:0 background-color:#df5a37; font-size: 14px; font-family: Arial; color: #474747; margin: 0 0 0 20px; display: block;">
                                                        <strong>Telefone: </strong> {{ $phone ?? null }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span width="280" style="width: 280px; line-height:auto; font-size:0 background-color:#df5a37; font-size: 14px; font-family: Arial; color: #474747; margin: 0 0 0 20px; display: block;">
                                                        <strong>E-mail: </strong> {{ $mail ?? null }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span width="280" style="width: 280px; line-height:auto; font-size:0 background-color:#df5a37; font-size: 14px; font-family: Arial; color: #474747; margin: 0 0 0 20px; display: block;">
                                                        <strong>Company: </strong> {{ $company ?? null }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span width="280" style="width: 280px; line-height:auto; font-size:0 background-color:#df5a37; font-size: 14px; font-family: Arial; color: #474747; margin: 0 0 0 20px; display: block;">
                                                        <strong>Assunto: </strong> {{ $assunto ?? null }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr height="45">
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr height="15">
            <td></td>
        </tr>
        <tr align="center">
            <td align="center">
                <span width="580" align="center"
                    style="width: 580px; line-height:auto; font-size:0 background-color:#df5a37; font-size: 10px; font-family: Arial; color: #474747; margin: 0 auto; display: block; text-align: center;">Sementes Giovelli
                    - Sistema de Comunicação Automática</span>
            </td>
        </tr>
        <tr height="35">
            <td></td>
        </tr>
    </table>
</body>

</html>
