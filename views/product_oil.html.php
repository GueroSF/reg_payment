<?php /** @var $this \model\ProductOil */ ?>
<div class="paymentAdd">
	<div class="month_name"><span>Внести платёж</span></div>
	<form id="addPayment" action="" method="post" class="table">
		<input type="date" name="date" value="<?= date('Y-m-d') ?>">
		<input type="number" step="0.01" name="payment">
		<label for="month">За:</label>
		<select name="month">
			<option></option>
			<?php foreach ($this->month() as $month): ?>
				<option value="<?= $month['num'] ?>"><?= model\NameMonth::get($month['num']) ?></option>
			<?php endforeach ?>
		</select>
		<label for="comment">Коментарий:</label>
		<input type="text" name="comment" maxlength="50">
		<input type="hidden" name="action" value="addPayment">
		<input type="submit" value="Добавить">
	</form>
</div>
<?php foreach ($this->getSum() as $money): if ($money['sum']=='0.00') continue; ?>
	<div class="month">
	    <div class="month_name">
            <?= model\NameMonth::get($money['num']) ?> <?= $money['sum'] ?>
        </div>
	    <div class="paymentList">
		    <div class="month_name">Платежи внесенные ранее:</div>
            <div class="table">
                <div class="td1">Дата платежа</div>
                <div class="td2">Сумма</div>
                <div class="td3">Комментарий</div>
            </div>
            <?php foreach ($money['payment'] as $payment): ?>
                <div class="table">
                    <div class="td1"><?= $payment['date_payment'] ?></div>
                    <div class="td2"><?= $payment['payment'] ?></div>
                    <div class="td3"><?= $payment['comment'] ?></div>
                </div>
            <?php endforeach ?>
		</div>
	</div>
<?php endforeach; ?>