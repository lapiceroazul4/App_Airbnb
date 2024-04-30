FROM node:20

WORKDIR /reservas
COPY package.json .
RUN npm install

COPY . .
CMD npm start