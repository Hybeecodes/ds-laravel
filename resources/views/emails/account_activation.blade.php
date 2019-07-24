<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>

<body>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="m_3641889022860125194main">
    <tbody><tr>
        <td height="100" align="center" valign="top" style="font-size:100px;line-height:100px">&nbsp;</td>
    </tr>
    <tr>
        <td align="center" valign="top" style="background:#f9f9f9;border-radius:10px 10px 0px 0px">
            <table width="105" border="0" align="center" cellpadding="0" cellspacing="0">
                <tbody><tr>
                    <td align="center" valign="top"><a href="#m_3641889022860125194_"><img src="https://storiesbydevs.herokuapp.com/images/devStoriesLogoNew.png" width="190" height="62" alt="DevStories Logo" class="CToWUd"></a></td>
                </tr>
                </tbody></table>
        </td>
    </tr>
    <tr>
        <td align="center" valign="top" bgcolor="#FFFFFF" style="border-radius:10px 10px 0px 0px">
            <table width="510" border="0" align="center" cellpadding="0" cellspacing="0" class="m_3641889022860125194two-left">
                <tbody><tr>
                    <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="m_3641889022860125194two-left-inner">
                            <tbody><tr>
                                <td align="left" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                                <td height="15" align="left" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="left" valign="top" style="font-family:'Open Sans',Verdana,Arial;font-size:24px;color:#767676;font-weight:bold;line-height:28px"><u></u>Welcome to DevStories!<u></u></td>
                            </tr>
                            <tr>
                                <td height="20" align="center" valign="middle" style="line-height:20px;font-size:20px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="left" valign="top" style="font-family:'Open Sans',sans-serif,Verdana;font-size:14px;font-weight:bold;color:#767676"><u></u>Hello {{$user['name']}}!<u></u></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top"><table width="510" border="0" align="center" cellpadding="0" cellspacing="0" class="m_3641889022860125194two-left-inner">
                                        <tbody><tr>
                                            <td align="left" valign="top"><table width="490" border="0" cellspacing="0" cellpadding="0" class="m_3641889022860125194two-left-inner">

                                                    <tbody><tr>
                                                        <td height="20" align="center" valign="middle" style="line-height:20px;font-size:20px">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" valign="top" style="font-family:'Open Sans',Verdana,Arial;font-size:14px;color:#767676;font-weight:normal;line-height:28px"><u></u>

                                                            You honestly cannot imagine how excited we are to have you here on our platform.
                                                            You have just joined over 10000 registered users who are set to seek and explore more opportunities that could make life so much easier and better!
                                                            With DevStories, connecting with customers and gaining visibility online has never been made easier! By joining us, we are sure you will be amazed at the endless stream of opportunities we are set to offer you - either as a business owner or client.&nbsp;&nbsp;

                                                            <u></u>&nbsp;</td>
                                                        <a href="{{ route('api.activate', ["token"=> $user->activation_token]) }}">
                                                            Please Verify your Account here
                                                        </a>
                                                    </tr>
                                                    <tr>
                                                        <td height="30" align="center" valign="middle" style="line-height:30px;font-size:30px">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" valign="top" style="font-family:'Open Sans',sans-serif,Verdana;font-size:14px;color:#767676;font-weight:normal"><u></u>Thank you, </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" valign="top" style="font-family:'Open Sans',sans-serif,Verdana;font-size:14px;color:#767676;font-weight:normal"><u></u>Team DevStories.</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="50" align="center" valign="middle" style="line-height:50px;font-size:50px">&nbsp;</td>
                                                    </tr>

                                                    </tbody></table></td>
                                        </tr>
                                        </tbody></table></td>
                            </tr>

                            </tbody></table></td>
                </tr>

                </tbody></table></td>
    </tr>

    <tr>
        <td align="center" valign="top" style="background:#233d7b;border-radius:0px 0px 10px 10px">
            <table width="510" border="0" align="center" cellpadding="0" cellspacing="0" class="m_3641889022860125194two-left-inner">
                <tbody><tr>
                    <td align="center" valign="top" style="font-family:'Open Sans',Verdana,Arial;font-size:12px;font-weight:normal;color:#fff;line-height:28px"><u></u>Copyright © 2019 DevStories. &nbsp; <u></u></td>
                </tr>
                <tr>
                    <td align="center" valign="top" style="font-family:'Open Sans',Verdana,Arial;font-size:12px;font-weight:normal;color:#fff;line-height:28px"><u></u><a href="#m_3641889022860125194_" style="text-decoration:none;color:#fff">Terms And Conditions</a> -<u></u> <u></u><a href="#m_3641889022860125194_" style="text-decoration:none;color:#fff">Support</a> - <u></u> <u></u><a href="#m_3641889022860125194_" style="text-decoration:none;color:#00a9a1">Unsubscribe</a><u></u></td>
                </tr>
                </tbody></table>
        </td>
    </tr>
    <tr>
        <td height="110" align="left" valign="top" style="font-size:110px;line-height:110px">&nbsp;</td>
    </tr>
    </tbody>
</table>
</body>

</html>