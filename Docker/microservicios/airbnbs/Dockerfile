FROM node:20

WORKDIR /airbnbs
COPY package.json .
RUN npm install

EXPOSE 3002

COPY . .
CMD npm start