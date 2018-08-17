@include("includes.mail.header")
<table align="center" border="0" bgcolor="#C9CCCF" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
    <tr>
        <td style="display: flex; justify-content: center">
            <p class="webfont" style="width: 410px; font-size: 18px;">Hello <?= $meetingAttendee->user->firstname?>,</p>
        </td>
    </tr>
    <tr>
        <td style="display: flex; justify-content: center;">
            <div>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-bottom: 0; margin-top: 0;">You have been added as an attendee for a meeting within your team <?= $meetingAttendee->meeting->team->team_name?>.</p>
                <br>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 0; margin-bottom: 0"><b>Meeting details: </b></p>
                <ul class="webfont">
                    <li>Subject: <?= $meetingAttendee->meeting->objective?></li>
                    <li>Date: <?= date("l d F Y", strtotime($meetingAttendee->meeting->date_meeting))?> at <?= $meetingAttendee->meeting->time_meeting?></li>
                </ul>
                <br>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 0; margin-bottom: 0"><b>Description:</b></p>
                <p class="webfont" style="width: 410px; font-size: 16px; margin-top: 0; margin-bottom: 0"><?= $meetingAttendee->meeting->description?></p>
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