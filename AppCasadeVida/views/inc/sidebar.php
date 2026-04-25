<section class="full-box cover dashboard-sideBar">
	<div class="full-box dashboard-sideBar-bg btn-menu-dashboard"></div>
	<div class="full-box dashboard-sideBar-ct">
		<!--SideBar Title -->
		<div class="full-box text-uppercase text-center text-titles dashboard-sideBar-title">
			<?php echo COMPANY; ?> <i class="zmdi zmdi-close btn-menu-dashboard visible-xs"></i>
		</div>
		<!-- SideBar User info -->
		<div class="full-box dashboard-sideBar-UserInfo">
			<figure class="full-box">
				<img src="<?php echo SERVERURL; ?>views/assets/img/logo.png" alt="UserIcon">
				<figcaption class="text-center text-titles">USUARIO: <?php echo $_SESSION['userName']; ?></figcaption>
			</figure>
			<ul class="full-box list-unstyled text-center">
				<?php if($_SESSION['userType']=="Administrador"): ?>
				<li>
					<a href="<?php echo SERVERURL; ?>account/<?php echo $_SESSION['userKey']; ?>/">
						<i class="zmdi zmdi-settings"></i>
					</a>
				</li>
				<?php endif; ?>
				<li>
					<a href="#!" class="btnFormsAjax" id="logout" data-action="logout" data-id="form-logout">
						<i class="zmdi zmdi-power"></i>
						Salida
					</a>
				</li>
			</ul>
			<form action="" id="form-logout" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="token" value="<?php echo $_SESSION['userToken']; ?>">
			</form>
		</div>
		<!-- SideBar Menu -->
		<ul class="list-unstyled full-box dashboard-sideBar-Menu">
			<?php if($_SESSION['userType']=="Administrador"): ?>
			<li>
				<a href="<?php echo SERVERURL; ?>home/">
					<i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i> Tablero
				</a>
			</li>
			<!-- Seccion Usuarios -->
			<li> 
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-account zmdi-hc-fw"></i> Administradores<i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="<?php echo SERVERURL; ?>admin/">
								<i class="zmdi zmdi-account-add zmdi-hc-fw"></i> Nuevo
							</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL; ?>adminlist/">
								<i class="zmdi zmdi-accounts zmdi-hc-fw"></i> Listado
							</a>
						</li>
					</ul>
			</li>
			<li> 
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-accounts zmdi-hc-fw"></i> Grupos<i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
					<ul class="list-unstyled full-box">
					   <li>
					    <a href="<?php echo SERVERURL; ?>casasdevida/">
					    <i class="zmdi zmdi-home zmdi-hc-fw"></i> Casas
			            </a>
						</li>
						<!--<li>
							<a href="<?php// echo SERVERURL; ?>casasdevida/">
								<i class="zmdi zmdi-account-add zmdi-hc-fw"></i>  Nuevo
							</a>
						</li>
						<li>
							<a href="<?php //echo SERVERURL; ?>casasdevidalist/">
								<i class="zmdi zmdi-accounts zmdi-hc-fw"></i>  Listado
							</a>
						</li>-->
						<li>
						<a href="<?php echo SERVERURL; ?>torres/">
					    <i class="zmdi zmdi-pin zmdi-hc-fw"></i> Sector
						</a>
						</li>
						<!--<li>
							<a href="<?php //echo SERVERURL; ?>torres/">
								<i class="zmdi zmdi-account-add zmdi-hc-fw"></i>  Nuevo
							</a>
						</li>
						<li>
							<a href="<?php //echo SERVERURL; ?>torreslist/">
								<i class="zmdi zmdi-accounts zmdi-hc-fw"></i>  Listado
							</a>
						</li>-->
					</ul>
			</li>
			<li>
			    <a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-account zmdi-hc-fw"></i> Usuarios<i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
				<ul class="list-unstyled full-box">
						<li>
							<a href="<?php echo SERVERURL; ?>ROL/">
								<i class="zmdi zmdi-account-add zmdi-hc-fw"></i> Rol
							</a>
						</li>
						<!--<li>
							<a href="<?php //echo SERVERURL; ?>permiso/">
								<i class="zmdi zmdi-key zmdi-hc-fw"></i> Permisos
							</a>
						</li>
						<li>
							<a href="<?php //echo SERVERURL; ?>modulo/">
								<i class="zmdi zmdi-folder-person zmdi-hc-fw"></i> Modulo
							</a>
						</li>-->
						<li>
							<a href="<?php echo SERVERURL; ?>usuario/">
								<i class="zmdi zmdi-account zmdi-hc-fw"></i> Usuario
							</a>
						</li>
				</ul>
			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-view-agenda zmdi-hc-fw"></i> Agenda de Servicio<i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="<?php echo SERVERURL; ?>agenda/">
							<i class="zmdi zmdi-view-agenda zmdi-hc-fw"></i> Nuevo
						</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>agendalist/">
							<i class="zmdi zmdi-view-agenda zmdi-hc-fw"></i> Listado
						</a>
					</li>
				</ul>
			</li>
			</li>
			<!--<li> 
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-account zmdi-hc-fw"></i> Integrantes<i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="<?php //echo SERVERURL; ?>integrante/">
								<i class="zmdi zmdi-account-add zmdi-hc-fw"></i> Nuevo
							</a>
						</li>
						<li>
							<a href="<?php //echo SERVERURL; ?>integrantelist/">
								<i class="zmdi zmdi-accounts zmdi-hc-fw"></i> Listado
							</a>
						</li>
					</ul>
			</li>-->
			<!--<li> 
				<a href="#!" class="btn-sideBar-SubMenu">
				<i class="zmdi zmdi-account zmdi-hc-fw"></i> Estudiantes<i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="<?php //echo SERVERURL; ?>student/">
							<i class="zmdi zmdi-account-add zmdi-hc-fw"></i> Nuevo
						</a>
					</li>
					<li>
						<a href="<?php //echo SERVERURL; ?>studentlist/">
							<i class="zmdi zmdi-accounts zmdi-hc-fw"></i> Listado
						</a>
					</li>
				</ul>
			</li>
			 seccion CLases -->
			<!--<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-videocam zmdi-hc-fw"></i> Clases <i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="<?php //echo SERVERURL; ?>class/">
							<i class="zmdi zmdi-tv-alt-play zmdi-hc-fw"></i> Nueva
						</a>
					</li>
					<li>
						<a href="<?php //echo SERVERURL; ?>classlist/">
							<i class="zmdi zmdi-tv-list zmdi-hc-fw"></i> Listado
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-account-add zmdi-hc-fw"></i> Inscripciones <i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="<?php //echo SERVERURL; ?>inscripcion/">
							<i class="zmdi zmdi-account zmdi-hc-fw"></i> Nuevo
						</a>
					</li>
					<li>
						<a href="<?php //echo SERVERURL; ?>inscripcionlist/">
							<i class="zmdi zmdi-accounts zmdi-hc-fw"></i> Listado
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-accounts zmdi-hc-fw"></i> Asistencia <i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="<?php //echo SERVERURL; ?>EXCEL/principal.php">
							<i class="zmdi zmdi-male-female zmdi-hc-fw"></i> Listado
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-file-plus zmdi-hc-fw"></i> Evaluaciones <i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="<?php //echo SERVERURL; ?>evaluacion/">
							<i class="zmdi zmdi-file-text zmdi-hc-fw"></i> Nuevo
						</a>
					</li>
					<li>
						<a href="<?php //echo SERVERURL; ?>evaluacionlist/">
							<i class="zmdi zmdi-folder-person zmdi-hc-fw"></i> Listado
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-book zmdi-hc-fw"></i> Biblioteca<i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="<?php //echo SERVERURL; ?>biblioteca/">
							<i class="zmdi zmdi-book zmdi-hc-fw"></i> Nuevo
						</a>
					</li>
					<li>
						<a href="<?php //echo SERVERURL; ?>bibliotecalist/">
							<i class="zmdi zmdi-book zmdi-hc-fw"></i> Listado
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-view-agenda zmdi-hc-fw"></i> Agenda<i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="<?php //echo SERVERURL; ?>agenda/">
							<i class="zmdi zmdi-view-agenda zmdi-hc-fw"></i> Nuevo
						</a>
					</li>
					<li>
						<a href="<?php //echo SERVERURL; ?>agendalist/">
							<i class="zmdi zmdi-view-agenda zmdi-hc-fw"></i> Listado
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-library zmdi-hc-fw"></i> Rubrica<i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="<?php //echo SERVERURL; ?>rubrica/">
							<i class="zmdi zmdi-library zmdi-hc-fw"></i> Nuevo
						</a>
					</li>
					<li>
						<a href="<?php //echo SERVERURL; ?>rubricalist/">
							<i class="zmdi zmdi-library zmdi-hc-fw"></i> Listado
						</a>
					</li>
				</ul>
			</li>

			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-book zmdi-hc-fw"></i> Materia<i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="<?php //echo SERVERURL; ?>materia/">
							<i class="zmdi zmdi-book zmdi-hc-fw"></i> Nuevo
						</a>
					</li>
					<li>
						<a href="<?php //echo SERVERURL; ?>materialist/">
							<i class="zmdi zmdi-book zmdi-hc-fw"></i> Listado
						</a>
					</li>
				</ul>
			</li>-->
			<?php endif; ?>
			<?php if($_SESSION['userType']=="Estudiante"): ?>
			<!--<li>
				<a href="<?php //echo SERVERURL; ?>home/">
					<i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i> Inicio
				</a>
			</li>
			<li>
				<a href="<?php //echo SERVERURL; ?>studentData/">
					<i class="zmdi zmdi-account-box zmdi-hc-fw"></i> Datos
				</a>
			</li>
			<li>
				<a href="<?php //echo SERVERURL; ?>videonow/">
					<i class="zmdi zmdi-tv-play zmdi-hc-fw"></i> Clases de hoy
				</a>
			</li>
			<li>
				<a href="<?php //echo SERVERURL; ?>videolist/">
					<i class="zmdi zmdi-tv-list zmdi-hc-fw"></i> Listado de clases
				</a>
			</li>
			<li>
				<a href="<?php //echo SERVERURL; ?>clasemateria/">
					<i class="zmdi zmdi-layers zmdi-hc-fw"></i> Datos Academicos
				</a>
			</li>
			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-book zmdi-hc-fw"></i> Biblioteca<i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="<?php //echo SERVERURL; ?>bibliotecadescarga/">
							<i class="zmdi zmdi-book zmdi-hc-fw"></i> Libros
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="<?php //echo SERVERURL; ?>clasehistorial/">
					<i class="zmdi zmdi-layers zmdi-hc-fw"></i> Historial Academico
				</a>
			</li>
			<li>
				<a href="<?php //echo SERVERURL; ?>agendapublicada/">
					<i class="zmdi zmdi-view-agenda zmdi-hc-fw"></i> Agenda
				</a>
			</li>
			<li>
				<a href="<?php //echo SERVERURL; ?>rubricapublicada/">
					<i class="zmdi zmdi-library zmdi-hc-fw"></i> Rubrica
				</a>
			</li>
			<li>
				<a href="<?php //echo SERVERURL; ?>evaluacionformulario/" id="examen" >
					<i class="zmdi zmdi-format-list-bulleted zmdi-hc-fw"></i> Evaluaciones
				</a>
			</li>-->
			<?php endif; ?>
			<?php if($_SESSION['userType']=="UsuarioCDV"): ?>
			<li>
				<a href="<?php echo SERVERURL; ?>dashboard/">
					<i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i> Tablero
				</a>
			</li>
			<li> 
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-accounts-alt"></i> Integrantes<i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="<?php echo SERVERURL; ?>integrante/">
								<i class="zmdi zmdi-account-add zmdi-hc-fw"></i> Nuevo
							</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL; ?>integrantelist/">
								<i class="zmdi zmdi-accounts zmdi-hc-fw"></i> Listado
							</a>
						</li>
					</ul>
			</li>
			<li> 
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-assignment"></i> Asistencia<i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="<?php echo SERVERURL; ?>asistenciaint/">
								<i class="zmdi zmdi-account-add zmdi-hc-fw"></i> Nuevo
							</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL; ?>asistenciaintlist/">
								<i class="zmdi zmdi-accounts zmdi-hc-fw"></i> Listado
							</a>
						</li>
					</ul>
			</li>
			<li> 
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-print"></i> Reportes<i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="<?php echo SERVERURL; ?>reporteint/">
								<i class="zmdi zmdi-account-add zmdi-hc-fw"></i> Nuevo
							</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL; ?>reporteintlist/">
								<i class="zmdi zmdi-accounts zmdi-hc-fw"></i> Listado
							</a>
						</li>
					</ul>
			</li>
			<li> 
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-phone-msg"></i> Seguimientos<i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="<?php echo SERVERURL; ?>seguimientoint/">
								<i class="zmdi zmdi-account-add zmdi-hc-fw"></i> Nuevo
							</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL; ?>seguimientointlist/">
								<i class="zmdi zmdi-accounts zmdi-hc-fw"></i> Listado
							</a>
						</li>
					</ul>
			<li>
				<a href="<?php echo SERVERURL; ?>agendapublicada/">
					<i class="zmdi zmdi-view-agenda zmdi-hc-fw"></i> Agenda de Servicio
				</a>
			</li>

			<?php endif; ?>
		</ul>
	</div>
</section>