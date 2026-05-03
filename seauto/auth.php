<?php
require_once 'db.php';
header('Content-Type: application/json; charset=utf-8');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {

    // ===== GİRİŞ =====
    case 'login':
        $rol    = $_POST['rol'] ?? '';
        $giris  = trim($_POST['giris'] ?? '');
        $sifre  = trim($_POST['sifre'] ?? '');

        if ($rol === 'admin') {
            // Admin sabit kullanıcı (isteğe göre DB'ye taşınabilir)
            if ($giris === 'admin' && $sifre === 'admin123') {
                $_SESSION['user_id']   = 0;
                $_SESSION['user_name'] = 'Admin';
                $_SESSION['rol']       = 'admin';
                echo json_encode(['success' => true, 'rol' => 'admin', 'name' => 'Admin']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Kullanıcı adı veya şifre hatalı.']);
            }
        } elseif ($rol === 'musteri') {
            // Müşteri: Mail + Telefon ile giriş
            $sql    = "SELECT MusteriID, Ad, Soyad FROM Musteriler WHERE Mail = ? AND Telefon = ?";
            $params = [$giris, $sifre];
            $stmt   = sqlsrv_query($conn, $sql, $params);
            if ($stmt && ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))) {
                $_SESSION['user_id']   = $row['MusteriID'];
                $_SESSION['user_name'] = $row['Ad'] . ' ' . $row['Soyad'];
                $_SESSION['rol']       = 'musteri';
                echo json_encode(['success' => true, 'rol' => 'musteri', 'name' => $_SESSION['user_name']]);
            } else {
                echo json_encode(['success' => false, 'message' => 'E-posta veya telefon hatalı.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Geçersiz rol.']);
        }
        break;

    // ===== ÇIKIŞ =====
    case 'logout':
        session_destroy();
        echo json_encode(['success' => true]);
        break;

    // ===== SESSION BİLGİSİ =====
    case 'session':
        if (!empty($_SESSION['rol'])) {
            echo json_encode([
                'loggedIn' => true,
                'rol'      => $_SESSION['rol'],
                'name'     => $_SESSION['user_name'],
                'id'       => $_SESSION['user_id']
            ]);
        } else {
            echo json_encode(['loggedIn' => false]);
        }
        break;

    default:
        echo json_encode(['error' => 'Geçersiz işlem.']);
}
?>
