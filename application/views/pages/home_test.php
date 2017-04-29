Hello World!
<?php echo anchor('login/logout', 'Logout'); ?>
</br>
<a href="<?php echo base_url('news/show_news'); ?>">Bandeja de entrada <span class="badge"><?php echo $totalnews ?></span></a>
</br>
<a href="<?php echo base_url('getingimages/search'); ?>">Ingimages API test</a>
<br />
<a href="<?php echo base_url('getdeposit/search'); ?>">DepositPhoto API test</a>
<br />
<a href="<?php echo base_url('getfotolia/search'); ?>">Fotolia API test</a>
<br />
<a href="<?php echo base_url('getfotosearch/search'); ?>">FotoSearch API test</a>
<br />
<a href="<?php echo base_url('getprovidersfull'); ?>">All API Providers test</a>
<br />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   	<script src="<?php echo base_url("materialize/js/materialize.js"); ?>"></script>
	<script src="<?php echo base_url("js/plugins.js"); ?>"></script>