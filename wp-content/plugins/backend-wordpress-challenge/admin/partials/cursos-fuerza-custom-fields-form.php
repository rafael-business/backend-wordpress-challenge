<?php
/**
 * Campos personalizados na adição/edição de um "cursos_fuerza"
 */
?>

<div class="bwc_box">
    <p class="meta-options bwc_field">
        <label for="bwc_link_insc"><?php _e( 'Link de inscrição no curso', 'backend-wordpress-challenge' ); ?></label>
        <input 
            id="bwc_link_insc" 
            type="url" 
            name="bwc_link_insc" 
            value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'bwc_link_insc', true ) ); ?>" 
        >
    </p>
    <p class="meta-options bwc_field">
        <label for="bwc_carga_horaria"><?php _e( 'Carga Horária', 'backend-wordpress-challenge' ); ?></label>
        <input 
            id="bwc_carga_horaria" 
            type="number" 
            name="bwc_carga_horaria" 
            value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'bwc_carga_horaria', true ) ); ?>" 
        >
    </p>
    <p class="meta-options bwc_field">
        <label for="bwc_data_limite"><?php _e( 'Data limite de inscrições', 'backend-wordpress-challenge' ); ?></label>
        <input 
            id="bwc_data_limite" 
            type="date" 
            name="bwc_data_limite" 
            value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'bwc_data_limite', true ) ); ?>" 
        >
    </p>
</div>
