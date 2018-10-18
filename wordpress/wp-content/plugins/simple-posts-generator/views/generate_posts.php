<h2>Generate Posts</h2>

<div class="generate__msg">
	<?php echo $this->get_msg(); ?>
</div>

<form method="POST" action="" class="form" id="post" autocomplete="off">
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">
				<div id="titlediv">
					<div id="titlewrap">
						<span class="hint">use {{i}} as text to have an incrementing value in the title</span>
						<input type="text" id="title" name="generate_post_title" maxlength="35" value="Sample Post {{i}}" />
					</div>
					<div class="inside">
						<div id="edit-slug-box" class="hide-if-no-js"></div>
					</div>
				</div>

				<div id="wp-content-wrap">
					<?php echo wp_editor('', 'generate_post_content'); ?>
				</div>
			</div>

			<div id="postbox-container-1" class="postbox-container">
				<div id="side-sortables" class="meta-box-sortables ui-sortable">
					<div id="submitdiv" class="postbox">
						<h3 class="hndle ui-sortable-handle"><span>Generate Posts</span></h3>
						<div class="inside">
							<div class="submitbox" id="submitpost">
								<div id="minor-publishing">
									<div id="misc-publishing-actions">
										<div class="misc-pub-section misc-pub-post-status">
											<label for="generate_post_qty"># of Generated Posts:</label>
											<input type="text" id="generate_post_qty" name="generate_post_qty" maxlength="3" value="1" style="max-width: 120px; width: 100%; text-align: center;" />
										</div>
									</div>
								</div>
								<div id="major-publishing-actions">
									<div id="publishing-action">
										<input type="submit" class="button button-primary button-large" value="Generate Posts" name="generate_posts" />
									</div>
									<div class="clear"></div>
								</div>
							</div>
						</div>
					</div>

					<div class="postbox">
						<h3 class="hndle ui-sortable-handle"><span>Post Type</span></h3>
						<div class="inside">
							<div>
								<select id="generate_post_type" name="generate_post_type">
									<?php
										$post_types = get_post_types( '', 'names' );

										foreach($post_types as $post_type) {
											echo '<option>'. $post_type .'</option>';
										}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div id="postbox-container-2" class="postbox-container">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">
					
				</div>
			</div>			

		</div>
	</div>
</form>