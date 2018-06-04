@include("includes.mail.header")
<table align="center" border="0" bgcolor="#C9CCCF" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
    <tr>
        <td style="display: flex; justify-content: center">
            <p class="webfont" style="width: 410px; font-size: 18px;">Hello <?= $receiver->firstname?>,</p>
        </td>
    </tr>
    <tr>
        <td style="display: flex; justify-content: center;">
            <div>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-bottom: 0; margin-top: 0;"><?= $team->team_name?> has sent you an invite to join his/her team!</p>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 0; margin-bottom: 0">Log in to your account and be part of <?= $team->team_name?>! or choose to wait for another team.</p>
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