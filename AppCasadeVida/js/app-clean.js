// Main Application Controller - Versión Limpia para Supabase
class AppController {
    constructor() {
        this.currentPage = 'dashboard';
        this.init();
    }

    async init() {
        // Esperar a que Supabase esté inicializado
        await this.waitForSupabase();
        
        // Initialize tooltips
        this.initTooltips();
        
        // Setup event listeners
        this.setupEventListeners();
        
        // Initialize notification system
        this.initNotificationSystem();
        
        // Load initial data
        await this.loadInitialData();
    }

    async waitForSupabase() {
        let attempts = 0;
        const maxAttempts = 10;
        
        while (!window.supabaseClient && attempts < maxAttempts) {
            await new Promise(resolve => setTimeout(resolve, 500));
            attempts++;
        }
        
        if (!window.supabaseClient) {
            console.error('Supabase client no pudo inicializarse');
            this.showMessage('Error: No se pudo conectar con la base de datos', 'error');
            return false;
        }
        
        return true;
    }

    initTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    setupEventListeners() {
        // Handle navigation clicks
        document.addEventListener('click', (e) => {
            if (e.target.closest('.nav-link')) {
                e.preventDefault();
                const href = e.target.closest('.nav-link').getAttribute('href');
                if (href && href !== '#') {
                    this.loadPage(href.substring(1));
                }
            }
        });

        // Handle form submissions
        document.addEventListener('submit', (e) => {
            if (e.target.closest('.crud-form')) {
                e.preventDefault();
                this.handleFormSubmit(e.target);
            }
        });

        // Handle modal events
        document.addEventListener('hidden.bs.modal', (e) => {
            this.resetModalForm(e.target);
        });
    }

    async loadInitialData() {
        try {
            // Cargar estadísticas iniciales
            await this.loadDashboardData();
        } catch (error) {
            console.error('Error cargando datos iniciales:', error);
        }
    }

    async loadDashboardData() {
        try {
            const statsResult = await window.db.getEstadisticas();
            if (statsResult.success) {
                this.updateDashboardStats(statsResult.data);
            }
        } catch (error) {
            console.error('Error cargando estadísticas:', error);
        }
    }

    updateDashboardStats(stats) {
        if (!stats) return;
        
        // Actualizar tarjetas de estadísticas
        const elements = {
            totalUsuarios: document.getElementById('stat-usuarios'),
            totalCasas: document.getElementById('stat-casas'),
            totalMiembros: document.getElementById('stat-miembros'),
            totalReuniones: document.getElementById('stat-reuniones')
        };

        Object.keys(elements).forEach(key => {
            if (elements[key]) {
                elements[key].textContent = stats[key] || 0;
            }
        });
    }

    async handleFormSubmit(form) {
        try {
            const formData = new FormData(form);
            const action = form.getAttribute('data-action');
            const data = Object.fromEntries(formData.entries());

            switch (action) {
                case 'create-usuario':
                    await this.createUsuario(data);
                    break;
                case 'create-casa-vida':
                    await this.createCasaVida(data);
                    break;
                case 'create-miembro':
                    await this.createMiembro(data);
                    break;
                default:
                    console.warn('Acción no manejada:', action);
            }
        } catch (error) {
            console.error('Error en formulario:', error);
            this.showMessage('Error al procesar el formulario', 'error');
        }
    }

    async createUsuario(data) {
        try {
            const result = await window.db.createUsuario({
                nombre: data.nombre,
                email: data.email,
                rol: data.rol,
                password_hash: this.hashPassword(data.password),
                telefono: data.telefono,
                activo: true
            });

            if (result.success) {
                this.showMessage('Usuario creado exitosamente', 'success');
                this.closeModal();
                await this.loadUsuarios();
            } else {
                this.showMessage(result.error, 'error');
            }
        } catch (error) {
            console.error('Error creando usuario:', error);
            this.showMessage('Error al crear usuario', 'error');
        }
    }

    async createCasaVida(data) {
        try {
            const result = await window.db.createCasaVida({
                nombre: data.nombre,
                direccion: data.direccion,
                dia_reunion: data.dia_reunion,
                hora_reunion: data.hora_reunion,
                capacidad_maxima: parseInt(data.capacidad_maxima) || 15,
                activa: true
            });

            if (result.success) {
                this.showMessage('Casa de vida creada exitosamente', 'success');
                this.closeModal();
                await this.loadCasasVida();
            } else {
                this.showMessage(result.error, 'error');
            }
        } catch (error) {
            console.error('Error creando casa de vida:', error);
            this.showMessage('Error al crear casa de vida', 'error');
        }
    }

    async createMiembro(data) {
        try {
            const result = await window.db.createMiembro({
                nombre: data.nombre,
                email: data.email,
                telefono: data.telefono,
                fecha_nacimiento: data.fecha_nacimiento,
                direccion: data.direccion,
                id_casa_vida: data.id_casa_vida ? parseInt(data.id_casa_vida) : null,
                activo: true
            });

            if (result.success) {
                this.showMessage('Miembro creado exitosamente', 'success');
                this.closeModal();
                await this.loadMiembros();
            } else {
                this.showMessage(result.error, 'error');
            }
        } catch (error) {
            console.error('Error creando miembro:', error);
            this.showMessage('Error al crear miembro', 'error');
        }
    }

    hashPassword(password) {
        // Hash simple para demostración (en producción usar bcrypt)
        let hash = 0;
        for (let i = 0; i < password.length; i++) {
            const char = password.charCodeAt(i);
            hash = ((hash << 5) - hash) + char;
            hash = hash & hash;
        }
        return hash.toString();
    }

    closeModal() {
        const modals = document.querySelectorAll('.modal.show');
        modals.forEach(modal => {
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) {
                modalInstance.hide();
            }
        });
    }

    resetModalForm(modal) {
        const form = modal.querySelector('form');
        if (form) {
            form.reset();
        }
    }

    showMessage(message, type = 'info') {
        // Crear toast notification
        const toastHtml = `
            <div class="toast align-items-center text-white bg-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'} border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;

        // Crear toast container si no existe
        let toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toastContainer';
            toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            document.body.appendChild(toastContainer);
        }

        // Agregar toast al container
        const toastElement = document.createElement('div');
        toastElement.innerHTML = toastHtml;
        toastContainer.appendChild(toastElement.firstElementChild);

        // Mostrar toast
        const toast = new bootstrap.Toast(toastContainer.lastElementChild);
        toast.show();

        // Remover toast después de ocultarse
        toastContainer.lastElementChild.addEventListener('hidden.bs.toast', () => {
            toastContainer.removeChild(toastContainer.lastElementChild);
        });
    }

    // Métodos de carga de páginas
    async loadUsuarios() {
        try {
            const result = await window.db.getUsuarios();
            if (result.success) {
                this.renderUsuariosTable(result.data);
            } else {
                this.showMessage(result.error, 'error');
            }
        } catch (error) {
            console.error('Error cargando usuarios:', error);
            this.showMessage('Error al cargar usuarios', 'error');
        }
    }

    async loadDashboard() {
        try {
            const contentArea = document.getElementById('contentArea');
            if (!contentArea) return;
            
            // Cargar dashboard limpio
            contentArea.innerHTML = '<div id="dashboardContent"></div>';
            
            const dashboard = new DashboardController();
        } catch (error) {
            console.error('Error cargando dashboard:', error);
            this.showMessage('Error al cargar dashboard', 'error');
        }
    }

    async loadCasasVida() {
        try {
            const result = await window.db.getCasasVida();
            if (result.success) {
                this.renderCasasVidaTable(result.data);
            } else {
                this.showMessage(result.error, 'error');
            }
        } catch (error) {
            console.error('Error cargando casas de vida:', error);
            this.showMessage('Error al cargar casas de vida', 'error');
        }
    }

    async loadMiembros() {
        try {
            const result = await window.db.getMiembros();
            if (result.success) {
                this.renderMiembrosTable(result.data);
            } else {
                this.showMessage(result.error, 'error');
            }
        } catch (error) {
            console.error('Error cargando miembros:', error);
            this.showMessage('Error al cargar miembros', 'error');
        }
    }

    renderUsuariosTable(usuarios) {
        const contentArea = document.getElementById('contentArea');
        if (!contentArea) return;

        let html = `
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Gestión de Usuarios</h2>
                <button class="btn btn-primary" onclick="app.showCreateUsuarioModal()">
                    <i class="fas fa-plus me-2"></i>Nuevo Usuario
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Teléfono</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
        `;

        usuarios.forEach(usuario => {
            html += `
                <tr>
                    <td>${usuario.id}</td>
                    <td>${usuario.nombre}</td>
                    <td>${usuario.email}</td>
                    <td><span class="badge bg-primary">${usuario.rol}</span></td>
                    <td>${usuario.telefono || '-'}</td>
                    <td><span class="badge bg-${usuario.activo ? 'success' : 'danger'}">${usuario.activo ? 'Activo' : 'Inactivo'}</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" onclick="app.editUsuario(${usuario.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="app.deleteUsuario(${usuario.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        html += `
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;

        contentArea.innerHTML = html;
    }

    renderCasasVidaTable(casasVida) {
        const contentArea = document.getElementById('contentArea');
        if (!contentArea) return;

        let html = `
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Gestión de Casas de Vida</h2>
                <button class="btn btn-primary" onclick="app.showCreateCasaVidaModal()">
                    <i class="fas fa-plus me-2"></i>Nueva Casa de Vida
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Día</th>
                                    <th>Hora</th>
                                    <th>Líder</th>
                                    <th>Capacidad</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
        `;

        casasVida.forEach(casa => {
            html += `
                <tr>
                    <td>${casa.id}</td>
                    <td>${casa.nombre}</td>
                    <td>${casa.direccion || '-'}</td>
                    <td>${casa.dia_reunion}</td>
                    <td>${casa.hora_reunion}</td>
                    <td>${casa.lider?.nombre || '-'}</td>
                    <td>${casa.capacidad_maxima}</td>
                    <td><span class="badge bg-${casa.activa ? 'success' : 'danger'}">${casa.activa ? 'Activa' : 'Inactiva'}</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" onclick="app.editCasaVida(${casa.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="app.deleteCasaVida(${casa.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        html += `
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;

        contentArea.innerHTML = html;
    }

    renderMiembrosTable(miembros) {
        const contentArea = document.getElementById('contentArea');
        if (!contentArea) return;

        let html = `
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Gestión de Miembros</h2>
                <button class="btn btn-primary" onclick="app.showCreateMiembroModal()">
                    <i class="fas fa-plus me-2"></i>Nuevo Miembro
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Casa de Vida</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
        `;

        miembros.forEach(miembro => {
            html += `
                <tr>
                    <td>${miembro.id}</td>
                    <td>${miembro.nombre}</td>
                    <td>${miembro.email || '-'}</td>
                    <td>${miembro.telefono || '-'}</td>
                    <td>${miembro.casa_vida?.nombre || '-'}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" onclick="app.editMiembro(${miembro.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="app.deleteMiembro(${miembro.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        html += `
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;

        contentArea.innerHTML = html;
    }

    showCreateUsuarioModal() {
        // Implementar modal para crear usuario
        this.showMessage('Función de crear usuario en desarrollo', 'info');
    }

    showCreateCasaVidaModal() {
        // Implementar modal para crear casa de vida
        this.showMessage('Función de crear casa de vida en desarrollo', 'info');
    }

    showCreateMiembroModal() {
        // Implementar modal para crear miembro
        this.showMessage('Función de crear miembro en desarrollo', 'info');
    }

    editUsuario(id) {
        this.showMessage(`Editar usuario ${id} - función en desarrollo`, 'info');
    }

    editCasaVida(id) {
        this.showMessage(`Editar casa de vida ${id} - función en desarrollo`, 'info');
    }

    editMiembro(id) {
        this.showMessage(`Editar miembro ${id} - función en desarrollo`, 'info');
    }

    async deleteUsuario(id) {
        if (confirm('¿Estás seguro de eliminar este usuario?')) {
            // Implementar eliminación
            this.showMessage('Función de eliminar usuario en desarrollo', 'info');
        }
    }

    async deleteCasaVida(id) {
        if (confirm('¿Estás seguro de eliminar esta casa de vida?')) {
            // Implementar eliminación
            this.showMessage('Función de eliminar casa de vida en desarrollo', 'info');
        }
    }

    async deleteMiembro(id) {
        if (confirm('¿Estás seguro de eliminar este miembro?')) {
            // Implementar eliminación
            this.showMessage('Función de eliminar miembro en desarrollo', 'info');
        }
    }
}

// Inicializar la aplicación cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', async () => {
    window.app = new AppController();
});
