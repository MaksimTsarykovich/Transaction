<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма загрузки файлов</title>

    <link rel="stylesheet" href="/assets/ccs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/ccs/main.css">

    <title>Transactions</title>

</head>
<body>
<table>

    <?php if ($this->params['flash']->has('error')): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
            <?= $this->params['flash']->get('error') ?>
        </div>
    <?php endif; ?>

    <div class="container-fluid mt-2">
        <?php if ($this->params['flash']->has('success')): ?>
            <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                <?= $this->params['flash']->get('success') ?>
            </div>
        <?php endif; ?>
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
    <script src="/assets/ccs/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>
