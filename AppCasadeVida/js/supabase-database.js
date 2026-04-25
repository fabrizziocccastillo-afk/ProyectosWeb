// Operaciones de base de datos con Supabase
// App Casas de Vida - Sistema de Gestión

class SupabaseDatabase {
    constructor() {
        this.client = window.supabaseClient;
    }

    // === OPERACIONES DE USUARIOS ===
    
    async login(email, password) {
        try {
            const { data, error } = await this.client.auth.signInWithPassword({
                email: email,
                password: password
            });
            
            if (error) throw error;
            return { success: true, user: data.user };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    async logout() {
        try {
            const { error } = await this.client.auth.signOut();
            if (error) throw error;
            return { success: true };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    async getCurrentUser() {
        try {
            const { data: { user }, error } = await this.client.auth.getUser();
            if (error) throw error;
            return { success: true, user };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    async getUsuarios() {
        try {
            const { data, error } = await this.client
                .from('usuarios')
                .select('*')
                .eq('activo', true)
                .order('nombre');
            
            if (error) throw error;
            return { success: true, data };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    async createUsuario(usuario) {
        try {
            const { data, error } = await this.client
                .from('usuarios')
                .insert([usuario])
                .select();
            
            if (error) throw error;
            return { success: true, data: data[0] };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    // === OPERACIONES DE CASAS DE VIDA ===
    
    async getCasasVida() {
        try {
            const { data, error } = await this.client
                .from('casas_vida')
                .select(`
                    *,
                    lider:lider_usuarios!id_lider(id, nombre, email),
                    anterior_lider:anterior_lider_usuarios!id_anterior_lider(id, nombre, email),
                    miembros:miembros(id, nombre, email)
                `)
                .eq('activa', true)
                .order('nombre');
            
            if (error) throw error;
            return { success: true, data };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    async createCasaVida(casaVida) {
        try {
            const { data, error } = await this.client
                .from('casas_vida')
                .insert([casaVida])
                .select();
            
            if (error) throw error;
            return { success: true, data: data[0] };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    async updateCasaVida(id, updates) {
        try {
            const { data, error } = await this.client
                .from('casas_vida')
                .update(updates)
                .eq('id', id)
                .select();
            
            if (error) throw error;
            return { success: true, data: data[0] };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    // === OPERACIONES DE MIEMBROS ===
    
    async getMiembros() {
        try {
            const { data, error } = await this.client
                .from('miembros')
                .select(`
                    *,
                    casa_vida:casas_vida(id, nombre, direccion)
                `)
                .eq('activo', true)
                .order('nombre');
            
            if (error) throw error;
            return { success: true, data };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    async createMiembro(miembro) {
        try {
            const { data, error } = await this.client
                .from('miembros')
                .insert([miembro])
                .select();
            
            if (error) throw error;
            return { success: true, data: data[0] };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    // === OPERACIONES DE REUNIONES ===
    
    async getReuniones(fechaInicio = null, fechaFin = null) {
        try {
            let query = this.client
                .from('reuniones')
                .select(`
                    *,
                    casa_vida:casas_vida(id, nombre, direccion, dia_reunion, hora_reunion),
                    asistencia:asistencia(presente, es_visitante)
                `)
                .order('fecha_reunion', { ascending: false });
            
            if (fechaInicio) {
                query = query.gte('fecha_reunion', fechaInicio);
            }
            if (fechaFin) {
                query = query.lte('fecha_reunion', fechaFin);
            }
            
            const { data, error } = await query;
            
            if (error) throw error;
            return { success: true, data };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    async createReunion(reunion) {
        try {
            const { data, error } = await this.client
                .from('reuniones')
                .insert([reunion])
                .select();
            
            if (error) throw error;
            return { success: true, data: data[0] };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    // === OPERACIONES DE ASISTENCIA ===
    
    async getAsistencia(idReunion) {
        try {
            const { data, error } = await this.client
                .from('asistencia')
                .select(`
                    *,
                    miembro:miembros(id, nombre, email)
                `)
                .eq('id_reunion', idReunion)
                .order('miembro.nombre');
            
            if (error) throw error;
            return { success: true, data };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    async registrarAsistencia(asistenciaData) {
        try {
            const { data, error } = await this.client
                .from('asistencia')
                .upsert(asistenciaData, {
                    onConflict: 'id_reunion,id_miembro'
                })
                .select();
            
            if (error) throw error;
            return { success: true, data };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    async registrarAsistenciaMultiple(asistenciaData) {
        try {
            const { data, error } = await this.client
                .from('asistencia')
                .upsert(asistenciaData, {
                    onConflict: 'id_reunion,id_miembro'
                })
                .select();
            
            if (error) throw error;
            return { success: true, data };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    // === OPERACIONES DE ENSEÑANZAS ===
    
    async getEnseñanzas() {
        try {
            const { data, error } = await this.client
                .from('enseñanzas')
                .select(`
                    *,
                    creador:usuarios(id, nombre, email)
                `)
                .eq('activo', true)
                .order('fecha_creacion', { ascending: false });
            
            if (error) throw error;
            return { success: true, data };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    async createEnseñanza(enseñanza) {
        try {
            const { data, error } = await this.client
                .from('enseñanzas')
                .insert([enseñanza])
                .select();
            
            if (error) throw error;
            return { success: true, data: data[0] };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    // === OPERACIONES DE ESTADÍSTICAS ===
    
    async getEstadisticas() {
        try {
            const { data, error } = await this.client
                .from('vista_estadisticas')
                .select('*');
            
            if (error) throw error;
            return { success: true, data: data[0] };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    async getEstadisticasPorCasaVida(idCasaVida, fechaInicio, fechaFin) {
        try {
            const { data, error } = await this.client
                .from('reuniones')
                .select(`
                    fecha_reunion,
                    asistencia_total,
                    visitantes
                `)
                .eq('id_casa_vida', idCasaVida)
                .gte('fecha_reunion', fechaInicio)
                .lte('fecha_reunion', fechaFin)
                .order('fecha_reunion');
            
            if (error) throw error;
            return { success: true, data };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    // === OPERACIONES DE NOTIFICACIONES ===
    
    async getNotificaciones(idUsuario, noLeidas = false) {
        try {
            let query = this.client
                .from('notificaciones')
                .select('*')
                .eq('id_usuario', idUsuario)
                .order('fecha_creacion', { ascending: false });
            
            if (noLeidas) {
                query = query.eq('leida', false);
            }
            
            const { data, error } = await query;
            
            if (error) throw error;
            return { success: true, data };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    async marcarNotificacionLeida(idNotificacion) {
        try {
            const { data, error } = await this.client
                .from('notificaciones')
                .update({ leida: true })
                .eq('id', idNotificacion)
                .select();
            
            if (error) throw error;
            return { success: true, data: data[0] };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    async createNotificacion(notificacion) {
        try {
            const { data, error } = await this.client
                .from('notificaciones')
                .insert([notificacion])
                .select();
            
            if (error) throw error;
            return { success: true, data: data[0] };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }

    // === UTILIDADES ===
    
    async testConnection() {
        try {
            const { data, error } = await this.client
                .from('configuracion')
                .select('clave, valor')
                .limit(1);
            
            if (error) throw error;
            return { success: true, message: 'Conexión exitosa con Supabase' };
        } catch (error) {
            return { success: false, error: error.message };
        }
    }
}

// Crear instancia global
window.db = new SupabaseDatabase();
