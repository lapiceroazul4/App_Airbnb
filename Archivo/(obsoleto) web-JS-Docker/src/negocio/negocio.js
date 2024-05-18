async function getAirbnbs(req, res) {
  try {
    const response = await fetch("http://airbnbs:3002/airbnbs");
    const data = await response.json();
    res.json(data);
  } catch (error) {
    console.error("Error:", error);
    res.status(500).send("Error al traer los productos");
  }
}

async function getAirbnbsByID(req, res) {
  const id = req.params.id;

  try {
    const response = await fetch(`http://airbnbs:3002/airbnbs/id/${id}`);
    const data = await response.json();
    
    res.json(data);
  } catch (error) {
    console.error("Error:", error);
    res.status(500).send("Error al traer el producto");
  }
}

async function getAirbnbsByHostId(req, res) {
  const hostId = req.params.hostId;

  try {
    const response = await fetch(
      `http://airbnbs:3002/airbnbs/hostId/${hostId}`
    );
    const data = await response.json();

    res.json(data);
  } catch (error) {
    console.error("Error:", error);
    res.status(500).send("Error al traer los productos por hostId");
  }
}

async function getAirbnbsByRoomType(req, res) {
  let roomType = req.params.roomType;
  if (req.params.roomType == "Entire home/apt") {
    roomType = "Entire%20home%2Fapt";
  }

  try {
    const response = await fetch(
      `http://airbnbs:3002/airbnbs/roomType/${roomType}`
    );
    const data = await response.json();

    res.json(data);
  } catch (error) {
    console.error("Error:", error);
    res.status(500).send("Error al traer los productos por roomType");
  }
}

async function createAirbnb(req, res) {
  try {
    const response = await fetch("http://airbnbs:3002/airbnbs", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(req.body),
    });

    if (response.ok) {
      const newAirbnb = await response.json();
      res.json(newAirbnb);
    } else {
      console.error("Error al crear el Airbnb:", response.statusText);
      res.status(500).send("Error al crear el Airbnb");
    }
  } catch (error) {
    console.error("Error al crear el Airbnb:", error);
    res.status(500).send("Error al crear el Airbnb");
  }
}
async function updateAirbnb(req, res) {
  const id = req.params.id;
  const airbnbData = req.body;

  try {
    const response = await fetch(`http://airbnbs:3002/airbnbs/${id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(airbnbData),
    });
    console.log(response);
    if (response.ok) {
      const result = await response.json();
      res.json(result);
    } else {
      console.error("Error al actualizar el Airbnb:", response);
      res.status(500).send("Error al actualizar el Airbnb");
    }
  } catch (error) {
    console.error("Error al actualizar el Airbnb:", error);
    res.status(500).send("Error al actualizar el Airbnb");
  }
}

async function deleteAirbnb(req, res) {
  const id = req.params.id;
  try {
    const response = await fetch(`http://airbnbs:3002/airbnbs/${id}`, {
      method: "DELETE",
    });

    if (response.ok) {
      const result = await response.json();
      res.json(result);
    } else {
      console.error("Error al eliminar el Airbnb:", response.statusText);
      res.status(500).send("Error al eliminar el Airbnb");
    }
  } catch (error) {
    console.error("Error al eliminar el Airbnb:", error);
    res.status(500).send("Error al eliminar el Airbnb");
  }
}

async function userValidation(req, res) {
  try {
    const response = await fetch("http://usuarios:3001/user/validation", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(req.body),
    });
    console.log(response);
    res.status(response.status).json(data);
  } catch (error) {
    console.error("Error al iniciar la sesión:", error);
    res.status(500).send("Error al iniciar la sesión");
  }
}

async function getReservas(req, res) {
  try {
    const response = await fetch("http://reservas:3003/reservas");
    const data = await response.json();
    res.json(data);
  } catch (error) {
    console.error("Error:", error);
    res.status(500).send("Error al traer las reservas");
  }
}

async function getReservasByUserID(req, res) {
  const user_id = req.params.user_id;

  try {
    const response = await fetch(`http://reservas:3003/reservas/userID/${user_id}`);
    const data = await response.json();

    res.json(data);
  } catch (error) {
    console.error("Error:", error);
    res.status(500).send("Error al traer la reserva");
  }
}

async function createReserva(req, res) {
  const reserva = req.body;

  try {
    const response = await fetch("http://reservas:3003/reservas", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(reserva),
    });

    if (response.ok) {
      const data = await response.json();
      res.json(data);
    } else if (response.status === 404) {
      res.status(404).send("No se encontró el usuario y/o el Airbnb");
    }
  } catch (error) {
    console.error("Error:", error);
    res.status(500).send("Por favor verifique los datos ingresados");
  }
}

async function deleteReservaByID(req, res) {
  const id = req.params.id;

  try {
    const response = await fetch(`http://reservas:3003/reservas/id/${id}`, {
      method: "DELETE",
    });

    const data = await response.json();

    res.json(data);
  } catch (error) {
    console.error("Error:", error);
    res.status(500).send("Error al eliminar la reserva");
  }
}

module.exports = {
  getAirbnbs,
  getAirbnbsByID,
  getAirbnbsByHostId,
  getAirbnbsByRoomType,
  updateAirbnb,
  createAirbnb,
  deleteAirbnb,
  userValidation,
  getReservas,
  getReservasByUserID,
  createReserva,
  deleteReservaByID,
};
