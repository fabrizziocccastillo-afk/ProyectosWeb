// Configuración de Supabase para App Casas de Vida
const SUPABASE_CONFIG = {
    url: 'https://hafdxfpcoxqnyyrphici.supabase.co',
    anonKey: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImhhZmR4ZnBjb3hxbnl5cnBoaWNpIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjQ2MjQ2NzksImV4cCI6MjA0MDIwMDY3OX0.sb_publishable_ymb54-xSoLPv5T5uv_aUfg_uLM3v..'
};

// Inicializar cliente de Supabase
const supabase = window.supabase.createClient(SUPABASE_CONFIG.url, SUPABASE_CONFIG.anonKey);

// Exportar para uso global
window.supabaseClient = supabase;
window.SUPABASE_CONFIG = SUPABASE_CONFIG;
