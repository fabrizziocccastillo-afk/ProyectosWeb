<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class rubricaModel extends mainModel{

		/*----------  Add rubrica Model  ----------*/
		public function add_rubrica_model($data){
			$query=self::connect()->prepare("INSERT INTO rubrica(titulo,imagen) VALUES(:Titulo,:Adjuntos)");

			$query->bindParam(":Titulo",$data['Titulo']);
            //$query->bindParam(":Autor",$data['Autor']);
			//$query->bindParam(":Tutor",$data['Tutor']);
			$query->bindParam(":Adjuntos",$data['Adjuntos']);
			$query->execute();
			return $query;
		}


		/*----------  Data rubrica Model  ----------*/
		public function data_rubrica_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT * FROM rubrica");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM rubrica WHERE idrubrica=:idrubrica");
				$query->bindParam(":idrubrica",$data['id']);
			}
			$query->execute();
			return $query;
		}


		/*----------  Delete rubrica Model  ----------*/
		public function delete_rubrica_model($code){
			$query=self::connect()->prepare("DELETE FROM rubrica WHERE idrubrica=:idrubrica");
			$query->bindParam(":idrubrica",$code);
			$query->execute();
			return $query;
		}


		/*----------  Update rubrica Model  ----------*/
		public function update_rubrica_model($data){
			$query=self::connect()->prepare("UPDATE rubrica SET Titulo=:Titulo,Autor=:Autor,Tutor=:Tutor,Adjuntos=:Adjuntos WHERE idrubrica=:idrubrica");
			$query->bindParam(":Titulo",$data['Titulo']);
            $query->bindParam(":Autor",$data['Autor']);
			$query->bindParam(":Tutor",$data['Tutor']);
			$query->bindParam(":Adjuntos",$data['Adjuntos']);
			$query->bindParam(":idrubrica",$data['id']);
			$query->execute();
			return $query;
		}
	}