<?php
function yiw_get_exclude_categories()
{
    $cats = get_option('id_cat_exclude');
    
    $cats = str_replace(" ", "", $cats);   // tolgo gli spazi che l'utente inserisce
    $cats = explode(",", $cats);           // divido le categorie tramite le virgole inserite
    
    $temp = array();
    foreach($cats as $cat)
    {
        $temp[] = $cat;              // metto tutte le categorie in un array temporaneo
    }
    
    // genero una nuova stringa con l'esclusione delle categorie passate in parametro, aggiugendo un meno davanti ad ogni numero (-1,-4,-7,ecc...)
    $i = 0; $query = '';
    foreach($temp as $c)
    {                                                                                                      
        if($i != 0) $query .= ',';    // aggiunge la virgola, soltanto se non è il primo elemento processato
        $query .= "-$c";
        
        $i++;
    }
    
    return $query;
}

function yiw_process($var)
{
    if(get_option($var['id']) != '')
    {
        return get_option($var['id']);
    }
    else
    {
        return $var['std'];
    }
}

function yiw_cleanArray($arr)
{
	$new_array = $arr;
	
	foreach($new_array as $key => $values)
	{
		if( is_array($values) )
		{
			foreach($values as $k => $v)
			{
				if( $k == 'order' OR $k == 'content_type' ) continue;
				                 
				if( !empty($v) AND !is_null($v) AND $v != '' AND $v != '0' AND $v != 'none' )
				{
					$clean = FALSE;
					break;  
				}
				else
				{
					$clean = TRUE;   
				}
			}	
			
			if( $clean ) unset( $new_array[$key] ); 
		}
		else return $new_array;
	}
	
	return $new_array;
}    

function yiw_num_( $from, $to )
{
	$r = array();
	
	for( $i = $from; $i <= $to; $i++ )
		$r[$i] = $i;
	
	return $r;
}                   

function get_list_forms( $addFirst = true )
{
	$forms = maybe_unserialize( get_option( 'bl_contact_forms', array() ) );
	$return = array();
	
	if( $addFirst )
		$return[''] = '';
	
	foreach( $forms as $form )
		$return[ sanitize_title( $form ) ] = $form;
	
	return $return;
}

function get_first_form()
{
	foreach( get_list_forms() as $id => $form )
		return $id;
}

function get_contact_form_shortcode()
{
	$name = get_option( 'bl_contact_form_choosen' );
	
	return '[contact_form id="' . $name . '"]';
}

function check_if_exists( $value, $array )
{
	$match = array();
	
	if( !in_array( $value, $array ) )
		return $value;
	else {
		if( !preg_match( '/([a-z]+)([0-9]+)/', $value, $match ) )
			$i = 1;
		else {
			$i = intval( $match[2] ) + 1;
			$value = $match[1];
		}
		return check_if_exists( $value . $i, $array );
	}
}
?>
