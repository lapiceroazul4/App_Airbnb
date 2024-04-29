const mysql = require("mysql2/promise");

// Configurar la conexión a la base de datos
const pool = mysql.createPool({
  host: "db",
  user: "root",
  password: "password",
  database: "airbnb_app"
});

// Función para crear una reserva
async function crearReserva({ airbnb_id, user_id}) {
    try {
      const [rows] = await pool.execute(
        'INSERT INTO micro_reservas (airbnb_id, user_id, fecha_reserva) VALUES (?, ?, NOW())',
        [airbnb_id, user_id]
      );
      return rows.insertId; // Retorna el ID de la reserva creada
    } catch (error) {
      throw error;
    }
  }
  
  // Función para obtener todas las reservas
  async function obtenerTodasLasReservas() {
    try {
      const [rows] = await pool.query('SELECT * FROM micro_reservas');
      return rows;
    } catch (error) {
      throw error;
    }
  }
  
  // Función para obtener una reserva por su ID
  async function obtenerReservaPorUserID(user_id) {
    try {
      const [rows] = await pool.execute(
        'SELECT * FROM micro_reservas WHERE user_id = ?',
        [user_id]
      );
      return rows; // Retorna la primera reserva encontrada
    } catch (error) {
      throw error;
    }
  }
  
  // Función para actualizar una reserva
  async function actualizarReserva(reserva_id, { airbnb_id, user_id, fecha }) {
    try {
      await pool.execute(
        'UPDATE micro_reservas SET airbnb_id = ?, user_id = ? WHERE reserva_id = ?',
        [airbnb_id, user_id, fecha, reserva_id]
      );
      return true; // Indica que la reserva se actualizó correctamente
    } catch (error) {
      throw error;
    }
  }
  
  // Función para eliminar una reserva
  async function eliminarReserva(reserva_id) {
    try {
      await pool.execute(
        'DELETE FROM micro_reservas WHERE reserva_id = ?',
        [reserva_id]
      );
      return true; // Indica que la reserva se eliminó correctamente
    } catch (error) {
      throw error;
    }
  }
  
  module.exports = {
    crearReserva,
    obtenerTodasLasReservas,
    obtenerReservaPorUserID,
    actualizarReserva,
    eliminarReserva
  };