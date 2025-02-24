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

        .positive {
            color: green;
        }

        .negative {
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
    <?php if ($this->flash->has('success')): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
            <?= $this->flash->get('success') ?>
        </div>
    <?php endif; ?>

    <?php if ($this->flash->has('error')): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
            <?= $this->flash->get('error') ?>
        </div>
    <?php endif; ?>
    <?php foreach ($this->params['transactions'] as $transaction):
        if(is_int($transaction)){
            continue;
        }
        ?>
        <tr>
            <td><?= $transaction['date'] ?></td>
            <td><?= $transaction['check'] ?></td>
            <td><?= $transaction['description'] ?></td>
            <td class="<?= $transaction['is_positive'] ? 'positive' : 'negative' ?>">
                <?= $transaction['amount'] ?>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
    <tfoot>

    <tr>
        <th colspan="3">Total Income:</th>
        <td><?= $this->params['transactions']['income'] ?></td>
    </tr>
    <tr>
        <th colspan="3">Total Expense:</th>
        <td><?= $this->params['transactions']['expense'] ?></td>
    </tr>
    <tr>
        <th colspan="3">Net Total:</th>
        <td><?= $this->params['transactions']['total'] ?></td>
    </tr>
    </tfoot>
</table>
</body>
</html>
