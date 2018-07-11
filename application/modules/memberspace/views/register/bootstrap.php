<?php $this->load->helper('form'); ?>

<?php echo form_open(current_url()); ?>
	<div class="form-group">
		<label for="InputUserName">Nom d'utilisateur<sup>*</sup></label>
		<input type="text" class="form-control" id="InputUserName" name="login" value="<?php echo set_value('login') ?>">
	</div>
	<div class="form-group">
		<label for="InputEmail">Email<sup>*</sup></label>
		<input type="email" class="form-control" id="InputEmail" name="email" value="<?php echo set_value('email'); ?>">
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="InputPassword">Mot de passe<sup>*</sup></label>
				<input type="password" class="form-control" id="InputPassword" name="password">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="InputConfirmPassword">Confirmation du mot de passe<sup>*</sup></label>
				<input type="password" class="form-control" id="InputConfirmPassword" name="passwordconfirm">
			</div>
		</div>
	</div>
	<input type="hidden" name="save-<?php echo $modelName ;?>" value="1"/>
	<div class="form-group">
		<button type="submit" class="btn btn-ar btn-primary pull-right">Se connecter</button>
	</div>
	
</form>

