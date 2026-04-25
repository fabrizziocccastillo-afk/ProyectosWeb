// Configuración de Supabase para App Casas de Vida
const SUPABASE_CONFIG = {
    url: 'https://hafdxfpcoxqnyyrphici.supabase.co',
    anonKey: 'sb_publishable_ymb54-xSoLPv5T5uv_aUfg_uLM3v..'
};

// Inicializar cliente de Supabase
const supabase = window.supabase.createClient(SUPABASE_CONFIG.url, SUPABASE_CONFIG.anonKey);

// Exportar para uso global
window.supabaseClient = supabase;
window.SUPABASE_CONFIG = SUPABASE_CONFIG;
