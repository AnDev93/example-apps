<?php
	class viewModel{
		/*--------- Modelo obtener vistas ---------*/
		protected static function get_view_model($view){
			$whiteList=[
				"dashboard",
                "user-add",
                "user-list"
			];
			if(in_array($view, $whiteList)){
				if(is_file("./view/content/".$view."-view.php")){
					$content="./view/content/".$view."-view.php";
				}else{
					$content="404";
				}
			}elseif($view=="login" || $view=="index"){
				$content="login";
			}elseif($view=="recovery"){
				$content="recovery";
			}else{
                $content="404";
            }
			return $content;
		}
	}
    