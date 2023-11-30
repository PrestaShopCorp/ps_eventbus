FROM node:20.10-alpine

ENV CI=true
RUN npm install -g pnpm \
  && pnpm install

WORKDIR /home/node
ADD . /home/node

ENTRYPOINT [ "pnpm" ]
CMD [ "test" ]
