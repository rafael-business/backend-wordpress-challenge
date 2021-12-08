<?php
/**
 * A funcionalidade pública do plugin.
 *
 * @link       https://rafael.business
 * @since      1.0.0
 *
 * @package    Backend_Wordpress_Challenge
 * @subpackage Backend_Wordpress_Challenge/public
 */

/**
 * Define o nome do plugin, a versão e as demais funcionalidades.
 *
 * @package    Backend_Wordpress_Challenge
 * @subpackage Backend_Wordpress_Challenge/public
 * @author     Rafael dos Santos Pedro <contato@rafael.business>
 */
class Backend_Wordpress_Challenge_Public {

	/**
	 * Nome do plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    Nome do plugin.
	 */
	private $plugin_name;

	/**
	 * Versão do plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    Versão atual do plugin.
	 */
	private $version;

	/**
	 * Inicializa a classe e define suas propriedades.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       Nome do plugin.
	 * @param      string    $version    		Versão do plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Registra as folhas de estilo para o lado público do site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/backend-wordpress-challenge-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Registra o JavaScript para o lado público do site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/backend-wordpress-challenge-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Adiciona as informações do curso antes do conteúdo.
	 * Adiciona o formulário ou o botão depois do conteúdo.
	 * 
	 * @since    1.0.0
	 */
	public function bwc_content_filter( $content ) {
		
		if ( is_single() && is_main_query() && ( 'cursos_fuerza' === get_post_type( get_the_ID() ) ) ){

			$before 	= include 'partials/backend-wordpress-challenge-infos.php';
			$after 		= include 'partials/backend-wordpress-challenge-insc-form.php'; 
			$content 	= $before . $content . $after;
		}

		return $content;

	}

	/**
	 * Registra as rotas necessárias na API REST do WordPress para inserção e 
	 * verificação dos dados dos interessados.
	 *
	 * @since    1.0.0
	 */
	public function bwc_register_rest_routes_cursos_fuerza () {

		register_rest_route( 'cursos-fuerza', '/insert-interessado', array(
			'methods' => 'POST',
			'callback' => array( $this, 'bwc_insert_interessado' ),
			'permission_callback' => '__return_true'
		));

		register_rest_route( 'cursos-fuerza', '/verify-interessado', array(
			'methods' => 'POST',
			'callback' => array( $this, 'bwc_verify_interessado' ),
			'permission_callback' => '__return_true'
		));
	}

	/**
	 * Insere um interessado no banco.
	 *
	 * @since    1.0.0
	 */
	public function bwc_insert_interessado () {

		$has_data = ( '' === $_POST['nome'] || '' === $_POST['email'] ) ? false : true;
		if ( !$has_data ) : 
		return '{"code": "error", "message": "' . __( 'Você precisa preencher todos os campos!', 'backend-wordpress-challenge' ) . '"}';
		endif;

		$redirect = esc_attr( get_post_meta( $_POST['curso_id'], 'bwc_link_insc', true ) );
		if ( !$redirect ) : 
		return '{"code": "error", "message": "' . __( 'Parece que existe um erro no link de inscrição desse curso.', 'backend-wordpress-challenge' ) . '"}';
		endif;
		
		global $wpdb;
		$table = $wpdb->prefix . 'cursos_interessados';

		$data = array( 
			'curso_id' 	=> $_POST['curso_id'], 
			'nome' 		=> $_POST['nome'], 
			'email'		=> $_POST['email'] 
		);

		$format = array( '%d', '%s', '%s' );
		$wpdb->insert( $table, $data, $format );

		return $wpdb->insert_id ? 
		'{"code": "success", "message": "' . __( 'Seu interesse foi registrado com sucesso! Você está sendo redirecionado.', 'backend-wordpress-challenge' ) . '", "redirect": "'. $redirect .'"}' : 
		'{"code": "error", "message": "' . __( 'Ocorreu um erro com a sua inscrição!', 'backend-wordpress-challenge' ) . '"}';
	}

	/**
	 * Verifica se o interessado já registrou interesse no curso.
	 *
	 * @since    1.0.0
	 */
	public function bwc_verify_interessado () {

		if ( '' === $_POST['email'] ) {

			return '{"code": "error", "message": "' . __( 'Você precisa preencher todos os campos!', 'backend-wordpress-challenge' ) . '"}';
		}
		
		global $wpdb;
		$query = "SELECT * FROM `{$wpdb->prefix}cursos_interessados` WHERE curso_id = '{$_POST['curso_id']}' AND email = '{$_POST['email']}'";
		$list = $wpdb->get_results($query);

		return $list ? 
		'{"code": "error", "message": "' . __( 'E-mail já cadastrado!', 'backend-wordpress-challenge' ) . '"}' : 
		false;
	}

}
