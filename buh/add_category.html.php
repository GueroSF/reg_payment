<div>
	<form action="" method="post" id="addCategory">
		<fieldset>
			<legend>Выбор счета:</legend>
			<select name="account">
				<option></option>
				<?php foreach ($accounts as $acc): ?>
					<option value="<?php echo $acc['id']; ?>"><?php echo $acc['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</fieldset>
		<fieldset>
			<legend>Имя категории:</legend>
			<input type="text" name="category">
		</fieldset>
		<fieldset>
			<legend>Добавить платеж:</legend>
			<input type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
			<input type="number" step="0.01" name="money">
			<select name="operation">
				<option></option>
				<?php foreach ($operations as $op): ?>
					<option value="<?php echo $op['id']; ?>"><?php echo $op['name']; ?></option>
				<?php endforeach ?>
			</select>
			<textarea name="comment" maxlength="100" rows="2"></textarea>
		</fieldset>
		<input type="hidden" name="action" value="addCategory">
		<input type="submit" value="Добавить">
	</form>
</div>
</content>
</body>
<script type="text/javascript">
	const form = document.getElementById('addCategory');
	form.addEventListener('submit', function (event) {
		let money = form.querySelector('[name=money]');
		let account = form.querySelector('[name=account]');
		let operation = form.querySelector('[name=operation]');
		if (money.value == ''||account.value == ''||operation.value==''){
			event.preventDefault();
			alert('Заполните поля!');
		}
	});
</script>
</html>