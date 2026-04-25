// Attendance Management System
class AttendanceManager {
    constructor() {
        this.currentAttendance = null;
        this.attendanceModal = null;
        this.init();
    }

    init() {
        this.createAttendanceModal();
    }

    createAttendanceModal() {
        const modalHtml = `
            <div class="modal fade" id="attendanceModal" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Registro de Asistencia</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="attendanceForm">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Fecha de Reunión</label>
                                        <input type="date" class="form-control" id="attendanceDate" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Casa de Vida</label>
                                        <select class="form-control" id="attendanceCasaVida" required>
                                            <option value="">Seleccione una casa de vida</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Tipo de Reunión</label>
                                        <select class="form-control" id="attendanceType">
                                            <option value="semanal">Reunión Semanal</option>
                                            <option value="estudio">Estudio Bíblico</option>
                                            <option value="oracion">Reunión de Oración</option>
                                            <option value="especial">Reunión Especial</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Tema/Enseñanza</label>
                                        <input type="text" class="form-control" id="attendanceTheme" placeholder="Tema de la reunión">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Maestro/Enseñador</label>
                                        <input type="text" class="form-control" id="attendanceTeacher" placeholder="Nombre del enseñador">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label mb-0">Lista de Asistencia</label>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="attendanceManager.selectAll()">
                                                <i class="fas fa-check-square me-1"></i>Seleccionar Todos
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="attendanceManager.deselectAll()">
                                                <i class="fas fa-square me-1"></i>Deseleccionar Todos
                                            </button>
                                        </div>
                                    </div>
                                    <div id="attendanceList" class="border rounded p-3" style="max-height: 400px; overflow-y: auto;">
                                        <!-- Attendance list will be loaded here -->
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Observaciones</label>
                                        <textarea class="form-control" id="attendanceObservations" rows="2" placeholder="Notas adicionales sobre la reunión"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Visitantes</label>
                                        <textarea class="form-control" id="attendanceVisitors" rows="2" placeholder="Nombres de visitantes (si los hay)"></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="attendanceApproved">
                                            <label class="form-check-label" for="attendanceApproved">
                                                Aprobado automáticamente
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="attendanceManager.saveAttendance()">
                                <i class="fas fa-save me-2"></i>Guardar Asistencia
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Add modal to body if it doesn't exist
        if (!document.getElementById('attendanceModal')) {
            document.body.insertAdjacentHTML('beforeend', modalHtml);
        }

        // Setup event listeners
        this.setupEventListeners();
    }

    setupEventListeners() {
        // Load casa vida options when modal is shown
        const modal = document.getElementById('attendanceModal');
        modal.addEventListener('show.bs.modal', () => {
            this.loadCasaVidaOptions();
            this.setDefaultDate();
        });

        // Load integrantes when casa vida is selected
        document.getElementById('attendanceCasaVida').addEventListener('change', () => {
            this.loadIntegrantes();
        });
    }

    loadCasaVidaOptions() {
        const user = getCurrentUser();
        const select = document.getElementById('attendanceCasaVida');
        let casasVida = db.read('casasVida').filter(c => c.estado === 'Activo');

        // Filter by user role
        if (user.rolNombre === 'Anciano') {
            casasVida = casasVida.filter(c => c.territorioId == user.territorioId);
        } else if (user.rolNombre === 'Lider') {
            casasVida = casasVida.filter(c => c.id == user.casaVidaId);
        }

        select.innerHTML = '<option value="">Seleccione una casa de vida</option>';
        casasVida.forEach(casa => {
            select.innerHTML += `<option value="${casa.id}">${casa.nombre}</option>`;
        });
    }

    setDefaultDate() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('attendanceDate').value = today;
    }

    loadIntegrantes() {
        const casaVidaId = document.getElementById('attendanceCasaVida').value;
        if (!casaVidaId) {
            document.getElementById('attendanceList').innerHTML = '<p class="text-muted">Seleccione una casa de vida</p>';
            return;
        }

        const integrantes = db.query('integrantes', { casaVidaId: casaVidaId, estado: 'Activo' });
        const attendanceList = document.getElementById('attendanceList');

        if (integrantes.length === 0) {
            attendanceList.innerHTML = '<p class="text-muted">No hay integrantes activos en esta casa de vida</p>';
            return;
        }

        attendanceList.innerHTML = integrantes.map(integrante => `
            <div class="integrante-attendance-item d-flex align-items-center p-2 border-bottom">
                <div class="form-check me-3">
                    <input class="form-check-input attendance-checkbox" type="checkbox" 
                           id="attend_${integrante.id}" value="${integrante.id}">
                </div>
                <img src="${integrante.foto || 'https://picsum.photos/seed/integrante/40/40'}" 
                     class="rounded-circle me-3" width="40" height="40" alt="${integrante.nombres}">
                <div class="flex-grow-1">
                    <strong>${integrante.nombres}</strong>
                    <div class="text-muted small">${db.getRoleName(integrante.rolId)}</div>
                </div>
                <div class="me-3">
                    <span class="badge bg-${integrante.bautizado === 'Si' ? 'success' : 'warning'}">
                        ${integrante.bautizado}
                    </span>
                </div>
                <div>
                    <input type="text" class="form-control form-control-sm" 
                           placeholder="Notas" style="width: 150px;"
                           id="notes_${integrante.id}">
                </div>
            </div>
        `).join('');
    }

    selectAll() {
        const checkboxes = document.querySelectorAll('.attendance-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = true);
    }

    deselectAll() {
        const checkboxes = document.querySelectorAll('.attendance-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = false);
    }

    saveAttendance() {
        const form = document.getElementById('attendanceForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const casaVidaId = document.getElementById('attendanceCasaVida').value;
        const date = document.getElementById('attendanceDate').value;
        const type = document.getElementById('attendanceType').value;
        const theme = document.getElementById('attendanceTheme').value;
        const teacher = document.getElementById('attendanceTeacher').value;
        const observations = document.getElementById('attendanceObservations').value;
        const visitors = document.getElementById('attendanceVisitors').value;
        const approved = document.getElementById('attendanceApproved').checked;

        // Get attended integrantes
        const attendedIntegrantes = [];
        const checkboxes = document.querySelectorAll('.attendance-checkbox:checked');
        
        checkboxes.forEach(checkbox => {
            const integranteId = checkbox.value;
            const notes = document.getElementById(`notes_${integranteId}`).value;
            
            attendedIntegrantes.push({
                integranteId: parseInt(integranteId),
                asistio: true,
                notas: notes
            });
        });

        // Get all integrantes for total count
        const allIntegrantes = db.query('integrantes', { casaVidaId: casaVidaId, estado: 'Activo' });
        const totalIntegrantes = allIntegrantes.length;

        // Create attendance record
        const attendanceData = {
            fecha: date,
            casaVidaId: parseInt(casaVidaId),
            tipo: type,
            tema: theme,
            maestro: teacher,
            asistentes: attendedIntegrantes,
            totalIntegrantes: totalIntegrantes,
            observaciones: observations,
            visitantes: visitors,
            estado: approved ? 'Aprobada' : 'Pendiente',
            createdBy: getCurrentUser().id
        };

        try {
            const attendance = db.create('asistencias', attendanceData);
            
            // Create notification
            notificationManager.notifyNewAsistencia(attendance);
            
            auth.showMessage('Asistencia registrada exitosamente', 'success');
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('attendanceModal'));
            modal.hide();
            
            // Refresh attendance view
            loadAsistencia();
            
        } catch (error) {
            console.error('Error saving attendance:', error);
            auth.showMessage('Error al guardar la asistencia', 'error');
        }
    }

    openAttendanceModal(attendanceId = null) {
        if (attendanceId) {
            // Edit existing attendance
            this.loadAttendanceData(attendanceId);
        } else {
            // New attendance
            this.resetForm();
        }

        const modal = new bootstrap.Modal(document.getElementById('attendanceModal'));
        modal.show();
    }

    loadAttendanceData(attendanceId) {
        const attendance = db.read('asistencias', attendanceId);
        if (!attendance) return;

        // Fill form with attendance data
        document.getElementById('attendanceDate').value = attendance.fecha;
        document.getElementById('attendanceCasaVida').value = attendance.casaVidaId;
        document.getElementById('attendanceType').value = attendance.tipo;
        document.getElementById('attendanceTheme').value = attendance.tema || '';
        document.getElementById('attendanceTeacher').value = attendance.maestro || '';
        document.getElementById('attendanceObservations').value = attendance.observaciones || '';
        document.getElementById('attendanceVisitors').value = attendance.visitantes || '';
        document.getElementById('attendanceApproved').checked = attendance.estado === 'Aprobada';

        // Load integrantes and set attendance
        this.loadIntegrantes();
        
        // Set attended checkboxes
        setTimeout(() => {
            attendance.asistentes.forEach(attended => {
                const checkbox = document.getElementById(`attend_${attended.integranteId}`);
                if (checkbox) {
                    checkbox.checked = attended.asistio;
                }
                
                const notesInput = document.getElementById(`notes_${attended.integranteId}`);
                if (notesInput) {
                    notesInput.value = attended.notas || '';
                }
            });
        }, 500);
    }

    resetForm() {
        document.getElementById('attendanceForm').reset();
        this.setDefaultDate();
        document.getElementById('attendanceList').innerHTML = '<p class="text-muted">Seleccione una casa de vida</p>';
    }

    generateAttendanceReport(attendanceId) {
        const attendance = db.read('asistencias', attendanceId);
        if (!attendance) return;

        const casaVida = db.read('casasVida', attendance.casaVidaId);
        const attendedCount = attendance.asistentes.filter(a => a.asistio).length;
        const attendanceRate = ((attendedCount / attendance.totalIntegrantes) * 100).toFixed(1);

        const reportHtml = `
            <div class="attendance-report">
                <h3>Reporte de Asistencia</h3>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Fecha:</strong> ${Utils.formatDate(attendance.fecha)}<br>
                        <strong>Casa de Vida:</strong> ${casaVida.nombre}<br>
                        <strong>Tipo:</strong> ${attendance.tipo}<br>
                        <strong>Maestro:</strong> ${attendance.maestro || 'N/A'}
                    </div>
                    <div class="col-md-6">
                        <strong>Total Integrantes:</strong> ${attendance.totalIntegrantes}<br>
                        <strong>Asistentes:</strong> ${attendedCount}<br>
                        <strong>Tasa de Asistencia:</strong> ${attendanceRate}%<br>
                        <strong>Estado:</strong> ${attendance.estado}
                    </div>
                </div>
                
                ${attendance.tema ? `<p><strong>Tema:</strong> ${attendance.tema}</p>` : ''}
                ${attendance.observaciones ? `<p><strong>Observaciones:</strong> ${attendance.observaciones}</p>` : ''}
                ${attendance.visitantes ? `<p><strong>Visitantes:</strong> ${attendance.visitantes}</p>` : ''}
                
                <h4>Lista de Asistencia</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Integrante</th>
                            <th>Asistió</th>
                            <th>Notas</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${attendance.asistentes.map(attended => {
                            const integrante = db.read('integrantes', attended.integranteId);
                            return `
                                <tr>
                                    <td>${integrante.nombres}</td>
                                    <td>
                                        <span class="badge bg-${attended.asistio ? 'success' : 'danger'}">
                                            ${attended.asistio ? 'Sí' : 'No'}
                                        </span>
                                    </td>
                                    <td>${attended.notas || '-'}</td>
                                </tr>
                            `;
                        }).join('')}
                    </tbody>
                </table>
            </div>
        `;

        // Create modal for report
        const modalHtml = `
            <div class="modal fade" id="reportModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Reporte de Asistencia</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            ${reportHtml}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" onclick="Utils.printElement('reportModal')">
                                <i class="fas fa-print me-2"></i>Imprimir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal if any
        const existingModal = document.getElementById('reportModal');
        if (existingModal) {
            existingModal.remove();
        }

        // Add new modal
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        const modalElement = document.getElementById('reportModal');
        const modal = new bootstrap.Modal(modalElement);
        modal.show();

        // Remove modal after hidden
        modalElement.addEventListener('hidden.bs.modal', () => {
            modalElement.remove();
        });
    }
}

// Attendance manager will be initialized in main.js

// Global function to open attendance form
function openAsistenciaForm() {
    attendanceManager.openAttendanceModal();
}

// Global function to view attendance details
function viewAsistencia(attendanceId) {
    attendanceManager.generateAttendanceReport(attendanceId);
}
