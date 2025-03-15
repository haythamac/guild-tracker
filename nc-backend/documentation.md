# Player tracker backend documentation

## First day
### Create a player model and migration


### Create player controller


### Create app/Services directory
### Create ScreenshotProcessingService.php
### Install tesseract ocr in the windows machine (https://github.com/UB-Mannheim/tesseract/wiki)
### Add to variable path
### Update the screenshotprocessingservice.php


### Add Queue Processing

## API Documentation

### Player Endpoints

#### Create Player
- **URL:** `/api/players`
- **Method:** `POST`
- **Description:** Create a new player.
- **Request Body:**
  ```json
  {
    "name": "string",
    "age": "number",
    "team": "string"
  }
  ```
- **Response:**
  ```json
  {
    "id": "number",
    "name": "string",
    "age": "number",
    "team": "string",
    "created_at": "string",
    "updated_at": "string"
  }
  ```

#### Get Player
- **URL:** `/api/players/{id}`
- **Method:** `GET`
- **Description:** Retrieve a player by ID.
- **Response:**
  ```json
  {
    "id": "number",
    "name": "string",
    "age": "number",
    "team": "string",
    "created_at": "string",
    "updated_at": "string"
  }
  ```

#### Update Player
- **URL:** `/api/players/{id}`
- **Method:** `PUT`
- **Description:** Update a player's information.
- **Request Body:**
  ```json
  {
    "name": "string",
    "age": "number",
    "team": "string"
  }
  ```
- **Response:**
  ```json
  {
    "id": "number",
    "name": "string",
    "age": "number",
    "team": "string",
    "created_at": "string",
    "updated_at": "string"
  }
  ```

#### Delete Player
- **URL:** `/api/players/{id}`
- **Method:** `DELETE`
- **Description:** Delete a player by ID.
- **Response:**
  ```json
  {
    "message": "Player deleted successfully."
  }
  ```