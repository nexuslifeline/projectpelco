<?php $collection=0; ?>



<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Collection Report</title>
</head>
<body  style="font-family:Calibri;font-size:11px;">
<table width="100%">
    <tr>
        <td width="50%"><h2>Collection Report</h2></td>
    </tr>
    <tr>
        <td width="50%"><i>From <?php echo date('M d, Y',strtotime($start)) ?> to <?php echo date('M d, Y',strtotime($end)) ?></i></td>
    </tr>
</table>


<br /><br />

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
    <tr>
        <td width="10%" style="background-color: #46b8da">Date</td>
        <td width="10%" style="background-color: #46b8da">Receipt #</td>
        <td width="10%" style="background-color: #46b8da">Account #</td>
        <td width="30%" style="background-color: #46b8da">Consumer</td>
        <td width="23%" style="background-color: #46b8da">Description</td>
        <td width="7%" style="background-color: #46b8da">Status</td>
        <td width="10%" align="right" style="background-color: #46b8da">Amount Paid</td>
    </tr>
    </thead>
    <tbody>
        <?php foreach($list as $row){ ?>
        <tr>
            <td><?php echo date('M d, Y',strtotime($row->date_paid)); ?></td>
            <td><?php echo $row->receipt_no; ?></td>
            <td><?php echo $row->account_no; ?></td>
            <td><?php echo $row->consumer_name; ?></td>
            <td><?php echo $row->description; ?></td>
            <td><?php echo $row->is_active; ?></td>
            <td align="right"><?php echo number_format($row->amount_paid,2); ?></td>
        </tr>

            <?php $collection+=$row->amount_paid; ?>

        <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td align="right" colspan="6"><h3>Total Collection</h3></td>
        <td align="right"><h3><?php echo number_format($collection,2); ?></h3></td>
    </tr>
    </tfoot>
</table>
</body>
</html>