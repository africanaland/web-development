<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$title or "Laravel Admin Panel"}}</title>
</head>
<body  class="app">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="left" valign="top">
        <table width="557" border="0" cellpadding="0" cellspacing="0" style="background: none repeat scroll 0 0 #FFFFFF;border: 2px solid #B5BCC1; border-top:9px solid #B5BCC1;">
            <tr >
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr >
                <td colspan="2">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                        <tr>
                            <td  style="float:left; padding:13px 0 0 10px; font-size:14px; color:#333; font-family:helvetica, arial; line-height:18px;">{!! $body !!}</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td align="left" style=""></td>
                <td align="right" valign="top" width="108" >&nbsp;</td>
            </tr>

            <tr>
                <td colspan="2" align="center">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="2">&nbsp; </td>
            </tr>

        </table></td>
    </tr>
</table>
</body>
</html>