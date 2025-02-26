<!DOCTYPE html>
<html lang="en">
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
            font-weight: bold;
        }

        .negative {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<table>

    <?php use App\Helpers\Utils;

    if ($this->flash->has('success')): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
            <?= $this->flash->get('success') ?>
        </div>
    <?php endif; ?>

    <?php if ($this->flash->has('error')): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
            <?= $this->flash->get('error') ?>
        </div>
    <?php endif; ?>

    <div class="container mt-5">
        <div class="d-flex justify-content-center">
            <table class="table table-bordered table-custom">
                <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Check #</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($this->params['transactionsSummary']['transactions'] as $transaction): ?>
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
                    <td><?= $this->params['transactionsSummary']['financialSummary']['income'] ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?= $this->params['transactionsSummary']['financialSummary']['expense'] ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?= $this->params['transactionsSummary']['financialSummary']['total'] ?></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>
