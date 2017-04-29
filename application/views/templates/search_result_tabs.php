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
			<li role="presentation" <?php echo $tag; ?>><a href="#<?php echo $provider; ?>" 
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
				<?php foreach ($content as $item => $data): ?>
				  	<?php if (is_array($data)): ?>
						<?php foreach ($data as $key => $images): ?>
							<?php if( !empty($images['thumburl']) ): ?>
								<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 fix-thumb-height">
								  	<div class="text-center">
										<a href="#" class="img-rounded" rel="popover" title="<?php echo $images['code']; ?>" 
										  data-img="<?php echo $images['caption']; ?>">
										  <img src="<?php echo $images['thumburl']; ?>" >
										</a>      
										<div class="caption">
										  	<div class="row">
												<div class="col-lg-2">
													<small>
														<?php echo $provider.':'.$images['code']; ?>
													</small>
												</div>
												<div class="col-lg-10 text-right">
													<a href="#"
														class="btn btn-default btn-xs" 
														role="button" data-toggle="modal" data-target="#myModal"                  
														data-url="<?php echo site_url($search_source.'/imgdetail').'/'.
															  $provider.'/'. $images['code']; ?>"
														data-img="<?php echo $images['code']; ?>"
														data-caption="<?php echo $images['caption']; ?>">
														<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<? endforeach; ?>
					<?php elseif ($item === 'pagination'): ?>
						<div class="row">
						    <div class="col-md-12 text-center">
						        <?php echo $data; ?>
						    </div>
						</div>
				  	<?php endif; ?>
				<?php endforeach; ?>
		  	</div>
	  	<?php endforeach; ?>
  </div>

</div>
