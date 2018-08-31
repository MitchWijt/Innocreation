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
                <p class="webfont" style="width: 410px; font-size: 16px; margin-bottom: 0; margin-top: 0;">There has been a request to reset your password with the account associated with this email address</p>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 0; margin-bottom: 0">If this was you click on the link to reset your password.</p>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 0; margin-bottom: 0"><a style="color: #FF6100 !important;" href="https://<?= $_SERVER["HTTP_HOST"]?><?= $user->getPasswordResetLink()?>">https://<?= $_SERVER["HTTP_HOST"]?><?= $user->getPasswordResetLink()?></a></p>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 0; margin-bottom: 20px">If this wasn't you please let us know and ignore this email</p>
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