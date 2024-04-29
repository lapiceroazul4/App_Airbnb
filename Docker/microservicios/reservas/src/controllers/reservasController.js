const express = require('express');
const router = express.Router();
const axios = require('axios');

const reservasModel = require('../models/reservasModel');

router.get("/reservas", async (req, res) => {
    var result;
    result = await reservasModel.obtenerTodasLasReservas();
    res.json(result);
  });
  
router.get("/reservas/userID/:user_id", async (req, res) => {
    const user_id = req.params.user_id;
    var result;
    result = await reservasModel.obtenerReservaPorUserID(user_id);
    res.json(result);
});

router.get("/reservas/reservationID/:reservation_id", async (req, res) => {
    const reservation_id = req.params.reservation_id;
    var result;
    result = await reservasModel.obtenerReservaPorReservationID(reservation_id);
    res.json(result[0]);
});

router.get("/reservas/hostID/:host_id", async (req, res) => {
    const host_id = req.params.host_id;
    var result;
    result = await reservasModel.obtenerReservaPorHostID(host_id);
    res.json(result);
});

router.post("/reservas", async (req, res) => {
  const { client_id, airbnb_id } = req.body;

  try {
      // Obtener nombres del cliente y del Airbnb
      const [clientResponse, airbnbResponse] = await Promise.all([
          axios.get(`http://localhost:3001/usuarios/${client_id}`),
          axios.get(`http://localhost:3002/airbnbs/id/${airbnb_id}`)
      ]);

      const client_name = clientResponse.data[0].name;
      const airbnb_name = airbnbResponse.data[0].name;
      const host_id = airbnbResponse.data[0].host_id;
      

      if (!client_name || !host_id || !airbnb_name) {
          return res.status(404).json({ error: 'Usuario o Airbnb no encontrado' });
      }

      // Crear la reserva
      const reservation = { airbnb_id, airbnb_name, host_id, client_id, client_name };
      const result = await reservasModel.crearReserva(reservation);

      return res.status(201).json(result);
  } catch (error) {
      console.error('Error al crear reserva:', error);
      return res.status(500).json({ error: 'Error interno del servidor' });
  }
});

router.delete('/reservas/reservationID/:reserva_id', async (req, res) => {
    const result = await reservasModel.eliminarReserva(req.params.reserva_id);
    res.json({ message: `${result}` });
});

module.exports = router;
