<?php $delinqBalance=0; ?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>List of Delinquent Consumer</title>
</head>
<body  style="font-family:Calibri;font-size:11px;">
<table width="100%">
    <tr>
        <td width="50%"><h2>List of Delinquent Consumer</h2></td>
    </tr>
</table>
<hr style="color: blue;margin-top: 0px;height: 2px;" />
<br /><br />


<br /><br />


<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
    <tr>
        <td width="10%" style="background-color: #46b8da;border-color: #000000;border-style: solid; border-width: 1px;">Account #</td>
        <td width="25%" style="background-color: #46b8da;border-color: #000000;border-style: solid; border-width: 1px;">Consumer</td>
        <td width="10%" align="right" style="background-color: #46b8da;border-color: #000000;border-style: solid; border-width: 1px;">Apprehended Amount</td>
        <td width="10%" align="right" style="background-color: #46b8da;border-color: #000000;border-style: solid; border-width: 1px;">Total Paid</td>
        <td width="10%" align="right" style="background-color: #46b8da;border-color: #000000;border-style: solid; border-width: 1px;">Total Balance</td>
        <td width="10%" align="right" style="background-color: #46b8da;border-color: #000000;border-style: solid; border-width: 1px;"># of Payments</td>
        <td width="10%" align="right" style="background-color: #46b8da;border-color: #000000;border-style: solid; border-width: 1px;"># of Delayed Months</td>
        <td width="10%" align="right"  align="right" style="background-color: #46b8da;border-color: #000000;border-style: solid; border-width: 1px;">Previous Balance</td>
    </tr>
    </thead>
    <tbody>
        <?php foreach($delinquent as $row){ ?>
            <tr>
                <td><?php echo $row->account_no; ?></td>
                <td><?php echo $row->consumer_name; ?></td>
                <td align="right"><?php echo number_format($row->ApprehendedAmount,2); ?></td>
                <td align="right"><?php echo number_format($row->TotalPayment,2); ?></td>
                <td align="right"><?php echo number_format($row->TotalBalance,2); ?></td>
                <td align="right"><?php echo number_format($row->PaymentsMade,0); ?></td>
                <td align="right"><?php echo number_format($row->DelayedMonths,0); ?></td>
                <td align="right"><?php echo number_format($row->PreviousBalance,2); ?></td>
                <?php $delinqBalance+=$row->PreviousBalance; ?>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7" align="right"><h3>Total Delinquent Balance </h3></td>
            <td align="right"><?php echo number_format($delinqBalance,2); ?></td>
        </tr>
    </tfoot>
</table>
</body>
</html>