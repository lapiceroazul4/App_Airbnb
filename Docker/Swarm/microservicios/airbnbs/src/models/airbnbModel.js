const mysql = require("mysql2/promise");

// Configurar la conexión a la base de datos
const pool = mysql.createPool({
  host: "db",
  user: "root",
  password: "password",
  database: "airbnb_app",
});

// Función para obtener todos los valores de la tabla micro_airbnbs
async function getAllAirbnbs() {
  try {
    const [rows] = await pool.query("SELECT * FROM micro_airbnbs");
    return rows;
  } catch (error) {
    console.error("Error al obtener los airbnbs:", error);
    throw error;
  }
}

// Función para obtener un airbnb por su id
async function getAirbnbById(id) {
  try {
    const [rows] = await pool.query(
      "SELECT * FROM micro_airbnbs WHERE id = ?",
      id
    );
    return rows;
  } catch (error) {
    console.error("Error al obtener el airbnb por id:", error);
    throw error;
  }
}

// Función para obtener todos los airbnb con un host_id específico
async function getAirbnbByHostId(hostId) {
  try {
    const [rows] = await pool.query(
      "SELECT * FROM micro_airbnbs WHERE host_id = ?",
      [hostId]
    );
    return rows;
  } catch (error) {
    console.error("Error al obtener los airbnbs por host_id:", error);
    throw error;
  }
}

// Función para obtener todos los airbnb con un room_type específico
async function getAirbnbsByRoomType(room_type) {
  try {
    const [rows] = await pool.query(
      "SELECT * FROM micro_airbnbs WHERE room_type = ?",
      [room_type]
    );
    return rows;
  } catch (error) {
    console.error("Error al obtener los airbnbs por room_type:", error);
    throw error;
  }
}

// Función para crear un nuevo airbnb
async function createAirbnb(airbnbData) {
  try {
    const query = `
      INSERT INTO micro_airbnbs (id, name, host_id, host_name, neighbourhood_group, neighbourhood, latitude, longitude, room_type, price, minimum_nights, number_of_reviews, rating, rooms, beds, bathrooms)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    `;
    const values = Object.values(airbnbData);

    const [result] = await pool.query(query, values);
    return { ...airbnbData };
  } catch (error) {
    console.error("Error al crear el airbnb:", error);
    throw error;
  }
}

// Función para actualizar un airbnb existente
async function updateAirbnb(id, airbnbData) {
  try {
    const result = await pool.query("UPDATE micro_airbnbs SET ? WHERE id = ?", [
      airbnbData,
      id,
    ]);
    let message;

    if (result[0].affectedRows > 0) {
      message = "Airbnb actualizado exitosamente";
    } else {
      message = "No existe un airbnb por ese id";
    }
    console.log(message);

    return message;
  } catch (error) {
    console.error("Error al actualizar el airbnb:", error);
    throw error;
  }
}

// Función para eliminar un airbnb por su id
async function deleteAirbnbById(id) {
  try {
    let message;
    const result = await pool.query(
      "DELETE FROM micro_airbnbs WHERE id = ?",
      id
    );

    if (result[0].affectedRows > 0) {
      message = "Airbnb eliminado exitosamente";
    } else {
      message = "No existe un airbnb por ese id";
    }
    console.log(message);

    return message;
  } catch (error) {
    console.error("Error al eliminar el airbnb por id:", error);
    throw error;
  }
}

module.exports = {
  getAllAirbnbs,
  getAirbnbById,
  getAirbnbByHostId,
  getAirbnbsByRoomType,
  createAirbnb,
  updateAirbnb,
  deleteAirbnbById,
};
