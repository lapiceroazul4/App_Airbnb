const express = require("express");
const app = express();
const morgan = require("morgan");

app.use(morgan("dev"));
app.use(express.urlencoded({ extended: true }));  
app.use(express.json());

app.use(require("./rutas.js"));

app.listen(3000, () => {
    console.log(`Servidor de la página ejecutándose en puerto 3000.`);
  });
