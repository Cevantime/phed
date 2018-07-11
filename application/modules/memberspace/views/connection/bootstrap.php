<?php $this->load->helper('form'); ?>

<?php echo form_open(current_url()); ?>

	<div class="form-group">
		<div class="input-group login-input">
			<span class="input-group-addon"><i class="fa fa-user"></i></span>
			<input type="text" name="login" class="form-control" placeholder="Nom d'utilisateur">
		</div>
		<br>
		<div class="input-group login-input">
			<span class="input-group-addon"><i class="fa fa-lock"></i></span>
			<input type="password" name="password" class="form-control" placeholder="Password">
		</div>
		<div class="checkbox pull-left">
			<input type="checkbox" id="checkbox_remember1" name="rememberme" value="1">
			<label for="checkbox_remember1">
				Se souvenir de moi
			</label>
		</div>
		<input type="hidden" name="login-user" value="1"/>
		<button type="submit" class="btn btn-ar btn-primary pull-right">Se connecter</button>
		<div class="clearfix"></div>
	</div>
</form>