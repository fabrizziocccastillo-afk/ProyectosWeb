// CRUD Operations and UI Functions
class CRUDManager {
    constructor() {
        this.modals = {};
        this.init();
    }

    init() {
        this.createModals();
    }

    createModals() {
        // Create modals for each entity
        const entities = [
            'iglesia', 'rol', 'usuario', 'territorio', 
            'casaVida', 'integrante', 'enseñanza', 'tarea'
        ];

        entities.forEach(entity => {
            this.createModalForEntity(entity);
        });
    }

    createModalForEntity(entity) {
        const modalId = `${entity}Modal`;
        const modalHtml = this.getModalTemplate(entity);
        
        // Add modal to body if it doesn't exist
        if (!document.getElementById(modalId)) {
            document.body.insertAdjacentHTML('beforeend', modalHtml);
        }
    }

    getModalTemplate(entity) {
        const templates = {
            iglesia: `
                <div class="modal fade" id="iglesiaModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Iglesia</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form class="crud-form" data-table="iglesias">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Nombre</label>
                                                <input type="text" class="form-control" name="nombre" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Teléfono</label>
                                                <input type="tel" class="form-control" name="telefono">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Dirección</label>
                                        <input type="text" class="form-control" name="direccion">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Pastor</label>
                                                <input type="text" class="form-control" name="pastor">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Ubicación GPS</label>
                                                <input type="text" class="form-control" name="ubicacionGps" placeholder="Latitud, Longitud">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Estado</label>
                                        <select class="form-control" name="estado">
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="saveForm('iglesiaModal')">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            `,
            rol: `
                <div class="modal fade" id="rolModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Rol</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form class="crud-form" data-table="roles">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre del Rol</label>
                                        <input type="text" class="form-control" name="nombre" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Estado</label>
                                        <select class="form-control" name="estado">
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="saveForm('rolModal')">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            `,
            territorio: `
                <div class="modal fade" id="territorioModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Territorio</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form class="crud-form" data-table="territorios">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre del Territorio</label>
                                        <input type="text" class="form-control" name="nombre" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Color</label>
                                        <input type="color" class="form-control" name="color">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Anciano Responsable</label>
                                        <select class="form-control" name="ancianoId" id="ancianoSelect">
                                            <option value="">Seleccione un anciano</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Estado</label>
                                        <select class="form-control" name="estado">
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="saveForm('territorioModal')">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            `,
            casaVida: `
                <div class="modal fade" id="casaVidaModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Casa de Vida</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form class="crud-form" data-table="casasVida">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Territorio</label>
                                                <select class="form-control" name="territorioId" id="territorioSelect">
                                                    <option value="">Seleccione un territorio</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Nombre de la Casa</label>
                                                <input type="text" class="form-control" name="nombre" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Líder</label>
                                                <select class="form-control" name="liderId" id="liderSelect">
                                                    <option value="">Seleccione un líder</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Anfitrión</label>
                                                <select class="form-control" name="anfitrionId" id="anfitrionSelect">
                                                    <option value="">Seleccione un anfitrión</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Dirección</label>
                                        <input type="text" class="form-control" name="direccion">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Ubicación GPS</label>
                                        <input type="text" class="form-control" name="ubicacionGps" placeholder="Latitud, Longitud">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Estado</label>
                                        <select class="form-control" name="estado">
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="saveForm('casaVidaModal')">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            `,
            integrante: `
                <div class="modal fade" id="integranteModal" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Integrante</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form class="crud-form" data-table="integrantes">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Nombres Completos</label>
                                                <input type="text" class="form-control" name="nombres" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Teléfono</label>
                                                <input type="tel" class="form-control" name="telefono">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Rol</label>
                                                <select class="form-control" name="rolId" id="rolIntegranteSelect">
                                                    <option value="">Seleccione un rol</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Casa de Vida</label>
                                                <select class="form-control" name="casaVidaId" id="casaVidaIntegranteSelect">
                                                    <option value="">Seleccione una casa de vida</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Dirección</label>
                                                <input type="text" class="form-control" name="direccion">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Sexo</label>
                                                <select class="form-control" name="sexo">
                                                    <option value="Masculino">Masculino</option>
                                                    <option value="Femenino">Femenino</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Edad</label>
                                                <input type="number" class="form-control" name="edad" min="1" max="120">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Fecha de Cumpleaños</label>
                                                <input type="date" class="form-control" name="fechaCumpleaños">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Foto</label>
                                                <input type="file" class="form-control" name="foto" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Curso Bíblico</label>
                                                <input type="text" class="form-control" name="cursoBiblico" placeholder="Ej: Básico, Intermedio">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Estado Curso</label>
                                                <select class="form-control" name="estadoCurso">
                                                    <option value="Activo">Activo</option>
                                                    <option value="Inactivo">Inactivo</option>
                                                    <option value="Completado">Completado</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Bautizado</label>
                                                <select class="form-control" name="bautizado">
                                                    <option value="No">No</option>
                                                    <option value="Si">Sí</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Estado</label>
                                        <select class="form-control" name="estado">
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="saveForm('integranteModal')">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            `,
            enseñanza: `
                <div class="modal fade" id="enseñanzaModal" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Enseñanza</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form class="crud-form" data-table="enseñanzas">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label class="form-label">Título</label>
                                                <input type="text" class="form-control" name="titulo" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Fecha</label>
                                                <input type="date" class="form-control" name="fecha" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Descripción</label>
                                        <textarea class="form-control" name="descripcion" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Archivo de Enseñanza</label>
                                        <div class="file-upload" id="fileUploadArea">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Arrastre un archivo aquí o haga clic para seleccionar</p>
                                            <input type="file" class="form-control" name="archivo" accept=".pdf,.doc,.docx,.ppt,.pptx,.mp4,.mp3" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Estado</label>
                                        <select class="form-control" name="estado">
                                            <option value="Activa">Activa</option>
                                            <option value="Inactiva">Inactiva</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="saveForm('enseñanzaModal')">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            `,
            tarea: `
                <div class="modal fade" id="tareaModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tarea</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form class="crud-form" data-table="tareas">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Líder Asignado</label>
                                                <select class="form-control" name="liderId" id="liderTareaSelect">
                                                    <option value="">Seleccione un líder</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Fecha Límite</label>
                                                <input type="date" class="form-control" name="fechaLimite">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Descripción de la Tarea</label>
                                        <textarea class="form-control" name="descripcion" rows="4" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Estado</label>
                                        <select class="form-control" name="estado">
                                            <option value="Pendiente">Pendiente</option>
                                            <option value="Iniciando">Iniciando</option>
                                            <option value="Terminada">Terminada</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Comentarios</label>
                                        <textarea class="form-control" name="comentarios" rows="3"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="saveForm('tareaModal')">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            `,
            usuario: `
                <div class="modal fade" id="usuarioModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form class="crud-form" data-table="usuarios">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Nombre Completo</label>
                                                <input type="text" class="form-control" name="nombre" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Usuario</label>
                                                <input type="text" class="form-control" name="username" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Contraseña</label>
                                                <input type="password" class="form-control" name="password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Rol</label>
                                                <select class="form-control" name="rolId" id="rolUsuarioSelect">
                                                    <option value="">Seleccione un rol</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Territorio</label>
                                                <select class="form-control" name="territorioId" id="territorioUsuarioSelect">
                                                    <option value="">Seleccione un territorio</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Casa de Vida</label>
                                                <select class="form-control" name="casaVidaId" id="casaVidaUsuarioSelect">
                                                    <option value="">Seleccione una casa de vida</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Estado</label>
                                        <select class="form-control" name="estado">
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="saveForm('usuarioModal')">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            `
        };

        return templates[entity] || '';
    }

    openModal(modalId, data = null) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        const form = modal.querySelector('.crud-form');
        if (data) {
            // Fill form with data for editing
            Object.keys(data).forEach(key => {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) {
                    input.value = data[key];
                }
            });
            form.dataset.action = 'update';
            form.dataset.id = data.id;
        } else {
            // Reset form for creating
            form.reset();
            form.dataset.action = 'create';
            delete form.dataset.id;
        }

        // Load select options
        this.loadSelectOptions(modalId);

        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }

    loadSelectOptions(modalId) {
        switch (modalId) {
            case 'territorioModal':
                this.loadAncianoOptions();
                break;
            case 'casaVidaModal':
                this.loadTerritorioOptions();
                this.loadLiderOptions();
                this.loadAnfitrionOptions();
                break;
            case 'integranteModal':
                this.loadRolOptions();
                this.loadCasaVidaOptions();
                break;
            case 'usuarioModal':
                this.loadRolOptions();
                this.loadTerritorioOptions();
                this.loadCasaVidaOptions();
                break;
            case 'tareaModal':
                this.loadLiderOptions();
                break;
        }
    }

    loadAncianoOptions() {
        const select = document.getElementById('ancianoSelect');
        if (!select) return;

        const ancianos = db.read('usuarios').filter(u => db.getRoleName(u.rolId) === 'Anciano');
        select.innerHTML = '<option value="">Seleccione un anciano</option>';
        ancianos.forEach(anciano => {
            select.innerHTML += `<option value="${anciano.id}">${anciano.nombre}</option>`;
        });
    }

    loadTerritorioOptions() {
        const selects = document.querySelectorAll('#territorioSelect, #territorioUsuarioSelect');
        selects.forEach(select => {
            if (!select) return;
            
            const territorios = db.read('territorios').filter(t => t.estado === 'Activo');
            select.innerHTML = '<option value="">Seleccione un territorio</option>';
            territorios.forEach(territorio => {
                select.innerHTML += `<option value="${territorio.id}">${territorio.nombre}</option>`;
            });
        });
    }

    loadLiderOptions() {
        const selects = document.querySelectorAll('#liderSelect, #liderTareaSelect');
        selects.forEach(select => {
            if (!select) return;
            
            const lideres = db.read('usuarios').filter(u => db.getRoleName(u.rolId) === 'Lider');
            select.innerHTML = '<option value="">Seleccione un líder</option>';
            lideres.forEach(lider => {
                select.innerHTML += `<option value="${lider.id}">${lider.nombre}</option>`;
            });
        });
    }

    loadAnfitrionOptions() {
        const select = document.getElementById('anfitrionSelect');
        if (!select) return;

        const anfitriones = db.read('usuarios').filter(u => db.getRoleName(u.rolId) === 'Anfitrion');
        select.innerHTML = '<option value="">Seleccione un anfitrión</option>';
        anfitriones.forEach(anfitrion => {
            select.innerHTML += `<option value="${anfitrion.id}">${anfitrion.nombre}</option>`;
        });
    }

    loadRolOptions() {
        const selects = document.querySelectorAll('#rolIntegranteSelect, #rolUsuarioSelect');
        selects.forEach(select => {
            if (!select) return;
            
            const roles = db.read('roles').filter(r => r.estado === 'Activo');
            select.innerHTML = '<option value="">Seleccione un rol</option>';
            roles.forEach(rol => {
                select.innerHTML += `<option value="${rol.id}">${rol.nombre}</option>`;
            });
        });
    }

    loadCasaVidaOptions() {
        const selects = document.querySelectorAll('#casaVidaIntegranteSelect, #casaVidaUsuarioSelect');
        selects.forEach(select => {
            if (!select) return;
            
            const casasVida = db.read('casasVida').filter(c => c.estado === 'Activo');
            select.innerHTML = '<option value="">Seleccione una casa de vida</option>';
            casasVida.forEach(casaVida => {
                select.innerHTML += `<option value="${casaVida.id}">${casaVida.nombre}</option>`;
            });
        });
    }

    deleteItem(table, id, itemName) {
        app.showConfirmDialog(
            `¿Está seguro de eliminar ${itemName}? Esta acción no se puede deshacer.`,
            () => {
                try {
                    db.delete(table, id);
                    auth.showMessage('Registro eliminado exitosamente', 'success');
                    app.refreshCurrentView();
                } catch (error) {
                    console.error('Delete error:', error);
                    auth.showMessage('Error al eliminar el registro', 'error');
                }
            }
        );
    }
}

// CRUD manager will be initialized in main.js

// Global functions for CRUD operations
function openModal(modalId, data = null) {
    crud.openModal(modalId, data);
}

function saveForm(modalId) {
    const modal = document.getElementById(modalId);
    const form = modal.querySelector('.crud-form');
    
    if (form.checkValidity()) {
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const table = form.dataset.table;
        const action = form.dataset.action || 'create';
        const id = form.dataset.id;

        try {
            let result;
            if (action === 'create') {
                result = db.create(table, data);
                auth.showMessage('Registro creado exitosamente', 'success');
            } else if (action === 'update') {
                result = db.update(table, id, data);
                auth.showMessage('Registro actualizado exitosamente', 'success');
            }

            bootstrap.Modal.getInstance(modal).hide();
            app.refreshCurrentView();

        } catch (error) {
            console.error('Save error:', error);
            auth.showMessage('Error al guardar el registro', 'error');
        }
    } else {
        form.reportValidity();
    }
}

function deleteItem(table, id, itemName) {
    crud.deleteItem(table, id, itemName);
}
