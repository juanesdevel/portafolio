<?php

function hashPassword($password) {
    /**
     * Hashes a password using bcrypt.
     *
     * @param string $password The password to hash.
     * @return string The hashed password.
     */
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hashedPassword) {
    /**
     * Verifies if a password matches a hash.
     *
     * @param string $password The password to verify.
     * @param string $hashedPassword The hashed password to compare against.
     * @return bool True if the password matches, false otherwise.
     */
    return password_verify($password, $hashedPassword);
}

// Ejemplo de uso
$password = "Admin1";
$hashed = hashPassword($password);

echo "Contraseña original: " . $password . "<br>";
echo "Hash de la contraseña: " . $hashed . "<br>";

// Verificar la contraseña
$passwordToCheck = "Admin1";
if (verifyPassword($passwordToCheck, $hashed)) {
    echo "La contraseña coincide.";
} else {
    echo "La contraseña no coincide.";
}

$passwordToCheck = "contraseñaIncorrecta";
if (verifyPassword($passwordToCheck, $hashed)) {
    echo "La contraseña coincide.";
} else {
    echo "La contraseña no coincide.";
}

?>