const express = require('express');
const reservasController = require('./controllers/reservasController.js'); 
const morgan = require('morgan');
const cors = require('cors');

const app = express();

app.use(cors());
app.use(morgan('dev'));
app.use(express.json());

app.use(reservasController);

app.listen(3003, () => {
    console.log('Microservicio Reservas ejecutandose en el puerto 3003');
});
