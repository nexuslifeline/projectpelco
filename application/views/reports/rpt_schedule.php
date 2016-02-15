<?php $balance=0; ?>



<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Consumer Payment Schedule</title>
</head>
<body  style="font-family:Calibri;font-size:11px;">
<table width="100%">
    <tr>
        <td width="50%"><h2>Consumer Payment Schedule</h2></td>

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
        <td width="20%" style="background-color: #46b8da;border-color: #000000;border-style: solid; border-width: 1px;">Due Date</td>
        <td width="65%" style="background-color: #46b8da">Description</td>
        <td width="20%" align="right" style="background-color: #46b8da">Due Amount</td>
    </tr>
    </thead>
    <tbody>
        <?php foreach($list as $row){ ?>
            <tr>
                <td><?php echo $row->sched_payment_date; ?></td>
                <td><?php echo $row->bill_description; ?></td>
                <td align="right"><?php echo number_format($row->due_amount,2); ?></td>
            </tr>

            <?php $balance+=$row->due_amount; ?>

        <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td align="right" colspan="2"><h3>Balance</h3></td>
        <td align="right"><h3><?php echo number_format($balance,2); ?></h3></td>
    </tr>
    </tfoot>
</table>
</body>
</html>