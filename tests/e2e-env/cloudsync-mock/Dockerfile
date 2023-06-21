FROM node:18.16-alpine

WORKDIR /home/node
ADD . /home/node
RUN npm install -g pnpm \
  && pnpm install

# USER node
ENTRYPOINT [ "pnpm" ]
CMD [ "test" ]
