FROM node:18.12-alpine

WORKDIR /home/node
ADD . /home/node

RUN yarn install
RUN yarn build

# USER node
ENTRYPOINT [ "yarn" ]
CMD ["start"]
