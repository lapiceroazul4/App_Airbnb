const { Router } = require("express");
const router = Router();
const usuariosModel = require("../models/usuariosModel");

router.get("/usuarios", async (req, res) => {
  var result;
  result = await usuariosModel.traerUsuarios();
  res.json(result);
});

router.get("/usuarios/:id", async (req, res) => {
  const id = req.params.id;
  var result;
  result = await usuariosModel.traerUsuario(id);
  res.json(result[0]);
});

router.get("/user/validation", async (req, res) => {
  const email = req.query.email;
  const password = req.query.password;
  var result;
  result = await usuariosModel.validarUsuario(email, password);
  console.log(result);
  res.json(result);
});

router.post("/usuarios/crearusuario", async (req, res) => {
  const user_id = req.body.user_id;
  const name = req.body.name;
  const role = req.body.role;
  const password = req.body.password;
  const email = req.body.email;
  var result = await usuariosModel.crearUsuario(
    user_id,
    name,
    role,
    password,
    email
  );
  res.send("El usuario ha sido creado");
});

router.delete("/usuarios/:id", async (req, res) => {
  const id = req.params.id;
  var result = await usuariosModel.borrarUsuario(id);
  res.send("El usuario ha sido eliminado");
});

module.exports = router;
