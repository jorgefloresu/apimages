<?php foreach ($result as $provider => $content): ?>					
		<?php foreach ($content as $item => $data): ?>
		  	<?php if (is_array($data)): ?>
				<?php foreach ($data as $key => $images): ?>
					<?php if( !empty($images['thumburl']) ): ?>
					<div class='brick' style='width:{width}px;'>
						<img src="<?php echo $images['thumburl']; ?>" width="100%"
					  		data-toggle="modal" data-target="#myModal"                  
							data-url="<?php echo site_url($search_source.'/imgdetail').'/'.
								  $provider.'/'. $images['code']; ?>"
							data-img="<?php echo $images['code']; ?>"
							data-caption="<?php echo $images['caption']; ?>" /></div><?php endif; ?>
				<? endforeach; ?>
	  		<?php endif; ?>
		<?php endforeach; ?>
  	<?php endforeach; ?>