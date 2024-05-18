const express = require('express');
const router = express.Router();

const airbnbModel = require('../models/airbnbModel');

router.get('/airbnbs', async (req, res) => {
    const airbnbs = await airbnbModel.getAllAirbnbs();
    res.json(airbnbs);
});

router.get('/airbnbs/id/:id', async (req, res) => {
    const airbnb = await airbnbModel.getAirbnbById(req.params.id);
    res.json(airbnb);
});

router.get('/airbnbs/hostId/:hostId', async (req, res) => {
    const airbnbs = await airbnbModel.getAirbnbByHostId(req.params.hostId);
    res.json(airbnbs);
});

router.get('/airbnbs/roomType/:roomType', async (req, res) => {
    const airbnbs = await airbnbModel.getAirbnbsByRoomType(req.params.roomType);
    res.json(airbnbs);
});

router.post('/airbnbs', async (req, res) => {
    const newAirbnb = await airbnbModel.createAirbnb(req.body);
    res.json(newAirbnb);
});

router.put('/airbnbs/:id', async (req, res) => {
    const result = await airbnbModel.updateAirbnb(req.params.id, req.body);
    res.json({ message: `${result}` });
});

router.delete('/airbnbs/:id', async (req, res) => {
    const result = await airbnbModel.deleteAirbnbById(req.params.id);
    res.json({ message: `${result}` });
});

module.exports = router;