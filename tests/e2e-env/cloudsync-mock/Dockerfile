FROM node:20.10-alpine

WORKDIR /home/node
ADD . /home/node
ENV CI=true
RUN npm install -g pnpm \
  && pnpm install

ENTRYPOINT [ "pnpm" ]
CMD [ "test" ]
