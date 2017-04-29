
	<?php foreach ($result as $provider => $content): ?>					
		<?php foreach ($content as $item => $data): ?>
		  	<?php if (is_array($data)): ?>
				<?php foreach ($data as $key => $images): ?>
					<?php if( !empty($images['thumburl']) ): ?>
					  	<div class="item">
					  		<img class="fix-thumb tilt" src="<?php echo $images['thumburl']; ?>" 
					  	data-toggle="modal" data-target="#myModal"                  
							data-url="<?php echo site_url($search_source.'/imgdetail').'/'.
								  $provider.'/'. $images['code']; ?>"
							data-img="<?php echo $images['code']; ?>"
							data-caption="<?php echo $images['caption']; ?>" />
						</div>
					<?php endif; ?>
				<? endforeach; ?>
	  		<?php endif; ?>
		<?php endforeach; ?>
  	<?php endforeach; ?>
	


