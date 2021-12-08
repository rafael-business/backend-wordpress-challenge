<?php
/**
 * Mostra a lista de interessados na página de edição do curso
 */
global $wpdb;
$query = "SELECT * FROM `{$wpdb->prefix}cursos_interessados` WHERE curso_id = {$_REQUEST['post']}";
$interessados = $wpdb->get_results($query);

if ( $interessados ) :

?>

<table class="interessados">
    <thead>
        <tr>
            <th><?php _e( 'Nome', 'backend-wordpress-challenge' ); ?></th>
            <th><?php _e( 'E-mail', 'backend-wordpress-challenge' ); ?></th>
            <th><?php _e( 'Data do interesse', 'backend-wordpress-challenge' ); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ( $interessados as $interessado ) : ?>
        <tr>
            <td><?= $interessado->nome ?></td>
            <td><?= $interessado->email ?></td>
            <td><?= date( 'd/m/Y à\s H:i', strtotime( $interessado->data_insc ) ) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
else : echo '<p>' . __( 'Não há interessados nesse curso ainda.', 'backend-wordpress-challenge' ) . '</p>';
endif;
