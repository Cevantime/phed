<?php $this->load->helper('form'); ?>

<?php echo form_open(current_url()); ?>
	<div class="form-group">
		<div class="input-group login-input">
			<span class="input-group-addon"><i class="fa fa-user"></i></span>
			<input type="text" class="form-control" name="login" placeholder="Votre nom d'utilisateur">
		</div>
		<br>
		<div class="input-group login-input">
			<span class="input-group-addon"><i class="fa fa-lock"></i></span>
			<input type="password" class="form-control" placeholder="Password" name="password">
		</div>
		<div class="checkbox">
			<input type="checkbox" id="checkbox_remember" name="rememberme" value="1">
			<label for="checkbox_remember">Se souvenir de moi</label>
		</div>
		<input type="hidden" name="login-user" value="1"/>
		<button type="submit" class="btn btn-ar btn-primary pull-right">Se connecter</button>
 		<a href="<?php echo base_url('lost_password') ?>" class="btn btn-ar btn-warning pull-right">Mot de passe oublié ?</a>
<!--		<a href="#" class="social-icon-ar sm twitter animated fadeInDown animation-delay-3"><i class="fa fa-twitter"></i></a>
		<a href="#" class="social-icon-ar sm google-plus animated fadeInDown animation-delay-4"><i class="fa fa-google-plus"></i></a>
		<a href="#" class="social-icon-ar sm facebook animated fadeInDown animation-delay-5"><i class="fa fa-facebook"></i></a>-->
		<div class="clearfix"></div>
	</div>
</form>