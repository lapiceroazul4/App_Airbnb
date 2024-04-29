const { Router } = require("express");
const router = Router();
let path = require("path");

const negocio = require("./negocio/negocio.js");

router.get("/logoairbnb.png", (req, res) => {
  res.sendFile(path.resolve("./src/vista/img/logoairbnb.png"));
});

router.get("/css/login.css", (req, res) => {
  res.sendFile(path.resolve("./src/vista/css/login.css"));
});

router.get("/", (req, res) => {
  res.sendFile(path.resolve("./src/vista/login.html"));
});

router.get("/cliente", (req, res) => {
  res.sendFile(path.resolve("./src/vista/client/cliente.html"));
});

router.get("/cliente/mostrarAirbnbs", (req, res) => {
  res.sendFile(path.resolve("./src/vista/client/mostrarAirbnbsCliente.html"));
});

router.get("/cliente/reservarAirbnbs", (req, res) => {
  res.sendFile(path.resolve("./src/vista/client/reservasCliente.html"));
});

router.get("/admin", (req, res) => {
  res.sendFile(path.resolve("./src/vista/admin/admin.html"));
});

router.get("/admin/mostrarAirbnbs", (req, res) => {
  res.sendFile(path.resolve("./src/vista/admin/mostrarAirbnbs.html"));
});

router.get('/admin/crearAirbnbs', (req, res) => {
    res.sendFile(path.resolve('./src/vista/admin/crearAirbnbs.html'));
});

router.get('/admin/actualizarAirbnbs', (req, res) => {
    res.sendFile(path.resolve('./src/vista/admin/actualizarAirbnbs.html'));
});

router.get('/admin/eliminarAirbnbs', (req, res) => {
    res.sendFile(path.resolve('./src/vista/admin/eliminarAirbnbs.html'));
});

router.get("/admin/reservarAirbnbs", (req, res) => {
  res.sendFile(path.resolve("./src/vista/admin/reservas.html"));
});

router.get("/admin/dashboard", (req, res) => {
  res.sendFile(path.resolve("./src/vista/admin/dashboard.html"));
});


router.get("/airbnbs", negocio.getAirbnbs);

router.get("/airbnbs/id/:id", negocio.getAirbnbsByID);

router.get("/airbnbs/hostId/:hostId", negocio.getAirbnbsByHostId);

router.get("/airbnbs/roomType/:roomType", negocio.getAirbnbsByRoomType);

router.post('/airbnbs', negocio.createAirbnb);

router.post('/validarUsuario', negocio.userValidation);

router.put('/updateAirbnb/:id', negocio.updateAirbnb);

router.delete('/deleteAirbnbs/:id', negocio.deleteAirbnb);

router.get("/reservas", negocio.getReservas);

router.get("/reservas/userID/:user_id", negocio.getReservasByUserID);

router.post("/reservas", negocio.createReserva);

router.delete("/reservas/id/:id", negocio.deleteReservaByID);

module.exports = router;
