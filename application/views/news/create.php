<ol class="breadcrumb">
  <li><a href="<?php echo base_url('pages/view'); ?>">Home</a></li>
  <li class="active">Create News</li>
</ol>

<div class="container">

<legend>Enter the data </legend>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('news/create', 'role="form"') ?>

	<div class="form-group">
		<label for="title">Title</label>
		<input class="form-control" type="input" id="title" name="title" placeholder="Enter the title"/>
	</div>
	
	<div class="form-group">
		<label for="text">Text</label>
		<textarea class="form-control" id="text" name="text" placeholder="Enter the body"></textarea>
	</div>
	
	<input type="file" id="userfile" name="userfile" size="20" /><br />
    
    <button class="btn btn-primary" type="submit" name="submit">Create news item</button>

<?php echo form_close(); ?>

</div>

