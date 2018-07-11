<?php function userVal($key, $pop){
	return isset($pop) && isset($pop[$key]) ? $pop[$key] : set_value($key); 
} ?>
<?php echo form_open(current_url()); ?>
	<div class="form-group">
		<label for="InputUserName">Nom d'utilisateur<sup>*</sup></label>
		<input type="text" class="form-control" id="InputUserName" name="login" value="<?php echo userVal('login', $popSaveUser) ?>">
	</div>
	<div class="form-group">
		<label for="InputEmail">Email<sup>*</sup></label>
		<input type="email" class="form-control" id="InputEmail" name="email" value="<?php echo userVal('email', $popSaveUser); ?>">
	</div>
	<?php if(isset($isEditUser)): ?>
	<input type="hidden" name="id" value="<?php echo userVal('id', $popSaveUser); ;?>">
	<?php endif; ?>
	<input type="hidden" name="save-user" value="1">
	<?php if(isset($isEditUser)): ?>
	<div class="form-group">
		<label for="InputOldPassword">Ancien mot de passe<sup>*</sup></label>
		<input type="password" class="form-control" id="InputOldPassword" name="oldpassword">
	</div>
	<?php endif; ?>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="InputPassword"><?php if(isset($isEditUser)): ?>Nouveau mot<?php else : ?>Mot<?php endif; ?> de passe<sup>*</sup></label>
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
	<div class="form-group">
		<button type="submit" class="btn btn-ar btn-primary pull-right"><i class="fa fa-floppy-o"></i> Enregistrer</button>
	</div>
</form>
