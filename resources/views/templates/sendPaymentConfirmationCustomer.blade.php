@include("includes.mail.header")
<? $packageItems = explode(",",$teamPackage->description);?>
<table align="center" border="0" bgcolor="#C9CCCF" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
    <tr>
        <td style="display: flex; justify-content: center;">
            <div>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-bottom: 20px; margin-top: 20px;">Congratulations <?= $user->getName()?>!</p>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 0; margin-bottom: 0">For taking another step towards your dreams and ideas with this package.</p>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 0; margin-bottom: 0">We hope you make it far with your team, goodluck!</p>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 10px; margin-bottom: 5px"><strong>Your package:</strong></p>
                <? if($teamPackage->custom_team_package_id == null) { ?>
                    <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 10px; margin-bottom: 0 !important"> <?= $teamPackage->title?></p>
                    <ul class="webfont" style="margin-top: 0 !important">
                        <? foreach($packageItems as $packageItem) { ?>
                            <li><?= $packageItem?></li>
                        <? } ?>
                    </ul>
                <? } else { ?>
                    <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 10px; margin-bottom: 0 !important"> Custom package</p>
                    <ul class="webfont" style="margin-top: 0 !important">
                        <li>Max. amount of <?= $teamPackage->customTeamPackage->members?> members</li>
                        <li>Max. amount of <?= $teamPackage->customTeamPackage->planners?> task planners</li>
                        <li>Max. amount of <?= $teamPackage->customTeamPackage->meetings?> meetings</li>
                        <? if($teamPackage->customTeamPackage->newsletters == 1) { ?>
                            <li>Create your own team newsletters</li>
                        <? } ?>
                    </ul>
                <? } ?>
                <? if($teamPackage->payment_preference == "monthly") { ?>
                    <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 20px; margin-bottom: 0">Price: &euro;<?= number_format($teamPackage->price, 2, ".", ".")?>/Month</p>
                <? } else { ?>
                    <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 20px; margin-bottom: 0">Price: &euro;<?= number_format($teamPackage->price, 2, ".", ".")?>/Year</p>
                <? } ?>
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