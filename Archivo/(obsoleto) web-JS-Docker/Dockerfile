FROM node:20

WORKDIR /web_airbnbs
COPY package.json .
RUN npm install

EXPOSE 3000

COPY . .
CMD npm start