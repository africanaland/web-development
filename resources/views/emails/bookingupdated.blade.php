<html style="width:100%;font-family: 'Poppins', sans-serif !important;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="telephone=no" name="format-detection">
  <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
  <title>{{ $title }}Thanks </title>

  <style type="text/css">
    .es-wrapper-color {
      width: 100%;
    }
  </style>
</head>

<body style="margin: 0px; background-color: #f5f5f5; color: #605c5b">
  <table style="background-image: url(http://africanaland.com/public/images/Shape21.png); background-repeat: no-repeat; background-size: cover;border-collapse:collapse; width:100%; min-height :26%;">
    <tr>

      <td valign="center" align="center" style="padding:0;margin:0px; ">
        <img src="http://africanaland.com/public/images/Vector-Smart-Object.png" alt="" style=" display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; margin: 60px;">
      </td>
    </tr>
    <tr style="border-collapse:collapse;">
      <td style="padding:0;margin:0px; ">
        <table style="max-width: 792px;width: 100%;margin: auto;background: #fff;  box-shadow: 0px 5px 10px -2px ;border-top-left-radius: 8px;border-top-right-radius: 8px;">
          <tbody>
            <td align="center" style=" margin:0px;padding-bottom:30px;padding-left:30px;padding-right:30px;padding-top:35px;">
              <p style="margin:0;line-height:58px;mso-line-height-rule:exactly;font-family: 'Poppins', sans-serif !important;font-size:38px;font-style:normal;font-weight:normal;color:#464646;">
                Dear <span style="color:#da8961;">{{$name}}, </span></p>
              <p style="margin:0px;  font-size:18px;font-family: 'Poppins', sans-serif !important;line-height:27px;">Your
                booking has been Updated successfully.</p>
              <p style="font-size: 22px;margin:0;line-height:58px;mso-line-height-rule:exactly;font-family: 'Poppins', sans-serif !important;font-style:normal;font-weight:normal;color:#464646;">
                Booking ID : <span style="color:#da8961;">{{$bookingId}} </span></p>
            </td>
          </tbody>
        </table>
      </td>
    </tr>
  </table>
  <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
    <tbody>

      <tr style="border-collapse:collapse;">
        <td style="padding:0;margin:0; ">
          <table style="max-width: 792px;width: 100%;margin: auto;background: #fff; box-shadow: 0px 5px 10px -2px ;">
            <tbody>
              <tr>

                <td align="center" style="margin:0;padding-bottom:5px;padding-left:30px;padding-right:30px;width:50%">
                  @if($img)
                  <img src="http://africanaland.com/public/uploads/{{$img}}" style="width: 100%; margin: 15px; margin-top:0px; ">
                  @else
                  <img src="http://africanaland.com/public/images/house.png" style="width: 100%; margin: 15px; margin-top:0px; ">
                  @endif

                </td>
                <td align="left" valign="top" style="margin:0;">


                  <table width="100%">
                    <tbody>
                      <tr>
                        <td>
                          <p style="margin-bottom: 0px;font-family: 'Poppins', sans-serif !important;  text-align: left; color:#da8961;font-size:24px; border-bottom: 1px solid #bababa;">
                            {{$propertyName}}</p>

                        </td>
                      </tr>
                      <tr>

                        <td>
                          <p style=" margin: 3px;font-family: 'Poppins', sans-serif !important; border-bottom: 1px solid #bababa;"> {{$address}} </p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p style="color:#da8961; margin: 3px;font-family: 'Poppins', sans-serif !important;">Check in :<span style="color: #000000;">
                              {{$checkin}}</span></p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p style="color:#da8961; margin: 3px; border-bottom: 1px solid #bababa;font-family: 'Poppins', sans-serif !important;">Check out :<span style="color: #000000;"> {{$checkout}}</span></p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <table style="width: 90%; ">
                    <tbody>
                      <tr>
                        <td>

                          <p style="color:#da8961; margin: 3px; float: left;font-family: 'Poppins', sans-serif !important;">Adult :<span style="color: #000000;">
                              NAN</span></p>

                        </td>

                        <td>
                          <p style="color:#da8961; margin: 3px; float: right;font-family: 'Poppins', sans-serif !important;">Children :<span style="color: #000000;">
                              NAN</span></p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p style="color:#da8961; margin: 3px; float: left;font-family: 'Poppins', sans-serif !important;">Rooms :<span style="color: #000000;">
                              NAN</span></p>
                        </td>
                        <td>
                          <p style="color:#da8961; margin: 3px; float: right; font-family: 'Poppins', sans-serif !important;">Type :<span style="color: #000000;">
                              NAN</span></p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  @if(!empty($service))
                  <table style="width: 90%;  border-top: 1px solid #bababa;">
                    <tbody>
                      <tr>
                        <td>
                          <p style="color:#da8961; margin: 3px; float: left;font-family: 'Poppins', sans-serif !important;">Additional Services </p>
                        </td>
                      </tr>
                      @foreach ($service as $item)
                      <tr>
                        <td>
                          <p style="font-family: 'Poppins', sans-serif !important; margin: 3px; float: left;">{{$item['name']}} @if($item['hrs'] != '') :
                            {{$item['hrs']}} Hours/Daily @endif</p>
                        </td>
                      </tr>
                      @endforeach

                    </tbody>
                  </table>
                  @endif

                </td>

              </tr>
              <!--
                <tr>
                    <p><span style="color:#da8961;font-size:24px; border-bottom: 1px solid #bababa;padding-bottom: 10px;">Total Price : 3200 $ </span></p>

                    <p style="font-size:24px; color: #464646;">Thanks</p>
                </tr> -->

            </tbody>
          </table>
        </td>
      </tr>
      <tr style="border-collapse:collapse;">
        <td style="padding:0;margin:0; ">
          <table style=" max-width: 792px;width: 100%;margin: auto;background: #fff; box-shadow: 0px 5px 10px -2px ;">
            <tbody>
              <td align="center" style="margin:0;padding-bottom:25px;padding-left:30px;padding-right:30px;padding-top:25px;  ">
                <p style="font-size: 20px;font-family: 'Poppins', sans-serif !important;"><span style="">Thanks for booking</span></p>
              </td>
            </tbody>
          </table>
        </td>
      </tr>
      <tr style="border-collapse:collapse;">
        <td style="padding:0;margin:0; ">
          <table style="background-color: #e4e4e4; max-width: 792px;width: 100%;margin: auto; box-shadow: 0px 5px 10px -2px ;">
            <tbody>
              <td align="center" style="margin:0;padding-bottom:25px;padding-left:30px;padding-right:30px;padding-top:25px;  ">
                <p style="    font-size: 16px; "><span style="font-family: 'Poppins', sans-serif !important;">You can view your booking and edit
                    detail by visiting </span></p>
                  <a href="{{ $url }}" style="padding: 10px 28px;background: #da8961;width: fit-content;font-family: 'Poppins', sans-serif !important;border-radius: 6px;color: #ffffff;text-decoration: none;margin-top: 1em !important;display: block;font-size: 13px;">Bookings</a>
              </td>
            </tbody>
          </table>
        </td>
      </tr>

      <tr style="border-collapse:collapse;">
        <td style="padding:0;margin:0; ">
          <table style="border-top: 1px solid #bababa; max-width: 792px;width: 100%;margin: auto;background: #fff; box-shadow: 0px 5px 10px -2px ;border-bottom-left-radius: 8px;border-bottom-right-radius: 8px;">
            <tbody>
              <td align="center" style="margin:0;padding-bottom:25px;padding-left:30px;padding-right:30px;padding-top:25px;">
                <p style="font-size: 24px;"><span style="color:#da8961 !important;font-family: 'Poppins', sans-serif !important;"><a style="color: #da8961; ">www.africanland.com </a></span></p>
              </td>
            </tbody>
          </table>
        </td>
      </tr>


    </tbody>
  </table>
  <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px; margin-top: 30px;">
    <tbody>



          
        <tr style="border-collapse:collapse;"> 
            <td  style="padding:0;margin:0; "> 
              <table style="max-width: 792px;width: 100%;margin: auto ;">
                <tbody>
                  <tr>
                      <td style="width: 70%;">
                        <p style="font-family: 'Poppins', sans-serif !important;"> <img src="http://africanaland.com/public/images/call1.png" style="width: 4%;"> : {{$sitePhone}} </p>
                      <p style="font-family: 'Poppins', sans-serif !important;"> <img src="http://africanaland.com/public/images/msg.png" style="width: 4%;"> : <a style="color: #da8961; ">{{$siteEmail}}</a> </p>
                      </td>
                       <td style="width: 30%; text-align: right;">
                        <span style="margin: 10px;">
                          <a href="{{$Facebook}}" style="text-decoration: none;">
                            <img src="http://africanaland.com/public/images/fb.png" >
                          </a>
  
                        </span>
                        <span style="margin: 10px;">
                          <a href="{{$Twitter}}" style="text-decoration: none;">
                            <img src="http://africanaland.com/public/images/twitter1.png">
                          </a>
                        </span>
                        <span style="margin: 10px;">
                          <a href="{{$Instagram}}" style="text-decoration: none;">
                            <img src="http://africanaland.com/public/images/insta.png" >
                          </a>
                        </span>
                      </td>
                  </tr> 
                </tbody>
              </table>
            </td> 
          </tr>
            <tr style="border-collapse:collapse; "> 
            <td  style="padding:0;margin:0; "> 
              <table style="max-width: 792px;width: 100%;margin: auto ;margin-top: 10px; border-top: 1px solid #e19e7d;">
                <tbody>
                 <tr>
                    <td style="width: 50%;padding: 10px;font-family: 'Poppins', sans-serif !important;text-align:center" ;>
                      <p>&copy; Copyright 2019 Africana Land Company</p>  
                  </td>
                </tr>
                </tbody>
              </table>
            </td> 
          </tr>        
        </tbody>
      </table>
   </body>
   </html>
   