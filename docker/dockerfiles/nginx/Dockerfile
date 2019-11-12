FROM nginx

WORKDIR /app

COPY conf/ ./conf
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

CMD  ["nginx", "-g", "daemon off;"]