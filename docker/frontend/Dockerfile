FROM node:latest

# Install dependencies
RUN apt-get update && apt-get install -y \
    vim \
    zip \
    unzip \
    curl


COPY --chown=1001:0 . /var/www
USER 1001
EXPOSE 5173

# https://github.com/vitejs/vite/discussions/3396
CMD ["sh", "-c", "npm install && npm run build && npm run dev", "npm install -D tailwindcss postcss autoprefixer"]
