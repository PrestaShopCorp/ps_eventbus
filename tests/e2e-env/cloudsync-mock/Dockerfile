FROM node:18.12-alpine

WORKDIR /home/node
USER root
ADD . /home/node

RUN yarn install
RUN ls -la
RUN yarn build

# USER node
CMD ["yarn", "start"]