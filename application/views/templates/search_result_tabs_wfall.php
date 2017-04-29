<div>

  	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<?php $first = true; ?>
		<?php foreach ($result as $provider => $content): ?>
			<?php if ($first): ?>
				<?php $tag='class="active"'; ?>
				<?php $first = false; ?>
			<?php else: ?>
			  	<?php $tag=''; ?>
			<?php endif; ?>
			<li id="myTabs" role="presentation" <?php echo $tag; ?> ><a href="#<?php echo $provider; ?>" 
			  aria-controls="<?php echo $provider; ?>" role="tab" data-toggle="tab">
			<?php echo $provider.' '; ?><span class="badge"><?php echo $content['rows']; ?></span></a></li>    
		<?php endforeach; ?>
	</ul>

  	<!-- Tab panes -->
	<div class="tab-content">
		<?php $first = true; ?>
		<?php foreach ($result as $provider => $content): ?>
			<?php if ($first): ?>
				<?php $tag='in active'; ?>
				<?php $first = false; ?>
			<?php else: ?>
				<?php $tag=''; ?>
			<?php endif; ?>
			<div role="tabpanel" class="tab-pane fade <?php echo $tag; ?>" id="<?php echo $provider; ?>">
				<div id="box-<?php echo $provider; ?>">
					
					<?php foreach ($content as $item => $data): ?>
					  	<?php if (is_array($data)): ?>
							<?php foreach ($data as $key => $images): ?>
								<?php if( !empty($images['thumburl']) ): ?>
											  	<img id="thumb" src="<?php echo $images['thumburl']; ?>" 
											  	data-toggle="modal" data-target="#myModal"                  
													data-url="<?php echo site_url($search_source.'/imgdetail').'/'.
														  $provider.'/'. $images['code']; ?>"
													data-img="<?php echo $images['code']; ?>"
													data-caption="<?php echo $images['caption']; ?>">
								<?php endif; ?>
							<? endforeach; ?>
				</div>
				<button id="load-images">Load images</button>	
				  		<?php endif; ?>
				<?php endforeach; ?>

		  	</div>
	  	<?php endforeach; ?>
  </div>

</div>
