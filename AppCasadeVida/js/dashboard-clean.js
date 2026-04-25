// Dashboard Controller - Versión Limpia para Supabase
class DashboardController {
    constructor() {
        this.init();
    }

    async init() {
        await this.loadDashboardData();
        this.setupEventListeners();
    }

    async loadDashboardData() {
        try {
            // Cargar estadísticas generales
            const statsResult = await window.db.getEstadisticas();
            if (statsResult.success) {
                this.renderDashboard(statsResult.data);
            } else {
                console.error('Error cargando estadísticas:', statsResult.error);
            }
        } catch (error) {
            console.error('Error cargando dashboard:', error);
        }
    }

    renderDashboard(stats) {
        const contentArea = document.getElementById('contentArea');
        if (!contentArea) return;

        const currentUser = getCurrentUser();
        const userRole = currentUser ? currentUser.rol : 'guest';

        let html = `
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="h3 mb-4">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Dashboard - ${currentUser ? currentUser.nombre : 'Invitado'}
                    </h1>
                </div>
            </div>
        `;

        // Tarjetas de estadísticas
        html += this.renderStatCards(stats, userRole);
        
        // Gráficos (si hay datos)
        if (stats) {
            html += this.renderCharts(stats);
        }

        // Actividad reciente
        html += this.renderRecentActivity(userRole);

        contentArea.innerHTML = html;
    }

    renderStatCards(stats, userRole) {
        const cards = [
            {
                title: 'Total Usuarios',
                value: stats.total_usuarios || 0,
                icon: 'fas fa-users',
                color: 'primary',
                permission: 'admin'
            },
            {
                title: 'Casas de Vida',
                value: stats.total_casas_vida || 0,
                icon: 'fas fa-home',
                color: 'success',
                permission: 'pastor'
            },
            {
                title: 'Total Miembros',
                value: stats.total_miembros || 0,
                icon: 'fas fa-user-friends',
                color: 'info',
                permission: 'lider'
            },
            {
                title: 'Reuniones Semana',
                value: stats.reuniones_semana || 0,
                icon: 'fas fa-calendar-check',
                color: 'warning',
                permission: 'lider'
            },
            {
                title: 'Promedio Asistencia',
                value: Math.round(stats.promedio_asistencia || 0) + '%',
                icon: 'fas fa-chart-line',
                color: 'secondary',
                permission: 'anciano'
            }
        ];

        let html = '<div class="row">';
        
        cards.forEach(card => {
            const hasPermission = this.checkPermission(userRole, card.permission);
            const cardClass = hasPermission ? '' : 'disabled';
            
            html += `
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card ${cardClass}">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="card-title mb-1">${card.title}</h6>
                                    <h3 class="mb-0">${card.value}</h3>
                                </div>
                                <div class="ms-3">
                                    <i class="${card.icon} fa-2x text-${card.color}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        html += '</div>';
        return html;
    }

    renderCharts(stats) {
        return `
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-chart-pie me-2"></i>Distribución por Rol</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="roleChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-chart-bar me-2"></i>Asistencia Mensual</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="attendanceChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    renderRecentActivity(userRole) {
        return `
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-clock me-2"></i>Actividad Reciente</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Nuevo usuario registrado
                                    <small class="text-muted">Hace 2 horas</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fas fa-home me-2"></i>
                                    Casa de vida creada
                                    <small class="text-muted">Hace 5 horas</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fas fa-users me-2"></i>
                                    Reunión registrada
                                    <small class="text-muted">Hace 1 día</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    checkPermission(userRole, requiredRole) {
        const roleHierarchy = {
            'admin': 5,
            'pastor': 4,
            'anciano': 3,
            'lider': 2,
            'miembro': 1
        };
        
        const userLevel = roleHierarchy[userRole] || 0;
        const requiredLevel = roleHierarchy[requiredRole] || 0;
        
        return userLevel >= requiredLevel;
    }

    setupEventListeners() {
        // Event listeners para interactividad del dashboard
        document.addEventListener('click', (e) => {
            if (e.target.closest('.stat-card')) {
                const card = e.target.closest('.stat-card');
                if (card && !card.classList.contains('disabled')) {
                    this.handleStatCardClick(card);
                }
            }
        });
    }

    handleStatCardClick(card) {
        // Implementar navegación a detalles según la tarjeta
        console.log('Clic en tarjeta:', card);
    }

    // Inicializar gráficos cuando el DOM esté listo
    async initCharts() {
        try {
            await new Promise(resolve => setTimeout(resolve, 100));
            
            // Gráfico de roles (ejemplo)
            const roleCtx = document.getElementById('roleChart');
            if (roleCtx) {
                new Chart(roleCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Admin', 'Pastores', 'Ancianos', 'Líderes', 'Miembros'],
                        datasets: [{
                            data: [1, 2, 3, 8, 15],
                            backgroundColor: [
                                '#FF6384',
                                '#36A2EB',
                                '#FFCE56',
                                '#4BC0C0',
                                '#9966FF'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }

            // Gráfico de asistencia (ejemplo)
            const attendanceCtx = document.getElementById('attendanceChart');
            if (attendanceCtx) {
                new Chart(attendanceCtx, {
                    type: 'line',
                    data: {
                        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                        datasets: [{
                            label: 'Asistencia (%)',
                            data: [85, 88, 82, 90, 87],
                            borderColor: '#36A2EB',
                            backgroundColor: 'rgba(54, 162, 235, 0.1)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100
                            }
                        }
                    }
                });
            }
        } catch (error) {
            console.error('Error inicializando gráficos:', error);
        }
    }
}

// Función global para mostrar dashboard
function showDashboard() {
    const contentArea = document.getElementById('contentArea');
    if (!contentArea) return;
    
    // Ocultar todas las secciones
    document.querySelectorAll('.content-section').forEach(section => {
        section.style.display = 'none';
    });
    
    // Mostrar dashboard
    const dashboard = new DashboardController();
}
