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
                <p class="webfont" style="width: 410px; font-size: 16px; margin-bottom: 0; margin-top: 0;">We hope you have found your way in Innocreation and discovered the possibilities within it.</p>
                <br>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 0; margin-bottom: 0"><b>If not. We have some tips for your right here! </b></p>
                <ul class="webfont">
                    <li>Upload a profile picture for more exposure</li>
                    <li>Add your experience to your expertises</li>
                    <li>Upload a portfolio or post your work/story for people to help at <a href="www.innocreation.net/innocreatives">Innocreatives</a></li>
                    <li>Discover teams. Create or join a team</li>
                </ul>
                <br>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 0; margin-bottom: 0"><b>We wish you good luck with your ideas and dreams!</b></p>
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