FROM node:20-alpine

WORKDIR /var/www

# Comando por defecto: eliminar archivo hot y compilar assets
CMD ["sh", "-c", "rm -f public/hot && npm ci && npm run build"]
