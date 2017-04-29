<ol class="breadcrumb">
  <li><a href="<?php echo base_url('pages/view'); ?>">Home</a></li>
  <li><a href="<?php echo base_url("news/show_news"); ?>">News</a></li>
  <li class="active">Edit News</li>
</ol>

<div class="container">

<legend>Enter the data </legend>

<?php echo validation_errors(); ?>

<?php if (empty($news_item['img_name'])) echo form_open_multipart('news/update', 'role="form"'); 
		else echo form_open('news/update', 'role="form"'); ?>

	<div class="form-group">
		<label for="title">Title</label>
		<input class="form-control" type="input" id="title" name="title" 
			value="<?php echo $news_item['title']; ?>"/>
	</div>
	
	<div class="form-group">
		<label for="text">Text</label>
		<textarea class="form-control" id="text" name="text" ><?php echo $news_item['text']; ?></textarea>
	</div>

	<input type="hidden" name="id" value="<?php echo $news_item['id']; ?>" />
	<input type="hidden" name="img_deleted" value='0' id="img_deleted" />
	<input type="hidden" name="img_edited" value="<?php echo $news_item['img_name']; ?>" />
	<input type="hidden" name="ext_edited" value="<?php echo $news_item['ext']; ?>" />

	<?php if (empty($news_item['img_name'])): ?>
		<input type="file" id="userfile" name="userfile" size="20" /><br />
	<?php else: ?>
		<div id="img_removed">
		<img src="<?php echo base_url('uploads/'.$news_item['thumb_name']); ?>" alt="foto" class="img-rounded">
	    <input type="button" id="del_img" name="del_img" value="Eliminar imagen" />
	    </div>
	    <br />
	<?php endif; ?>
	
    <button class="btn btn-primary" type="submit" name="submit">Save changes</button>

<?php echo form_close(); ?>

</div>
