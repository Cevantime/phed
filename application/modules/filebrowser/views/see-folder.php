
<h2>
    Mes fichiers 
    <div class="file-actions">
        <a title="Ajouter un dossier" href="#" class="action" data-action="add-folder"><i class="fa fa-folder"></i></a> 
        <a title="Ajouter un fichier" href="#" class="action" data-action="add-file"><i class="fa fa-file"></i></a>
    </div>
</h2>
<div id="file-browser">
	<div id="main-folder">
		<?php $this->load->view('filebrowser/includes/_folder', array('files', $files)); ?>
	</div>
	<div id="file-viewer">
			
	</div>
</div>