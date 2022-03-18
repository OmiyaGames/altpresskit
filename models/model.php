<?php

require 'helpers/filehelper.php';

class Model {

	protected $data;

	public $isDeveloper = false;

	public $images = array();
	public $icon;
	public $logo;
	public $header;
	
	public $logoZip;
	public $imageZip;

	public function __construct($directory, $data) {
		$this->data = $data;
		$this->images = FileHelper::getImages('data' . (strlen($directory) > 0 ? '/' : '') . $directory . '/images');

		if ($this->images != null) {
			foreach ($this->images as $folder => $images) {
				foreach ($images as $key => $image){
				
					if (Model::endsWith($image, 'logo.png') || Model::endsWith($image, 'logo.svg')) {
						$this->logo = $image;
						unset($this->images[$folder][$key]);
					}
					
					if (Model::endsWith($image, 'icon.png')) {
						$this->icon = $image;
					}

					if (Model::endsWith($image, 'header.png')) {
						$this->header = $image;
						unset($this->images[$folder][$key]);
					}

					if (Model::endsWith($image, 'images.zip')) {
						$this->imageZip = $image;
						unset($this->images[$folder][$key]);
					}

					if (Model::endsWith($image, 'logo.zip')) {
						$this->logoZip = $image;
						unset($this->images[$folder][$key]);
					}
				}
			}
		}

		if (!isset($this->icon)) $this->icon = $this->logo;
		if (!isset($this->header)) $this->header = $this->logo;
	}

	public function __get($param) {
		if (isset($this->data[$param])) {
			return $this->data[$param];
		} else {
			return null;
		}
	}

	public function __isset($param) {
		return isset($this->data[$param]);
	}

	private static function endsWith($haystack, $needle) {
		$length = strlen($needle);
		if ($length == 0) {
			return true;
		}

		return (substr($haystack, -$length) === $needle);
	}
}
?>
