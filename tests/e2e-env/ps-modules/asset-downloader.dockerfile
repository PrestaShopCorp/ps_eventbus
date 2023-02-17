FROM alpine:latest

RUN apk add -U jq curl sed
WORKDIR /
ADD ./asset-downloader.sh /
RUN mkdir -p /asset

ENTRYPOINT [ "sh" ]
CMD ["/asset-downloader.sh"]
