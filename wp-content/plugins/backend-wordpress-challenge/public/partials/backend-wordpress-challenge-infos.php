<?php
/**
 * Informaçãoes sobre o curso na single.
 */

$carga_horaria = esc_attr( get_post_meta( get_the_ID(), 'bwc_carga_horaria', true ) );
$carga_horaria_html = __( 'Carga Horária: ', 'backend-wordpress-challenge' ) . $carga_horaria;

$bwc_data_limite = esc_attr( get_post_meta( get_the_ID(), 'bwc_data_limite', true ) );
$data_limite = date( 'd/m/Y', strtotime( $bwc_data_limite ) );
$insc_encerradas = '<strong>'. __( 'As inscrições já se encerraram!', 'backend-wordpress-challenge' ) .'</strong>';
$data_limite_html = strtotime( $bwc_data_limite ) > time() ? __( 'Data limite das Inscrições: ', 'backend-wordpress-challenge' ) . $data_limite : $insc_encerradas;

return '<p>'. $carga_horaria_html . '<br />' . $data_limite_html .'</p>';
