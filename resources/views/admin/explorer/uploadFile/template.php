	<div class="uploadFile content">
		<h2>Загрузка файла</h2>
	</div>
	<div class="main content">
		<span><?=$arData['path'];?></span><br/><br/>
		<form method="POST" action="/admin/explorer/uploadFile/" enctype="multipart/form-data" class="uploadForm">
			<input type="text" name="path" value="<?=$arData['path']?>" hidden>
			<p>Выберите файл для загрузки</p>
			<input type="file" name="uploadFiles[]" multiple>
			<button name="isUpload">Загрузить файл</button>
		</form>

	</div>
<?php

