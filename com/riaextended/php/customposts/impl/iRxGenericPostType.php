<?php

interface IRXGenericPostType{
	
	public function create($cptHelper, $settings);
	public function getSettings();
	public function getPostSlug();
}


?>