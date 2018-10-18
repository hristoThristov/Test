<div class="djpr-player">
	<div class="djpr-player-container">
		<div class="djpr-cover">
			<div class="djpr-plate">
				<img src="<?php echo DJPR_PLUGIN_URL . 'img/cover.png'; ?>" alt="">
			</div>
			<div class="djpr-cover-cont">
				<div class="djpr-song-info">

					<div class="djpr-play-audio">
						<audio src=""></audio>
					</div>

					<!-- <div class="type"></div> -->
					<div class="name"></div>

					<div class="djpr-controls">
						<div class="djpr-time">
							<div class="djpr-current-time">00:00</div>
							<div class="djpr-duration">00:00</div>
							<div class="djpr-clear"></div>
						</div>
						<div class="djpr-bar">
							<div class="djpr-progressbar ui-slider-handle"></div>
						</div>
						<div class="djpr-controls-cont">
							<div class="djpr-volume">
								<div class="djpr-volume-bar"></div>
								<div class="djpr-volume-controls">
									<i class="djpr djpr-sound"></i>
									<i class="djpr djpr-soundlow"></i>
									<i class="djpr djpr-soundnone"></i>
								</div>
							</div>

							<div class="djpr-navigation">
								<div class="djpr-rewind djpr-rewind-previous">
									<i class="djpr djpr-rewind-prev"></i>
									<p>-15</p>
								</div>

								<div class="djpr-prev">
									<i class="djpr djpr-previous"></i>
								</div>

								<div class="djpr-playbttn">
									<i class="djpr djpr-play"></i>
									<i class="djpr djpr-pause"></i>
								</div>

								<div class="djpr-next">
									<i class="djpr djpr-previous"></i>
								</div>

								<div class="djpr-rewind djpr-rewind-next">
									<i class="djpr djpr-rewind-prev"></i>
									<p>+30</p>
								</div>
							</div>
							<?php $djpr_download = get_option('djpr_options')['djpr_download']; ?>
							<?php if($djpr_download != ''){ ?>
							<div class="djpr-download-bttn">
								<a href="#" download>
									<i class="djpr djpr-download"></i>
								</a>
							</div>
							<?php } ?>
							<div class="clear"></div>
						</div>
					</div>
				</div>
					
				<div class="djpr-mobilelist-container">
					<div class="djpr-mobilelist">
						<div class="djpr-list">
							<div class="span"></div>
							<div class="span"></div>
							<div class="span"></div>
						</div>
						<p>Track List</p>
					</div>
				</div>
			</div>
		</div>
		<div class="djpr-playlist">
			<div class="djpr-cover-cont">
				<div class="djrp-list">
					
				<?php
					$djprPosts = new WP_Query(array('post_type' => 'djsong', 'posts_per_page'=>-1, 'order' => 'DESC', 'orderby' => 'date'));
					while ($djprPosts->have_posts()) :
					$djprPosts->the_post();

					if(get_post_meta(get_post()->ID, 'upload_djsong_external', true) != ''){
						$djpr_song_url = get_post_meta(get_post()->ID, 'upload_djsong_external', true);
					}else{
						$djpr_song_url_id = get_post_meta(get_post()->ID, 'upload_djsong_file', true);
						$djpr_song_url = wp_get_attachment_url($djpr_song_url_id);
					}
					if($djpr_song_url != ''){
				?>
					<div class="djpr-list-song" data-url="<?php echo $djpr_song_url; ?>">
						<div class="djpr-playpause">
							<i class="djpr djpr-pause-little"></i>
							<i class="djpr djpr-play-little"></i>
						</div>
						<p class="title"><?php the_title(); ?></p>
					</div>
				<?php
					}
					endwhile;
				?>

				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>