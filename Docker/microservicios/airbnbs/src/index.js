const express = require('express');
const airbnbController = require("./controllers/airbnbController");
const morgan = require("morgan");
const cors = require("cors");

const app = express();

app.use(cors());
app.use(morgan("dev"));
app.use(express.json());

app.use(airbnbController);

app.listen(3002, () => {
    console.log(`Microservicio Airbnbs escuchando en el puerto 3002.`);
});