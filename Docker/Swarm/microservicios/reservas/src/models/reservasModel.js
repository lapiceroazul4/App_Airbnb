const mysql = require("mysql2/promise");

// Configurar la conexión a la base de datos
const pool = mysql.createPool({
  host: "db",
  user: "root",
  password: "password",
  database: "airbnb_app"
});

// Función para crear una reserva
async function crearReserva({airbnb_id, airbnb_name, host_id, client_id, client_name}) {
    try {
      const [rows] = await pool.execute(
        'INSERT INTO micro_reservas (airbnb_id, airbnb_name, host_id, client_id, client_name, reservation_date) VALUES (?, ?, ?, ?, ?, NOW())',
        [airbnb_id, airbnb_name, host_id, client_id, client_name]
      );
      return rows.insertId;
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
        'SELECT * FROM micro_reservas WHERE client_id = ?',
        [user_id]
      );
      return rows;
    } catch (error) {
      throw error;
    }
  }

  // Función para obtener una reserva por su reservation_id
  async function obtenerReservaPorReservationID(reservation_id) {
    try {
      const [rows] = await pool.execute(
        'SELECT * FROM micro_reservas WHERE reservation_id = ?',
        [reservation_id]
      );
      return rows;
    } catch (error) {
      throw error;
    }
  }

  async function obtenerReservaPorHostID(host_id) {
    try {
      const [rows] = await pool.execute(
        'SELECT * FROM micro_reservas WHERE host_id = ?',
        [host_id]
      );
      return rows;
    } catch (error) {
      throw error;
    }
  }
  
  // Función para eliminar una reserva
  async function eliminarReserva(reservation_id) {
    try {
      await pool.execute(
        'DELETE FROM micro_reservas WHERE reservation_id = ?',
        [reservation_id]
      );
      return true;
    } catch (error) {
      throw error;
    }
  }
  
  module.exports = {
    crearReserva,
    obtenerTodasLasReservas,
    obtenerReservaPorUserID,
    obtenerReservaPorReservationID,
    obtenerReservaPorHostID,
    eliminarReserva
  };