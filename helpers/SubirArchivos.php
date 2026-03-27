<?php
/**
 * Helper subir archivos
 */

class SubirArchivos {
    const UPLOAD_DIR = __DIR__ . '/../assets/uploads/';
    
    public static function subir($file, $proyecto_id = null) {
        if (!is_dir(self::UPLOAD_DIR)) {
            mkdir(self::UPLOAD_DIR, 0755, true);
        }
        
        $tipos_permitidos = ['pdf', 'doc', 'docx', 'jpg', 'png', 'zip'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($ext, $tipos_permitidos)) {
            throw new Exception('Tipo de archivo no permitido');
        }
        
        if ($file['size'] > 5 * 1024 * 1024) { // 5MB
            throw new Exception('Archivo muy grande');
        }
        
        $nombre_seguro = $proyecto_id . '_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $ruta = self::UPLOAD_DIR . $nombre_seguro;
        
        if (move_uploaded_file($file['tmp_name'], $ruta)) {
            return [
                'nombre_original' => $file['name'],
                'nombre_archivo' => $nombre_seguro,
                'ruta' => $ruta,
                'tamano' => $file['size']
            ];
        }
        throw new Exception('Error al subir archivo');
    }
}

