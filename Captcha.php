<?php
session_start();

class Captcha {

    function Captcha() {
        $this->img = imagecreatetruecolor(100, 20);
        $this->background_color = imagecolorallocate($this->img, 91, 91, 91);
        imagefilledrectangle($this->img, 0, 0, 100, 20, $this->background_color);
        $this->word = '';
     
    }

    function random_word($nb_letters) {

        $voyelles = array('a', 'e', 'i', 'o', 'u', 'y');
        $consonnes = array('b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'r', 's', 't', 'v', 'w',
            'br', 'bl', 'cr', 'ch', 'dr', 'fr', 'dr', 'fr', 'fl', 'gr', 'gl', 'pr', 'pl', 'ps', 'st', 'tr', 'vr');

        $word = '';
        $nv = count($voyelles);
        $nc = count($consonnes);
        for ($i = 0; $i < round($nb_letters / 2); $i++) {

            $word .= $voyelles[mt_rand(0, $nv)];
            $word .= $consonnes[mt_rand(0, $nc)];
            $this->word = $word;
            $_SESSION['captcha'] = $this->word;
        }

   //     On met le texte dans l image
        $text_color = imagecolorallocate($this->img, 255, 255, 255);
        imagestring($this->img, 7, 5, 5, $this->word, $text_color);
     
    }
    
        function flou_gaussien($nb_time) {
           $matrix_classical = array(
          array(1, 2, 1),
          array(2,4,2),
          array(1,2,1),
        );
           
           for ($i = 0; $i < $nb_time; $i++)
             imageconvolution($this->img, $matrix_classical, 16, 0);
    }
    
    function flou_classical($nb_time) {
           $matrix_classical = array(
          array(1, 1, 1),
          array(1,1,1),
          array(1,1,1),
        );
           
           for ($i = 0; $i < $nb_time; $i++)
             imageconvolution($this->img, $matrix_classical, 9, 0);
    }

    function save_img() {
        // Sauvegarde de l'image sous le nom 'simpletext.jpg'
        imagejpeg($this->img, 'captcha.jpg');

        // Libération de la mémoire
        imagedestroy($this->img);
        
    }

}
?>
