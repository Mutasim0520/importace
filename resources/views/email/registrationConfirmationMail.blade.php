<!DOCTYPE>
<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Importacebd.com</title>
</head>
<body>
<div class="container" style="margin-left: 50px; margin-right: 50px; padding: 5px;">
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">
            <div class="panel-default" style="background-color: ghostwhite;">
                <div class="panel-heading panel-blue" style="background-color:#01b2d2 ;padding: 20px; font-size: 30px; text-align: center;">
                    Importacebd.com
                </div>
                <div class="panel-body" style="padding: 10px;">
                    <h2>Hello {{$user->name}}</h2>
                    <p style="text-align: justify; font-size: 13px;">
                        Please confirm your account in the link below
                    </p>
                    <div style="text-align: center;">
                        <a href="http://importacebd.com/activate/{{($user->id)}}" style="padding: 10px;background-color: #00A6C7;text-decoration: none;color: white; font-size: 20px; ">Confirm Account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</table>
</body>
