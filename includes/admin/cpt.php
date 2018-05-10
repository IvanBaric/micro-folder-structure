<?php


function tl_register_todo_cpt(){
    $labels = array(
        'name'               => _x( 'Todo', 'post type general name', 'my-todo-list' ),
        'singular_name'      => _x( 'Todo', 'post type singular name', 'my-todo-list' ),
        'menu_name'          => _x( 'Todos', 'admin menu', 'my-todo-list' ),
        'name_admin_bar'     => _x( 'Todo', 'add new on admin bar', 'my-todo-list' ),
        'add_new'            => _x( 'Add New', 'book', 'my-todo-list' ),
        'add_new_item'       => __( 'Add New Todo', 'my-todo-list' ),
        'new_item'           => __( 'New Todo', 'my-todo-list' ),
        'edit_item'          => __( 'Edit Todo', 'my-todo-list' ),
        'view_item'          => __( 'View Todo', 'my-todo-list' ),
        'all_items'          => __( 'All Todos', 'my-todo-list' ),
        'search_items'       => __( 'Search Todo', 'my-todo-list' ),
        'parent_item_colon'  => __( 'Parent Todos:', 'my-todo-list' ),
        'not_found'          => __( 'No todo found.', 'my-todo-list' ),
        'not_found_in_trash' => __( 'No todos found in Trash.', 'my-todo-list' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.', 'my-todo-list' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'todo' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array( 'title', 'author', 'thumbnail', 'excerpt', 'comments', 'featured-image' ),
        'taxonomies'         => array('category'),
        'menu_icon'          => 'dashicons-welcome-write-blog',
        'register_meta_box_cb' => function (){
            add_meta_box('tl_todo_fields', __('Todo Fields', 'my-todo-list'),'tl_todo_fields_callback', 'todo', 'normal', 'default');
        }

    );

    function tl_todo_fields_callback($post){
        wp_nonce_field(basename(__FILE__), 'wp_todos_nonce');

        $tl_todo_stored_meta = get_post_meta($post->ID);
        ?>
           			<div class="wrap todo-form">
				<div class="form-group">
					<label for="priority"><?php esc_html_e('Priority', 'my-todo-list'); ?></label>
					<select name="priority" id="priority">
						<?php
							$option_values = array('Low', 'Normal', 'High');
							foreach($option_values as $key => $value){
								if($value == $tl_todo_stored_meta['priority'][0]){
									?>
										<option selected><?php echo $value; ?></option>
									<?php
								} else {
									?>
										<option><?php echo $value; ?></option>
									<?php
								}
							}
						?>
					</select>
				</div>

				<div class="form-group">
					<label for="details"><?php esc_html_e('Details', 'my-todo-list'); ?></label>
					<?php
						$content = get_post_meta($post->ID, 'details', true);
						$editor = 'details';
						$settings = array(
							'textarea_rows' => 5,
							'media_buttons' => true
						);

						wp_editor($content, $editor, $settings);
					?>
				</div>

				<div class="form-group">
					<label for="due_date"><?php esc_html_e('Due Date', 'my-todo-list'); ?></label>
					<input type="date" name="due_date" id="due_date" value="<?php if(!empty($tl_todo_stored_meta['due_date'])) echo esc_attr($tl_todo_stored_meta['due_date'][0]); ?>">
				</div>
			</div>

                </div>
            </div>

        <?php
    }

    register_post_type( 'todo', $args );



}
add_action('init', 'tl_register_todo_cpt');


    function mtl_todos_save($post_id){
    	$post = get_post( $post_id );
    	$currentPostType = $post->post_type;

    	$listAllPostTypes = get_post_types();


    	if(!in_array($currentPostType, $listAllPostTypes)){
    	    !wp_die("File: ".__FILE__ ." <br/>Line:". __LINE__ ."<br/> Ne postoji PostType: " . $currentPostType, "Greška");
    	}

        if($currentPostType != 'todo'){
            return false;
        }

		$is_autosave = wp_is_post_autosave($post_id);
		$is_revision = wp_is_post_revision($post_id);
		$is_valid_nonce = (isset($_POST['wp_todos_nonce']) && wp_verify_nonce($_POST['wp_todos_nonce'], basename(__FILE__)))? 'true' : 'false';

		if($is_autosave || $is_revision || !$is_valid_nonce){
			return;
		}
		if(isset($_POST['priority'])){
			update_post_meta($post_id, 'priority', sanitize_text_field($_POST['priority']));
		}

		if(isset($_POST['details'])){
			update_post_meta($post_id, 'details', sanitize_text_field($_POST['details']));
		}

		if(isset($_POST['due_date'])){
			update_post_meta($post_id, 'due_date', sanitize_text_field($_POST['due_date']));
		}
	}

	add_action('save_post', 'mtl_todos_save');

