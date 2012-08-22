<?php

function thumb($image_path, $width, $height, $return_html = false)
{
    // Get the CodeIgniter super object
    $CI =& get_instance();

    // Path to image thumbnail
    $parts = explode('/', $image_path);
    $file_name = $parts[count($parts) - 1];
    $image_thumb = dirname($image_path) . '/' . $file_name . '_' . $width . 'x' . $height . '.jpg';

    if( ! file_exists($image_thumb))
    {
        // LOAD LIBRARY
        $CI->load->library('image_lib');

        // CONFIGURE IMAGE LIBRARY
        $config['image_library']    = 'GD2';
        $config['source_image']     = $image_path;
        $config['new_image']        = $image_thumb;
        $config['maintain_ratio']   = true;
        $config['height']           = $height;
        $config['width']            = $width;
        $CI->image_lib->initialize($config);
        $CI->image_lib->resize();
        $CI->image_lib->clear();
    }

    $thumb_path = BASE_URL . '/' . $image_thumb;

    if ($return_html == false)
    {
        return $thumb_path;
    }
    else
    {
        return img(array(
            'class' => 'thumbnail',
            'src'   => $thumb_path
        ));
    }

}

/* End of file image_helper.php */
/* Location: ./application/helpers/thumbnail_helper.php */