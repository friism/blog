FROM ubuntu:bionic

RUN apt-get update && apt-get install -y --no-install-recommends software-properties-common \
    && add-apt-repository ppa:certbot/certbot \
    && apt-get update && apt-get install -y --no-install-recommends certbot \
    && rm -rf /var/lib/apt/lists/*

ENTRYPOINT [ "certbot" ]
