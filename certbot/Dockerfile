FROM ubuntu

RUN apt-get update && apt-get install -y --no-install-recommends certbot \
    && rm -rf /var/lib/apt/lists/*

ENTRYPOINT [ "certbot" ]
