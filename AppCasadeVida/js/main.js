// Main Entry Point - Initialize Application
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - Initializing Casa de Vida App...');
    
    // Check if all required modules are loaded
    const requiredModules = ['DatabaseManager', 'AuthSystem', 'AppController', 'CRUDManager', 'NotificationManager'];
    const missingModules = requiredModules.filter(module => typeof window[module] === 'undefined');
    
    if (missingModules.length > 0) {
        console.error('Missing modules:', missingModules);
        showError('Error: No se pudieron cargar todos los módulos necesarios');
        return;
    }
    
    // Initialize database
    try {
        window.db = new DatabaseManager();
        console.log('Database initialized successfully');
    } catch (error) {
        console.error('Database initialization error:', error);
        showError('Error al inicializar la base de datos');
        return;
    }
    
    // Initialize auth system
    try {
        window.auth = new AuthSystem();
        console.log('Auth system initialized successfully');
    } catch (error) {
        console.error('Auth initialization error:', error);
        showError('Error al inicializar el sistema de autenticación');
        return;
    }
    
    // Initialize app controller
    try {
        window.app = new AppController();
        console.log('App controller initialized successfully');
    } catch (error) {
        console.error('App controller initialization error:', error);
        showError('Error al inicializar la aplicación');
        return;
    }
    
    // Initialize CRUD manager
    try {
        window.crud = new CRUDManager();
        console.log('CRUD manager initialized successfully');
    } catch (error) {
        console.error('CRUD manager initialization error:', error);
        showError('Error al inicializar el gestor CRUD');
        return;
    }
    
    // Initialize notification manager
    try {
        window.notificationManager = new NotificationManager();
        console.log('Notification manager initialized successfully');
    } catch (error) {
        console.error('Notification manager initialization error:', error);
        showError('Error al inicializar el sistema de notificaciones');
        return;
    }
    
    // Initialize attendance manager
    try {
        window.attendanceManager = new AttendanceManager();
        console.log('Attendance manager initialized successfully');
    } catch (error) {
        console.error('Attendance manager initialization error:', error);
        console.warn('Attendance manager not available');
    }
    
    // Initialize file manager
    try {
        window.fileManager = new FileManager();
        console.log('File manager initialized successfully');
    } catch (error) {
        console.error('File manager initialization error:', error);
        console.warn('File manager not available');
    }
    
    // Initialize charts manager
    try {
        window.chartsManager = new ChartsManager();
        console.log('Charts manager initialized successfully');
    } catch (error) {
        console.error('Charts manager initialization error:', error);
        console.warn('Charts manager not available');
    }
    
    // Setup global error handlers
    window.addEventListener('error', function(event) {
        console.error('Global error:', event.error);
        showError('Error inesperado: ' + event.error.message);
    });
    
    window.addEventListener('unhandledrejection', function(event) {
        console.error('Unhandled promise rejection:', event.reason);
        showError('Error en una operación asíncrona');
    });
    
    console.log('Casa de Vida App initialized successfully!');
});

// Error display function
function showError(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'alert alert-danger position-fixed top-0 start-50 translate-middle-x mt-3';
    errorDiv.style.zIndex = '9999';
    errorDiv.innerHTML = `
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Error:</strong> ${message}
        <button type="button" class="btn-close ms-2" onclick="this.parentElement.remove()"></button>
    `;
    
    document.body.appendChild(errorDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (errorDiv.parentElement) {
            errorDiv.remove();
        }
    }, 5000);
}

// Debug function to check application state
window.debugApp = function() {
    console.log('=== Casa de Vida App Debug Info ===');
    console.log('Database:', !!window.db);
    console.log('Auth:', !!window.auth);
    console.log('App:', !!window.app);
    console.log('CRUD:', !!window.crud);
    console.log('Notifications:', !!window.notificationManager);
    console.log('Current User:', window.auth?.currentUser);
    console.log('Database Data:', window.db?.data);
    console.log('=====================================');
};

// Make sure all global functions are available
window.showDashboard = function() {
    if (!window.app) {
        showError('Aplicación no inicializada');
        return;
    }
    window.app.currentPage = 'dashboard';
    loadDashboard();
    
    // Initialize charts after dashboard is loaded
    setTimeout(() => {
        if (window.chartsManager) {
            window.chartsManager.initializeDashboardCharts();
        }
    }, 500);
};

window.showIglesias = function() {
    if (!window.app) {
        showError('Aplicación no inicializada');
        return;
    }
    if (!hasPermission('Pastor') && !hasPermission('Administrador')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    window.app.currentPage = 'iglesias';
    loadIglesias();
};

window.showRoles = function() {
    if (!window.app) {
        showError('Aplicación no inicializada');
        return;
    }
    if (!hasPermission('Pastor') && !hasPermission('Administrador')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    window.app.currentPage = 'roles';
    loadRoles();
};

window.showUsuarios = function() {
    if (!window.app) {
        showError('Aplicación no inicializada');
        return;
    }
    if (!hasPermission('Pastor') && !hasPermission('Administrador')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    window.app.currentPage = 'usuarios';
    loadUsuarios();
};

window.showTerritorios = function() {
    if (!window.app) {
        showError('Aplicación no inicializada');
        return;
    }
    if (!hasPermission('Anciano') && !hasPermission('Pastor') && !hasPermission('Administrador')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    window.app.currentPage = 'territorios';
    loadTerritorios();
};

window.showCasasVida = function() {
    if (!window.app) {
        showError('Aplicación no inicializada');
        return;
    }
    if (!hasPermission('Anciano') && !hasPermission('Pastor') && !hasPermission('Administrador')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    window.app.currentPage = 'casasVida';
    loadCasasVida();
};

window.showIntegrantes = function() {
    if (!window.app) {
        showError('Aplicación no inicializada');
        return;
    }
    if (!hasPermission('Anciano') && !hasPermission('Pastor') && !hasPermission('Administrador')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    window.app.currentPage = 'integrantes';
    loadIntegrantes();
};

window.showEnseñanzas = function() {
    if (!window.app) {
        showError('Aplicación no inicializada');
        return;
    }
    if (!hasPermission('Anciano') && !hasPermission('Pastor') && !hasPermission('Administrador')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    window.app.currentPage = 'enseñanzas';
    loadEnseñanzas();
};

window.showTareas = function() {
    if (!window.app) {
        showError('Aplicación no inicializada');
        return;
    }
    if (!hasPermission('Anciano') && !hasPermission('Pastor') && !hasPermission('Administrador')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    window.app.currentPage = 'tareas';
    loadTareas();
};

window.showAsistencia = function() {
    if (!window.app) {
        showError('Aplicación no inicializada');
        return;
    }
    if (!hasPermission('Lider')) {
        auth.showMessage('No tienes permisos para acceder a esta sección', 'error');
        return;
    }
    window.app.currentPage = 'asistencia';
    loadAsistencia();
};

window.showProfile = function() {
    if (!window.app) {
        showError('Aplicación no inicializada');
        return;
    }
    window.app.currentPage = 'profile';
    loadProfile();
};

window.openModal = function(modalId, data = null) {
    if (!window.crud) {
        showError('Sistema CRUD no disponible');
        return;
    }
    window.crud.openModal(modalId, data);
};

window.saveForm = function(modalId) {
    if (!window.crud) {
        showError('Sistema CRUD no disponible');
        return;
    }
    window.crud.saveForm(modalId);
};

window.deleteItem = function(table, id, itemName) {
    if (!window.crud) {
        showError('Sistema CRUD no disponible');
        return;
    }
    window.crud.deleteItem(table, id, itemName);
};

window.logout = function() {
    if (!window.auth) {
        showError('Sistema de autenticación no disponible');
        return;
    }
    window.auth.logout();
};

window.loadNotifications = function() {
    if (!window.notificationManager) {
        console.warn('Notification system not available');
        return;
    }
    window.notificationManager.loadNotifications();
};

window.markAsRead = function(notificationId) {
    if (!window.notificationManager) {
        showError('Sistema de notificaciones no disponible');
        return;
    }
    window.notificationManager.markAsRead(notificationId);
};

window.openAsistenciaForm = function() {
    if (!window.attendanceManager) {
        showError('Sistema de asistencia no disponible');
        return;
    }
    window.attendanceManager.openAttendanceModal();
};

window.viewAsistencia = function(attendanceId) {
    if (!window.attendanceManager) {
        showError('Sistema de asistencia no disponible');
        return;
    }
    window.attendanceManager.generateAttendanceReport(attendanceId);
};

window.downloadFile = function(filename, content) {
    if (!window.fileManager) {
        showError('Sistema de archivos no disponible');
        return;
    }
    window.fileManager.downloadFile(filename, content);
};

// Utility functions
window.isLoggedIn = function() {
    return window.auth && window.auth.getCurrentUser() !== null;
};

window.getCurrentUser = function() {
    return window.auth ? window.auth.getCurrentUser() : null;
};

window.hasPermission = function(requiredRole) {
    return window.auth ? window.auth.checkPermission(requiredRole) : false;
};

console.log('Main.js loaded successfully');

// Function to update existing admin user to Administrator role
window.updateAdminToAdministrator = function() {
    if (window.db) {
        // Find and update admin user
        const adminUser = window.db.data.usuarios.find(u => u.username === 'admin');
        
        if (adminUser) {
            // Update to Administrator role
            adminUser.rolId = 1; // Administrator role (first role created)
            adminUser.nombre = 'Administrador Principal';
            adminUser.isAdmin = true;
            adminUser.permissions = {
                canManageAllUsers: true,
                canManageAllTerritories: true,
                canManageAllCasasVida: true,
                canViewAllReports: true,
                canDeleteData: true,
                canExportData: true,
                canManageSystemSettings: true
            };
            adminUser.updatedAt = new Date().toISOString();
            
            window.db.saveDatabase();
            console.log('Admin user updated to Administrator role');
            
            // Update current session if admin is logged in
            if (window.auth && window.auth.currentUser && window.auth.currentUser.username === 'admin') {
                window.auth.currentUser.rolNombre = 'Administrador';
                window.auth.currentUser.isAdmin = true;
                window.auth.updateUserInterface();
            }
            
            auth.showMessage('Usuario admin actualizado a rol de Administrador', 'success');
            return true;
        } else {
            console.log('Admin user not found');
            return false;
        }
    }
    
    return false;
};

// Auto-update admin user if needed
setTimeout(() => {
    if (window.db) {
        const adminUser = window.db.data.usuarios.find(u => u.username === 'admin');
        if (adminUser && (!adminUser.isAdmin || adminUser.rolNombre !== 'Administrador')) {
            updateAdminToAdministrator();
        }
    }
}, 1000);
