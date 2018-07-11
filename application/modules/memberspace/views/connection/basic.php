<?php $this->load->helper('form'); ?>
<?php echo form_open(current_url()); ?>
	<p>
		<label>Nom d'utilisateur</label>
		<input type="text" name="login"/>
	</p>
	<p>
		<label>Mot de passe</label>
		<input type="password" name="password"/>
	</p>
	<p>
		<label for="checkbox_remember1">Se souvenir de moi</label>
		<input type="checkbox" id="checkbox_remember1" name="rememberme" value="1">
	</p>
		<input type="hidden" name="login-user" value="1"/>
	<p>
		<button type="submit">Se connecter</button>
	</p>
</form>