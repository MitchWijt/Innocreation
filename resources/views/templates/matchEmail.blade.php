@include("includes.mail.header")
<table align="center" border="0" bgcolor="#C9CCCF" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
    <tr>
        <td style="display: flex; justify-content: center">
            <p class="webfont" style="width: 410px; font-size: 18px;">Hello InnoCreator!,</p>
        </td>
    </tr>
    <tr>
        <td style="display: flex; justify-content: center;">
            <div>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-bottom: 0; margin-top: 0;">You have been matched with a fellow Innocreator!.</p>
                <br>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-bottom: 0; margin-top: 0;">Login now to connect and collaborate with <?= $user->firstname?>!</p>
                <div style="display: flex !important; justify-content: center !important">
                    <img style="width: 500px !important; height: 250px !important;" src="<?= $user->getProfilePicture()?>" alt="">
                    <img style="width: 500px !important; height: 250px !important;" src="<?= $receiver->getProfilePicture()?>" alt="">
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