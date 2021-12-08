<?php
/**
 * As funcionalidades específicas do admin.
 *
 * @link       https://rafael.business
 * @since      1.0.0
 *
 * @package    Backend_Wordpress_Challenge
 * @subpackage Backend_Wordpress_Challenge/admin
 */

/**
 * Define o nome do plugin, a versão, e as funcionalidades do admin.
 *
 * @package    Backend_Wordpress_Challenge
 * @subpackage Backend_Wordpress_Challenge/admin
 * @author     Rafael dos Santos Pedro <contato@rafael.business>
 */
class Backend_Wordpress_Challenge_Admin {

	/**
	 * O nome do plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    O nome deste plugin.
	 */
	private $plugin_name;

	/**
	 * A versão do plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    A versão atual deste plugin.
	 */
	private $version;

	/**
	 * Inicializa a classe e seta as propriedades.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       O nome deste plugin.
	 * @param      string    $version    		A versão deste plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Registra os estilos usados no admin.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/backend-wordpress-challenge-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Registra o post type "Cursos Fuerza".
	 *
	 * @since    1.0.0
	 */
	public function bwc_register_cursos_fuerza_post_type() {
		
		$labels = array(
			'name'                  => _x( 'Cursos Fuerza', 'Post Type General Name', 'backend-wordpress-challenge' ),
			'singular_name'         => _x( 'Curso Fuerza', 'Post Type Singular Name', 'backend-wordpress-challenge' ),
			'menu_name'             => __( 'Cursos Fuerza', 'backend-wordpress-challenge' ),
			'name_admin_bar'        => __( 'Cursos Fuerza', 'backend-wordpress-challenge' ),
			'archives'              => __( 'Cursos - Arquivos', 'backend-wordpress-challenge' ),
			'attributes'            => __( 'Cursos - Atributos', 'backend-wordpress-challenge' ),
			'parent_item_colon'     => __( 'Curso Pai:', 'backend-wordpress-challenge' ),
			'all_items'             => __( 'Todos os Cursos', 'backend-wordpress-challenge' ),
			'add_new_item'          => __( 'Adicionar novo Curso', 'backend-wordpress-challenge' ),
			'add_new'               => __( 'Adicionar Novo', 'backend-wordpress-challenge' ),
			'new_item'              => __( 'Novo Curso', 'backend-wordpress-challenge' ),
			'edit_item'             => __( 'Editar Curso', 'backend-wordpress-challenge' ),
			'update_item'           => __( 'Atualizar Curso', 'backend-wordpress-challenge' ),
			'view_item'             => __( 'Ver Curso', 'backend-wordpress-challenge' ),
			'view_items'            => __( 'Ver Cursos', 'backend-wordpress-challenge' ),
			'search_items'          => __( 'Pesquisar Curso', 'backend-wordpress-challenge' ),
			'not_found'             => __( 'Nada encontrado', 'backend-wordpress-challenge' ),
			'not_found_in_trash'    => __( 'Nada encontrado na lixeira', 'backend-wordpress-challenge' ),
			'featured_image'        => __( 'Imagem em Destaque', 'backend-wordpress-challenge' ),
			'set_featured_image'    => __( 'Escolha uma imagem', 'backend-wordpress-challenge' ),
			'remove_featured_image' => __( 'Remover imagem de Destaque', 'backend-wordpress-challenge' ),
			'use_featured_image'    => __( 'Usar como imagem de Destaque', 'backend-wordpress-challenge' ),
			'insert_into_item'      => __( 'Inserir no Curso', 'backend-wordpress-challenge' ),
			'uploaded_to_this_item' => __( 'Upado para este curso', 'backend-wordpress-challenge' ),
			'items_list'            => __( 'Lista de Cursos', 'backend-wordpress-challenge' ),
			'items_list_navigation' => __( 'Lista de Navegação para Cursos', 'backend-wordpress-challenge' ),
			'filter_items_list'     => __( 'Lista de filtros para Cursos', 'backend-wordpress-challenge' ),
		);

		$args = array(
			'label'                 => __( 'Curso Fuerza', 'backend-wordpress-challenge' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 25,
			'menu_icon'             => 'dashicons-welcome-learn-more',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'show_in_rest'          => true,
		);

		register_post_type( 'cursos_fuerza', $args );
	
	}

	/**
	 * Registra os meta boxes na página de adição/edição dos cursos.
	 * 
	 * @since    1.0.0
	 */
	public function bwc_register_cursos_fuerza_meta_boxes() {

		add_meta_box( 
			'bwc-1', 
			__( 'Informações', 'backend-wordpress-challenge' ), 
			array( $this, 'bwc_display_cursos_fuerza_custom_fields' ), 
			'cursos_fuerza', 
			'side', 
			'low' 
		);

		add_meta_box( 
			'bwc-2', 
			__( 'Interessados', 'backend-wordpress-challenge' ), 
			array( $this, 'bwc_display_cursos_fuerza_interessados' ), 
			'cursos_fuerza'
		);

	}

	/**
	 * Mostra os campos personalizados na página de adição/edição dos cursos.
	 * 
	 * @since    1.0.0
	 * @param WP_Post $post Objeto do post atual.
	 */
	public function bwc_display_cursos_fuerza_custom_fields( $post ) {

		include plugin_dir_path( __FILE__ ) . './partials/cursos-fuerza-custom-fields-form.php';
	}

	/**
	 * Mostra a tabela de interessados na página de adição/edição dos cursos.
	 * 
	 * @since    1.0.0
	 * @param WP_Post $post Objeto do post atual.
	 */
	public function bwc_display_cursos_fuerza_interessados( $post ) {

		include plugin_dir_path( __FILE__ ) . './partials/cursos-fuerza-interessados.php';
	}

	/**
	 * Salva os campos personalizados.
	 * 
	 * @since    1.0.0
	 * @param int $post_id Post ID.
	 */
	public function bwc_save_cursos_fuerza_custom_fields( $post_id ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

		if ( $parent_id = wp_is_post_revision( $post_id ) ) {

			$post_id = $parent_id;
		}

		$fields = [
			'bwc_link_insc',
			'bwc_carga_horaria',
			'bwc_data_limite',
		];

		foreach ( $fields as $field ) {

			if ( array_key_exists( $field, $_POST ) ) {

				update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
			}
		}

	}

	/**
	 * Cria a coluna "Interessados" na visualização da lista dos cursos.
	 * 
	 * @since    1.0.0
	 * @param 	array 	$columns 	Lista de heads da tabela.
	 */
	public function bwc_cursos_fuerza_columns( $columns ) {

		$columns['interessados'] = __( 'Interessados', 'backend-wordpress-challenge' );
		return $columns;
	}

	/**
	 * Mostra o número de interessados na coluna "Interessados".
	 * 
	 * @since    1.0.0
	 * @param string 	$column 	Índice da coluna.
	 * @param int 		$post_id 	Post ID.
	 */
	public function bwc_cursos_fuerza_column( $column, $post_id ) {

		global $wpdb;
		$query = "SELECT * FROM `{$wpdb->prefix}cursos_interessados` WHERE curso_id = {$post_id}";
		$interessados = $wpdb->get_results($query);
		
		$n_interessados = $interessados ? count( $interessados ) : 0;
		if ( 'interessados' === $column ) echo $n_interessados; 
	}

}
