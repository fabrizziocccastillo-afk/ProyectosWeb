// Password Reset System
class PasswordResetManager {
    constructor() {
        this.init();
    }

    init() {
        // Setup form validation
        this.setupFormValidation();
    }

    setupFormValidation() {
        const form = document.getElementById('resetPasswordForm');
        if (form) {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.resetPassword();
            });
        }
    }

    // Show reset password modal
    showResetModal() {
        const modal = new bootstrap.Modal(document.getElementById('resetPasswordModal'));
        modal.show();
        
        // Clear previous input
        document.getElementById('resetEmail').value = '';
        
        // Focus on email input
        setTimeout(() => {
            document.getElementById('resetEmail').focus();
        }, 500);
    }

    // Reset password functionality
    resetPassword() {
        const email = document.getElementById('resetEmail').value.trim();
        
        if (!email) {
            auth.showMessage('Por favor ingresa tu correo electrónico', 'error');
            return;
        }

        if (!this.validateEmail(email)) {
            auth.showMessage('Por favor ingresa un correo electrónico válido', 'error');
            return;
        }

        try {
            // Find user by email
            const user = this.findUserByEmail(email);
            
            if (!user) {
                // For security, don't reveal if email exists or not
                this.simulateEmailSending(email);
                return;
            }

            // Generate new password
            const newPassword = this.generatePassword();
            
            // Update user password
            this.updateUserPassword(user.id, newPassword);
            
            // Send password email
            this.sendPasswordEmail(email, user.nombre, newPassword);
            
            // Show confirmation
            this.showEmailSentConfirmation();
            
            // Close reset modal
            const resetModal = bootstrap.Modal.getInstance(document.getElementById('resetPasswordModal'));
            resetModal.hide();
            
        } catch (error) {
            console.error('Password reset error:', error);
            auth.showMessage('Error al restablecer la contraseña', 'error');
        }
    }

    // Find user by email
    findUserByEmail(email) {
        const users = db.read('usuarios');
        return users.find(user => 
            user.email && user.email.toLowerCase() === email.toLowerCase() && 
            user.estado === 'Activo'
        );
    }

    // Validate email format
    validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Generate random password
    generatePassword() {
        const length = 8;
        const charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let password = '';
        
        for (let i = 0; i < length; i++) {
            password += charset.charAt(Math.floor(Math.random() * charset.length));
        }
        
        // Ensure at least one number and one letter
        if (!/\d/.test(password)) {
            password = password.slice(0, -1) + Math.floor(Math.random() * 10);
        }
        
        return password;
    }

    // Update user password in database
    updateUserPassword(userId, newPassword) {
        const hashedPassword = db.hashPassword(newPassword);
        db.update('usuarios', userId, { 
            password: hashedPassword,
            updatedAt: new Date().toISOString(),
            passwordResetAt: new Date().toISOString()
        });
        
        console.log(`Password updated for user ${userId}`);
    }

    // Send password email (simulated)
    sendPasswordEmail(email, userName, newPassword) {
        // In a real application, this would send an actual email
        // For now, we'll simulate it and show the password in console
        
        const emailContent = `
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center;">
                    <h2><i class="fas fa-church"></i> Casa de Vida</h2>
                    <p>Sistema de Gestión Integral</p>
                </div>
                
                <div style="padding: 30px; background-color: #f8f9fa;">
                    <h3>Restablecimiento de Contraseña</h3>
                    <p>Hola ${userName},</p>
                    <p>Hemos recibido una solicitud para restablecer tu contraseña. Tu nueva contraseña es:</p>
                    
                    <div style="background: white; border: 2px solid #667eea; padding: 15px; text-align: center; margin: 20px 0; border-radius: 8px;">
                        <h4 style="color: #667eea; margin: 0;">${newPassword}</h4>
                    </div>
                    
                    <p><strong>Instrucciones:</strong></p>
                    <ol>
                        <li>Usa esta nueva contraseña para iniciar sesión</li>
                        <li>Te recomendamos cambiar tu contraseña después de iniciar sesión</li>
                        <li>Si no solicitaste este cambio, contacta al administrador</li>
                    </ol>
                    
                    <div style="text-align: center; margin: 30px 0;">
                        <a href="http://localhost:8080" style="background: #667eea; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block;">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </a>
                    </div>
                </div>
                
                <div style="background: #333; color: white; padding: 20px; text-align: center;">
                    <p style="margin: 0;">&copy; 2024 Casa de Vida - Todos los derechos reservados</p>
                    <p style="margin: 5px 0 0 0; font-size: 12px; opacity: 0.8;">
                        Este es un correo automático, por favor no responder
                    </p>
                </div>
            </div>
        `;

        // Simulate email sending
        console.log('=== EMAIL ENVIADO ===');
        console.log('Para:', email);
        console.log('Asunto: Restablecimiento de Contraseña - Casa de Vida');
        console.log('Contraseña generada:', newPassword);
        console.log('===================');
        
        // Store email in localStorage for demo purposes
        const emailLog = JSON.parse(localStorage.getItem('emailLog') || '[]');
        emailLog.push({
            to: email,
            subject: 'Restablecimiento de Contraseña - Casa de Vida',
            password: newPassword,
            sentAt: new Date().toISOString(),
            content: emailContent
        });
        localStorage.setItem('emailLog', JSON.stringify(emailLog));
        
        return true;
    }

    // Simulate email sending for security (when email not found)
    simulateEmailSending(email) {
        // Simulate delay to make it seem realistic
        setTimeout(() => {
            this.showEmailSentConfirmation();
            
            const resetModal = bootstrap.Modal.getInstance(document.getElementById('resetPasswordModal'));
            resetModal.hide();
        }, 1500);
    }

    // Show email sent confirmation
    showEmailSentConfirmation() {
        const modal = new bootstrap.Modal(document.getElementById('emailSentModal'));
        modal.show();
        
        // Create notification
        if (window.notificationManager) {
            notificationManager.createNotification(
                'Se ha enviado un correo con tu contraseña restablecida',
                'success'
            );
        }
    }

    // Show email log (for demo purposes)
    showEmailLog() {
        const emailLog = JSON.parse(localStorage.getItem('emailLog') || '[]');
        
        if (emailLog.length === 0) {
            auth.showMessage('No hay correos enviados', 'info');
            return;
        }

        const logHtml = `
            <div class="modal fade" id="emailLogModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-envelope me-2"></i>Registro de Correos Enviados
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Para</th>
                                            <th>Asunto</th>
                                            <th>Contraseña</th>
                                            <th>Enviado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${emailLog.map(email => `
                                            <tr>
                                                <td>${email.to}</td>
                                                <td>${email.subject}</td>
                                                <td><code>${email.password}</code></td>
                                                <td>${Utils.formatDateTime(email.sentAt)}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" onclick="passwordReset.clearEmailLog()">
                                <i class="fas fa-trash me-2"></i>Limpiar Registro
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal if any
        const existingModal = document.getElementById('emailLogModal');
        if (existingModal) {
            existingModal.remove();
        }

        // Add new modal
        document.body.insertAdjacentHTML('beforeend', logHtml);
        
        const modalElement = document.getElementById('emailLogModal');
        const modal = new bootstrap.Modal(modalElement);
        modal.show();

        // Remove modal after hidden
        modalElement.addEventListener('hidden.bs.modal', () => {
            modalElement.remove();
        });
    }

    // Clear email log
    clearEmailLog() {
        localStorage.removeItem('emailLog');
        auth.showMessage('Registro de correos eliminado', 'success');
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('emailLogModal'));
        modal.hide();
    }

    // Check if user has email configured
    checkUserEmail(userId) {
        const user = db.read('usuarios', userId);
        return user && user.email && user.email.trim() !== '';
    }

    // Get users without email for admin notification
    getUsersWithoutEmail() {
        const users = db.read('usuarios');
        return users.filter(user => !user.email || user.email.trim() === '');
    }
}

// Initialize password reset manager
const passwordReset = new PasswordResetManager();

// Global functions
window.showResetPasswordModal = function() {
    passwordReset.showResetModal();
};

window.resetPassword = function() {
    passwordReset.resetPassword();
};

window.showEmailLog = function() {
    passwordReset.showEmailLog();
};

// Show edit profile modal
window.showEditProfileModal = function() {
    const user = getCurrentUser();
    const userData = db.getUser(user.id);
    
    if (!userData) {
        auth.showMessage('Error al cargar datos del usuario', 'error');
        return;
    }
    
    // Fill form with current data
    document.getElementById('editNombre').value = userData.nombre || '';
    document.getElementById('editEmail').value = userData.email || '';
    document.getElementById('editPassword').value = '';
    document.getElementById('editConfirmPassword').value = '';
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editProfileModal'));
    modal.show();
};

// Save profile changes
window.saveProfile = function() {
    const user = getCurrentUser();
    const userData = db.getUser(user.id);
    
    if (!userData) {
        auth.showMessage('Error al cargar datos del usuario', 'error');
        return;
    }
    
    const nombre = document.getElementById('editNombre').value.trim();
    const email = document.getElementById('editEmail').value.trim();
    const password = document.getElementById('editPassword').value;
    const confirmPassword = document.getElementById('editConfirmPassword').value;
    
    // Validation
    if (!nombre) {
        auth.showMessage('El nombre es requerido', 'error');
        return;
    }
    
    if (!email) {
        auth.showMessage('El correo electrónico es requerido', 'error');
        return;
    }
    
    if (!passwordReset.validateEmail(email)) {
        auth.showMessage('El correo electrónico no es válido', 'error');
        return;
    }
    
    if (password && password !== confirmPassword) {
        auth.showMessage('Las contraseñas no coinciden', 'error');
        return;
    }
    
    if (password && password.length < 6) {
        auth.showMessage('La contraseña debe tener al menos 6 caracteres', 'error');
        return;
    }
    
    try {
        // Prepare update data
        const updateData = {
            nombre: nombre,
            email: email,
            updatedAt: new Date().toISOString()
        };
        
        // Update password if provided
        if (password) {
            updateData.password = db.hashPassword(password);
        }
        
        // Update user in database
        db.update('usuarios', userData.id, updateData);
        
        // Update current session
        if (window.auth && window.auth.currentUser) {
            window.auth.currentUser.nombre = nombre;
            window.auth.updateUserInterface();
        }
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('editProfileModal'));
        modal.hide();
        
        // Show success message
        auth.showMessage('Perfil actualizado exitosamente', 'success');
        
        // Refresh profile view
        loadProfile();
        
        // Create notification
        if (window.notificationManager) {
            notificationManager.createNotification('Tu perfil ha sido actualizado', 'success', user.id);
        }
        
    } catch (error) {
        console.error('Profile update error:', error);
        auth.showMessage('Error al actualizar el perfil', 'error');
    }
};

// Add email log viewer to admin menu (if user is admin)
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        if (window.auth && window.auth.isMainAdmin && window.auth.isMainAdmin()) {
            // Add email log viewer to navbar for admin
            const navbar = document.querySelector('.navbar-nav.me-auto');
            if (navbar) {
                const emailLogItem = document.createElement('li');
                emailLogItem.className = 'nav-item';
                emailLogItem.innerHTML = `
                    <a class="nav-link" href="#" onclick="showEmailLog()">
                        <i class="fas fa-envelope-open-text me-1"></i>Registro de Correos
                    </a>
                `;
                navbar.appendChild(emailLogItem);
            }
        }
    }, 2000);
});
