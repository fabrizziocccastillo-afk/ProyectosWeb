<?php
		if($actionsRequired){
			      require_once "../models/evaluacionformModel.php";
		}else{
		          require_once "./models/evaluacionformModel.php";   
		        }
    class evaluacionformController extends evaluacionformModel{
        public function data_evaluacionform_Controller($usuario,$code){
            $evaluacionformModel = new evaluacionformModel();
            $datosEvaluacion = $evaluacionformModel->show_evaluacionform_model($usuario,$code);
            return $datosEvaluacion;
        }

        public function data_preguntasform_Controller($usuario,$code){
            $preguntasformModel = new evaluacionformModel();
            $datosPreguntas = $preguntasformModel->show_preguntasform_model($usuario,$code);
            return $datosPreguntas;
        }

        public function data_respuestasform_Controller($usuario,$code){
            $respuestasformModel = new evaluacionformModel();
            $datosRespuestas = $respuestasformModel->show_respuestasform_model($usuario,$code);
            return $datosRespuestas;
        }
    }
?>