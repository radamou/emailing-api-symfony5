FROM alpine:3.10.1 AS base

WORKDIR /var/www

RUN apk update && \
    apk add --no-cache nginx vim iputils curl
RUN apk update && apk add bash
RUN adduser -S -D www-data && \
    adduser www-data www-data

RUN mkdir -p /run/nginx
RUN rm /etc/nginx/conf.d/default.conf

COPY nginx.conf /etc/nginx/conf.d/nginx.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
