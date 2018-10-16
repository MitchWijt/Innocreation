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
                <p class="webfont" style="width: 410px; font-size: 16px; margin-bottom: 10px !important; margin-top: 0;"><?= $poster->firstname?> has posted a new post on the Innocreatives feed!</p>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 0; margin-bottom: 0"><a style='color: #FF6100; text-decoration: none' href="https://<?= $_SERVER["HTTP_HOST"]?>/login">Login</a> to your account to see and respond to the post!</p>
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