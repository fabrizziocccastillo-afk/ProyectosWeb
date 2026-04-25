// File Management System
class FileManager {
    constructor() {
        this.maxFileSize = 10 * 1024 * 1024; // 10MB
        this.allowedTypes = {
            'enseñanza': ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'mp4', 'mp3', 'txt'],
            'foto': ['jpg', 'jpeg', 'png', 'gif', 'webp'],
            'general': ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'jpg', 'jpeg', 'png', 'gif']
        };
    }

    setupFileUpload(inputId, dropZoneId, fileType = 'general') {
        const input = document.getElementById(inputId);
        const dropZone = document.getElementById(dropZoneId);

        if (!input || !dropZone) return;

        // Click on drop zone to open file dialog
        dropZone.addEventListener('click', () => {
            input.click();
        });

        // Handle file selection
        input.addEventListener('change', (e) => {
            this.handleFileSelect(e.target.files[0], fileType);
        });

        // Drag and drop events
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                this.handleFileSelect(files[0], fileType);
            }
        });
    }

    handleFileSelect(file, fileType) {
        if (!file) return;

        // Validate file type
        const extension = this.getFileExtension(file.name);
        if (!this.isFileTypeAllowed(extension, fileType)) {
            auth.showMessage(`Tipo de archivo no permitido: ${extension}`, 'error');
            return;
        }

        // Validate file size
        if (file.size > this.maxFileSize) {
            auth.showMessage('El archivo es demasiado grande (máximo 10MB)', 'error');
            return;
        }

        // Process file based on type
        if (fileType === 'foto') {
            this.processImageFile(file);
        } else {
            this.processGeneralFile(file);
        }
    }

    processImageFile(file) {
        const reader = new FileReader();
        
        reader.onload = (e) => {
            const imageData = e.target.result;
            
            // Update preview if exists
            const preview = document.getElementById('imagePreview');
            if (preview) {
                preview.src = imageData;
                preview.style.display = 'block';
            }

            // Store in hidden input if exists
            const hiddenInput = document.getElementById('imageData');
            if (hiddenInput) {
                hiddenInput.value = imageData;
            }

            auth.showMessage('Imagen cargada exitosamente', 'success');
        };

        reader.readAsDataURL(file);
    }

    processGeneralFile(file) {
        // For now, we'll store the file info in a hidden input
        // In a real application, you would upload to a server
        const fileInfo = {
            name: file.name,
            size: file.size,
            type: file.type,
            lastModified: file.lastModified
        };

        const hiddenInput = document.getElementById('fileInfo');
        if (hiddenInput) {
            hiddenInput.value = JSON.stringify(fileInfo);
        }

        // Update file display
        const fileDisplay = document.getElementById('fileDisplay');
        if (fileDisplay) {
            fileDisplay.innerHTML = `
                <div class="d-flex align-items-center p-2 border rounded">
                    <i class="fas ${Utils.getFileIcon(this.getFileExtension(file.name))} me-2"></i>
                    <div class="flex-grow-1">
                        <strong>${file.name}</strong>
                        <div class="text-muted small">${Utils.formatFileSize(file.size)}</div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="fileManager.removeFile()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
        }

        auth.showMessage('Archivo seleccionado: ' + file.name, 'success');
    }

    removeFile() {
        const fileInput = document.getElementById('fileInput');
        const fileInfo = document.getElementById('fileInfo');
        const fileDisplay = document.getElementById('fileDisplay');

        if (fileInput) fileInput.value = '';
        if (fileInfo) fileInfo.value = '';
        if (fileDisplay) fileDisplay.innerHTML = '';

        auth.showMessage('Archivo eliminado', 'info');
    }

    getFileExtension(filename) {
        return filename.split('.').pop().toLowerCase();
    }

    isFileTypeAllowed(extension, fileType) {
        const allowed = this.allowedTypes[fileType] || this.allowedTypes.general;
        return allowed.includes(extension);
    }

    // Simulate file download (in real app, this would be from server)
    downloadFile(filename, content = null) {
        if (content) {
            // Download provided content
            Utils.downloadFile(content, filename);
        } else {
            // Simulate download with placeholder
            auth.showMessage('Descargando: ' + filename, 'info');
            
            // Create a simple text file as example
            const sampleContent = `Contenido de ejemplo para ${filename}\n\nEste es un archivo de muestra generado por el sistema.\nFecha: ${new Date().toLocaleString()}`;
            Utils.downloadFile(sampleContent, filename);
        }
    }

    // Create data URL from file
    createDataUrl(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            
            reader.onload = () => resolve(reader.result);
            reader.onerror = reject;
            
            reader.readAsDataURL(file);
        });
    }

    // Compress image if needed
    async compressImage(file, maxWidth = 800, maxHeight = 600, quality = 0.8) {
        return new Promise((resolve) => {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();

            img.onload = () => {
                // Calculate new dimensions
                let { width, height } = img;
                
                if (width > maxWidth || height > maxHeight) {
                    const ratio = Math.min(maxWidth / width, maxHeight / height);
                    width *= ratio;
                    height *= ratio;
                }

                canvas.width = width;
                canvas.height = height;

                // Draw and compress
                ctx.drawImage(img, 0, 0, width, height);
                
                canvas.toBlob(resolve, 'image/jpeg', quality);
            };

            img.src = URL.createObjectURL(file);
        });
    }

    // Generate thumbnail
    async generateThumbnail(file, size = 150) {
        return new Promise((resolve) => {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();

            img.onload = () => {
                // Calculate thumbnail dimensions
                const { width, height } = img;
                const ratio = Math.min(size / width, size / height);
                
                canvas.width = width * ratio;
                canvas.height = height * ratio;

                // Draw thumbnail
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                
                resolve(canvas.toDataURL('image/jpeg', 0.8));
            };

            img.src = URL.createObjectURL(file);
        });
    }

    // Validate image file
    validateImageFile(file) {
        if (!file.type.startsWith('image/')) {
            throw new Error('El archivo no es una imagen');
        }

        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            throw new Error('Tipo de imagen no soportado');
        }

        return true;
    }

    // Setup multiple file inputs
    setupMultipleFileUploads() {
        // Setup enseñanza file upload
        this.setupFileUpload('enseñanzaFile', 'enseñanzaFileUpload', 'enseñanza');
        
        // Setup integrante photo upload
        this.setupFileUpload('integranteFoto', 'integranteFotoUpload', 'foto');
        
        // Setup general file uploads
        document.querySelectorAll('.file-upload').forEach(dropZone => {
            const inputId = dropZone.getAttribute('data-input');
            const fileType = dropZone.getAttribute('data-type') || 'general';
            this.setupFileUpload(inputId, dropZone.id, fileType);
        });
    }
}

// File manager will be initialized in main.js

// Setup file uploads when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    if (window.fileManager) {
        window.fileManager.setupMultipleFileUploads();
    }
});

// Global function for file downloads
function downloadFile(filename, content) {
    fileManager.downloadFile(filename, content);
}
