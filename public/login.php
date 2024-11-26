<?php
session_start();
require_once '../config/config.php'; // Include la configurazione del database

// Variabili per errori
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_utente = trim($_POST['nome_utente']);
    $password = $_POST['password'];

    if ($nome_utente && $password) {
        $query = "SELECT * FROM utenti WHERE nome_utente = :nome_utente";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nome_utente', $nome_utente);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && hash('sha256', $password) === $user['password_hash']) {
            // Salva l'utente nella sessione
            $_SESSION['nome_utente'] = $user['nome_utente'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Username o password errati.';
        }
    } else {
        $error = 'Inserisci username e password.';
    }
}
require_once '../includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Login - GENE.SYS</title>
</head>
<body>
<div class="full-screen-container d-flex justify-content-center align-items-center">
    <div class="container" style="max-width: 900px;">
        <div class="row">
            <!-- Colonna Sinistra -->
            <div class="col-md-6">
                <div>
                    <img src="../assets/uploads/login2.png" class="card-img-top-login rounded"
                         alt="Caracol">
                </div>
            </div>
            <!-- Colonna Destra -->
            <div class="col-md-6">
                <div>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <div class="card shadow-sm p-4 border-0 rounded">
                        <div class="d-flex justify-content-center mb-4">
                            <a href="index.php">
                                <img src="assets/uploads/logoGenesis.png" alt="Logo" style="width: 80px; height: 80px;">
                            </a>
                        </div>
                        <form action="" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nome_utente" name="nome_utente" placeholder="Username"
                                       required>
                                <label for="nome_utente">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                                       required>
                                <label for="password">Password</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 rounded-pill">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?php
require_once '../includes/footer.php'; // Include la navbar
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
