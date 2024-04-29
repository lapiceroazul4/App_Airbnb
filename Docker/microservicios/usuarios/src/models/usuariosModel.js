const mysql = require('mysql2/promise');
const connection = mysql.createPool({
    host: "db",
    user: "root",
    password: "password",
    database: "airbnb_app"
});

async function traerUsuarios() {
    const result = await connection.query('SELECT * FROM micro_users');
    return result[0];
}

async function traerUsuario(id) {
    const result = await connection.query('SELECT * FROM micro_users WHERE user_id = ? ', id);
return result;
}

async function validarUsuario(email, password) {
    const result = await connection.query('SELECT * FROM micro_users WHERE email = ? AND password = ?', [email, password]);
return result[0];
}

async function crearUsuario(user_id, name, role, password, email) {
    const result = await connection.query('INSERT INTO micro_users values (?, ?, ?, ?, ?)', [user_id, name, role, password, email]);
    return result[0];
}

async function borrarUsuario(id) {
    const result = await connection.query('DELETE FROM micro_users WHERE user_id = ?', id);
    return result[0];
}

module.exports = {
    traerUsuarios,
    traerUsuario,
    validarUsuario,
    crearUsuario,
    borrarUsuario
};
