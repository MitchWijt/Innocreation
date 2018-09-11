@include("includes.mail.header")
<table align="center" border="0" bgcolor="#C9CCCF" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
    <tr>
        <td style="display: flex; justify-content: center">
            <p class="webfont" style="width: 410px; font-size: 18px;">Hello <?= $user->firstname?>,</p>
        </td>
    </tr>
    <tr>
        <td style="display: flex; justify-content: center;">
            <div>
                <div style="display: flex !important; justify-content: center !important">
                    <p class="webfont" style="width: 410px; font-size: 16px; margin-bottom: 0; margin-top: 0;">We thank you for joining Innocreation!</p>
                </div>
                <div style="display: flex !important; justify-content: center !important">
                    <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 0; margin-bottom: 0">Take a look around and discover all the possibilities within Innocreation. If you need help understanding Innocreation, Follow "Inno" the helper right!.</p>
                </div>
                <div style="display: flex !important; justify-content: center !important">
                    <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 0; margin-bottom: 0">We wish you good luck with finding/creating a team!</p>
                </div>
                <div style="display: flex !important; justify-content: center !important">
                    <img style="width: 500px !important; height: 250px !important;" src="cid:email.png" alt="">
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td style="display: flex; justify-content: center">
            <p class="webfont" style="width: 410px; font-size: 18px;">Make your dreams a reality! - Innocreation</p>
        </td>
    </tr>
</table>
@include("includes.mail.footer")