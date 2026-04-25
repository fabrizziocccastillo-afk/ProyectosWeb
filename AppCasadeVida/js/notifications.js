// Notification System
class NotificationManager {
    constructor() {
        this.notifications = [];
        this.soundEnabled = true;
        this.init();
    }

    init() {
        this.setupNotificationSound();
        this.setupNotificationArea();
    }

    setupNotificationSound() {
        // Create audio element for notification sound
        const audio = document.getElementById('notificationSound');
        if (audio) {
            this.audioElement = audio;
        }
    }

    setupNotificationArea() {
        // Setup notification dropdown
        this.updateNotificationUI();
    }

    createNotification(message, type = 'info', userId = null) {
        const notification = db.createNotification(message, type, userId);
        
        // Play sound if enabled
        if (this.soundEnabled && this.audioElement) {
            this.audioElement.play().catch(e => console.log('Audio play failed:', e));
        }

        // Update UI
        this.updateNotificationUI();
        
        return notification;
    }

    loadNotifications() {
        const user = getCurrentUser();
        if (!user) return;

        this.notifications = db.getNotifications(user.id);
        this.updateNotificationUI();
    }

    updateNotificationUI() {
        const notificationCount = document.getElementById('notificationCount');
        const notificationList = document.getElementById('notificationList');
        
        if (!notificationCount || !notificationList) return;

        // Count unread notifications
        const unreadCount = this.notifications.filter(n => !n.leida).length;
        
        // Update badge
        notificationCount.textContent = unreadCount;
        notificationCount.style.display = unreadCount > 0 ? 'inline-block' : 'none';

        // Update notification list
        if (this.notifications.length === 0) {
            notificationList.innerHTML = `
                <li class="dropdown-item text-muted text-center">
                    No hay notificaciones
                </li>
            `;
        } else {
            notificationList.innerHTML = this.notifications.map(notification => `
                <li class="notification-item ${!notification.leida ? 'unread' : ''}" 
                    onclick="markAsRead(${notification.id})">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <div class="fw-medium">${notification.mensaje}</div>
                            <div class="notification-time">${app.formatDateTime(notification.createdAt)}</div>
                        </div>
                        <div class="ms-2">
                            <span class="badge bg-${this.getNotificationColor(notification.tipo)}">
                                ${notification.tipo}
                            </span>
                        </div>
                    </div>
                </li>
            `).join('');
        }
    }

    getNotificationColor(type) {
        const colors = {
            'info': 'info',
            'success': 'success',
            'warning': 'warning',
            'error': 'danger'
        };
        return colors[type] || 'secondary';
    }

    markAsRead(notificationId) {
        db.markNotificationAsRead(notificationId);
        this.loadNotifications();
    }

    markAllAsRead() {
        const user = getCurrentUser();
        if (!user) return;

        this.notifications.forEach(notification => {
            if (!notification.leida) {
                db.markNotificationAsRead(notification.id);
            }
        });
        
        this.loadNotifications();
    }

    toggleSound() {
        this.soundEnabled = !this.soundEnabled;
        auth.showMessage(
            this.soundEnabled ? 'Sonido de notificaciones activado' : 'Sonido de notificaciones desactivado',
            'info'
        );
    }

    // System notifications for different events
    notifyNewIntegrante(integrante) {
        const message = `Nuevo integrante registrado: ${integrante.nombres}`;
        this.createNotification(message, 'success');
    }

    notifyNewEnseñanza(enseñanza) {
        const message = `Nueva enseñanza disponible: ${enseñanza.titulo}`;
        this.createNotification(message, 'info');
    }

    notifyNewAsistencia(asistencia) {
        const message = `Nuevo reporte de asistencia registrado`;
        this.createNotification(message, 'info');
    }

    notifyNewTarea(tarea) {
        const message = `Nueva tarea asignada: ${tarea.descripcion}`;
        this.createNotification(message, 'warning');
    }

    notifyTaskCompleted(tarea) {
        const message = `Tarea completada: ${tarea.descripcion}`;
        this.createNotification(message, 'success');
    }

    notifyBirthday(integrante) {
        const message = `¡Hoy cumple años ${integrante.nombres}! 🎂`;
        this.createNotification(message, 'success');
    }
}

// Notification manager will be initialized in main.js

// Global functions
function loadNotifications() {
    notificationManager.loadNotifications();
}

function markAsRead(notificationId) {
    notificationManager.markAsRead(notificationId);
}

function markAllAsRead() {
    notificationManager.markAllAsRead();
}

function toggleNotificationSound() {
    notificationManager.toggleSound();
}

// Check for birthdays daily
function checkBirthdays() {
    const user = getCurrentUser();
    if (!user) return;

    const today = new Date();
    const todayMonth = today.getMonth() + 1;
    const todayDay = today.getDate();

    const integrantes = db.read('integrantes').filter(i => {
        if (!i.fechaCumpleaños || i.estado !== 'Activo') return false;
        
        const birthDate = new Date(i.fechaCumpleaños);
        return birthDate.getMonth() + 1 === todayMonth && birthDate.getDate() === todayDay;
    });

    integrantes.forEach(integrante => {
        notificationManager.notifyBirthday(integrante);
    });
}

// Check birthdays every hour
setInterval(checkBirthdays, 3600000);
