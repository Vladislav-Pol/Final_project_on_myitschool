<script src="/resources/js/admin/script.js"></script>
<div class="creat_edit content">
	<h2><?=$arData['heading']?></h2>
	<div class="functions">
		<a href="/admin/explorer/?path=<?=$arData['path']?>" class="button">Отмена</a>
		<button name="<?=$arData['buttonSaveName']?>" form="creat_edit">Сохранить</button>
	</div>
</div>
<div class="main content">
	<span><?=$arData['path']?></span><br/><br/>
	<form method="post" action="/admin/explorer/create_edit/" id="creat_edit">
		<input type="text" name="path" value="<?=$arData['path']?>" hidden>
		<input type="text" name="oldName" value="<?=$arData['edit']?>" hidden>
		<input type="text" name="oldFileExtension" value="<?=$arData['fileType']?>" hidden>
		<p>Введите имя и выберите тип элемнта</p>
		<input type="text" name="fileName" value="<?=$arData['edit']?>">
		<select name="extension" id="selectType" onchange="HideTextArea(this.value)">
			<?php foreach ($arData['FILE_TYPES'] as $type => $typeName): ?>
				<option value="<?=$type?>"
					<?php if (isset($arData['fileType']) && $type == $arData['fileType']) {
						echo " selected";
					}elseif ($arData['edit']) {
						echo " hidden";
					}?>
				><?=$typeName?>
				</option>
			<?php endforeach; ?>
		</select>
		<div id="contentFile">
			<p>Заполните/отредактируйте содержимое файла</p>
			<textarea name="fileContent"><?=$arData['fileContent']?></textarea>
		</div>
	</form>
</div>
<script>
	HideTextArea(selectType.value)
</script>


