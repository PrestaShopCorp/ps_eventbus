FROM ngrok/ngrok

ENV NGROK_CONFIG=/etc/ngrok.yml
WORKDIR /

ADD ./ngrok.yml /etc/ngrok.yml
ADD ./start.sh ./start.sh

ENTRYPOINT ["/bin/bash", "-c", "/start.sh"]
