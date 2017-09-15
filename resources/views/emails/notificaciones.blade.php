<!DOCTYPE html>
<html style="margin: 0; padding: 0;">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <meta name="robots" content="noindex,nofollow">
  </head>
  <?php
    $style = [
      /* Layout ------------------------------ */
      'body' => 'margin: 0; padding: 0; width: 100%; background-color: #FFF;',
      'email-wrapper' => 'border-collapse: collapse; table-layout: fixed; min-width: 320px; width: 100%; background-color: #fff;',

      /* Header ----------------------- */
      'email-header' => 'margin: 0 auto; max-width: 600px; width: calc(28000% - 167400px);',
      'email-logo' => 'margin: 0px 20px 20px;',
      'email-img' => 'display: block; max-width: 300px;',

      /* Title ----------------------- */
      'email-titulo-wrapper' => 'background-color: #8fbf5c;',
      'email-titulo' => 'vertical-align: middle; font-family: avenir,sans-serif; font-size: 17px; line-height: 50px; text-align: center; color: #FFF;',

      /* Body ------------------------------ */
      'email-body-wrap' => 'margin: 0 auto; max-width: 600px; width: calc(28000% - 167400px); overflow-wrap: break-word; word-wrap: break-word; word-break: break-word;',
      'email-white-space' => 'line-height: 20px; font-size: 20px;',
      'email-body-line' => 'margin: 0 20px 12px; font-size: 13px; line-height: 21px; color: #4f4f4f; font-family: sans-serif;',
      'text-center' => 'text-align: center;',
      'body-href' => 'text-decoration: underline; color:#075aad',
      'body-header' => 'margin: 0 20px 12px; font-size: 15px; line-height: 24px; color: #4f4f4f; font-family: sans-serif;',
      'body-line' => 'margin: 0 20px 12px; font-size: 13px; line-height: 21px; color: #4f4f4f; font-family: sans-serif;',
      'button' => 'display: inline-block; width: 200px; min-height: 45px; background-color: #3869D4; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 45px; text-align: center; text-decoration: none; -webkit-text-size-adjust: none;',

      /* Footer ------------------------------ */
      'email-footer' => 'margin: 0 20px 12px; font-family: sans-serif; font-size: 12px; line-height: 19px; color: #8e959c;',
      'email-footer-href' => 'text-decoration: underline; color: #18527c;'
    ];
  ?>
  <body style="{{ $style['body'] }}">
    <table style="{{ $style['email-wrapper'] }}" width="100%" cellpadding="0" cellspacing="0">
      <tbody>
        <tr>
          <td>
            <!-- Logo -->
            <div style="{{ $style['email-header'] }}">
              <div style="{{ $style['email-logo'] }}">
                <img style="{{ $style['email-img'] }}" src="{{ url('/images/bellezaexpress.jpg') }}"/>
              </div>
            </div>
            <!-- Titulo -->
            <div style="{{ $style['email-titulo-wrapper'] }}">
              <p style="{{ $style['email-body-wrap'].' '.$style['email-titulo'] }}">
                <strong>{{ $titulo }}</strong>
              </p>
            </div>
            <div style="{{ $style['email-white-space'] }}">&nbsp;</div>
            <div style="{{ $style['email-white-space'] }}">&nbsp;</div>

            <!-- Body -->
            <div style="{{ $style['email-body-wrap'] }}">
              @yield('content')
            </div>
            <div style="{{ $style['email-white-space'] }}">&nbsp;</div>
            <div style="{{ $style['email-body-wrap'] }}">
              <p style="{{ $style['email-body-line'] }} {{ $style['text-center'] }}">
                <a href="http://www.bellezaexpress.com/aplicativos" style="{{ $style['button'] }}" target="_blank">
                  Realizar
                </a>
              </p>
            </div>
            <div style="{{ $style['email-white-space'] }}">&nbsp;</div>

            <!-- Footer -->
            <div style="{{ $style['email-body-wrap'] }}">
              <p style="{{ $style['email-footer'] }}">Cualquier inquietud con el aplicativo comuníquese con el departamento de tecnología (ext. 123 ó 109 Cali) o escríbanos a <a style="{{ $style['email-footer-href'] }}" href="mailto:sistemas@bellezaexpress.com">sistemas@bellezaexpress.com</a></p>
            </div>
            <div style="{{ $style['email-white-space'] }}">&nbsp;</div>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>
