FROM node:20.10-alpine

ENV CI=true
ENV RUN_IN_DOCKER=1
RUN npm install -g pnpm

WORKDIR /home/node
ADD . /home/node
RUN pnpm install

ENTRYPOINT [ "pnpm" ]
CMD [ "test" ]
