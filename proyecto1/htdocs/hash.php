
<?php
import bcrypt

def hash_password(password):
    """Hashes a password using bcrypt."""
    salt = bcrypt.gensalt()
    hashed_password = bcrypt.hashpw(password.encode('utf-8'), salt)
    return hashed_password

password = input("Introduce la contraseña que quieres hashear: ")
hashed = hash_password(password)

print(f"Hash de la contraseña: {hashed}")
?>