<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class bibliotecaModel extends mainModel{

		/*----------  Add biblioteca Model  ----------*/
		public function add_biblioteca_model($data){
			$query=self::connect()->prepare("INSERT INTO biblioteca(Titulo,Autor,Tutor,Adjuntos) VALUES(:Titulo,:Autor,:Tutor,:Adjuntos)");

			$query->bindParam(":Titulo",$data['Titulo']);
            $query->bindParam(":Autor",$data['Autor']);
			$query->bindParam(":Tutor",$data['Tutor']);
			$query->bindParam(":Adjuntos",$data['Adjuntos']);
			$query->execute();
			return $query;
		}


		/*----------  Data biblioteca Model  ----------*/
		public function data_biblioteca_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT idbiblioteca FROM biblioteca");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM biblioteca WHERE idbiblioteca=:idbiblioteca");
				$query->bindParam(":idbiblioteca",$data['id']);
			}
			$query->execute();
			return $query;
		}


		/*----------  Delete biblioteca Model  ----------*/
		public function delete_biblioteca_model($code){
			$query=self::connect()->prepare("DELETE FROM biblioteca WHERE idbiblioteca=:idbiblioteca");
			$query->bindParam(":idbiblioteca",$code);
			$query->execute();
			return $query;
		}


		/*----------  Update biblioteca Model  ----------*/
		public function update_biblioteca_model($data){
			$query=self::connect()->prepare("UPDATE biblioteca SET Titulo=:Titulo,Autor=:Autor,Tutor=:Tutor,Adjuntos=:Adjuntos WHERE idbiblioteca=:idbiblioteca");
			$query->bindParam(":Titulo",$data['Titulo']);
            $query->bindParam(":Autor",$data['Autor']);
			$query->bindParam(":Tutor",$data['Tutor']);
			$query->bindParam(":Adjuntos",$data['Adjuntos']);
			$query->bindParam(":idbiblioteca",$data['id']);
			$query->execute();
			return $query;
		}
	}