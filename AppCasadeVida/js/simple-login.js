// Login Simple para App Casas de Vida
class SimpleLogin {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.checkExistingSession();
    }

    setupEventListeners() {
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleLogin();
            });
        }
    }

    async checkExistingSession() {
        try {
            // Verificar si ya hay una sesión activa
            const { data: { user }, error } = await window.supabaseClient.auth.getUser();
            
            if (user && !error) {
                console.log('Usuario ya autenticado:', user);
                
                // Obtener información del usuario
                const userInfo = await this.getUserInfo(user.email);
                
                if (userInfo.success) {
                    this.showMainApp({
                        id: userInfo.data.id,
                        email: userInfo.data.email,
                        nombre: userInfo.data.nombre,
                        rol: userInfo.data.rol,
                        telefono: userInfo.data.telefono,
                        authUser: user
                    });
                } else {
                    console.error('Error obteniendo info del usuario:', userInfo.error);
                }
            }
        } catch (error) {
            console.log('No hay sesión activa:', error);
        }
    }

    async handleLogin() {
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();

        if (!username || !password) {
            this.showMessage('Por favor ingrese usuario y contraseña', 'error');
            return;
        }

        console.log('Intentando login con:', username);

        try {
            // Login directo con Supabase Auth
            const { data, error } = await window.supabaseClient.auth.signInWithPassword({
                email: username,
                password: password
            });

            if (error) {
                console.error('Error de autenticación:', error);
                this.showMessage('Error de autenticación: ' + error.message, 'error');
                return;
            }

            console.log('Login exitoso:', data.user);

            // Obtener información adicional del usuario
            const userInfo = await this.getUserInfo(data.user.email);
            
            if (userInfo.success) {
                this.showMainApp({
                    id: userInfo.data.id,
                    email: userInfo.data.email,
                    nombre: userInfo.data.nombre,
                    rol: userInfo.data.rol,
                    telefono: userInfo.data.telefono,
                    authUser: data.user
                });
                
                this.showMessage('¡Bienvenido ' + userInfo.data.nombre + '!', 'success');
            } else {
                console.error('Error obteniendo información del usuario:', userInfo.error);
                this.showMessage('Error al obtener información del usuario', 'error');
            }

        } catch (error) {
            console.error('Error en login:', error);
            this.showMessage('Error al iniciar sesión: ' + error.message, 'error');
        }
    }

    async getUserInfo(email) {
        try {
            const { data, error } = await window.supabaseClient
                .from('usuarios')
                .select('*')
                .eq('email', email)
                .eq('activo', true)
                .single();
            
            if (error) throw error;
            return { success: true, data };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    showMainApp(user) {
        // Ocultar login
        document.getElementById('loginScreen').style.display = 'none';
        
        // Mostrar aplicación principal
        document.getElementById('mainApp').style.display = 'block';
        
        // Actualizar información del usuario
        const currentUserElement = document.getElementById('currentUser');
        if (currentUserElement) {
            currentUserElement.textContent = user.nombre;
        }
        
        // Guardar en localStorage
        localStorage.setItem('currentUser', JSON.stringify(user));
        
        console.log('Aplicación principal mostrada para:', user);
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

    async logout() {
        try {
            await window.supabaseClient.auth.signOut();
            localStorage.removeItem('currentUser');
            
            // Mostrar login
            document.getElementById('loginScreen').style.display = 'block';
            document.getElementById('mainApp').style.display = 'none';
            
            this.showMessage('Sesión cerrada correctamente', 'info');
        } catch (error) {
            console.error('Error en logout:', error);
        }
    }
}

// Funciones globales simples
function showMainApp() {
    if (typeof SimpleLogin !== 'undefined') {
        const login = new SimpleLogin();
        login.showMainApp({
            id: 2,
            email: 'admin@casasvida.com',
            nombre: 'Admina',
            rol: 'admin',
            telefono: null,
            authUser: { email: 'admin@casasvida.com' }
        });
    } else {
        console.error('SimpleLogin class no encontrada');
    }
}

function logout() {
    if (typeof SimpleLogin !== 'undefined') {
        const login = new SimpleLogin();
        login.logout();
    } else {
        console.error('SimpleLogin class no encontrada');
    }
}

function showMessage(message, type = 'info') {
    if (typeof window.showToastMessage === 'function') {
        window.showToastMessage(message, type);
    } else {
        console.error('showToastMessage function not found');
        alert(message);
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    console.log('SimpleLogin inicializado');
    console.log('Clases disponibles:', {
        SimpleLogin: typeof SimpleLogin !== 'undefined'
    });
});
