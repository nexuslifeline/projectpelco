<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Consumer Ledger</title>
</head>
<body  style="font-family:Calibri;font-size:11px;">
    <table width="100%">
        <tr>
            <td width="50%"><h2>Consumer Ledger</h2></td>

        </tr>
    </table>
    <br /><br />
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="10%">Account # :</td>
            <td width="30%"><b><?php echo $consumer[0]->account_no; ?></b></td>
            <td width="30%" align="right">Payable Period : </td>
            <td width="30%" align="right"><b><?php echo $consumer[0]->period; ?></b></td>
        </tr>
        <tr>
            <td width="10%">Consumer :</td>
            <td width="30%"><b><?php echo $consumer[0]->consumer_name; ?></b></td>
            <td width="30%" align="right">Apprehended Amount : </td>
            <td width="30%" align="right"><b><?php echo number_format($consumer[0]->total_back_bill_amount,2); ?></b></td>
        </tr>
        <tr>
            <td width="10%">Contact # :</td>
            <td width="30%"><b><?php echo $consumer[0]->contact_no; ?></b></td>
            <td width="30%" align="right">Address : </td>
            <td width="30%" align="right"><b><?php echo $consumer[0]->consumer_address; ?></b></td>
        </tr>

    </table>

    <br /><br />

    <table width="100%" border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <td style="background-color: #46b8da;border-color: #000000;border-style: solid; border-width: 1px;">Date</td>
                <td style="background-color: #46b8da">Account #</td>
                <td style="background-color: #46b8da">Receipt #</td>
                <td style="background-color: #46b8da">Description</td>
                <td style="background-color: #46b8da" align="right">Debit</td>
                <td style="background-color: #46b8da" align="right">Credit</td>
                <td style="background-color: #46b8da" align="right">Balance</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ledger as $row){ ?>
            <tr>
                <td><?php echo $row->TransDate; ?></td>
                <td><?php echo $row->account_no; ?></td>
                <td><?php echo $row->receipt_no; ?></td>
                <td><?php echo $row->Description; ?></td>
                <td align="right"><?php echo number_format($row->Debit,2); ?></td>
                <td align="right"><?php echo number_format($row->Credit,2); ?></td>
                <td align="right"><?php echo number_format($row->Balance,2); ?></td>
            </tr>
            <?php } ?>

        </tbody>
        <tfoot>
            <tr>
                <td align="right" colspan="6"><h3>Balance</h3></td>
                <td align="right"><h3><?php echo number_format($row->Balance,2); ?></h3></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>