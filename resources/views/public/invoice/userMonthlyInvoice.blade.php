@include("includes.invoice.header")
<div class="webfont">
    <div style="margin-left: 50px;">
        <h1 style="margin-bottom: 5px;">Innocreation</h1>
        <p style="margin: 0 !important">Dagpauwoog 81</p>
        <p style="margin: 0 !important">Netherlands, NL, 4814VG</p>
        <p style="margin: 0 !important">VAT ID: NL234360069B01</p>
        <h1 style="margin-bottom: 5px;"><?= $invoice->user->getName()?></h1>
        <p style="margin: 0 !important"><?= $invoice->user->country->country?>, <?= $invoice->user->postalcode?>, <?= $invoice->user->state?></p>
        <p style="margin: 0 !important"><?= $invoice->user->email?></p>
    </div>
    <div style="margin-left: 450px; margin-bottom: 20px">
        <h1 style="margin-bottom: 5px;">Invoice</h1>
        <p style="margin: 0 !important">Invoice number: <?= $invoice->invoice_number?></p>
        <p style="margin: 0 !important">Invoice date: <?= date("Y-m-d", strtotime($invoice->created_at))?></p>
        <p style="margin: 0 !important">Chamber of Commerce number: 72024992</p>
    </div>
    <div style="margin-left: 450px; margin-bottom: 40px;">
        <p style="margin: 0 !important">Period: <?= date("m", strtotime($invoice->created_at . "-1 month"))?> - <?= date("m", strtotime($invoice->created_at))?></p>
    </div>
    <div style="margin-left: 100px;">
        <table style="width: 900px; margin-left: 50px">
            <tr style="text-align: left">
                <th style="margin-right: 60px;">Description</th>
                <th>Amount</th>
                <th>VAT NL</th>
                <th>Date</th>
                <th>EU</th>
            </tr>
            <tr>
                <? if($teamPackage->custom_team_package_id != null) { ?>
                    <td>Custom package for team <?= $invoice->teamPackage->team->team_name?></td>
                <? } else { ?>
                    <td><?= $invoice->teamPackage->title?> for team <?= $invoice->teamPackage->team->team_name?></td>
                <? } ?>
                <td><?= number_format($invoice->amount - ($invoice->amount / 100 * $vatRate), 2, ".", ".")?></td>
                <td><?= number_format($invoice->amount / 100 * $vatRate, 2, ".", ".")?></td>
                <td><?= date("Y-m-d", strtotime($invoice->created_at))?></td>
                <td>€ <?= number_format(($invoice->amount - ($invoice->amount / 100 * $vatRate)) + ($invoice->amount / 100 * $vatRate), 2, ".", ".")?></td>
            </tr>
        </table>
    </div>
    <div style="margin-left: 510px; margin-bottom: 100px !important;">
        <p style="font-weight: bold; font-size: 19px !important">Total: € <?= ($invoice->amount - ($invoice->amount / 100 * $vatRate)) + ($invoice->amount / 100 * $vatRate)?></p>
    </div>
    <div style="margin-left: 180px;">
        <i>Your credit card will be automatically charged within 2-3 days.</i>
    </div>
</div>
<style>
    th{
        border-bottom: 1px solid black;
    }
    table{
        /*-webkit-border-horizontal-spacing: 0 !important;*/
    }
</style>
</body>
</html>