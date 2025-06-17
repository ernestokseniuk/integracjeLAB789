# Lab 8 - Containerized Authentication API

This lab contains a .NET 9 Web API with JWT authentication running in Docker.

## How to run

1. Navigate to the lab8 directory:
   ```powershell
   cd lab8
   ```

2. Build and start the container:
   ```powershell
   docker-compose up --build
   ```

3. The API will be available at: http://localhost:8081

## API Endpoints

- `GET /` - Health check endpoint
- `POST /api/users/authenticate` - Authenticate user and get JWT token
- `GET /api/numbers` - Protected endpoint requiring JWT token

## Testing

You can test the authentication endpoint:
```powershell
# Authenticate
curl -X POST http://localhost:8081/api/users/authenticate `
  -H "Content-Type: application/json" `
  -d '{"username": "admin", "password": "password"}'

# Use the returned token for protected endpoints
curl -X GET http://localhost:8081/api/numbers `
  -H "Authorization: Bearer YOUR_JWT_TOKEN_HERE"
```

## Stopping the container

```powershell
docker-compose down
```
