FROM node:20

WORKDIR /usuarios
COPY package.json .
RUN npm install

COPY . .
CMD npm start