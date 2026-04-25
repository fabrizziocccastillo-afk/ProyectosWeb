// Configuración de Supabase para App Casas de Vida
const SUPABASE_CONFIG = {
    url: 'https://hafdxfpcoxqnyyrphici.supabase.co',
    anonKey: 'sb_publishable_ymb54-xSoLPv5T5uv_aUfg_uLM3v..'
};

// Esperar a que la librería de Supabase esté disponible
function initializeSupabase() {
    if (typeof window.supabase !== 'undefined') {
        const supabase = window.supabase.createClient(SUPABASE_CONFIG.url, SUPABASE_CONFIG.anonKey);
        window.supabaseClient = supabase;
        window.SUPABASE_CONFIG = SUPABASE_CONFIG;
        console.log('Supabase client initialized successfully');
        return true;
    } else {
        console.error('Supabase library not loaded');
        return false;
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    if (!initializeSupabase()) {
        // Reintentar después de un pequeño delay
        setTimeout(initializeSupabase, 1000);
    }
});

// También intentar inmediatamente por si el DOM ya está cargado
initializeSupabase();
