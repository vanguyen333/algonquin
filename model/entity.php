<?php
	class Entity{		

		private $id;
		private $name;
		private $birthate;
		private $image;
				
		function __construct($id, $name, $birthdate, $image){
			$this->setId($id);
			$this->setName($name);
			$this->setBirthdate($birthdate);
			$this->setImage($image);
			}		
		
		public function getName(){
			return $this->name;
		}
		
		public function setName($name){
			$this->name = $name;
		}
		
		public function getBirthdate(){
			return $this->birthdate;
		}
		
		public function setBirthdate($birthdate){
			$this->birthdate = $birthdate;
		}

		public function getImage(){
			return $this->image;
		}

		public function setImage($image){
			$this->image = $image;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

	}
?>