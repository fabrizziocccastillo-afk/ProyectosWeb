<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class agendaModel extends mainModel{

		/*----------  Add agenda Model  ----------*/
		public function add_agenda_model($data){
			$query=self::connect()->prepare("INSERT INTO agenda(titulo,imagen) VALUES(:Titulo,:Adjuntos)");

			$query->bindParam(":Titulo",$data['Titulo']);
            //$query->bindParam(":Autor",$data['Autor']);
			//$query->bindParam(":Tutor",$data['Tutor']);
			$query->bindParam(":Adjuntos",$data['Adjuntos']);
			$query->execute();
			return $query;
		}


		/*----------  Data agenda Model  ----------*/
		public function data_agenda_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT * FROM agenda");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM agenda WHERE idagenda=:idagenda");
				$query->bindParam(":idagenda",$data['id']);
			}
			$query->execute();
			return $query;
		}


		/*----------  Delete agenda Model  ----------*/
		public function delete_agenda_model($code){
			$query=self::connect()->prepare("DELETE FROM agenda WHERE idagenda=:idagenda");
			$query->bindParam(":idagenda",$code);
			$query->execute();
			return $query;
		}


		/*----------  Update agenda Model  ----------*/
		public function update_agenda_model($data){
			$query=self::connect()->prepare("UPDATE agenda SET Titulo=:Titulo,Autor=:Autor,Tutor=:Tutor,Adjuntos=:Adjuntos WHERE idagenda=:idagenda");
			$query->bindParam(":Titulo",$data['Titulo']);
            $query->bindParam(":Autor",$data['Autor']);
			$query->bindParam(":Tutor",$data['Tutor']);
			$query->bindParam(":Adjuntos",$data['Adjuntos']);
			$query->bindParam(":idagenda",$data['id']);
			$query->execute();
			return $query;
		}
	}