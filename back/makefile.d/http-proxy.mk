.PHONY: start-http-proxy

start-http-proxy:
ifeq ($(OS), Darwin)
	@if  docker ps --filter "name=http-proxy" | grep Up; then \
		echo "status already started"; \
	else \
		docker run -d --restart=always \
          -v /var/run/docker.sock:/tmp/docker.sock:ro \
          -v ~/.dinghy/certs:/etc/nginx/certs \
          -p 80:80 -p 443:443 -p 19322:19322/udp \
          -e DNS_IP=127.0.0.1 -e CONTAINER_NAME=http-proxy \
          --name http-proxy \
          codekitchen/dinghy-http-proxy; \
	fi
endif
