<?php

if (class_exists('ACFImage')) {
    return;
}

class ACFImage
{

    var $imageID = 0;
    public $outputHTML;
    public $outputUrl;
    public $size;
    public $class;

    function __construct( $img, $size = 'large', $class = 'img-fluid' )
    {
        $this->setImageID($img);
        $this->size = $size;
        $this->class = $class;

        $this->output();
    }

    /**
     * Image ID holen, egal welcher Rückgabewert in ACF definiert wurde.
     *
     * @param [type] $img
     * @return integer
     */
    function setImageID( $img ): int {

        if ( is_array($img) ) {
            $this->imageID = absint($img['ID']);
        }

        if ( is_int($img) ) {
            $this->imageID = absint($img);
        }

        if( is_string($img) ) {
            $this->imageID = attachment_url_to_postid($img);
        }

        return $this->imageID;
    }

    public function output() {
        if ($this->imageID) {
            $this->outputHTML = wp_get_attachment_image( $this->imageID, $this->size, false, [ 'class' => $this->class ] );
        }
    }

    public function outputUrl() {
        if ($this->imageID) {
            $this->outputUrl = wp_get_attachment_image_url($this->imageID, $this->size, false);
        }
    }
}


if( !function_exists('the_acf_image') ) {
    /**
     * Wrapper Funktion für die ACF Image Klasse
     *
     * @return void
     */
    function the_acf_image( $img, $size = 'large', $class = 'img-fluid' ){
        echo get_acf_image( $img, $size, $class );
    }
}

if( !function_exists('get_acf_image') ) {
    /**
     * Wrapper Funktion für die ACF Image Klasse
     *
     * @return void
     */
    function get_acf_image( $img, $size = 'large', $class = 'img-fluid' ){
        $imgClass = new ACFImage( $img, $size, $class );
        return $imgClass->outputHTML;
    }
}

if( !function_exists('get_acf_image_url') ) {
    /**
     * Wrapper Funktion für die ACF Image Klasse
     *
     * @return void
     */
    function get_acf_image_url( $img, $size = 'large', $class = 'img-fluid' ){
        $imgClass = new ACFImage( $img, $size, null );
        return $imgClass->outputUrl;
    }
}
