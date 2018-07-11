<?php $this->load->helper('form'); ?>

<?php echo form_open(current_url()); ?>
	<p>
		<label for="InputUserName">Nom d'utilisateur<sup>*</sup></label>
		<input type="text" class="form-control" id="InputUserName" name="login" value="<?php echo set_value('login') ?>">
	</p>

	<p>
		<label for="InputEmail">Email<sup>*</sup></label>
		<input type="email" class="form-control" id="InputEmail" name="email" value="<?php echo set_value('email'); ?>">
	</p>
	
	<p>
		<label for="InputPassword">Mot de passe<sup>*</sup></label>
		<input type="password" class="form-control" id="InputPassword" name="password">
	</p>
	<p>
		<label for="InputConfirmPassword">Confirmation du mot de passe<sup>*</sup></label>
		<input type="password" class="form-control" id="InputConfirmPassword" name="passwordconfirm">
	</p>
	<input type="hidden" name="save-<?php echo $modelName ;?>" value="1"/>

	<p>
		<button type="submit">Se connecter</button>
	</p>
</form>
