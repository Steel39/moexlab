FROM node:22.8.0

# Install dependencies
RUN apt-get update && apt-get install -y \
    vim \
    zip \
    unzip \
    curl

COPY --chown=1001:1000 . /var/www

RUN mkdir ".npm"

RUN useradd -u 1001 -ms /bin/bash -g 1000 www

RUN chown -R 1001:0 "/.npm"

USER 1001
EXPOSE 5173

# https://github.com/vitejs/vite/discussions/3396
CMD ["sh", "-c", "npm install && npm run build && npm run dev -- --host"]
