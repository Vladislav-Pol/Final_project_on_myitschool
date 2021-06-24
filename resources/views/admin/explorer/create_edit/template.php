<?php
if(!isset($_REQUEST['path']))
	header('Location: ./index.php');
?>
	<script src="/js/adminScripts.js"></script>
	<div class="creat_edit content">
		<?if($create):?>
			<h2>Создание нового элемента</h2>
		<?elseif($edit):?>
			<h2>Редактирование элемента</h2>
		<?else: return;?>
		<?endif;?>
		<div class="functions">
			<a href="../../templates?path=<?=$path?>" class="button">Отмена</a>
			<button name="<?=$create ? "saveNewElement" : "saveElement"?>" form="creat_edit">Сохранить</button>
		</div>

	</div>
	<div class="main content">
		<span><?=$path;?></span><br/><br/>
		<form method="post" action="/admin/explorer/index.php" id="creat_edit">
			<input type="text" name="path" value="<?=$path?>" hidden>
			<input type="text" name="oldName" value="<?=$edit??''?>" hidden>
			<input type="text" name="oldFileExtension" value="<?=$fileType??''?>" hidden>
			<p>Введите имя и выберите тип элемнта</p>
			<input type="text" name="fileName" value="<?=$edit??''?>">
			<select name="extension" id="selectType" onchange="HideTextArea(this.value)">
				<?foreach (FILE_TYPE as $type => $typeName):?>
					<option value="<?= $type?>"
						<? if(isset($fileType) && $type == $fileType){
							echo " selected";
						}
						elseif($edit){
							echo " hidden";
						}?>
					>
						<?= $typeName?>
					</option>
				<?endforeach;?>
			</select>
			<div id="contentFile">
				<p>Заполните/отредактируйте содержимое файла</p>
				<textarea name="fileContent"><?= $fileContent??""?></textarea>
			</div>
		</form>

	</div>
	<script>
		HideTextArea(selectType.value)
	</script>
<?php

