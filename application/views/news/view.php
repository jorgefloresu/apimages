<ol class="breadcrumb">
  <li><a href="<?php echo site_url('pages/view'); ?>">Home</a></li>
  <li><a href="<?php echo site_url("news/show_news"); ?>">News</a></li>
  <li class="active">News detail</li>
</ol>

<div class="row">
  <div class="col-sm-6 col-md-3">
	<div class="thumbnail">
	<img src="<?php echo base_url('uploads/'.$news_item['img_name'].$news_item['ext']); ?>" alt="foto" class="img-rounded">
      <div class="caption">
      	<p><small><?php echo $news_item['img_name'].$news_item['ext']; ?></small></p>
        <h3><?php echo $news_item['title']; ?></h3>
        <p><?php echo $news_item['text']; ?></p>
        <p>
          <a href="#" class="btn btn-primary" role="button">Botón</a>
          <a href="#" class="btn btn-default" role="button">Botón</a>
        </p>
      </div>
	</div>
 </div>
</div>

<br />

