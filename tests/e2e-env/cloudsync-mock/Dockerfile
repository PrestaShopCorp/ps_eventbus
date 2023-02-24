FROM node:18.12-alpine

WORKDIR /home/node
ADD . /home/node
RUN yarn install


# USER node
ENTRYPOINT [ "yarn" ]
CMD ["test"]
