// Charts and Statistics
class ChartsManager {
    constructor() {
        this.chartColors = [
            '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', 
            '#FECA57', '#DDA0DD', '#98D8C8', '#F7DC6F',
            '#667eea', '#764ba2', '#f093fb', '#f5576c'
        ];
    }

    // Create attendance chart
    createAttendanceChart(canvasId, data) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return null;

        const ctx = canvas.getContext('2d');
        
        // Simple bar chart implementation
        this.drawBarChart(ctx, data, {
            title: 'Asistencia Semanal',
            xLabel: 'Semana',
            yLabel: 'Asistentes',
            color: this.chartColors[0]
        });
    }

    // Create integrantes by role chart
    createIntegrantesByRoleChart(canvasId) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return null;

        const user = getCurrentUser();
        let integrantes = db.read('integrantes').filter(i => i.estado === 'Activo');

        // Filter by user role
        if (user.rolNombre === 'Anciano') {
            integrantes = integrantes.filter(i => {
                const casaVida = db.read('casasVida').find(c => c.id == i.casaVidaId);
                return casaVida && casaVida.territorioId == user.territorioId;
            });
        } else if (user.rolNombre === 'Lider') {
            integrantes = integrantes.filter(i => i.casaVidaId == user.casaVidaId);
        }

        // Count by role
        const roles = {};
        integrantes.forEach(integrante => {
            const roleName = db.getRoleName(integrante.rolId);
            roles[roleName] = (roles[roleName] || 0) + 1;
        });

        const data = Object.entries(roles).map(([name, value]) => ({ name, value }));
        
        const ctx = canvas.getContext('2d');
        this.drawPieChart(ctx, data, {
            title: 'Integrantes por Rol'
        });
    }

    // Create casas de vida chart
    createCasasVidaChart(canvasId) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return null;

        const user = getCurrentUser();
        let casasVida = db.read('casasVida').filter(c => c.estado === 'Activo');

        // Filter by user role
        if (user.rolNombre === 'Anciano') {
            casasVida = casasVida.filter(c => c.territorioId == user.territorioId);
        } else if (user.rolNombre === 'Lider') {
            casasVida = casasVida.filter(c => c.id == user.casaVidaId);
        }

        // Count integrantes per casa
        const data = casasVida.map(casa => {
            const integrantesCount = db.query('integrantes', { casaVidaId: casa.id, estado: 'Activo' }).length;
            return {
                name: casa.nombre,
                value: integrantesCount
            };
        });

        const ctx = canvas.getContext('2d');
        this.drawBarChart(ctx, data, {
            title: 'Integrantes por Casa de Vida',
            xLabel: 'Casa de Vida',
            yLabel: 'Integrantes',
            color: this.chartColors[1]
        });
    }

    // Create bautizados vs no bautizados chart
    createBautizadosChart(canvasId) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return null;

        const user = getCurrentUser();
        let integrantes = db.read('integrantes').filter(i => i.estado === 'Activo');

        // Filter by user role
        if (user.rolNombre === 'Anciano') {
            integrantes = integrantes.filter(i => {
                const casaVida = db.read('casasVida').find(c => c.id == i.casaVidaId);
                return casaVida && casaVida.territorioId == user.territorioId;
            });
        } else if (user.rolNombre === 'Lider') {
            integrantes = integrantes.filter(i => i.casaVidaId == user.casaVidaId);
        }

        const bautizados = integrantes.filter(i => i.bautizado === 'Si').length;
        const noBautizados = integrantes.filter(i => i.bautizado === 'No').length;

        const data = [
            { name: 'Bautizados', value: bautizados },
            { name: 'Por Bautizar', value: noBautizados }
        ];

        const ctx = canvas.getContext('2d');
        this.drawPieChart(ctx, data, {
            title: 'Estado de Bautismo'
        });
    }

    // Simple bar chart implementation
    drawBarChart(ctx, data, options) {
        const canvas = ctx.canvas;
        const width = canvas.width = canvas.offsetWidth;
        const height = canvas.height = canvas.offsetHeight;
        
        const padding = 40;
        const chartWidth = width - padding * 2;
        const chartHeight = height - padding * 2;
        
        // Clear canvas
        ctx.clearRect(0, 0, width, height);
        
        // Find max value
        const maxValue = Math.max(...data.map(d => d.value));
        
        // Draw title
        if (options.title) {
            ctx.font = 'bold 16px Arial';
            ctx.fillStyle = '#333';
            ctx.textAlign = 'center';
            ctx.fillText(options.title, width / 2, 20);
        }
        
        // Draw bars
        const barWidth = chartWidth / data.length * 0.8;
        const barSpacing = chartWidth / data.length * 0.2;
        
        data.forEach((item, index) => {
            const barHeight = (item.value / maxValue) * chartHeight;
            const x = padding + index * (barWidth + barSpacing) + barSpacing / 2;
            const y = height - padding - barHeight;
            
            // Draw bar
            ctx.fillStyle = options.color || this.chartColors[index % this.chartColors.length];
            ctx.fillRect(x, y, barWidth, barHeight);
            
            // Draw value on top
            ctx.fillStyle = '#333';
            ctx.font = '12px Arial';
            ctx.textAlign = 'center';
            ctx.fillText(item.value, x + barWidth / 2, y - 5);
            
            // Draw label
            ctx.save();
            ctx.translate(x + barWidth / 2, height - padding + 15);
            ctx.rotate(-Math.PI / 6);
            ctx.textAlign = 'right';
            ctx.fillText(item.name, 0, 0);
            ctx.restore();
        });
        
        // Draw axes
        ctx.strokeStyle = '#333';
        ctx.lineWidth = 1;
        ctx.beginPath();
        ctx.moveTo(padding, padding);
        ctx.lineTo(padding, height - padding);
        ctx.lineTo(width - padding, height - padding);
        ctx.stroke();
        
        // Draw labels
        if (options.yLabel) {
            ctx.save();
            ctx.translate(15, height / 2);
            ctx.rotate(-Math.PI / 2);
            ctx.font = '12px Arial';
            ctx.fillStyle = '#666';
            ctx.textAlign = 'center';
            ctx.fillText(options.yLabel, 0, 0);
            ctx.restore();
        }
    }

    // Simple pie chart implementation
    drawPieChart(ctx, data, options) {
        const canvas = ctx.canvas;
        const width = canvas.width = canvas.offsetWidth;
        const height = canvas.height = canvas.offsetHeight;
        
        const centerX = width / 2;
        const centerY = height / 2;
        const radius = Math.min(width, height) / 2 - 40;
        
        // Clear canvas
        ctx.clearRect(0, 0, width, height);
        
        // Draw title
        if (options.title) {
            ctx.font = 'bold 16px Arial';
            ctx.fillStyle = '#333';
            ctx.textAlign = 'center';
            ctx.fillText(options.title, width / 2, 20);
        }
        
        // Calculate total
        const total = data.reduce((sum, item) => sum + item.value, 0);
        
        // Draw pie slices
        let currentAngle = -Math.PI / 2;
        
        data.forEach((item, index) => {
            const sliceAngle = (item.value / total) * Math.PI * 2;
            
            // Draw slice
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius, currentAngle, currentAngle + sliceAngle);
            ctx.lineTo(centerX, centerY);
            ctx.fillStyle = this.chartColors[index % this.chartColors.length];
            ctx.fill();
            
            // Draw label
            const labelAngle = currentAngle + sliceAngle / 2;
            const labelX = centerX + Math.cos(labelAngle) * (radius * 0.7);
            const labelY = centerY + Math.sin(labelAngle) * (radius * 0.7);
            
            ctx.fillStyle = '#fff';
            ctx.font = 'bold 12px Arial';
            ctx.textAlign = 'center';
            ctx.fillText(item.name, labelX, labelY);
            ctx.fillText(`${((item.value / total) * 100).toFixed(1)}%`, labelX, labelY + 15);
            
            currentAngle += sliceAngle;
        });
        
        // Draw legend
        let legendY = height - 20;
        data.forEach((item, index) => {
            const legendX = 20 + index * 120;
            
            // Color box
            ctx.fillStyle = this.chartColors[index % this.chartColors.length];
            ctx.fillRect(legendX, legendY, 15, 15);
            
            // Label
            ctx.fillStyle = '#333';
            ctx.font = '12px Arial';
            ctx.textAlign = 'left';
            ctx.fillText(`${item.name} (${item.value})`, legendX + 20, legendY + 12);
        });
    }

    // Create attendance trend chart
    createAttendanceTrendChart(canvasId, months = 6) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return null;

        const user = getCurrentUser();
        let asistencias = db.read('asistencias');

        // Filter by user role
        if (user.rolNombre === 'Anciano') {
            asistencias = asistencias.filter(a => {
                const casaVida = db.read('casasVida').find(c => c.id == a.casaVidaId);
                return casaVida && casaVida.territorioId == user.territorioId;
            });
        } else if (user.rolNombre === 'Lider') {
            asistencias = asistencias.filter(a => a.casaVidaId == user.casaVidaId);
        }

        // Group by month
        const monthlyData = {};
        const today = new Date();
        
        for (let i = 0; i < months; i++) {
            const date = new Date(today.getFullYear(), today.getMonth() - i, 1);
            const monthKey = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
            monthlyData[monthKey] = { month: date.toLocaleDateString('es-CO', { month: 'short', year: 'numeric' }), total: 0, attended: 0 };
        }

        asistencias.forEach(asistencia => {
            const date = new Date(asistencia.fecha);
            const monthKey = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
            
            if (monthlyData[monthKey]) {
                monthlyData[monthKey].total += asistencia.totalIntegrantes || 0;
                monthlyData[monthKey].attended += (asistencia.asistentes || []).length;
            }
        });

        const data = Object.values(monthlyData).reverse().map(month => ({
            name: month.month,
            value: month.total > 0 ? Math.round((month.attended / month.total) * 100) : 0
        }));

        const ctx = canvas.getContext('2d');
        this.drawLineChart(ctx, data, {
            title: 'Tendencia de Asistencia (%)',
            xLabel: 'Mes',
            yLabel: 'Porcentaje'
        });
    }

    // Simple line chart implementation
    drawLineChart(ctx, data, options) {
        const canvas = ctx.canvas;
        const width = canvas.width = canvas.offsetWidth;
        const height = canvas.height = canvas.offsetHeight;
        
        const padding = 40;
        const chartWidth = width - padding * 2;
        const chartHeight = height - padding * 2;
        
        // Clear canvas
        ctx.clearRect(0, 0, width, height);
        
        // Draw title
        if (options.title) {
            ctx.font = 'bold 16px Arial';
            ctx.fillStyle = '#333';
            ctx.textAlign = 'center';
            ctx.fillText(options.title, width / 2, 20);
        }
        
        // Find max value
        const maxValue = Math.max(...data.map(d => d.value));
        
        // Draw line
        ctx.strokeStyle = this.chartColors[0];
        ctx.lineWidth = 2;
        ctx.beginPath();
        
        data.forEach((item, index) => {
            const x = padding + (index / (data.length - 1)) * chartWidth;
            const y = height - padding - (item.value / maxValue) * chartHeight;
            
            if (index === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });
        
        ctx.stroke();
        
        // Draw points and labels
        data.forEach((item, index) => {
            const x = padding + (index / (data.length - 1)) * chartWidth;
            const y = height - padding - (item.value / maxValue) * chartHeight;
            
            // Draw point
            ctx.fillStyle = this.chartColors[0];
            ctx.beginPath();
            ctx.arc(x, y, 4, 0, Math.PI * 2);
            ctx.fill();
            
            // Draw value
            ctx.fillStyle = '#333';
            ctx.font = '12px Arial';
            ctx.textAlign = 'center';
            ctx.fillText(item.value + '%', x, y - 10);
            
            // Draw label
            ctx.save();
            ctx.translate(x, height - padding + 15);
            ctx.rotate(-Math.PI / 6);
            ctx.textAlign = 'right';
            ctx.fillText(item.name, 0, 0);
            ctx.restore();
        });
        
        // Draw axes
        ctx.strokeStyle = '#333';
        ctx.lineWidth = 1;
        ctx.beginPath();
        ctx.moveTo(padding, padding);
        ctx.lineTo(padding, height - padding);
        ctx.lineTo(width - padding, height - padding);
        ctx.stroke();
    }

    // Initialize all dashboard charts
    initializeDashboardCharts() {
        setTimeout(() => {
            this.createIntegrantesByRoleChart('roleChart');
            this.createCasasVidaChart('casasChart');
            this.createBautizadosChart('bautizadosChart');
            this.createAttendanceTrendChart('trendChart');
        }, 100);
    }
}

// Charts manager will be initialized in main.js

// Auto-initialize charts when dashboard is shown
document.addEventListener('DOMContentLoaded', () => {
    // This will be handled in main.js
});
