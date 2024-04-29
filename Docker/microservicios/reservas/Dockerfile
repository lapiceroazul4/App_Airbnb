FROM node:20

WORKDIR /reservas
COPY package.json .
RUN npm install

EXPOSE 3003

COPY . .
CMD npm start