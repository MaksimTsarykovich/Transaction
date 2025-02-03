<!DOCTYPE html>
<html>
<head>
    <title>Transactions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        table tr th, table tr td {
            padding: 5px;
            border: 1px #eee solid;
        }

        tfoot tr th, tfoot tr td {
            font-size: 20px;
        }

        tfoot tr th {
            text-align: right;
        }

        green {
            color: green;
        }

        red {
            color: red;
        }
    </style>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>Date</th>
        <th>Check #</th>
        <th>Description</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>


    <?php foreach ($this->params['transactions'] as $transaction): ?>
        <tr>
            <td><?= $transaction['data'] ?></td>
            <td><?= $transaction['check'] ?></td>
            <td><?= $transaction['description'] ?></td>
            <td ><?= $transaction['amount'] ?></td>
            <td ><?= $transaction['is_positive'] ?></td>
        </tr>
    <?php endforeach; ?>

    </tbody>
    <tfoot>

    <tr>
        <th colspan="3">Total Income:</th>
        <td><?=$this->params['income']?></td>
    </tr>
    <tr>
        <th colspan="3">Total Expense:</th>
        <td><?=$this->params['expense']?></td>
    </tr>
    <tr>
        <th colspan="3">Net Total:</th>
        <td><?=$this->params['net']?></td>
    </tr>
    </tfoot>
</table>
</body>
</html>
