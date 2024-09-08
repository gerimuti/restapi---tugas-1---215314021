<?php
// Menginclude file koneksi database
include 'function.php';

// Periksa apakah data POST dikirimkan
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Mendapatkan input dari formulir login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Siapkan query untuk memeriksa apakah username sudah ada
    $stmt = mysqli_prepare($koneksi, "SELECT password FROM login WHERE username = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars(mysqli_error($koneksi)));
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Username ditemukan, verifikasi password
        if (password_verify($password, $row['password'])) {
            // Login berhasil
            echo '<script language="javascript">
                alert("Anda Berhasil Login!"); document.location="todo.php";</script>';
        } else {
            // Password salah
            echo '<script language="javascript">
                alert("Username atau Password Salah! Silahkan Login Kembali."); document.location="index.php";</script>';
        }
    } else {
        // Username tidak ditemukan, daftarkan pengguna baru
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = mysqli_prepare($koneksi, "INSERT INTO login (username, password) VALUES (?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars(mysqli_error($koneksi)));
        }

        mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPassword);

        if (mysqli_stmt_execute($stmt)) {
            // Pendaftaran berhasil, redirect ke halaman login
            echo '<script language="javascript">
                alert("Pendaftaran Berhasil! Anda Sekarang Terdaftar dan Login."); document.location="todo.php";</script>';
        } else {
            // Terjadi kesalahan saat pendaftaran
            echo '<script language="javascript">
                alert("Terjadi kesalahan saat pendaftaran. Silahkan coba lagi."); document.location="index.php";</script>';
        }
    }

    // Menutup statement dan koneksi
    mysqli_stmt_close($stmt);
} else {
    echo '<script language="javascript">
        alert("Data tidak ditemukan. Pastikan Anda mengisi semua kolom."); document.location="index.php";</script>';
}

// Menutup koneksi
mysqli_close($koneksi);
