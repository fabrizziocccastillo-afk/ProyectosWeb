// Authentication System
class AuthSystem {
    constructor() {
        this.currentUser = null;
        this.init();
    }

    init() {
        // Check if user is already logged in
        const savedUser = localStorage.getItem('currentUser');
        if (savedUser) {
            this.currentUser = JSON.parse(savedUser);
            this.showMainApp();
        } else {
            this.showLoginScreen();
        }

        // Setup login form
        this.setupLoginForm();
    }

    setupLoginForm() {
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleLogin();
            });
        }
    }

    async handleLogin() {
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();

        if (!username || !password) {
            this.showMessage('Por favor ingrese usuario y contraseña', 'error');
            return;
        }

        console.log('Iniciando login con:', { username, password });

        try {
            // Login con Supabase usando email como username
            const result = await window.db.login(username, password);
            
            console.log('Resultado del login:', result);
            
            if (!result.success) {
                console.error('Error en login:', result.error);
                this.showMessage(result.error || 'Error al iniciar sesión', 'error');
                return;
            }

            // Obtener información adicional del usuario
            console.log('Buscando información adicional para:', result.user.email);
            const userInfo = await this.getUserInfo(result.user.email);
            
            console.log('Información del usuario:', userInfo);
            
            if (!userInfo.success) {
                console.error('Error obteniendo info de usuario:', userInfo.error);
                this.showMessage('Error al obtener información del usuario', 'error');
                return;
            }

            // Login successful
            this.currentUser = {
                id: userInfo.data.id,
                email: userInfo.data.email,
                nombre: userInfo.data.nombre,
                rol: userInfo.data.rol,
                telefono: userInfo.data.telefono,
                authUser: result.user
            };

            console.log('Usuario actual establecido:', this.currentUser);

            // Save to localStorage
            localStorage.setItem('currentUser', JSON.stringify(this.currentUser));

            // Show main app
            this.showMainApp();
            this.showMessage('Bienvenido ' + this.currentUser.nombre, 'success');

        } catch (error) {
            console.error('Error general en login:', error);
            this.showMessage('Error al iniciar sesión: ' + error.message, 'error');
        }
    }

    async getUserInfo(email) {
        try {
            console.log('Buscando usuario con email:', email);
            
            const { data, error } = await window.supabaseClient
                .from('usuarios')
                .select('*')
                .eq('email', email)
                .eq('activo', true)
                .single();
            
            console.log('Resultado de búsqueda:', { data, error });
            
            if (error) {
                console.error('Error en consulta de usuario:', error);
                return { success: false, error: error.message };
            }
            
            if (!data) {
                console.error('Usuario no encontrado en la tabla usuarios');
                return { success: false, error: 'Usuario no encontrado en la tabla usuarios. Verifica que el email esté registrado correctamente.' };
            }
            
            return { success: true, data };
        } catch (error) {
            console.error('Error en getUserInfo:', error);
            return { success: false, error: error.message };
        }
    }

    async logout() {
        try {
            // Logout de Supabase
            await window.db.logout();
        } catch (error) {
            console.error('Error en logout de Supabase:', error);
        }
        
        this.currentUser = null;
        localStorage.removeItem('currentUser');
        this.showLoginScreen();
        this.showMessage('Sesión cerrada correctamente', 'info');
    }

    showLoginScreen() {
        document.getElementById('loginScreen').classList.remove('d-none');
        document.getElementById('mainApp').classList.add('d-none');
    }

    showMainApp() {
        document.getElementById('loginScreen').classList.add('d-none');
        document.getElementById('mainApp').classList.remove('d-none');
        
        // Update UI with user info
        this.updateUserInterface();
        
        // Show dashboard by default
        showDashboard();
        
        // Load notifications
        loadNotifications();
    }

    updateUserInterface() {
        if (!this.currentUser) return;

        // Update current user display
        const currentUserElement = document.getElementById('currentUser');
        if (currentUserElement) {
            currentUserElement.textContent = this.currentUser.nombre;
        }

        // Update navigation based on role
        this.updateNavigationByRole();
    }

    updateNavigationByRole() {
        const role = this.currentUser.rol;
        
        // Hide/show menu items based on role
        const navItems = document.querySelectorAll('.navbar-nav .nav-link');
        
        navItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            
            // Administrator can see everything
            if (role === 'admin') {
                item.style.display = 'block';
            }
            // Pastor can see most things but not system admin functions
            else if (role === 'pastor') {
                if (text.includes('sistema') || text.includes('configuración')) {
                    item.style.display = 'none';
                } else {
                    item.style.display = 'block';
                }
            }
            // Anciano can see most things but not admin functions
            else if (role === 'anciano') {
                if (text.includes('iglesias') || text.includes('usuarios') || text.includes('sistema')) {
                    item.style.display = 'none';
                } else {
                    item.style.display = 'block';
                }
            }
            // Lider has limited access
            else if (role === 'lider') {
                if (text.includes('mantenimiento') || text.includes('enseñanzas')) {
                    item.style.display = 'none';
                } else {
                    item.style.display = 'block';
                }
            }
            // Other roles have minimal access
            else {
                if (text.includes('mantenimiento') || text.includes('gestión')) {
                    item.style.display = 'none';
                } else {
                    item.style.display = 'block';
                }
            }
        });
    }

    checkPermission(requiredRole) {
        if (!this.currentUser) return false;
        
        const roleHierarchy = {
            'admin': 5,
            'pastor': 4,
            'anciano': 3,
            'lider': 2,
            'miembro': 1
        };
        
        const userLevel = roleHierarchy[this.currentUser.rol] || 0;
        const requiredLevel = roleHierarchy[requiredRole] || 0;
        
        return userLevel >= requiredLevel;
    }

    // Check if user is main administrator
    isMainAdmin() {
        if (!this.currentUser) return false;
        
        const user = db.getUser(this.currentUser.id);
        return user && user.isAdmin === true;
    }

    // Check specific admin permissions
    hasAdminPermission(permission) {
        if (!this.currentUser) return false;
        
        const user = db.getUser(this.currentUser.id);
        if (!user || !user.permissions) return false;
        
        return user.permissions[permission] === true;
    }

    getCurrentUser() {
        return this.currentUser;
    }

    showMessage(message, type = 'info') {
        // Create toast notification
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

        // Create toast container if it doesn't exist
        let toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toastContainer';
            toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            document.body.appendChild(toastContainer);
        }

        // Add toast to container
        const toastElement = document.createElement('div');
        toastElement.innerHTML = toastHtml;
        toastContainer.appendChild(toastElement.firstElementChild);

        // Show toast
        const toast = new bootstrap.Toast(toastContainer.lastElementChild);
        toast.show();

        // Remove toast after it's hidden
        toastContainer.lastElementChild.addEventListener('hidden.bs.toast', () => {
            toastContainer.removeChild(toastContainer.lastElementChild);
        });
    }
}

// Auth system will be initialized in main.js

// Global logout function
function logout() {
    auth.logout();
}

// Check if user is logged in
function isLoggedIn() {
    return auth.getCurrentUser() !== null;
}

// Get current user
function getCurrentUser() {
    return auth.getCurrentUser();
}

// Check user permission
function hasPermission(requiredRole) {
    return auth.checkPermission(requiredRole);
}
