                <h1 class="text-primary">Subir imagen</h1>
                        <form action="Backend/subir.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="my-input">Seleccione una Imagen</label>
                            <input id="my-input"  type="file" name="imagen">
                        </div>
                        <div class="form-group">
                            <label for="my-input">Titulo de la Imagen</label>
                            <input id="my-input" class="form-control" type="text" name="titulo">
                        </div>
                        <?php if(isset($_SESSION['mensaje'])){ ?>
                        <div class="alert alert-<?php echo $_SESSION['tipo'] ?> alert-dismissible fade show" role="alert">
                        <strong><?php echo $_SESSION['mensaje']; ?></strong> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                        <?php session_unset(); } ?>
                        <input type="submit" value="Guardar" class="btn btn-primary" name="Guardar">
                        </form>
                    </div>
                    <div class="col-lg-8">
                        <h1 class="text-primary text-center">Galeria de Imagenes</h1>
                        <hr>
                        <div class="card-columns">
                            <?php //foreach($resultado as $row){ ?>
                        <div class="card">
                    <img src="Backend/imagenes/<?php echo $row['foto']; ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                    <h5 class="card-title"><strong><?php echo $row['foto']; ?></strong></h5>
                    </div>          
                </div>
                <?php //}?>
