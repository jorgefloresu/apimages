<ol class="breadcrumb">
  <li><a href="<?php echo base_url('pages/view'); ?>">Home</a></li>
  <li class="active">News</li>
</ol>

<h2><?php echo $title ?></h2>
<table class="table table-hover">
<tr>
		<th>Title</th>
		<th>Text</th>
		<th>Image</th>
		<th colspan="2">Actions</th>
</tr>

<?php foreach ($news as $news_item): ?>

<tr>
        <td><?php echo $news_item['title'] ?></td>
        <td><?php echo $news_item['text'] ?></td>
        <?php if (empty($news_item['img_name'])): ?>
        	<td>No image</td>
        <?php else: ?>
        	<td><img src="<?php echo base_url('uploads/'.$news_item['thumb_name']); ?>" alt="foto" class="img-rounded"></td>
        <?php endif; ?>
        <td><?php echo anchor('news/view/'.$news_item['slug'], 'View article'); ?></td>
        <td><?php echo anchor('news/edit/'.$news_item['slug'], 'Edit article'); ?></td>
</tr>

<?php endforeach ?>
</table>

