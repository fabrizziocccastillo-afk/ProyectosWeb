// View Functions for Each Screen
function loadDashboard() {
    const user = getCurrentUser();
    const stats = db.getDashboardStats(user.id);
    
    const content = `
        <div class="fade-in">
            <h2 class="mb-4">Dashboard</h2>
            
            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon primary">
                            <i class="fas fa-cross"></i>
                        </div>
                        <div class="stat-number">${stats.porBautizar}</div>
                        <div class="stat-label">Por Bautizar</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon success">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number">${stats.totalIntegrantes}</div>
                        <div class="stat-label">Total Integrantes</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon warning">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="stat-number">${stats.casasAsignadas}</div>
                        <div class="stat-label">Casas Asignadas</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon info">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="stat-number">${stats.notificacionesPendientes}</div>
                        <div class="stat-label">Notificaciones</div>
                    </div>
                </div>
            </div>

            <!-- Birthday List -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Cumpleañeros del Mes</h5>
                        </div>
                        <div class="card-body">
                            ${stats.cumpleañerosMes.length > 0 ? 
                                stats.cumpleañerosMes.map(integrante => `
                                    <div class="birthday-item">
                                        <img src="${integrante.foto || 'https://picsum.photos/seed/integrante/40/40'}" 
                                             class="birthday-avatar" alt="${integrante.nombres}">
                                        <div class="flex-grow-1">
                                            <strong>${integrante.nombres}</strong>
                                            <div class="text-muted small">
                                                ${app.formatDate(integrante.fechaCumpleaños)}
                                            </div>
                                        </div>
                                    </div>
                                `).join('') :
                                '<p class="text-muted">No hay cumpleañeros este mes</p>'
                            }
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Actividad Reciente</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>Última reunión</span>
                                    <strong>Hace 3 días</strong>
                                </div>
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>Nuevos integrantes</span>
                                    <strong>2 esta semana</strong>
                                </div>
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>Tareas completadas</span>
                                    <strong>5 este mes</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('contentArea').innerHTML = content;
}

function loadIglesias() {
    const iglesias = db.read('iglesias');
    
    const content = `
        <div class="fade-in">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Iglesias</h2>
                <button class="btn btn-primary" onclick="openModal('iglesiaModal')">
                    <i class="fas fa-plus me-2"></i>Nueva Iglesia
                </button>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Pastor</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${iglesias.map(iglesia => `
                                    <tr>
                                        <td><strong>${iglesia.nombre}</strong></td>
                                        <td>${iglesia.direccion || '-'}</td>
                                        <td>${iglesia.telefono || '-'}</td>
                                        <td>${iglesia.pastor || '-'}</td>
                                        <td>
                                            <span class="badge bg-${iglesia.estado === 'Activo' ? 'success' : 'secondary'}">
                                                ${iglesia.estado}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="openModal('iglesiaModal', ${JSON.stringify(iglesia).replace(/"/g, '&quot;')})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('iglesias', ${iglesia.id}, '${iglesia.nombre}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                        ${iglesias.length === 0 ? '<p class="text-center text-muted">No hay iglesias registradas</p>' : ''}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('contentArea').innerHTML = content;
}

function loadRoles() {
    const roles = db.read('roles');
    
    const content = `
        <div class="fade-in">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Roles</h2>
                <button class="btn btn-primary" onclick="openModal('rolModal')">
                    <i class="fas fa-plus me-2"></i>Nuevo Rol
                </button>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre del Rol</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${roles.map(rol => `
                                    <tr>
                                        <td><strong>${rol.nombre}</strong></td>
                                        <td>
                                            <span class="badge bg-${rol.estado === 'Activo' ? 'success' : 'secondary'}">
                                                ${rol.estado}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="openModal('rolModal', ${JSON.stringify(rol).replace(/"/g, '&quot;')})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('roles', ${rol.id}, '${rol.nombre}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                        ${roles.length === 0 ? '<p class="text-center text-muted">No hay roles registrados</p>' : ''}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('contentArea').innerHTML = content;
}

function loadUsuarios() {
    const usuarios = db.read('usuarios');
    
    const content = `
        <div class="fade-in">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Usuarios</h2>
                <button class="btn btn-primary" onclick="openModal('usuarioModal')">
                    <i class="fas fa-plus me-2"></i>Nuevo Usuario
                </button>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Usuario</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Territorio</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${usuarios.map(usuario => `
                                    <tr>
                                        <td><strong>${usuario.nombre}</strong></td>
                                        <td>${usuario.username}</td>
                                        <td>${usuario.email || '-'}</td>
                                        <td>
                                            <span class="badge bg-primary">${db.getRoleName(usuario.rolId)}</span>
                                        </td>
                                        <td>${usuario.territorioId ? db.getTerritoryName(usuario.territorioId) : '-'}</td>
                                        <td>
                                            <span class="badge bg-${usuario.estado === 'Activo' ? 'success' : 'secondary'}">
                                                ${usuario.estado}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="openModal('usuarioModal', ${JSON.stringify(usuario).replace(/"/g, '&quot;')})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('usuarios', ${usuario.id}, '${usuario.nombre}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                        ${usuarios.length === 0 ? '<p class="text-center text-muted">No hay usuarios registrados</p>' : ''}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('contentArea').innerHTML = content;
}

function loadTerritorios() {
    const territorios = db.read('territorios');
    
    const content = `
        <div class="fade-in">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Territorios</h2>
                <button class="btn btn-primary" onclick="openModal('territorioModal')">
                    <i class="fas fa-plus me-2"></i>Nuevo Territorio
                </button>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Color</th>
                                    <th>Anciano</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${territorios.map(territorio => `
                                    <tr>
                                        <td><strong>${territorio.nombre}</strong></td>
                                        <td>
                                            <span class="badge" style="background-color: ${territorio.color || '#667eea'}">
                                                <i class="fas fa-palette me-1"></i>
                                            </span>
                                        </td>
                                        <td>${territorio.ancianoId ? db.getUser(territorio.ancianoId)?.nombre : '-'}</td>
                                        <td>
                                            <span class="badge bg-${territorio.estado === 'Activo' ? 'success' : 'secondary'}">
                                                ${territorio.estado}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="openModal('territorioModal', ${JSON.stringify(territorio).replace(/"/g, '&quot;')})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('territorios', ${territorio.id}, '${territorio.nombre}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                        ${territorios.length === 0 ? '<p class="text-center text-muted">No hay territorios registrados</p>' : ''}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('contentArea').innerHTML = content;
}

function loadCasasVida() {
    const casasVida = db.read('casasVida');
    
    const content = `
        <div class="fade-in">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Casas de Vida</h2>
                <button class="btn btn-primary" onclick="openModal('casaVidaModal')">
                    <i class="fas fa-plus me-2"></i>Nueva Casa de Vida
                </button>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Territorio</th>
                                    <th>Líder</th>
                                    <th>Anfitrión</th>
                                    <th>Dirección</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${casasVida.map(casa => `
                                    <tr>
                                        <td><strong>${casa.nombre}</strong></td>
                                        <td>${casa.territorioId ? db.getTerritoryName(casa.territorioId) : '-'}</td>
                                        <td>${casa.liderId ? db.getUser(casa.liderId)?.nombre : '-'}</td>
                                        <td>${casa.anfitrionId ? db.getUser(casa.anfitrionId)?.nombre : '-'}</td>
                                        <td>${casa.direccion || '-'}</td>
                                        <td>
                                            <span class="badge bg-${casa.estado === 'Activo' ? 'success' : 'secondary'}">
                                                ${casa.estado}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="openModal('casaVidaModal', ${JSON.stringify(casa).replace(/"/g, '&quot;')})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('casasVida', ${casa.id}, '${casa.nombre}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                        ${casasVida.length === 0 ? '<p class="text-center text-muted">No hay casas de vida registradas</p>' : ''}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('contentArea').innerHTML = content;
}

function loadIntegrantes() {
    const user = getCurrentUser();
    let integrantes = db.read('integrantes');
    
    // Filter by user role
    if (user.rolNombre === 'Anciano') {
        integrantes = integrantes.filter(i => {
            const casaVida = db.read('casasVida').find(c => c.id == i.casaVidaId);
            return casaVida && casaVida.territorioId == user.territorioId;
        });
    } else if (user.rolNombre === 'Lider') {
        integrantes = integrantes.filter(i => i.casaVidaId == user.casaVidaId);
    }
    
    const content = `
        <div class="fade-in">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Integrantes</h2>
                <button class="btn btn-primary" onclick="openModal('integranteModal')">
                    <i class="fas fa-plus me-2"></i>Nuevo Integrante
                </button>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Rol</th>
                                    <th>Casa de Vida</th>
                                    <th>Bautizado</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${integrantes.map(integrante => `
                                    <tr>
                                        <td>
                                            <img src="${integrante.foto || 'https://picsum.photos/seed/integrante/40/40'}" 
                                                 class="rounded-circle" width="40" height="40" alt="${integrante.nombres}">
                                        </td>
                                        <td><strong>${integrante.nombres}</strong></td>
                                        <td>${integrante.telefono || '-'}</td>
                                        <td>
                                            <span class="badge bg-info">${db.getRoleName(integrante.rolId)}</span>
                                        </td>
                                        <td>${integrante.casaVidaId ? db.getCasaVidaName(integrante.casaVidaId) : '-'}</td>
                                        <td>
                                            <span class="badge bg-${integrante.bautizado === 'Si' ? 'success' : 'warning'}">
                                                ${integrante.bautizado}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-${integrante.estado === 'Activo' ? 'success' : 'secondary'}">
                                                ${integrante.estado}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="openModal('integranteModal', ${JSON.stringify(integrante).replace(/"/g, '&quot;')})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('integrantes', ${integrante.id}, '${integrante.nombres}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                        ${integrantes.length === 0 ? '<p class="text-center text-muted">No hay integrantes registrados</p>' : ''}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('contentArea').innerHTML = content;
}

function loadEnseñanzas() {
    const user = getCurrentUser();
    let enseñanzas = db.read('enseñanzas');
    
    // Only show active enseñanzas
    enseñanzas = enseñanzas.filter(e => e.estado === 'Activa');
    
    const content = `
        <div class="fade-in">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Enseñanzas</h2>
                ${hasPermission('Anciano') ? `
                    <button class="btn btn-primary" onclick="openModal('enseñanzaModal')">
                        <i class="fas fa-plus me-2"></i>Nueva Enseñanza
                    </button>
                ` : ''}
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        ${enseñanzas.map(enseñanza => `
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">${enseñanza.titulo}</h5>
                                        <p class="card-text">${enseñanza.descripcion || 'Sin descripción'}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">${app.formatDate(enseñanza.fecha)}</small>
                                            <div>
                                                ${enseñanza.archivo ? `
                                                    <button class="btn btn-sm btn-outline-primary" onclick="downloadFile('${enseñanza.archivo}')">
                                                        <i class="fas fa-download me-1"></i>Descargar
                                                    </button>
                                                ` : ''}
                                                ${hasPermission('Anciano') ? `
                                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('enseñanzas', ${enseñanza.id}, '${enseñanza.titulo}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                ` : ''}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                    ${enseñanzas.length === 0 ? '<p class="text-center text-muted">No hay enseñanzas disponibles</p>' : ''}
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('contentArea').innerHTML = content;
}

function loadTareas() {
    const user = getCurrentUser();
    let tareas = db.read('tareas');
    
    // Filter by user role
    if (user.rolNombre === 'Lider') {
        tareas = tareas.filter(t => t.liderId == user.id);
    }
    
    const content = `
        <div class="fade-in">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Tareas</h2>
                ${hasPermission('Anciano') ? `
                    <button class="btn btn-primary" onclick="openModal('tareaModal')">
                        <i class="fas fa-plus me-2"></i>Nueva Tarea
                    </button>
                ` : ''}
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Líder Asignado</th>
                                    <th>Fecha Límite</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${tareas.map(tarea => `
                                    <tr>
                                        <td><strong>${tarea.descripcion}</strong></td>
                                        <td>${tarea.liderId ? db.getUser(tarea.liderId)?.nombre : '-'}</td>
                                        <td>${tarea.fechaLimite ? app.formatDate(tarea.fechaLimite) : '-'}</td>
                                        <td>
                                            <span class="badge status-${tarea.estado.toLowerCase().replace(' ', '-')}">
                                                ${tarea.estado}
                                            </span>
                                        </td>
                                        <td>
                                            ${user.rolNombre === 'Lider' && tarea.estado !== 'Terminada' ? `
                                                <button class="btn btn-sm btn-outline-success" onclick="updateTaskStatus(${tarea.id}, 'Terminada')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            ` : ''}
                                            ${hasPermission('Anciano') ? `
                                                <button class="btn btn-sm btn-outline-primary" onclick="openModal('tareaModal', ${JSON.stringify(tarea).replace(/"/g, '&quot;')})">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('tareas', ${tarea.id}, '${tarea.descripcion}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            ` : ''}
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                        ${tareas.length === 0 ? '<p class="text-center text-muted">No hay tareas registradas</p>' : ''}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('contentArea').innerHTML = content;
}

function loadAsistencia() {
    const user = getCurrentUser();
    const asistencias = db.read('asistencias');
    
    const content = `
        <div class="fade-in">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Registro de Asistencia</h2>
                <button class="btn btn-primary" onclick="openAsistenciaForm()">
                    <i class="fas fa-plus me-2"></i>Nueva Asistencia
                </button>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Secuencial</th>
                                    <th>Fecha</th>
                                    <th>Casa de Vida</th>
                                    <th>Asistentes</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${asistencias.map(asistencia => `
                                    <tr>
                                        <td><strong>#${asistencia.id}</strong></td>
                                        <td>${app.formatDate(asistencia.fecha)}</td>
                                        <td>${asistencia.casaVidaId ? db.getCasaVidaName(asistencia.casaVidaId) : '-'}</td>
                                        <td>${asistencia.asistentes ? asistencia.asistentes.length : 0}</td>
                                        <td>${asistencia.totalIntegrantes || 0}</td>
                                        <td>
                                            <span class="badge bg-${asistencia.estado === 'Aprobada' ? 'success' : asistencia.estado === 'Pendiente' ? 'warning' : 'secondary'}">
                                                ${asistencia.estado}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewAsistencia(${asistencia.id})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            ${asistencia.estado !== 'Aprobada' ? `
                                                <button class="btn btn-sm btn-outline-success" onclick="approveAsistencia(${asistencia.id})">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            ` : ''}
                                            ${asistencia.estado === 'Aprobada' ? `
                                                <button class="btn btn-sm btn-outline-warning" onclick="reverseAsistencia(${asistencia.id})">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            ` : ''}
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('asistencias', ${asistencia.id}, 'Asistencia #${asistencia.id}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                        ${asistencias.length === 0 ? '<p class="text-center text-muted">No hay registros de asistencia</p>' : ''}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('contentArea').innerHTML = content;
}

function loadProfile() {
    const user = getCurrentUser();
    const userData = db.getUser(user.id);
    
    const content = `
        <div class="fade-in">
            <h2 class="mb-4">Mi Perfil</h2>
            
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="https://picsum.photos/seed/user/150/150" class="rounded-circle mb-3" width="150" height="150">
                            <h4>${user.nombre}</h4>
                            <p class="text-muted">${db.getRoleName(user.rolId)}</p>
                            <button class="btn btn-sm btn-outline-primary mt-2" onclick="showEditProfileModal()">
                                <i class="fas fa-edit me-1"></i>Editar Perfil
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Información Personal</h5>
                            ${!userData.email ? `
                                <span class="badge bg-warning">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Sin correo configurado
                                </span>
                            ` : ''}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Usuario:</strong> ${user.username}</p>
                                    <p><strong>Email:</strong> ${userData.email || 'No registrado'}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Rol:</strong> ${db.getRoleName(user.rolId)}</p>
                                    <p><strong>Estado:</strong> 
                                        <span class="badge bg-${userData.estado === 'Activo' ? 'success' : 'secondary'}">
                                            ${userData.estado}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            ${user.territorioId ? `
                                <p><strong>Territorio:</strong> ${db.getTerritoryName(user.territorioId)}</p>
                            ` : ''}
                            ${user.casaVidaId ? `
                                <p><strong>Casa de Vida:</strong> ${db.getCasaVidaName(user.casaVidaId)}</p>
                            ` : ''}
                            
                            ${!userData.email ? `
                                <div class="alert alert-warning mt-3">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Importante:</strong> Configura tu correo electrónico para poder restablecer tu contraseña en caso de que la olvides.
                                </div>
                            ` : `
                                <div class="alert alert-success mt-3">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Tu correo está configurado. Puedes usar "¿Olvidaste tu contraseña?" en la pantalla de login.
                                </div>
                            `}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('contentArea').innerHTML = content;
}

// Helper functions
function updateTaskStatus(taskId, newStatus) {
    db.update('tareas', taskId, { 
        estado: newStatus,
        fechaCulminacion: new Date().toISOString()
    });
    auth.showMessage('Tarea actualizada exitosamente', 'success');
    loadTareas();
}

function approveAsistencia(asistenciaId) {
    db.update('asistencias', asistenciaId, { estado: 'Aprobada' });
    auth.showMessage('Asistencia aprobada', 'success');
    loadAsistencia();
}

function reverseAsistencia(asistenciaId) {
    db.update('asistencias', asistenciaId, { estado: 'Pendiente' });
    auth.showMessage('Asistencia revertida', 'info');
    loadAsistencia();
}

function viewAsistencia(asistenciaId) {
    const asistencia = db.read('asistencias', asistenciaId);
    // Implementation for viewing attendance details
    auth.showMessage('Función de vista detallada en desarrollo', 'info');
}

function openAsistenciaForm() {
    // Implementation for attendance form
    auth.showMessage('Formulario de asistencia en desarrollo', 'info');
}

function downloadFile(filename) {
    // Implementation for file download
    auth.showMessage('Descarga de archivo en desarrollo', 'info');
}
