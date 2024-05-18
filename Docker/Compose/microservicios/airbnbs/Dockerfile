FROM node:20

WORKDIR /airbnbs
COPY package.json .
RUN npm install

COPY . .
CMD npm start