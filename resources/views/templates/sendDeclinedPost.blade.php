@include("includes.mail.header")
<table align="center" border="0" bgcolor="#C9CCCF" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
    <tr>
        <td style="display: flex; justify-content: center;">
            <div>
                <p class="webfont" style="width: 410px; font-size: 18px;">Hello <?= $user->firstname?>,</p>
                <br>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-bottom: 0; margin-top: 0;">Thank you again for sharing your passion with us and for being the biggest reason for the foundation of collaboration and creation!</p>
                <br><br>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 0; margin-bottom: 0">We are sorry to inform you that your passion post does not meet the requirements listed in our terms to post.</p>
                <br>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 0; margin-bottom: 0">We still thank you for sharing!</p>
                <br><br>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 0; margin-bottom: 0">Goodluck with collaboration and we hope a lot of great connections and projects will come your way!</p>
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