// Main Application Controller
class AppController {
    constructor() {
        this.currentPage = 'dashboard';
        this.init();
    }

    init() {
        // Initialize tooltips
        this.initTooltips();
        
        // Setup event listeners
        this.setupEventListeners();
        
        // Initialize notification system
        this.initNotificationSystem();
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

    initNotificationSystem() {
        // Check for new notifications every 30 seconds
        setInterval(() => {
            if (isLoggedIn()) {
                loadNotifications();
            }
        }, 30000);
    }

    handleFormSubmit(form) {
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

            // Close modal
            const modal = form.closest('.modal');
            if (modal) {
                bootstrap.Modal.getInstance(modal).hide();
            }

            // Refresh current view
            this.refreshCurrentView();

            // Create notification for relevant users
            this.createNotificationForAction(table, action, result);

        } catch (error) {
            console.error('Form submission error:', error);
            auth.showMessage('Error al procesar el formulario', 'error');
        }
    }

    createNotificationForAction(table, action, data) {
        let message = '';
        let targetUsers = [];

        switch (table) {
            case 'integrantes':
                message = `Nuevo integrante registrado: ${data.nombres}`;
                targetUsers = this.getUsersForNotification(['Pastor', 'Anciano', 'Lider']);
                break;
            case 'enseñanzas':
                message = `Nueva enseñanza disponible: ${data.titulo}`;
                targetUsers = this.getUsersForNotification(['Lider']);
                break;
            case 'asistencias':
                message = `Nuevo reporte de asistencia registrado`;
                targetUsers = this.getUsersForNotification(['Pastor', 'Anciano']);
                break;
            case 'tareas':
                message = `Nueva tarea asignada: ${data.descripcion}`;
                targetUsers = this.getUsersForNotification(['Lider']);
                break;
        }

        if (message) {
            targetUsers.forEach(userId => {
                db.createNotification(message, 'info', userId);
            });
        }
    }

    getUsersForNotification(roles) {
        return db.read('usuarios')
            .filter(user => roles.includes(db.getRoleName(user.rolId)))
            .map(user => user.id);
    }

    refreshCurrentView() {
        switch (this.currentPage) {
            case 'dashboard':
                showDashboard();
                break;
            case 'iglesias':
                showIglesias();
                break;
            case 'roles':
                showRoles();
                break;
            case 'usuarios':
                showUsuarios();
                break;
            case 'territorios':
                showTerritorios();
                break;
            case 'casasVida':
                showCasasVida();
                break;
            case 'integrantes':
                showIntegrantes();
                break;
            case 'enseñanzas':
                showEnseñanzas();
                break;
            case 'tareas':
                showTareas();
                break;
            case 'asistencia':
                showAsistencia();
                break;
        }
    }

    resetModalForm(modal) {
        const form = modal.querySelector('.crud-form');
        if (form) {
            form.reset();
            form.dataset.action = 'create';
            form.dataset.id = '';
        }
    }

    formatCurrency(amount) {
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP'
        }).format(amount);
    }

    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('es-CO');
    }

    formatDateTime(dateString) {
        const date = new Date(dateString);
        return date.toLocaleString('es-CO');
    }

    generateColorCode(index) {
        const colors = [
            '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', 
            '#FECA57', '#DDA0DD', '#98D8C8', '#F7DC6F'
        ];
        return colors[index % colors.length];
    }

    exportToCSV(data, filename) {
        const csv = this.convertToCSV(data);
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        
        link.setAttribute('href', url);
        link.setAttribute('download', filename);
        link.style.visibility = 'hidden';
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    convertToCSV(data) {
        if (!data || data.length === 0) return '';
        
        const headers = Object.keys(data[0]);
        const csvHeaders = headers.join(',');
        
        const csvRows = data.map(row => {
            return headers.map(header => {
                const value = row[header];
                return typeof value === 'string' && value.includes(',') 
                    ? `"${value}"` 
                    : value;
            }).join(',');
        });
        
        return [csvHeaders, ...csvRows].join('\n');
    }

    showConfirmDialog(message, onConfirm) {
        const modalHtml = `
            <div class="modal fade" id="confirmModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirmar Acción</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>${message}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" id="confirmBtn">Confirmar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal if any
        const existingModal = document.getElementById('confirmModal');
        if (existingModal) {
            existingModal.remove();
        }

        // Add new modal
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        const modalElement = document.getElementById('confirmModal');
        const modal = new bootstrap.Modal(modalElement);
        
        // Setup confirm button
        modalElement.querySelector('#confirmBtn').addEventListener('click', () => {
            onConfirm();
            modal.hide();
        });
        
        // Remove modal after hidden
        modalElement.addEventListener('hidden.bs.modal', () => {
            modalElement.remove();
        });
        
        modal.show();
    }
}

// App controller will be initialized in main.js

// Global functions for navigation
function showDashboard() {
    app.currentPage = 'dashboard';
    loadDashboard();
}

function showIglesias() {
    if (!hasPermission('Pastor')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    app.currentPage = 'iglesias';
    loadIglesias();
}

function showRoles() {
    if (!hasPermission('Pastor')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    app.currentPage = 'roles';
    loadRoles();
}

function showUsuarios() {
    if (!hasPermission('Pastor')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    app.currentPage = 'usuarios';
    loadUsuarios();
}

function showTerritorios() {
    if (!hasPermission('Anciano')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    app.currentPage = 'territorios';
    loadTerritorios();
}

function showCasasVida() {
    if (!hasPermission('Anciano')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    app.currentPage = 'casasVida';
    loadCasasVida();
}

function showIntegrantes() {
    if (!hasPermission('Anciano')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    app.currentPage = 'integrantes';
    loadIntegrantes();
}

function showEnseñanzas() {
    if (!hasPermission('Anciano')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    app.currentPage = 'enseñanzas';
    loadEnseñanzas();
}

function showTareas() {
    if (!hasPermission('Anciano')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    app.currentPage = 'tareas';
    loadTareas();
}

function showAsistencia() {
    if (!hasPermission('Lider')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    app.currentPage = 'asistencia';
    loadAsistencia();
}

function showProfile() {
    app.currentPage = 'profile';
    loadProfile();
}
