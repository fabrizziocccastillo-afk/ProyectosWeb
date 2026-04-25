// Database Manager - File-based JSON storage
class DatabaseManager {
    constructor() {
        this.dbName = 'casadevida_db.json';
        this.data = this.loadDatabase();
        this.initializeDefaultData();
    }

    // Load database from file
    loadDatabase() {
        try {
            const stored = localStorage.getItem(this.dbName);
            return stored ? JSON.parse(stored) : this.getEmptyDatabase();
        } catch (error) {
            console.error('Error loading database:', error);
            return this.getEmptyDatabase();
        }
    }

    // Save database to file
    saveDatabase() {
        try {
            localStorage.setItem(this.dbName, JSON.stringify(this.data, null, 2));
            return true;
        } catch (error) {
            console.error('Error saving database:', error);
            return false;
        }
    }

    // Get empty database structure
    getEmptyDatabase() {
        return {
            iglesias: [],
            roles: [],
            usuarios: [],
            territorios: [],
            casasVida: [],
            integrantes: [],
            enseñanzas: [],
            tareas: [],
            asistencias: [],
            notificaciones: [],
            settings: {
                nextId: {
                    iglesia: 1,
                    rol: 1,
                    usuario: 1,
                    territorio: 1,
                    casaVida: 1,
                    integrante: 1,
                    enseñanza: 1,
                    tarea: 1,
                    asistencia: 1,
                    notificacion: 1
                }
            }
        };
    }

    // Initialize default data
    initializeDefaultData() {
        // Create default roles if they don't exist
        if (this.data.roles.length === 0) {
            const defaultRoles = [
                { id: this.getNextId('rol'), nombre: 'Administrador', estado: 'Activo' },
                { id: this.getNextId('rol'), nombre: 'Pastor', estado: 'Activo' },
                { id: this.getNextId('rol'), nombre: 'Anciano', estado: 'Activo' },
                { id: this.getNextId('rol'), nombre: 'Lider', estado: 'Activo' },
                { id: this.getNextId('rol'), nombre: 'Colaborador', estado: 'Activo' },
                { id: this.getNextId('rol'), nombre: 'Anfitrion', estado: 'Activo' },
                { id: this.getNextId('rol'), nombre: 'Integrante', estado: 'Activo' }
            ];
            this.data.roles.push(...defaultRoles);
        }

        // Create default admin user if it doesn't exist
        if (this.data.usuarios.length === 0) {
            const adminUser = {
                id: this.getNextId('usuario'),
                username: 'admin',
                password: this.hashPassword('admin123'),
                nombre: 'Administrador Principal',
                email: 'admin@casadevida.com',
                rolId: 1, // Administrator role
                territorioId: null,
                casaVidaId: null,
                estado: 'Activo',
                createdAt: new Date().toISOString(),
                isAdmin: true, // Mark as main administrator
                permissions: {
                    canManageAllUsers: true,
                    canManageAllTerritories: true,
                    canManageAllCasasVida: true,
                    canViewAllReports: true,
                    canDeleteData: true,
                    canExportData: true,
                    canManageSystemSettings: true
                }
            };
            this.data.usuarios.push(adminUser);
        }

        this.saveDatabase();
    }

    // Get next ID for a table
    getNextId(table) {
        const nextId = this.data.settings.nextId[table]++;
        this.saveDatabase();
        return nextId;
    }

    // Hash password (simple implementation)
    hashPassword(password) {
        return btoa(password); // Simple encoding for demo
    }

    // Verify password
    verifyPassword(password, hash) {
        return btoa(password) === hash;
    }

    // Generic CRUD operations
    create(table, data) {
        if (!this.data[table]) {
            throw new Error(`Table ${table} does not exist`);
        }
        
        const newItem = {
            id: this.getNextId(table),
            ...data,
            createdAt: new Date().toISOString(),
            updatedAt: new Date().toISOString()
        };
        
        this.data[table].push(newItem);
        this.saveDatabase();
        return newItem;
    }

    read(table, id = null) {
        if (!this.data[table]) {
            throw new Error(`Table ${table} does not exist`);
        }
        
        if (id) {
            return this.data[table].find(item => item.id == id);
        }
        
        return this.data[table];
    }

    update(table, id, data) {
        if (!this.data[table]) {
            throw new Error(`Table ${table} does not exist`);
        }
        
        const index = this.data[table].findIndex(item => item.id == id);
        if (index === -1) {
            throw new Error(`Item with id ${id} not found in table ${table}`);
        }
        
        this.data[table][index] = {
            ...this.data[table][index],
            ...data,
            updatedAt: new Date().toISOString()
        };
        
        this.saveDatabase();
        return this.data[table][index];
    }

    delete(table, id) {
        if (!this.data[table]) {
            throw new Error(`Table ${table} does not exist`);
        }
        
        const index = this.data[table].findIndex(item => item.id == id);
        if (index === -1) {
            throw new Error(`Item with id ${id} not found in table ${table}`);
        }
        
        const deletedItem = this.data[table].splice(index, 1)[0];
        this.saveDatabase();
        return deletedItem;
    }

    // Query operations
    query(table, filters = {}) {
        let results = this.data[table] || [];
        
        Object.keys(filters).forEach(key => {
            if (filters[key] !== null && filters[key] !== undefined) {
                results = results.filter(item => item[key] == filters[key]);
            }
        });
        
        return results;
    }

    // Get user by username
    getUserByUsername(username) {
        return this.data.usuarios.find(user => user.username === username);
    }

    // Get role name by ID
    getRoleName(roleId) {
        const role = this.data.roles.find(r => r.id == roleId);
        return role ? role.nombre : 'Desconocido';
    }

    // Get territory name by ID
    getTerritoryName(territoryId) {
        const territory = this.data.territorios.find(t => t.id == territoryId);
        return territory ? territory.nombre : 'Sin Territorio';
    }

    // Get casa de vida name by ID
    getCasaVidaName(casaVidaId) {
        const casaVida = this.data.casasVida.find(c => c.id == casaVidaId);
        return casaVida ? casaVida.nombre : 'Sin Casa de Vida';
    }

    // Get statistics for dashboard
    getDashboardStats(userId) {
        const user = this.getUser(userId);
        const userRole = this.getRoleName(user.rolId);
        
        let stats = {
            porBautizar: 0,
            totalIntegrantes: 0,
            casasAsignadas: 0,
            notificacionesPendientes: 0,
            cumpleañerosMes: []
        };

        // Get integrantes based on user role
        let integrantes = [];
        if (userRole === 'Pastor') {
            // Pastor can see all integrantes
            integrantes = this.data.integrantes.filter(i => i.estado === 'Activo');
        } else if (userRole === 'Anciano') {
            // Anciano can see integrantes from his territory
            integrantes = this.data.integrantes.filter(i => 
                i.estado === 'Activo' && this.isInUserTerritory(i, user)
            );
        } else if (userRole === 'Lider') {
            // Lider can see integrantes from his casa de vida
            integrantes = this.data.integrantes.filter(i => 
                i.estado === 'Activo' && i.casaVidaId == user.casaVidaId
            );
        }

        stats.porBautizar = integrantes.filter(i => i.bautizado === 'No').length;
        stats.totalIntegrantes = integrantes.length;

        // Count casas asignadas
        if (userRole === 'Pastor') {
            stats.casasAsignadas = this.data.casasVida.filter(c => c.estado === 'Activo').length;
        } else if (userRole === 'Anciano') {
            stats.casasAsignadas = this.data.casasVida.filter(c => 
                c.estado === 'Activo' && c.territorioId == user.territorioId
            ).length;
        } else if (userRole === 'Lider') {
            stats.casasAsignadas = user.casaVidaId ? 1 : 0;
        }

        // Count pending notifications
        stats.notificacionesPendientes = this.data.notificaciones.filter(n => 
            !n.leida && (n.usuarioId == userId || n.usuarioId === null)
        ).length;

        // Get birthday people for current month
        const currentMonth = new Date().getMonth() + 1;
        stats.cumpleañerosMes = integrantes.filter(i => {
            if (!i.fechaCumpleaños) return false;
            const birthMonth = new Date(i.fechaCumpleaños).getMonth() + 1;
            return birthMonth === currentMonth;
        });

        return stats;
    }

    // Check if integrante is in user's territory
    isInUserTerritory(integrante, user) {
        const casaVida = this.data.casasVida.find(c => c.id == integrante.casaVidaId);
        return casaVida && casaVida.territorioId == user.territorioId;
    }

    // Get user by ID
    getUser(userId) {
        return this.data.usuarios.find(u => u.id == userId);
    }

    // Create notification
    createNotification(message, type = 'info', userId = null) {
        const notification = {
            id: this.getNextId('notificacion'),
            mensaje: message,
            tipo: type,
            usuarioId: userId,
            leida: false,
            createdAt: new Date().toISOString()
        };
        
        this.data.notificaciones.push(notification);
        this.saveDatabase();
        return notification;
    }

    // Mark notification as read
    markNotificationAsRead(notificationId) {
        const notification = this.data.notificaciones.find(n => n.id == notificationId);
        if (notification) {
            notification.leida = true;
            this.saveDatabase();
        }
        return notification;
    }

    // Get notifications for user
    getNotifications(userId) {
        return this.data.notifications.filter(n => 
            n.usuarioId == userId || n.usuarioId === null
        ).sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));
    }

    // Export database
    exportDatabase() {
        return JSON.stringify(this.data, null, 2);
    }

    // Import database
    importDatabase(jsonData) {
        try {
            this.data = JSON.parse(jsonData);
            this.saveDatabase();
            return true;
        } catch (error) {
            console.error('Error importing database:', error);
            return false;
        }
    }
}

// Function to reset admin user to Administrator role
    resetAdminToAdministrator() {
        // Find existing admin user
        const adminUser = this.data.usuarios.find(u => u.username === 'admin');
        
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
            
            this.saveDatabase();
            console.log('Admin user updated to Administrator role');
            return true;
        }
        
        return false;
    }

// Database will be initialized in main.js
