<?php
error_reporting(E_ALL);
require('captcha.php');

	
	
	function contact() {
		
		global $page;
                $captcha = new Captcha();
                $captcha->random_word(6);
               // $captcha->flou_gaussien(1);
                $captcha->save_img();
		
	
	}
	
