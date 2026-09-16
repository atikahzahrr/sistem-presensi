<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__ . '/../app/controllers/SiswaController.php';
require_once __DIR__ . '/../app/controllers/AbsenController.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'siswa_index';

switch ($action) {
    case 'siswa_index':
        $controller = new SiswaController();
        $controller->index();
        break;
    case 'siswa_create':
        $controller = new SiswaController();
        $controller->create();
        break;
    case 'siswa_store':
        $controller = new SiswaController();
        $controller->store();
        break;
    case 'siswa_edit':
        $controller = new SiswaController();
        $controller->edit();
        break;
    case 'siswa_update':
        $controller = new SiswaController();
        $controller->update();
        break;
    case 'siswa_delete':
        $controller = new SiswaController();
        $controller->delete();
        break;
    case 'siswa_filter':
        $controller = new SiswaController();
        $controller->filterByClass();
        break;

    case 'absen_index':
        $controller = new AbsenController();
        $controller->index();
        break;
    case 'absen_create':
        $controller = new AbsenController();
        $controller->create();
        break;
    case 'absen_store':
        $controller = new AbsenController();
        $controller->store();
        break;
    case 'absen_edit':
        $controller = new AbsenController();
        $controller->edit();
        break;
    case 'absen_update':
        $controller = new AbsenController();
        $controller->update();
        break;
    case 'absen_delete':
        $controller = new AbsenController();
        $controller->delete();
        break;
    case 'absen_filter_date':
        $controller = new AbsenController();
        $controller->filterByDate();
        break;
    case 'absen_filter_class':
        $controller = new AbsenController();
        $controller->filterByClass();
        break;
    
    default:
        header("Location: index.php?action=siswa_index");
        break;
}
?>